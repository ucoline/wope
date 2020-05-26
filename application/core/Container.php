<?php
/**
 * App Container
 *
 * @package     Wope - Modern Wordpress Starter Theme
 * @author      Ucolabs <hello@ucolabs.com>
 * @link        https://github.com/ucolabs/wope
 * @since       1.0.0
 */

class Container
{
    public static $array = array();
    public static $is_logged_in = false;
    public static $current_lang = false;
    public static $current_user = array();
    public static $current_user_id = false;

    /**
     * Add array to container
     *
     * @param array $array
     * @return void
     */
    public static function add_array($array = array())
    {
        if (is_array($array) && $array) {
            foreach ($array as $key => $value) {
                self::$array[$key] = $value;
            }
        }
    }

    /**
     * Add value to array
     *
     * @param boolean $key
     * @param string $value
     * @return void
     */
    public static function add_value($key = false, $value = '')
    {
        if ($key) {
            self::$array[$key] = $value;
        }
    }

    /**
     * Get array value
     *
     * @param boolean $key
     * @return void
     */
    public static function get($key = false)
    {
        if ($key && isset(self::$array[$key])) {
            return self::$array[$key];
        }
    }

    /**
     * Update array value
     *
     * @param boolean $key
     * @param boolean $value
     * @return void
     */
    public static function update($key = false, $value = false)
    {
        if ($key && isset(self::$array[$key])) {
            self::$array[$key] = $value;
        }
    }

    /**
     * Delete array value
     *
     * @param boolean $key
     * @return void
     */
    public static function delete($key = false)
    {
        if ($key && isset(self::$array[$key])) {
            unset(self::$array[$key]);
        }
    }

    /**
     * List array
     *
     * @return void
     */
    public static function list_array()
    {
        return self::$array;
    }

    /**
     * Add js files
     *
     * @param array $array
     * @return void
     */
    public static function add_js($files = array())
    {
        $js_files = self::js_files();

        if (is_array($files) && $files) {
            self::$array['js_files'] = array_merge($js_files, $files);
        }
    }

    /**
     * Get js files
     *
     * @return array
     */
    public static function js_files()
    {
        $output = array();

        if (isset(self::$array['js_files']) && is_array(self::$array['js_files'])) {
            $output = self::$array['js_files'];
        }

        return $output;
    }
}
