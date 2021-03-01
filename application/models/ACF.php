<?php
/**
 * ACF Model
 * Docs: https://www.advancedcustomfields.com/resources/acf_register_block_type/
 * Tutorial: https://www.advancedcustomfields.com/blog/acf-5-8-introducing-acf-blocks-for-gutenberg/
 *
 * @package     Wope - Starter theme for wordpress
 * @author      Ucoline <hello@ucoline.com>
 * @link        https://github.com/ucoline/wope
 * @since       1.0.0
 */

namespace Models;

class ACF
{
    // Init ACF Blocks
    public function init()
    {
        acf_register_block(array(
            'name' => 'icon-box',
            'title' => 'Icon box',
            'description' => 'Icon box block.',
            'render_callback' => 'acf_block_render_callback',
            'category' => 'formatting',
            'icon' => 'align-full-width',
            'keywords' => array('testimonial', 'quote'),
        ));

        acf_register_block(array(
            'name' => 'home-slider',
            'title' => 'Home slider',
            'description' => 'Home slider block.',
            'render_callback' => 'acf_block_render_callback',
            'category' => 'formatting',
            'icon' => 'align-full-width',
            'keywords' => array('slider', 'home'),
        ));

        acf_register_block(array(
            'name' => 'reasons',
            'title' => 'Reasons',
            'description' => 'Reasons block.',
            'render_callback' => 'acf_block_render_callback',
            'category' => 'formatting',
            'icon' => 'align-full-width',
            'keywords' => array('reason', 'home'),
        ));

        acf_register_block(array(
            'name' => 'company-profile',
            'title' => 'Company profile',
            'description' => 'Company profile block.',
            'render_callback' => 'acf_block_render_callback',
            'category' => 'formatting',
            'icon' => 'align-full-width',
            'keywords' => array('reason', 'home'),
        ));
    }
}
