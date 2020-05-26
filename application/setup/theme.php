<?php
/**
 * Register theme settings
 *
 * @package     Wope - Modern Wordpress Starter Theme
 * @author      UCO Labs <hello@ucolabs.com>
 * @link https://developer.wordpress.org/reference/functions/add_action/
 */

// Theme after setup
add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
    add_theme_support('menus');

    // Image sizes
    // add_image_size('40x40', 40, 40, true);
    // add_image_size('250x250', 250, 250, true);
});
