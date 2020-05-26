<?php
/**
 * Tools
 *
 * @package     Wope - Modern Wordpress Starter Theme
 * @author      Ucolabs <hello@ucolabs.com>
 * @link        https://github.com/ucolabs/wope
 * @since       1.0.0
 */

namespace Utils;

class Tools
{
    // Remove file ext from name
    public static function file_ext_from_name($str = false)
    {
        $array = array('.jpg', '.jpeg', '.png', '.gif');

        if ($str) {
            $output = str_replace($array, '', mb_strtolower($str));
            return $output;
        }

        return false;
    }

    // Number format
    public static function numformat($number = false, $default = null)
    {
        if (is_numeric($number) && $number > 0) {
            return number_format($number, 0, '', '.');
        } elseif (is_numeric($default)) {
            return $default;
        }
    }

    // Format website
    public static function format_website($string = false, $type = 'name')
    {
        $site_name = str_replace('http://', '', $string);
        $site_name = str_replace('https://', '', $site_name);

        if ($type == 'name') {
            return rtrim($site_name, '/');
        } else {
            $protocol = 'http://';

            if (stripos($string, 'https://') !== false) {
                $protocol = 'https://';
            }

            return $protocol . $site_name;
        }
    }

    // Resize Gutenberg gallery image
    public static function resize_gutenberg_gallery_image($content, $size = 'gallery_item')
    {
        if (! is_main_query()) {
            return $content;
        }

        // Find gallery blocks
        $regexp = "<li\s[^>]*blocks-gallery-item[^>]*>(.*)<\/li>";
        
        if (preg_match_all("/$regexp/imsU", $content, $matches, PREG_PATTERN_ORDER)) {
            $updated = false;

            foreach ($matches[0] as $key => $match) {
                if (preg_match('/<img\s[^>]*data-id="(.*)"[^>]*>/imsU', $match, $match_img)) {
                    $img = array_value($match_img, 0);
                    $img_id = array_value($match_img, 1);
                    $attachment = wp_get_attachment_image_src($img_id, $size);
                    if (isset($attachment[0]) && $attachment[0]) {
                        $attachment_url = $attachment[0];
                        if (preg_match('/<img\s[^>]*src="(.*)"[^>]*>/imsU', $img, $img_src)) {
                            $img_replaced = str_replace($img_src[1], $attachment_url, $img);
                            $matches[1][$key] = str_replace($img, $img_replaced, $match);
                            $updated = true;
                        }
                    }
                }
            }

            if ($updated) {
                $content = str_replace($matches[0], $matches[1], $content);
            }
        }
        
        return $content;
    }

    public static function log($message, $file)
    {
        $log = $message. PHP_EOL;
        $log .= "-----------------------------". PHP_EOL;
        
        file_put_contents($file, $log, FILE_APPEND);
    }
}
