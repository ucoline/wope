<?php 
// Site options
add_action('update_option', function( $option_name, $old_value, $value ) {
    $key = "get-option-{$option_name}";
    \Libs\Redis::delete($key);
}, 10, 3);

// Save post
add_action('save_post', function($post_id, $post, $update) {
    $link = "get-the-link-{$post_id}";
    $tags = "get-post-tags-{$post_id}";
    $title = "get-the-title-{$post_id}";
    $categories = "get-post-categories-{$post_id}";

    \Libs\Redis::delete($link);
    \Libs\Redis::delete($tags);
    \Libs\Redis::delete($title);
    \Libs\Redis::delete($categories);

    if (function_exists('get_fields')) {
        $meta_values = get_fields($post_id);

        if ($meta_values) {
            foreach ($meta_values as $meta_key => $meta_value) {
                $key = "get-post-meta-field-{$meta_key}-{$post_id}";
                \Libs\Redis::delete($key);
            }
        }
    }
}, 10, 3);

// Update nav menu
add_action('wp_update_nav_menu', function ($id, $data = NULL){
    foreach( get_nav_menu_locations() as $location => $menu_id ){
        $menu_id = "get-wp-menu-{$menu_id}";
        $menu_id = "custom-menu-{$menu_id}";
        $menu_location = "get-wp-menu-{$location}";
        $menu_location = "custom-menu-{$location}";

        \Libs\Redis::delete($menu_id);
        \Libs\Redis::delete($menu_location);
    }
}, 10, 2);