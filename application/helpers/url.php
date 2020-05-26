<?php
// Get assets url
function assets_url($url = false)
{
    return THEME_PATH_URL .'assets/'. $url;
}

// Get assets images url
function images_url($url = false)
{
    return assets_url('images/' . $url);
}

// Get assets libraries url
function libs_url($url = false)
{
    return assets_url('libs/' . $url);
}

// Get assets theme url
function theme_url($url = false)
{
    return assets_url('theme/' . $url);
}

// Get theme admin folder url
function admin_folder_url($folder = false)
{
    return ADMIN_PATH_URL . $folder;
}

// Uploads URL
function upload_url()
{
    $upload_dir = wp_upload_dir();
    return $upload_dir['baseurl'];
}

// Full url path
function get_current_url($full = true)
{
    if (isset($_SERVER['REQUEST_URI'])) {
        $server= &$_SERVER;
        $ssl = (!empty($server['HTTPS']) && $server['HTTPS'] == 'on') ? true:false;
        $sp = strtolower($server['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port = $server['SERVER_PORT'];
        $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
        $host = isset($server['HTTP_X_FORWARDED_HOST']) ? $server['HTTP_X_FORWARDED_HOST'] : (isset($server['HTTP_HOST']) ? $server['HTTP_HOST'] : null);
        $host = isset($host) ? $host : $server['SERVER_NAME'] . $port;
        $uri = $protocol . '://' . $host . $server['REQUEST_URI'];

        if ($full) {
            return $uri;
        }

        $segments = explode('?', $uri, 2);
        $url = $segments[0];
        return $url;
    }
}
