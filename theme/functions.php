<?php
// Load boot file
require_once 'boot.php';

// Header minified css
function header_css()
{
    $file_name = 'style-135.min.css';

    $files = array(
        theme_url('css/main.css'),
        theme_url('css/theme.css'),
        theme_url('css/styles.css'),
    );

    minify_css($files, $file_name, false);

    return $file_name;
}

// Footer minified js
function footer_js()
{
    $file_name = 'scripts-246.min.js';

    $files = array(
        theme_url('js/owl.load.js'),
        theme_url('js/scripts.all.js'),
        theme_url('js/scripts.load.js'),
    );

    minify_js($files, $file_name, false);

    return $file_name;
}