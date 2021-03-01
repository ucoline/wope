<?php
// Load boostrap file
require_once 'bootstrap.php';

// Global vars
$current_user = array();
$is_logged_in = is_user_logged_in();
$current_lang = get_locale();

// Create container
$container = new Container;
$container::$current_lang = $current_lang;

if ($is_logged_in) {
    $current_user = wp_get_current_user();

    $container::$is_logged_in = true;
    $container::$current_user = $current_user;
    $container::$current_user_id = $current_user->ID;
}

// Ajax action
add_action('init', function () {
    if (input_post('ajax') || input_get('xr')) {
        include_framework_file('ajax-router');
        exit();
    }
});

// Template include filter
add_action('template_include', function ($original_template) {
    $template = App::template_router();

    if ($template && file_exists($template)) {
        return $template;
    }

    return $original_template;
});

// Template redirect
add_action('template_redirect', function () {
    $status = session_status();

    if (PHP_SESSION_DISABLED === $status) {
        // That's why you cannot rely on sessions!
        return;
    }

    if (PHP_SESSION_NONE === $status) {
        session_start();
    }
});

// ACF init
add_action('acf/init', function () {
    if (function_exists('acf_register_block')) {
        $model = new \Models\ACF();
        $model->init();
    }
});

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

if (!function_exists('get_fields') && !is_admin()) {
    echo 'Plugin "Advanced Custom Fields" required! Please install to use the theme!';
    die();
}
