<?php
/**
 * Register theme filters
 *
 * @package     Wope - Modern Wordpress Starter Theme
 * @author      UCO Labs <hello@ucolabs.com>
 * @link https://developer.wordpress.org/reference/functions/add_filter/
 */

// Disable xmlrpc
add_filter('xmlrpc_enabled', '__return_false');

// Remove srcset from images
add_filter('wp_calculate_image_srcset', '__return_false');

// Disable feed
function _disable_feed()
{
    wp_die(__('No feed available, please visit the <a href="'. esc_url(home_url('/')) .'">homepage</a>!'));
}

add_action('do_feed', '_disable_feed', 1);
add_action('do_feed_rdf', '_disable_feed', 1);
add_action('do_feed_rss', '_disable_feed', 1);
add_action('do_feed_rss2', '_disable_feed', 1);
add_action('do_feed_atom', '_disable_feed', 1);
add_action('do_feed_rss2_comments', '_disable_feed', 1);
add_action('do_feed_atom_comments', '_disable_feed', 1);

add_filter('wpseo_json_ld_output', '__return_false');