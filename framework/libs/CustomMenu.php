<?php
/**
 * Custom Menu
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link        https://github.com/ucoline/wope
 * @since       1.0.0
 */

namespace Libs;

class CustomMenu
{
    private $menus;
    private $deep;
    private $menu_items;
    private $current_object_id;

    public function __construct($location, $args = array())
    {
        // Get menu from redis
        $redis_menu = false;
        $redis_key = "custom-menu-". $location;
        $redis_json = Redis::get($redis_key);

        if (!is_null($redis_json) && !empty($redis_json)) {
            $redis_menu = json_decode($redis_json);
        }

        if ($redis_menu) {
            $this->menu_items = $redis_menu;
        } else {
            $this->init($location, $redis_key);
        }

        $this->location = $location;
        $this->current_object_id = get_queried_object_id();

        // Configure
        $this->config($args);
    }

    private function init($location, $redis_key)
    {
        // Get all locations
        $locations = get_nav_menu_locations();

        // Get object id by location
        $object = wp_get_nav_menu_object($locations[$location]);

        // Get menu items by menu name
        $this->menu_items = wp_get_nav_menu_items($object->name);

        // Set to redis
        Redis::set($redis_key, json_encode($this->menu_items));
    }

    private function config($args)
    {
        $deep = array_value($args, 'deep', 10);
        $tpl_path = array_value($args, 'tpl_path');
        $menu_id = array_value($args, 'menu_id');
        $menu_class = array_value($args, 'menu_class');

        $this->path = false;
        $this->path_name = false;

        $this->deep = is_numeric($deep) ? $deep : 10;

        $this->_menu_id = is_string($menu_id) ? $menu_id : 'menu-'. $this->location;
        $this->_menu_class = is_string($menu_class) && $menu_class ? $menu_class : 'nav menu-'. $this->location;

        if ($tpl_path && is_dir(base_path($tpl_path))) {
            $this->path_name = trim($tpl_path, '/');
            $this->path = base_path($tpl_path) . DS;
        }
    }

    public function get($as_array = false)
    {
        if ($this->menu_items) {
            $this->menus = $this->buildTree($this->menu_items, 0);

            if ($as_array) {
                return $this->menus;
            } else {
                $items = $this->_draw($this->menus);

                $data = array(
                    'location' => $this->location,
                    'menu_id' => $this->_menu_id,
                    'menu_class' => $this->_menu_class,
                    'wrapper' => $items,
                );

                $this->outer_view($data);
            }
        }
    }

    private function _draw(array &$elements, $parent = 0, $level = 0)
    {
        $level++;
        $output = '';

        foreach ($elements as &$element) {
            if ($element['menu_item_parent'] == $parent) {
                $item = $element;
                $item['data'] = $element;
                $children = $element['childs'];

                if ($children) {
                    $childs = $this->_draw($children, $element['ID'], $level);

                    $data = array(
                        'location' => $this->location,
                        'menu_id' => $this->_menu_id,
                        'menu_class' => $this->_menu_class,
                        'wrapper' => $childs,
                    );

                    $item['wrapper'] = $this->inner_view($level, $data);
                } else {
                    $item['wrapper'] = false;
                }

                $output .= $this->item_view($level, $item);
                unset($element);
            }
        }

        return $output;
    }

    private function buildTree(array &$elements, $parent = 0, $level = 0)
    {
        $output = array();
        $level++;

        foreach ($elements as &$element) {
            if ($element->menu_item_parent == $parent && $level <= $this->deep) {
                $item = $this->_set_menu_item($element, $level);

                $children = $this->buildTree($elements, $element->ID, $level);

                if ($children) {
                    $item['childs'] = $children;
                }

                $output[$element->ID] = $item;
                unset($element);
            }
        }

        return $output;
    }

    private function _set_menu_item($menu, $level = 1)
    {
        $item = array();
        $item['ID'] = $menu->ID;
        $item['title'] = $menu->title;
        $item['url'] = $menu->url;
        $item['object_id'] = $menu->object_id;
        $item['object'] = $menu->object;
        $item['type'] = $menu->type;
        $item['type_label'] = $menu->type_label;
        $item['menu_item_parent'] = $menu->menu_item_parent;
        $item['target'] = $menu->target;
        $item['attr_title'] = $menu->attr_title;
        $item['description'] = $menu->description;

        if ($this->current_object_id == $menu->object_id) {
            $item['current_item'] = true;
            $menu->classes[] = 'current-menu-item';
        } else {
            $item['current_item'] = false;
            $menu->classes = $menu->classes;
        }

        $item['classes'] = trim(implode(' ', $menu->classes));

        if ($menu->classes) {
            $classes = array();

            foreach ($menu->classes as $ckey => $class) {
                if ($class) {
                    $classes[$ckey] = $class;
                }
            }

            $item['classes_list'] = $classes;
        } else {
            $item['classes_list'] = array();
        }

        $item['childs'] = array();

        return $item;
    }

    private function outer_view($data = array(), $view = false)
    {
        $filename_theme = "{$this->path_name}/outer.php";

        if ($this->path && is_file(base_path($filename_theme))) {
            return base_path($this->path_name . '/outer', $data, $view);
        } else {
            return app_view('libs/custom-menu/outer', $data, $view);
        }
    }

    private function item_view($level, $data = array())
    {
        $app_file = "libs/custom-menu/item-{$level}.php";

        if ($this->path) {
            $theme_file = "{$this->path_name}/item.php";
            $theme_file2 = "{$this->path_name}/item-{$level}.php";

            if (is_file(base_path($theme_file2))) {
                return base_path($this->path_name . '/item-' . $level, $data, true);
            } elseif (is_file(base_path($theme_file))) {
                return base_path($this->path_name . '/item', $data, true);
            }
        }

        if (is_file(app_path($app_file))) {
            return app_view('libs/custom-menu/item-' . $level, $data, true);
        } else {
            return app_view('libs/custom-menu/item', $data, true);
        }
    }

    private function inner_view($level, $data = array())
    {
        $app_file = "libs/custom-menu/inner-{$level}.php";

        if ($this->path) {
            $theme_file = "{$this->path_name}/inner.php";
            $theme_file2 = "{$this->path_name}/inner-{$level}.php";

            if (is_file(base_path($theme_file2))) {
                return base_path($this->path_name . '/inner-' . $level, $data, true);
            } elseif (is_file(base_path($theme_file))) {
                return base_path($this->path_name . '/inner', $data, true);
            }
        }

        if (is_file(app_path($app_file))) {
            return app_view('libs/custom-menu/inner-' . $level, $data, true);
        } else {
            return app_view('libs/custom-menu/inner', $data, true);
        }
    }
}
