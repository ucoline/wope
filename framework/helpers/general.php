<?php
// Form notify
function form_notify($type = 'error', $array = array())
{
    $output = [
        'error' => true,
        'success' => false,
        'title' => __('Error', 'wope'),
        'msg' => __('An error occurred while processing your request. Please try again.', 'wope'),
        'notify' => 'notify-error',
        'icon' => 'fa fa-exclamation-circle'
    ];

    if ($type == 'success') {
        $output = [
            'error' => false,
            'success' => true,
            'title' => __('Success', 'wope'),
            'msg' => '',
            'notify' => 'notify-success',
            'icon' => 'fa fa-check-circle'
        ];
    }

    if (isset($array['title'])) {
        $output['title'] = $array['title'];
    }

    if (isset($array['msg'])) {
        $output['msg'] = $array['msg'];
    }

    if (isset($array['notify'])) {
        $output['notify'] = $array['notify'];
    }

    if (isset($array['icon'])) {
        $output['icon'] = $array['icon'];
    }

    return $output;
}

// ACF block render
function acf_block_render_callback($block)
{
    $block_name = $block['name'];

    if (file_exists(get_theme_file_path("/partials/{$block_name}.php"))) {
        include(get_theme_file_path("/partials/{$block_name}.php"));
    }
}

// Get acf image size url
function get_acf_image_size_url($array, $size = 'thumbnail', $default = '')
{
    $output = $default;

    if (is_array($array) && $array) {
        $output = array_value($array, 'url');
        $image_sizes = array_value($array, 'sizes');

        if (isset($image_sizes[$size])) {
            $output = $image_sizes[$size];
        }
    }

    return $output;
}

// Get menu by location
function get_menu($location, $args = array())
{
    $menu = new \Libs\CustomMenu($location, $args);
    return $menu->get();
}
