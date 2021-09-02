<?php

/**
 * Theme
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link        https://github.com/ucoline/wope
 * @since       1.0.0
 */

use \Libs\Redis;

class Theme
{
    // Retrieves an option value based on an option name
    public static function get_option($key, $defult = false)
    {
        $item = Redis::get_the_option($key);
        return $item ? $item : $defult;
    }

    // Retrieve post title
    public static function get_the_title($id, $defult = false)
    {
        $item = Redis::get_the_title($id);
        return $item ? $item : $defult;
    }

    // Retrieves the full permalink for the current post or post ID
    public static function get_the_permalink($id, $defult = false)
    {
        $item = Redis::get_the_link($id);
        return $item ? $item : $defult;
    }

    // Retrieves information about the current site
    public static function get_bloginfo($key, $defult = false)
    {
        $item = Redis::get_blog_info($key);
        return $item ? $item : $defult;
    }

    // Displays a navigation menu
    public static function nav_menu($location, $args = array(), $defult = false)
    {
        $item = Redis::get_menu($location, $args);
        return $item ? $item : $defult;
    }

    // Retrieve post categories
    public static function get_the_category($post_id = false, $defult = false)
    {
        if (is_numeric($post_id)) {
            $id = $post_id;
        } else {
            $id = get_queried_object_id();
        }

        $item = Redis::get_the_category($id);
        return $item ? $item : $defult;
    }

    // Retrieve post categories
    public static function get_the_tags($post_id = false, $defult = false)
    {
        if (is_numeric($post_id)) {
            $id = $post_id;
        } else {
            $id = get_queried_object_id();
        }

        $item = Redis::get_the_tags($id);
        return $item ? $item : $defult;
    }

    // Returns the value of a specific acf field
    public static function get_field($selector, $post_id = false, $defult = false)
    {
        $item = Redis::get_field($selector, $post_id);
        return $item ? $item : $defult;
    }

    // Returns the value of wp_query
    public static function WP_Query($args = array())
    {
        $output = array();
        $args_key = serialize($args);
        $sql_key = md5($args_key);
        $cached_results = Redis::wp_query('get', $sql_key);

        if (!is_null($cached_results)) {
            return $cached_results;
        } else {
            $output = new \WP_Query($args);
            Redis::wp_query('set', $sql_key, $output);
        }

        return $output;
    }

    // Returns the value of get_terms
    public static function get_terms($args = array())
    {
        $output = array();
        $args_key = serialize($args);
        $sql_key = md5($args_key);
        $cached_results = Redis::get_terms('get', $sql_key);

        if (!is_null($cached_results)) {
            return $cached_results;
        } else {
            $output = get_terms($args);
            Redis::get_terms('set', $sql_key, $output);
        }

        return $output;
    }

    // Returns the value of get_term_by
    public static function get_term_by($field, $value, $taxonomy = '', $output = OBJECT, $filter = 'raw')
    {
        $output = array();
        $args_key = serialize($field . '-' . $value . '-' . $taxonomy . '-' . $output . '-' . $filter);
        $sql_key = md5($args_key);
        $cached_results = Redis::get_term_by('get', $sql_key);

        if (!is_null($cached_results)) {
            return $cached_results;
        } else {
            $output = $category = get_term_by($field, $value, $taxonomy, $output, $filter);
            Redis::get_term_by('set', $sql_key, $output);
        }

        return $output;
    }
}
