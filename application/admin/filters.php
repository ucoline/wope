<?php
// Add assets files
add_action('admin_enqueue_scripts', function () {
    wp_enqueue_media();
    wp_enqueue_script('admin-scripts', admin_folder_url('assets/admin-scripts.js'), false, '5.3.0');
});

// Init
add_action('init', function () {
    wp_enqueue_style('admin-styles', admin_folder_url('assets/admin-style.css'), false, '5.3.1');
});

// Post image column
function add_img_column_posts($columns)
{
    $columns = array_slice($columns, 0, 2, true) + array("img" => __('Image', 'wope')) + array_slice($columns, 1, count($columns) - 1, true);
    return $columns;
}

function manage_img_column_posts($column_name, $post_id)
{
    if ($column_name == 'img') {
        $img = get_the_post_thumbnail_url($post_id, 'thumbnail');

        if ($img) {
            echo '<img src="' . $img . '" alt="image" width="80" height="80" />';
        }
    }

    return $column_name;
}

add_filter('manage_posts_columns', 'add_img_column_posts');
add_filter('manage_posts_custom_column', 'manage_img_column_posts', 10, 5);
