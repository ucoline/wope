<?php
/**
 * App Model
 *
 * @package     Wope - Modern Wordpress Starter Theme
 * @author      Ucolabs <hello@ucolabs.com>
 * @link        https://github.com/ucolabs/wope
 * @since       1.0.0
 */

namespace Models;

class App
{
    // Instagram profile datas
    public static function get_instagram_profile()
    {
        $access_token = \Theme::get_option('instagram_access_token');
        $datas = self::api_curl_connect("https://api.instagram.com/v1/users/self/?access_token=" . $access_token);

        if (isset($datas->data)) {
            return $datas->data;
        }

        return false;
    }

    // Instagram datas
    public static function get_instagram_data($count = 10)
    {
        $access_token = \Theme::get_option('instagram_access_token');
        $user_search = self::api_curl_connect("https://api.instagram.com/v1/users/self/media/recent/?access_token=" . $access_token . '&count=' . $count);

        if (isset($user_search->data[0]->id)) {
            return $user_search->data;
        }

        return false;
    }

    // API curl connect
    public static function api_curl_connect($api_url)
    {
        $connection_c = curl_init(); // initializing
        curl_setopt($connection_c, CURLOPT_URL, $api_url); // API URL to connect
        curl_setopt($connection_c, CURLOPT_RETURNTRANSFER, 1); // return the result, do not print
        curl_setopt($connection_c, CURLOPT_TIMEOUT, 20);
        
        $json_return = curl_exec($connection_c); // connect and get json data
        
        curl_close($connection_c); // close connection
        return json_decode($json_return); // decode and return
    }
}
