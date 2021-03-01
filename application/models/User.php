<?php
/**
 * User Model
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link        https://github.com/ucoline/wope
 * @since       1.0.0
 */

namespace Models;

class User
{
    // Get user fullname
    public static function getFullname($user = null)
    {
        $output = '';

        if (isset($user->first_name) && $user->first_name) {
            $output .= $user->first_name;

            if (isset($user->last_name) && $user->last_name) {
                $output .= ' ' . $user->last_name;
            }
        } elseif (isset($user->display_name)) {
            $output = $user->display_name;
        } elseif (isset($user->user_nicename)) {
            $output = $user->user_nicename;
        } else {
            $output = 'Unknown';
        }

        return ucwords($output);
    }

    // Get user firstname
    public static function getFirstname($user = null)
    {
        $output = '';

        if (isset($user->first_name) && $user->first_name) {
            $output .= $user->first_name;
        } elseif (isset($user->display_name)) {
            $output = $user->display_name;
        } elseif (isset($user->user_nicename)) {
            $output = $user->user_nicename;
        } else {
            $output = 'Unknown';
        }

        return ucwords($output);
    }

    // Count all users by role
    public static function countAll($roles = array('author'))
    {
        $count = 0;
        $roles_query = '';

        if (is_array($roles)) {
            $roles_array = array();

            foreach ($roles as $role) {
                $crole = clean_str($role);
                $roles_array[] = "umeta.meta_value LIKE '%$crole%'";
            }

            if ($roles_array) {
                $roles_implode = implode(' OR ', $roles_array);
                $roles_query = "({$roles_implode})";
            }
        } elseif (is_string($roles)) {
            $crole = clean_str($roles);
            $roles_query = "umeta.meta_value LIKE '%$crole%'";
        }

        if ($roles_query) {
            global $wpdb;

            $query_count = "SELECT COUNT(*) FROM $wpdb->users users
            INNER JOIN $wpdb->usermeta umeta ON (users.ID = umeta.user_id)
            WHERE umeta.meta_key = 'wp_capabilities'
            AND {$roles_query}";

            $count = $wpdb->get_var($query_count);
        }

        return $count ? $count : 0;
    }

    // Count user posts
    public static function countPosts($user_ID = 0, $type = 'publish')
    {
        $count = 0;

        if (is_numeric($user_ID) && $user_ID > 0) {
            global $wpdb;
            $type = clean_str($type);
            $type = \Utils\Str::remove_spaces($type);

            $count = $wpdb->get_var("SELECT COUNT(*) as count FROM wp_posts WHERE post_type='post' AND post_status='{$type}' AND post_author = $user_ID");
        }

        return $count ? $count : 0;
    }

    // Count user comments
    public static function countComments($user_ID = 0)
    {
        $count = 0;

        if (is_numeric($user_ID) && $user_ID > 0) {
            global $wpdb;
            $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) AS total FROM $wpdb->comments WHERE comment_approved = 1 AND user_id = %s", $user_ID));
        }

        return $count ? $count : 0;
    }
}
