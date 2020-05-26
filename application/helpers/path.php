<?php
// Get theme admin path
function admin_path($folder = false)
{
    $path = str_replace('/', DS, ADMIN_PATH);
    $output = $path;

    if ($folder) {
        $folder = str_replace('/', DS, $folder);
        return $output . $folder;
    }

    return $output;
}

// Get theme app path
function app_path($folder = false)
{
    $path = str_replace('/', DS, APP_PATH);
    $output = $path;

    if ($folder) {
        $folder = str_replace('/', DS, $folder);
        return $output . $folder;
    }

    return $output;
}

// Get base path
function base_path($folder = false)
{
    $path = str_replace('/', DS, BASE_PATH);
    $output = $path;

    if ($folder) {
        $folder = str_replace('/', DS, $folder);
        return $output . $folder;
    }

    return $output;
}

// Get theme path
function theme_path($folder = false)
{
    $path = str_replace('/', DS, THEME_PATH);
    $output = $path;

    if ($folder) {
        $folder = str_replace('/', DS, $folder);
        return $output . $folder;
    }

    return $output;
}

// Home path
function home_path()
{
    $home = set_url_scheme(get_option('home'), 'http');
    $siteurl = set_url_scheme(get_option('siteurl'), 'http');

    if (! empty($home) && 0 !== strcasecmp($home, $siteurl)) {
        $wp_path_rel_to_home = str_ireplace($home, '', $siteurl); /* $siteurl - $home */
        $pos                 = strripos(str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']), trailingslashit($wp_path_rel_to_home));
        $home_path           = substr($_SERVER['SCRIPT_FILENAME'], 0, $pos);
        $home_path           = trailingslashit($home_path);
    } else {
        $home_path = ABSPATH;
    }

    return str_replace('\\', '/', $home_path);
}

// JSON path
function json_path($folder = false)
{
    $dir = WP_CONTENT_DIR . DS . 'json';

    // Check dir
    if (!is_dir($dir)) {
        wp_mkdir_p($dir);
    }

    $path = str_replace('/', DS, $dir);
    $output = $path . DS;

    if ($folder) {
        $folder = str_replace('/', DS, $folder);
        return $output . $folder;
    }

    return $output;
}
