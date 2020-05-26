<?php
// Load boostrap file
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Set session
if (!is_cli() && session_id() == '') {
    session_start();
}

// Global vars
$current_lang = 'en';
$current_user = array();
$is_logged_in = is_user_logged_in();

// Create container
$container = new Container;
$container::$current_lang = $current_lang;

if ($is_logged_in) {
    $current_user = wp_get_current_user();

    $container::$is_logged_in = true;
    $container::$current_user = $current_user;
    $container::$current_user_id = $current_user->ID;
}

// Check and load admin
if ($is_logged_in && is_admin()) {
    $redirect = true;

    if (in_array('administrator', (array) $current_user->roles)) {
        $redirect = false;
    } elseif (in_array('editor', (array) $current_user->roles)) {
        $redirect = false;
    }

    if ($redirect) {
        App::page_404();
        die();
    }

    include_admin_file('init');
}

// Ajax action
add_action('init', function () {
    if (input_post('xaction') || input_get('xr')) {
        include_app_file('ajax/router');
        exit();
    }
});

// Template include filter
// add_action('template_include', function ($original_template) {
//     App::template_router();

//     return $original_template;
// });
