<?php
/**
 * Register menu locations
 *
 * @package     Wope - Modern Wordpress Starter Theme
 * @author      UCO Labs <hello@ucolabs.com>
 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
 */

// Register menus
register_nav_menus(
    array(
        'header-menu' => __('Header Menu'),
        'footer-menu' => __('Footer Menu'),
    )
);