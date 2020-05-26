<?php
define('ADMIN_DIR_NAME', 'admin');
define('APP_DIR_NAME', 'application');
define('THEME_DIR_NAME', 'theme');
define('THEME_ROOT_URI', get_theme_root_uri() . '/');

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(__FILE__) . DS);
define('THEME_NAME', basename(dirname(__FILE__)));

define('THEME_PATH', BASE_PATH . THEME_DIR_NAME . DS);
define('THEME_PATH_URL', THEME_ROOT_URI . THEME_NAME .'/');

define('APP_PATH', BASE_PATH . APP_DIR_NAME . DS);
define('ADMIN_PATH', BASE_PATH . ADMIN_DIR_NAME . DS);
define('ADMIN_PATH_URL', THEME_PATH_URL . ADMIN_DIR_NAME . '/');

// Load vendor
require_once BASE_PATH . 'vendor/autoload.php';

// Load app helpers
foreach (glob(APP_PATH . 'helpers/*.php') as $filename) {
    include $filename;
}

// Load app theme setup
foreach (glob(APP_PATH . 'setup/*.php') as $filename) {
    include $filename;
}

// Load app system files
foreach (glob(APP_PATH . 'core/*.php') as $filename) {
    include $filename;
}