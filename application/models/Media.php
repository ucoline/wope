<?php
/**
 * Media Model
 *
 * @package     Wope - Modern Wordpress Starter Theme
 * @author      Ucolabs <hello@ucolabs.com>
 * @link        https://github.com/ucolabs/wope
 * @since       1.0.0
 */

namespace Models;

class Media
{
    // Get attachment by author
    public static function attachmentByAuthor($user_id = 0, $attachment_id = 0)
    {
        if (is_numeric($user_id) && $user_id > 0 && is_numeric($attachment_id) && $attachment_id > 0) {
            global $wpdb;
            return $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID = $attachment_id AND post_author = $user_id AND post_type = 'attachment'");
        }

        return false;
    }
}
