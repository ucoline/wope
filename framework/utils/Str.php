<?php
/**
 * String Utility
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link        https://github.com/ucoline/wope
 * @since       1.0.0
 */

namespace Utils;

class Str
{
    // Trim Slashes
    public static function trim_slashes($str)
    {
        return trim($str, '/');
    }

    // String to lower
    public static function strtolower($str)
    {
        return mb_strtolower($str, 'UTF-8');
    }

    // String to lower
    public static function strtoupper($str)
    {
        return mb_strtoupper($str, 'UTF-8');
    }

    // String to lower
    public static function strtotitle($str)
    {
        return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
    }

    // Quotes to Entities
    public static function quotes_to_entities($str)
    {
        $find = array("\'", "\"", "'", '"');
        $replace = array("&#39;", "&quot;", "&#39;", "&quot;");

        return str_replace($find, $replace, $str);
    }

    // Remove all chars from string
    public static function remove_all($string, $except = false)
    {
        if ($string && $except == 'letters') {
            return preg_replace('/[^a-zA-Z]/', '', $string);
        }

        if ($string && $except == 'numbers') {
            return preg_replace('/[^0-9.]/', '', $string);
        }

        if ($string && $except == 'letters-numbers') {
            return preg_replace('/[^a-zA-Z0-9.]/', '', $string);
        }

        return false;
    }

    // Remove all spaces from string
    public static function remove_spaces($string)
    {
        $stripped = preg_replace('/\s+/', ' ', $string);

        return preg_replace('/\s/', '', $stripped);
    }

    // Generate random string
    public static function random_string($type = 'alnum', $len = 8)
    {
        switch ($type) {
            case 'alpha':
                $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'alpha-lower':
                $pool = 'abcdefghijklmnopqrstuvwxyz';
                break;
            case 'alnum':
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;
            case 'alnum-lower':
                $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
                break;
            case 'numeric':
                $pool = '0123456789';
                break;
            case 'nozero':
                $pool = '123456789';
                break;
        }

        return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
    }

    // Obfuscate email address
    public static function obfuscate_email($email_address = false)
    {
        $output = $email_address;
        $explode = explode("@", $email_address);
        $name = array_value($explode, 0);
        $name_fchars = substr($name, 0, 2);
        $name_length = strlen($name);
        $email = array_value($explode, 1);
        $email_fchars = substr($email, 0, 3);
        $email_lchars = substr($email, -3);
        $email_length = strlen($email);

        if ($name_length > 0 && $email_length > 0) {
            $output = $name_fchars . str_repeat('*', ($name_length - 2));
            $output .= '@';
            $output .= $email_fchars . str_repeat('*', ($email_length - 6)) . $email_lchars;
        }

        return $output;
    }

    // Reading post time
    public static function estimated_reading_time($content = false)
    {
        if ($content) {
            $words = str_word_count(strip_tags($content));
            $minutes = floor($words / 275);

            if (1 <= $minutes) {
                $estimated_time = $minutes . ' min';
            } else {
                $estimated_time = '1 min';
            }

            return $estimated_time;
        }
    }

    // Strip words
    public static function strip_words($content, $limit = 40, $button = 'Read more...')
    {
        $content = strip_tags($content);
        $content = trim($content);

        if ($content) {
            $output = '';
            $array = explode(' ', $content);

            if (count($array) > $limit) {
                $i = 0;

                foreach ($array as $item) {
                    if ($i <= $limit) {
                        $output .= $item . ' ';
                    }
                    $i++;
                }

                $output = trim($output);
                $output = $output . '... ' . $button;

                return $output;
            }
        }

        return $content;
    }
}
