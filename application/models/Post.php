<?php
/**
 * Post Model
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link        https://github.com/ucoline/wope
 * @since       1.0.0
 */

namespace Models;

class Post
{
    // Get latest posts
    public static function latestPosts($limit = 12, $offset = 0, $paged = 1, $search = false)
    {
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'orderby' => 'post_date',
            'order' => 'DESC',
        );

        // Check limit
        if (is_numeric($limit) && $limit > 0) {
            $args['posts_per_page'] = $limit;
        } else {
            $args['posts_per_page'] = 12;
        }

        // Check offset
        if (is_numeric($offset) && $offset > 0) {
            $args['offset'] = $offset;
        }

        // Check pagination
        if (is_numeric($paged) && $paged > 0) {
            $args['paged'] = $paged;
        }

        // Check search
        if ($search) {
            $args['s'] = $search;
        }

        // Query
        $query = new \WP_Query($args);

        return $query;
    }

    // Get post by author
    public static function postByAuthor($user_id = 0, $post_id = 0)
    {
        if (is_numeric($user_id) && $user_id > 0 && is_numeric($post_id) && $post_id > 0) {
            global $wpdb;
            return $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID = $post_id AND post_author = $user_id AND post_type = 'post'");
        }

        return false;
    }
}
