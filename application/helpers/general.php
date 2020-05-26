<?php
// Form notify
function form_notify($type = 'error', $array = array())
{
    $output = [
        'error' => true,
        'success' => false,
        'title' => 'Uyarı',
        'msg' => 'İşleminiz yapılırken teknik bir hata oluştu. Lütfen sayfayı yenileyip tekrar deneyin.',
        'notify' => 'notify-error',
        'icon' => 'fa fa-exclamation-circle'
    ];

    if ($type == 'success') {
        $output = [
            'error' => false,
            'success' => true,
            'title' => 'theMagger Bildirim',
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

// Display translated text
function _trs($text, $domain = false)
{
    $text_domain = $domain ? $domain : THEME_NAME;
    echo translate($text, $text_domain);
}

// Retrieve the translation of text
function __trs($text, $domain = false)
{
    $text_domain = $domain ? $domain : THEME_NAME;
    return translate($text, $text_domain);
}

// Minify js
function minify_css($files, $minify, $disabled = false)
{
    if ($disabled) {
        return;
    }

    $home_path = home_path();
    $path = $home_path . 'assets/theme/min/';
    $minify_file = $path . $minify;

    if (!is_file($minify_file) && is_array($files) && $files) {
        $buffer = '';

        foreach ($files as $file) {
            $filename = str_replace(site_url(), '', $file);
            $filename = $home_path . trim($filename, '/');

            if (is_file($filename)) {
                $buffer .= file_get_contents($filename);
            }
        }

        if ($buffer) {
            $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
            $buffer = str_replace(': ', ':', $buffer);
            $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
            $minified_codes = preg_replace("/\r|\n/", "", $buffer);
            file_put_contents($minify_file, $minified_codes);
        }
    }
}

// Minify js
function minify_js($files, $minify, $disabled = false)
{
    if ($disabled) {
        return;
    }

    $home_path = home_path();
    $path = $home_path . 'assets/theme/min/';
    $minify_file = $path . $minify;

    if (!is_file($minify_file) && is_array($files) && $files) {
        $buffer = '';

        foreach ($files as $file) {
            $filename = str_replace(site_url(), '', $file);
            $filename = $home_path . trim($filename, '/');

            if (is_file($filename)) {
                $jsfile = file_get_contents($filename);
                $buffer .= \Libs\JSMinifier::minify($jsfile);
            }
        }

        if ($buffer) {
            $minified_codes = preg_replace("/\r|\n/", "", $buffer);
            file_put_contents($minify_file, $minified_codes);
        }
    }
}

// Get menu by location
function get_menu($location, $args = array())
{
    $menu = new \Libs\CustomMenu($location, $args);
    return $menu->get();
}