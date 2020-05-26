<?php
/**
 * Category Model
 *
 * @package     Wope - Modern Wordpress Starter Theme
 * @author      Ucolabs <hello@ucolabs.com>
 * @link        https://github.com/ucolabs/wope
 * @since       1.0.0
 */

namespace Models;

class Category
{
    // Get primary category
    public static function getPrimaryCategory($post_id = 0, $term = 'category', $return_all_categories = false)
    {
        $output = array();

        if (class_exists('WPSEO_Primary_Term')) {
            // Show Primary category by Yoast if it is enabled & set
            $wpseo_primary_term = new \WPSEO_Primary_Term($term, $post_id);
            $primary_term = get_term($wpseo_primary_term->get_primary_term());

            if (!is_wp_error($primary_term)) {
                $output['primary_category'] = $primary_term;
            }
        }

        if (empty($output['primary_category']) || $return_all_categories) {
            $categories_list = get_the_terms($post_id, $term);

            if (empty($output['primary_category']) && !empty($categories_list)) {
                $output['primary_category'] = $categories_list[0];  //get the first category
            }
            if ($return_all_categories) {
                $output['all_categories'] = array();

                if (!empty($categories_list)) {
                    foreach ($categories_list as &$category) {
                        $output['all_categories'][] = $category->term_id;
                    }
                }
            }
        }

        return $output;
    }

    // Count category posts
    public static function countPosts($category_id = false)
    {
        $count = 0;

        if (is_numeric($category_id) && $category = get_category($category_id)) {
            $catid = $category->term_id;

            if ($category->parent === 0) {
                global $wpdb;

                $category_tax_ids = $category_id;

                $categoryChilds = self::getChildsID(array(
                    'select' => 'term_taxonomy_id',
                    'parent' => $category_id
                ), 'string');

                if ($categoryChilds) {
                    $category_tax_ids .= ',' . $categoryChilds;
                }

                $query = "SELECT COUNT(*) FROM (
                    SELECT posts.ID FROM $wpdb->posts posts
                    INNER JOIN wp_term_relationships terms ON (posts.ID = terms.object_id)
                    WHERE terms.term_taxonomy_id IN ({$category_tax_ids})
                    AND posts.post_type = 'post'
                    AND posts.post_status = 'publish'
                    GROUP BY posts.ID
                ) a";

                $count = $wpdb->get_var($query);
            } else {
                $count = $category->category_count;
            }
        }

        return $count;
    }

    // Get child categories ID
    public static function getChildsID($args = array(), $output = 'array')
    {
        global $wpdb;
        $query = "SELECT terms.*, tax.term_taxonomy_id FROM $wpdb->terms terms INNER JOIN  $wpdb->term_taxonomy tax ON terms.term_id = tax.term_id ";
        $query .= "WHERE tax.taxonomy = 'category' ";

        $parent = array_value($args, 'parent');
        $exclude = array_value($args, 'exclude');
        $select = array_value($args, 'select');

        $limit = array_value($args, 'limit');
        $offset = array_value($args, 'offset', 0);

        $orderby = clean_order_by(array_value($args, 'orderby'));
        $order = clean_order_by(array_value($args, 'order'));

        if ($exclude) {
            $exclude = clean_exclude_id($exclude);
            $query .= "AND terms.term_id NOT IN ($exclude) ";
        }

        if (is_numeric($parent)) {
            $query .= "AND tax.parent = $parent ";
        }

        if ($orderby && $order) {
            $query .= "ORDER BY $orderby $order ";
        }

        if (is_numeric($limit)) {
            if (is_numeric($offset)) {
                $query .= "LIMIT $offset, $limit";
            } else {
                $query .= "LIMIT 0, $limit";
            }
        }

        $results = $wpdb->get_results($query);
        $array = array();

        if ($results) {
            foreach ($results as $value) {
                if ($select == 'term_taxonomy_id') {
                    $array[] = $value->term_taxonomy_id;
                } else {
                    $array[] = $value->term_id;
                }
            }
        }

        if ($output == 'string') {
            return implode(',', $array);
        }

        return $array;
    }
}
