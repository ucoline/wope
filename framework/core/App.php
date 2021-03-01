<?php

/**
 * App
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link        https://github.com/ucoline/wope
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
        global $wp_query;

        $id = $wp_query->queried_object_id;
        $object = $wp_query->get_queried_object();
        $object_type = queried_object_type($object);

        if ($object_type == 'product') {
            return templates_path('product-sinle.php');
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
        $file = framework_path('config.php');
        include $file;

        if (isset($config[$key])) {
            return $config[$key];
        } else {
            return $default;
        }
    }
}
