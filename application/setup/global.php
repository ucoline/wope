<?php
/**
 * Global filters
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link https://developer.wordpress.org/reference/functions/add_action/
 */

// Remove jQuery and migration
add_action('wp_default_scripts', function ($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array('jquery-core', 'jquery-migrate'));
        }
    }
});

// Add jQuery
add_action("wp_enqueue_scripts", function () {
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js", false, null);
        wp_enqueue_script('jquery');
    }
}, 11);

// Remove global wp head items
add_action('after_setup_theme', function () {
    if (!is_admin()) {
        // Remove admin bar
        // add_filter('show_admin_bar', '__return_false');

        // Remove wp version
        add_filter('the_generator', '__return_empty_string');

        // Disable xmlrpc
        add_filter('xmlrpc_enabled', '__return_false');

        // Remove srcset from images
        add_filter('wp_calculate_image_srcset', '__return_false');

        // Remove wlwmanifest
        remove_action('wp_head', 'wlwmanifest_link');

        // Remove pagination
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

        // Remove shortlink
        remove_action('wp_head', 'wp_shortlink_wp_head', 10);

        // Remove hints
        remove_action('wp_head', 'wp_resource_hints', 2);

        // Remove emojis
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
    }
});
