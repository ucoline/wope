<?php
/**
 * Register theme settings
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link https://developer.wordpress.org/reference/functions/add_action/
 */

// Theme after setup
add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
    add_theme_support('menus');

    // Image sizes
    add_image_size('300x300', 300, 300, true);
});
