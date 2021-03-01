<?php
// Form notify
function form_notify($type = 'error', $array = array())
{
    $output = [
        'error' => true,
        'success' => false,
        'title' => lexicon('error'),
        'msg' => lexicon('ajax_error_msg'),
        'notify' => 'notify-error',
        'icon' => 'fa fa-exclamation-circle'
    ];

    if ($type == 'success') {
        $output = [
            'error' => false,
            'success' => true,
            'title' => lexicon('notification'),
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

// Lexicon
function lexicon($key, $lang = false)
{
    $output = '';
    $language = 'en';
    $folder = APP_PATH .'lexicon'. DS;

    if (!$lang) {
        $language = Container::$current_lang;
    } else {
        $language = $lang;
    }

    // Get file
    $file = $folder . $language . '.php';

    if (isset($file)) {
        $array = include $file;

        if (isset($array[$key])) {
            $output = $array[$key];
        }
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

// Get menu by location
function get_menu($location, $args = array())
{
    $menu = new \Libs\CustomMenu($location, $args);
    return $menu->get();
}
