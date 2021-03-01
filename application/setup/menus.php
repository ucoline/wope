<?php
/**
 * Register menu locations
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
 */

// Register menus
register_nav_menus(
    array(
        'header-menu' => __('Header Menu', 'wope'),
        'footer-menu' => __('Footer Menu', 'wope'),
    )
);
