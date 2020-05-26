<?php 
// Meta title
function meta_title()
{
    $site_name = Theme::get_bloginfo('name');
    $site_description = Theme::get_bloginfo('description');
    $site_title = $site_name . ': ' . $site_description;

    if (is_front_page() || is_home()) {
        $title = $site_title;
    } elseif (is_search()) {
        $search = get_query_var('s');
        $t_sep = '%WP_TITLE_SEP%';
        $title = sprintf(__('Search Results %1$s %2$s'), $t_sep, strip_tags($search));
    } elseif (is_category()) {
        $title = single_term_title('', false) . ' &bull; ' . $site_title;
    } elseif (is_tag()) {
        $title = '#' . single_term_title('', false) . ' &bull; ' . $site_title;
    } elseif (is_author() && ! is_post_type_archive()) {
        $author = get_queried_object();
        if ($author) {
            $title = Utils\Turkish::ucfirst_words($author->display_name) . ' &bull; ' . $site_title;
        }
    } elseif (is_single() || (is_home() && ! is_front_page()) || (is_page() && ! is_front_page())) {
        $title = single_post_title('', false) . ' &bull; ' . $site_title;
    } else {
        $title = wp_title('') . ': ' . $site_description;
    }

    return $title;
}

// Gender
function gender($key = false)
{
    $array = array(
        1 => _trs('Male'),
        2 => _trs('Female')
    );

    if (isset($array[$key]) && $array[$key]) {
        return $array[$key];
    }

    return $array;
}