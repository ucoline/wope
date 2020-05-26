<?php
// Add new category field
function extra_category_fields($category)
{ ?>
<tr class="form-field">
  <th scope="row" valign="top"><label for="term_sort"><?php _trs('Category sort'); ?></label></th>
  <td><input type="number" name="term_sort" id="term_sort" value="<?= isset($category->term_sort) ? $category->term_sort : '0'; ?>" size="40"></td>
</tr>
<?php
}

add_action('category_edit_form_fields', 'extra_category_fields');

// Save extra category fields hook
function save_extra_category_fileds($term_id)
{
    global $wpdb;
    $sort = input_post('term_sort', 0);

    if (is_numeric($sort)) {
        $wpdb->update($wpdb->terms, ['term_sort' => $sort], ['term_id' => $term_id]);
    }
}

add_action('edited_category', 'save_extra_category_fileds');
