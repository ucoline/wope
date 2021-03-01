<?php
// Clean GET query
function input_get($key = false, $default = false)
{
    if (isset($_GET[$key])) {
        $query = $_GET[$key];

        if (is_array($query) && $query) {
            $output = clean_array($query);
        } else {
            $output = esc_html(esc_attr($query));
        }

        return $output;
    }

    return $default;
}

// Clean POST query
function input_post($key = false, $default = false)
{
    if (isset($_POST[$key])) {
        $post = $_POST[$key];

        if (is_array($post) && $post) {
            $output = clean_array($post);
        } else {
            $output = esc_html(esc_attr($post));
        }

        return $output;
    }

    return $default;
}

// Clean request value
function request_value($key = false, $default = false)
{
    if (isset($_REQUEST[$key]) && $_REQUEST[$key]) {
        return $_REQUEST[$key];
    }

    return $default;
}
