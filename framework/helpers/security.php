<?php
// Clean array
function clean_array($array = array())
{
    $output = array();

    if ($array) {
        foreach ($array as $key => $value) {
            $clear_key = esc_html(esc_attr($key));

            if (is_array($value) && $value) {
                $clear_value = clean_array($value);
            } else {
                $clear_value = esc_html(esc_attr($value));
            }

            $output[$clear_key] = $clear_value;
        }
    }

    return $output;
};

// Clear string from tags and chars
function clean_str($data)
{
    $datas = trim($data);
    $datas = strip_tags($datas);

    return esc_html(esc_attr($datas));
}

// Clean string for exclude ID
function clean_exclude_id($string)
{
    $output = preg_replace('/[^0-9 ,]/', '', $string);
    $output = clean_str($output);
    return $output;
}

// Clean string for post date
function clean_post_date($string)
{
    $output = preg_replace('/[^0-9 :-]/', '', $string);
    $output = clean_str($output);
    return $output;
}

// Clean order by
function clean_order_by($string)
{
    $output = preg_replace('/[^a-zA-Z0-9 ._]/', '', $string);
    $output = clean_str($output);
    return $output;
}

// Clean string for value or type
function clean_value_and_type($string)
{
    $output = preg_replace('/[^a-zA-Z0-9._-]/', '', $string);
    $output = clean_str($output);
    return $output;
}
