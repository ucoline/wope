<?php
/**
 * Redis library
 *
 * @package     Wope - Modern Wordpress Starter Theme
 * @author      Daniele Alessandri <suppakilla@gmail.com>
 * @link        https://github.com/nrk/predis
 */

namespace Libs;

class Redis
{
    public static function prefix($key = false, $append = false)
    {
        $prefix = '';
        $uniqkey = \App::config('redis_key');

        if ($key && $append) {
            $prefix = $uniqkey ? $uniqkey .'_'. $key : $key;
        } elseif($key) {
            $prefix = $key;
        }

        return $prefix;
    }

    public static function is_active()
    {
        return \App::config('redis_on', false);
    }

    public static function connect($args = array())
    {
        if (self::is_active()) {
            if (is_array($args) && $args) {
                $client = new \Predis\Client($args);
            } else {
                $client = new \Predis\Client(['scheme' => 'tcp', 'host' => '127.0.0.1']);
            }
    
            // $client->auth('mypassword');
    
            return $client;
        }
    }

    public static function get($key)
    {
        if (self::is_active()) {
            $redis_key = self::prefix($key, true);

            $client = self::connect();
            return $client->get($redis_key);
        }
    }

    public static function set($key, $value, $expire = 0)
    {
        if (self::is_active()) {
            $redis_key = self::prefix($key, true);

            $client = self::connect();
            $client->set($redis_key, $value);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }
    }

    public static function rpush($key, $value, $expire = 0)
    {
        if (self::is_active()) {
            $redis_key = self::prefix($key, true);
    
            $client = self::connect();
            $client->rpush($redis_key, $value);
    
            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }
    }

    public static function lpush($key, $value, $expire = 0)
    {
        if (self::is_active()) {
            $redis_key = self::prefix($key, true);
    
            $client = self::connect();
            $client->rpush($redis_key, $value);
    
            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }
    }

    public static function lrange($key, $x = 0, $y = -1)
    {
        if (self::is_active()) {
            $redis_key = self::prefix($key, true);
    
            $client = self::connect();
            return $client->lrange($redis_key, $x, $y);
        }
    }

    public static function delete($key)
    {
        if (self::is_active()) {
            $redis_key = self::prefix($key, true);
    
            $client = self::connect();
            return $client->del($redis_key);
        }
    }

    public static function get_the_title($key, $expire = 86400)
    {
        $is_active = self::is_active();

        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-the-title-'. $key, true);
            $cache = $client->get($redis_key);
    
            if ($cache && is_string($cache)) {
                return $cache;
            }
        }

        $value = get_the_title($key);

        if ($value && $is_active) {
            $client->set($redis_key, $value);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $value;
    }

    public static function get_the_link($key, $expire = 86400)
    {
        $is_active = self::is_active();

        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-the-link-'. $key, true);
            $cache = $client->get($redis_key);
    
            if ($cache && is_string($cache)) {
                return $cache;
            }
        }

        $value = get_the_permalink($key);

        if ($value && $is_active) {
            $client->set($redis_key, $value);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $value;
    }

    public static function get_blog_info($key, $expire = 86400)
    {
        $is_active = self::is_active();
        
        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-option-blog'. $key, true);
            $cache = $client->get($redis_key);
    
            if ($cache && is_string($cache)) {
                return $cache;
            }
        }

        $value = get_bloginfo($key);

        if ($value && $is_active) {
            $client->set($redis_key, $value);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }    
        }

        return $value;
    }

    public static function get_the_option($key, $expire = 86400)
    {
        $is_active = self::is_active();
        
        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-option-'. $key, true);
            $cache = $client->get($redis_key);
    
            if ($cache && is_string($cache)) {
                return $cache;
            }
        }

        $value = get_option($key);

        if ($value && $is_active) {
            $client->set($redis_key, $value);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $value;
    }

    public static function get_menu($key, $args, $expire = 86400)
    {
        $is_active = self::is_active();
        
        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-wp-menu-'. $key, true);
            $cache = $client->get($redis_key);
    
            if ($cache && is_string($cache)) {
                echo $cache;
                return;
            }
        }

        if (is_array($args) && $args) {
            if ($is_active) {
                ob_start();
                wp_nav_menu($args);
                $wp_nav_menu = ob_get_clean();
    
                if ($wp_nav_menu) {
                    $client->set($redis_key, $wp_nav_menu);
    
                    if (is_numeric($expire) && $expire > 0) {
                        $client->expire($redis_key, $expire);
                    }
    
                    echo $wp_nav_menu;
                }
            } else {
                wp_nav_menu($args);
            }
        }
    }

    public static function get_field($selector, $post_id, $expire = 86400)
    {
        $is_active = self::is_active();
        
        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-post-meta-field-'. $selector .'-'. $post_id, true);
            $cache = $client->get($redis_key);
    
            if ($cache && !is_null($cache)) {
                return json_decode($cache, true);
            }
        }

        $value = get_field($selector, $post_id);

        if ($value && $is_active) {
            $client->set($redis_key, json_encode($value));

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $value;
    }

    public static function get_the_category($post_id, $expire = 86400)
    {
        $is_active = self::is_active();
        
        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-post-categories-'. $post_id, true);
            $cache = $client->get($redis_key);
    
            if ($cache && !is_null($cache)) {
                return json_decode($cache);
            }
        }

        $categories = get_the_category($post_id);

        if ($categories && $is_active) {
            $client->set($redis_key, json_encode($categories));

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $categories;
    }

    public static function get_the_tags($post_id, $expire = 86400)
    {
        $is_active = self::is_active();
        
        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-post-tags-'. $post_id, true);
            $cache = $client->get($redis_key);
    
            if ($cache && !is_null($cache)) {
                return json_decode($cache);
            }
        }

        $tags = get_the_tags($post_id);

        if ($tags && $is_active) {
            $client->set($redis_key, json_encode($tags));

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $tags;
    }
}
