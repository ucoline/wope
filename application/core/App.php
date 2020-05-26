<?php
/**
 * App
 *
 * @package     Wope - Modern Wordpress Starter Theme
 * @author      Ucolabs <hello@ucolabs.com>
 * @link        https://github.com/ucolabs/wope
 * @since       1.0.0
 */

class App
{
    // Page links
    public static function page_link($type)
    {
        $pages = array(
            'about' => 1,
            'services' => 2,
            'contacts' => 3,
        );

        if (isset($pages[$type])) {
            return get_the_permalink($pages[$type]);
        }
    }

    // Template router
    public static function template_router()
    {
        $post_type = get_post_type();

        if ($post_type == 'news') {
            include_theme_file('news/single');
            exit();
        }
    }
    
    // 404 Error page
    public static function page_404()
    {
        global $wp_query;

        status_header(404);
        $wp_query->set_404();
        get_template_part(404);

        exit();
    }

    // Get config
    public static function config($key, $default = false)
    {
        $file = base_path('config.php');
        include $file;

        if (isset($config[$key])) {
            return $config[$key];
        } else {
            return $default;
        }
    }
}
