<?php
define('ADMIN_DIR_NAME', 'admin');
define('APP_DIR_NAME', 'application');
define('ASSETS_DIR_NAME', 'assets');
define('FRAMEWORK_DIR_NAME', 'framework');
define('INC_DIR_NAME', 'inc');
define('TEMPLATES_DIR_NAME', 'templates');
define('THEME_ROOT_URI', get_theme_root_uri() . '/');

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', dirname(__DIR__) . DS);
define('THEME_NAME', basename(dirname(__DIR__)));

define('TEMPLATES_PATH', BASE_PATH . TEMPLATES_DIR_NAME . DS);
define('THEME_PATH_URL', THEME_ROOT_URI . THEME_NAME .'/');

define('APP_PATH', BASE_PATH . APP_DIR_NAME . DS);
define('APP_PATH_URL', THEME_PATH_URL . APP_DIR_NAME .'/');

define('ADMIN_PATH', APP_PATH . ADMIN_DIR_NAME . DS);
define('ADMIN_PATH_URL', APP_PATH_URL . ADMIN_DIR_NAME . '/');

define('FRAMEWORK_PATH', BASE_PATH . FRAMEWORK_DIR_NAME . DS);
define('INC_PATH', BASE_PATH . INC_DIR_NAME . DS);

define('ASSETS_PATH', BASE_PATH . ASSETS_DIR_NAME . DS);
define('ASSETS_PATH_URL', THEME_PATH_URL . ASSETS_DIR_NAME .'/');

// Load vendor
require_once 'vendor/autoload.php';

// Load app helpers
foreach (glob(FRAMEWORK_PATH . 'helpers/*.php') as $filename) {
    include $filename;
}

// Load app theme setup
foreach (glob(APP_PATH . 'setup/*.php') as $filename) {
    include $filename;
}

// Load app system files
foreach (glob(FRAMEWORK_PATH . 'core/*.php') as $filename) {
    include $filename;
}
