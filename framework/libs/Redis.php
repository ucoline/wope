<?php

/**
 * Redis library
 * URL: https://github.com/nrk/predis
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link        https://github.com/ucoline/wope
 * @since       1.0.0
 */

namespace Libs;

class Redis
{
    public static function prefix($key = false, $append = false)
    {
        $prefix = '';
        $host = $_SERVER['HTTP_HOST'];
        $uniqkey = $host . '_' . \App::config('redis_key');

        if ($key && $append) {
            $prefix = $uniqkey ? $uniqkey . '_' . $key : $key;
        } elseif ($key) {
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
            $redis_client = \App::config('redis_client');

            if (is_array($args) && $args) {
                $client = new \Predis\Client($args);
            } elseif ($redis_client) {
                $client = new \Predis\Client($redis_client);
            } else {
                $client = new \Predis\Client(['scheme' => 'tcp', 'host' => '127.0.0.1']);
            }

            $redis_password = \App::config('redis_password');

            if ($redis_password) {
                $client->auth($redis_password);
            }

            return $client;
        }
    }

    public static function keys($key)
    {
        if (self::is_active()) {
            $redis_key = self::prefix($key, true);

            $client = self::connect();
            return $client->keys($redis_key);
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

    public static function crypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = \App::config('secret_key', 'hgeUehJdgw82kghdu2kdj38hd3hdlHs38Ldh38sl');
        $secret_iv = \App::config('secret_iv', 'kGy3ldh39LLd393Ldh3LdKMbsy3zmdsJksLei83dj');
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } elseif ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public static function get_the_title($key, $expire = 0)
    {
        $is_active = self::is_active();

        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-the-title-' . $key, true);
            $cache = $client->get($redis_key);

            if ($cache && is_string($cache)) {
                $hash = self::crypt('decrypt', $cache);
                return $hash;
            }
        }

        $value = get_the_title($key);

        if ($value && $is_active) {
            $hash = self::crypt('encrypt', $value);
            $client->set($redis_key, $hash);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $value;
    }

    public static function get_the_link($post, $expire = 0)
    {
        $is_active = self::is_active();

        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-the-link-' . $post, true);
            $cache = $client->get($redis_key);

            if ($cache && is_string($cache)) {
                $hash = self::crypt('decrypt', $cache);
                return $hash;
            }
        }

        $value = get_the_permalink($post);

        if ($value && $is_active) {
            $hash = self::crypt('encrypt', $value);
            $client->set($redis_key, $hash);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $value;
    }

    public static function get_blog_info($key, $expire = 0)
    {
        $is_active = self::is_active();

        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-option-blog' . $key, true);
            $cache = $client->get($redis_key);

            if ($cache && is_string($cache)) {
                $hash = self::crypt('decrypt', $cache);
                return $hash;
            }
        }

        $value = get_bloginfo($key);

        if ($value && $is_active) {
            $hash = self::crypt('encrypt', $value);
            $client->set($redis_key, $hash);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $value;
    }

    public static function get_the_option($key, $expire = 0)
    {
        $is_active = self::is_active();

        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-option-' . $key, true);
            $cache = $client->get($redis_key);

            if ($cache && is_string($cache)) {
                $hash = self::crypt('decrypt', $cache);
                return $hash;
            }
        }

        $value = get_option($key);

        if ($value && $is_active) {
            $hash = self::crypt('encrypt', $value);
            $client->set($redis_key, $hash);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $value;
    }

    public static function get_menu($key, $args, $expire = 0)
    {
        $is_active = self::is_active();

        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-wp-menu-' . $key, true);
            $cache = $client->get($redis_key);

            if ($cache && is_string($cache)) {
                $hash = self::crypt('decrypt', $cache);
                echo $hash;
                return;
            }
        }

        if (is_array($args) && $args) {
            if ($is_active) {
                ob_start();
                wp_nav_menu($args);
                $wp_nav_menu = ob_get_clean();

                if ($wp_nav_menu) {
                    $hash = self::crypt('encrypt', $wp_nav_menu);
                    $client->set($redis_key, $hash);

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

    public static function get_field($selector, $post_id, $expire = 0)
    {
        $is_active = self::is_active();

        if (is_numeric($post_id)) {
            $id = $post_id;
        } else {
            $id = get_queried_object_id();
        }

        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-post-meta-field-' . $selector . '-' . $id, true);
            $cache = $client->get($redis_key);

            if ($cache && !is_null($cache)) {
                $hash = self::crypt('decrypt', $cache);
                return unserialize($hash);
            }
        }

        $value = get_field($selector, $post_id);
        $data = serialize($value);

        if ($data && $is_active) {
            $hash = self::crypt('encrypt', $data);
            $client->set($redis_key, $hash);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $value;
    }

    public static function get_the_category($post_id, $expire = 0)
    {
        $is_active = self::is_active();

        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-post-categories-' . $post_id, true);
            $cache = $client->get($redis_key);

            if ($cache && !is_null($cache)) {
                $hash = self::crypt('decrypt', $cache);
                return unserialize($hash);
            }
        }

        $categories = get_the_category($post_id);

        if ($categories && $is_active) {
            $data = serialize($categories);
            $hash = self::crypt('encrypt', $data);
            $client->set($redis_key, $hash);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $categories;
    }

    public static function get_the_tags($post_id, $expire = 0)
    {
        $is_active = self::is_active();

        if ($is_active) {
            $client = self::connect();
            $redis_key = self::prefix('get-post-tags-' . $post_id, true);
            $cache = $client->get($redis_key);

            if ($cache && !is_null($cache)) {
                $hash = self::crypt('decrypt', $cache);
                return unserialize($hash);
            }
        }

        $tags = get_the_tags($post_id);

        if ($tags && $is_active) {
            $data = serialize($tags);
            $hash = self::crypt('encrypt', $data);
            $client->set($redis_key, $hash);

            if (is_numeric($expire) && $expire > 0) {
                $client->expire($redis_key, $expire);
            }
        }

        return $tags;
    }

    public static function wp_query($command = 'set', $query_key = '', $result = null)
    {
        $prefix = "get-wp-query-sql-";
        return self::cached_sql_queries($prefix, $command, $query_key, $result);
    }

    public static function get_terms($command = 'set', $query_key = '', $result = null)
    {
        $prefix = "get-wp-terms-sql-";
        return self::cached_sql_queries($prefix, $command, $query_key, $result);
    }

    public static function get_term_by($command = 'set', $query_key = '', $result = null)
    {
        $prefix = "get-wp-terms-by-sql-";
        return self::cached_sql_queries($prefix, $command, $query_key, $result);
    }

    public static function cached_sql_queries($prefix, $command = 'set', $query_key = '', $result = null, $delete = 'multi')
    {
        if (is_string($prefix) && !empty($prefix)) {
            $key = "{$prefix}{$query_key}";

            if ($command == 'get') {
                $cached_item = self::get($key);

                if (!is_null($cached_item) && is_string($cached_item) && !empty($cached_item)) {
                    $hash = self::crypt('decrypt', $cached_item);
                    return unserialize($hash);
                }
            } elseif ($command == 'set' && !is_null($result)) {
                $serialize = serialize($result);
                $hash = self::crypt('encrypt', $serialize);
                self::set($key, $hash);
            } elseif ($command == 'delete') {
                if ($delete == 'single') {
                    self::delete($key);
                } else {
                    $cached_keys = self::keys($prefix . '*');

                    if ($cached_keys && is_array($cached_keys)) {
                        foreach ($cached_keys as $cached_key) {
                            self::delete($cached_key, false);
                        }
                    } elseif ($cached_keys && is_string($cached_keys)) {
                        self::delete($cached_keys, false);
                    }
                }
            }
        }
    }
}
