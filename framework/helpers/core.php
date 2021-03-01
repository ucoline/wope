<?php
// Get array value
function array_value($array = false, $key = false, $default = false)
{
    if (is_array($array) && isset($array[$key])) {
        return $array[$key];
    }

    return $default;
}

// Autoload php files
function autoload_files($folder)
{
    if (is_dir($folder)) {
        foreach (glob($folder . '/*.php') as $filename) {
            include $filename;
        }
    } elseif (is_dir(base_path($folder))) {
        foreach (glob(base_path($folder) . '/*.php') as $filename) {
            include $filename;
        }
    }
}

// Code debug
function debug($code)
{
    echo '<pre>';
    print_r($code);
    echo '</pre>';
}

// Check cli mode
function is_cli()
{
    if (php_sapi_name() == "cli") {
        return true;
    }

    return false;
}

// Include file
function include_file($file = false)
{
    $inc = $file . '.php';

    if (is_file($inc)) {
        include $inc;
    } elseif (is_file(base_path($inc))) {
        include base_path($inc);
    } else {
        return false;
    }
}

// Include admin file
function include_admin_file($file = false)
{
    $inc = admin_path($file . '.php');

    if (is_file($inc)) {
        include $inc;
    }
}

// Include app file
function include_app_file($file = false)
{
    $inc = app_path($file . '.php');

    if (is_file($inc)) {
        include $inc;
    }
}

// Include app file
function include_framework_file($file = false)
{
    $inc = framework_path($file . '.php');

    if (is_file($inc)) {
        include $inc;
    }
}

// Include inc file
function include_inc_file($file = false)
{
    $inc = inc_path($file . '.php');

    if (is_file($inc)) {
        include $inc;
    }
}

// Include template file
function include_template($file = false)
{
    $inc = templates_path($file . '.php');

    if (is_file($inc)) {
        include $inc;
    }
}

// Include admin view
function admin_view($file = false, $data = array(), $view = false)
{
    $inc = admin_path($file);
    return get_view($inc, $data, $view);
}

// Include app view
function app_view($file = false, $data = array(), $view = false)
{
    $inc = app_path($file);
    return get_view($inc, $data, $view);
}

// Include framework view
function framework_view($file = false, $data = array(), $view = false)
{
    $inc = framework_path($file);
    return get_view($inc, $data, $view);
}

// Include inc view
function inc_view($file = false, $data = array(), $view = false)
{
    $inc = inc_path($file);
    return get_view($inc, $data, $view);
}

// Include theme layout
function template_view($file = false, $data = array(), $view = false)
{
    $inc = templates_path($file);
    return get_view($inc, $data, $view);
}

// Include view
function get_view($file = false, $data = array(), $view = false)
{
    $inc = $file . '.php';

    if (is_file($inc)) {
        if ($data && is_array($data)) {
            extract($data);
        }

        if ($view) {
            ob_start();
            include $inc;
            return ob_get_clean();
        } else {
            include $inc;
        }
    }
}

// Include theme partial
function get_partial($file = false, $data = array(), $view = false)
{
    $inc = base_path('partials/' . $file);
    return get_view($inc, $data, $view);
}

// Include theme section
function get_section($file = false, $data = array(), $view = false)
{
    $inc = base_path('sections/' . $file);
    return get_view($inc, $data, $view);
}

// Remove dirs
function rm_dir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);

        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rm_dir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }

        reset($objects);
        rmdir($dir);
    }
}

// Get queried object type
function queried_object_type($object)
{
    $output = '';

    if (isset($object->post_type)) {
        $output = $object->post_type;
    } elseif (isset($object->taxonomy)) {
        $output = $object->taxonomy;
    } elseif (isset($object->name)) {
        $output = 'post_type_' . $object->name;
    }

    return $output;
}
