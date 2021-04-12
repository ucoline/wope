<?php
// Option element
function admin_theme_panel_option_element($args)
{
    $id = array_value($args, 'id');
    $type = array_value($args, 'type');
    $attrs = array_value($args, 'attrs');
    $items = array_value($args, 'items', array());
    $editor = array_value($args, 'editor', array());
    $option_value = get_option($id);

    if ($type == 'input') {
        echo '<input type="text" class="form-control" name="' . $id . '" id="' . $id . '" value="' . $option_value . '" ' . $attrs . ' />';
    } elseif ($type == 'number') {
        echo '<input type="number" class="form-control" name="' . $id . '" id="' . $id . '" value="' . $option_value . '" ' . $attrs . ' />';
    } elseif ($type == 'textarea') {
        echo '<textarea class="form-control" name="' . $id . '" id="' . $id . '" ' . $attrs . '>' . $option_value . '</textarea>';
    } elseif ($type == 'editor') {
        $editor['textarea_name'] = $id;
        wp_editor($option_value, $id, $editor);
    } elseif ($type == 'select' && is_array($items) && $items) {
        echo '<select name="' . $id . '" id="' . $id . '">';
        foreach ($items as $key => $value) {
            if ($option_value == $key) {
                echo '<option value="' . $key . '" selected>' . $value . '</option>';
            } else {
                echo '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        echo '</select>';
    } elseif (is_array($items) && $items && ($type == 'checkbox' || $type == 'radio')) {
        foreach ($items as $key => $value) {
            $checkboxid = $key . '-' . $key;

            echo '<div style="padding-bottom:5px;">';
            if ($option_value == $key) {
                echo '<input type="' . $type . '" id="' . $checkboxid . '" name="' . $id . '" value="' . $option_value . '" style="margin-top:0;" checked>';
            } else {
                echo '<input type="' . $type . '" id="' . $checkboxid . '" name="' . $id . '" value="' . $option_value . '" style="margin-top:0;">';
            }

            echo '<label for="' . $checkboxid . '" style="display:inline-block;">' . $value . '</label>';
            echo '</div>';
        }
    } elseif ($type == 'gallery') {
        echo '<div class="select-gallery-box">';
        echo '<div class="select-gallery-box-in">';
        echo '<input type="text" name="' . $id . '" class="select-gallery-input" id="' . $id . '" value="' . $option_value . '" ' . $attrs . '>';
        echo  '<button type="button" class="button button-primary btn-select-gallery">' . __('Select image', 'wope') . '</button>';
        echo '</div>';
        echo '<div class="select-gallery-box-img">';
        if (is_string($option_value) && !empty($option_value)) {
            echo '<img src="' . $option_value . '" alt="image" />';
        }
        echo '</div>';
        echo '</div>';
    }
}
