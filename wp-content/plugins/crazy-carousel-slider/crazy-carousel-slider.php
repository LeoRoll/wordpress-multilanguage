<?php

/*
  Plugin Name: Crazy-Themes Slider Carousel
  Description: Crazy Theme Default Carousel Slider.
  Version: 4.0
  Author: Crazy-themes
  Author URI: http://crazy-themes.com
 */

function crazy_carousel_slider_load_plugin() {

    add_action('init', 'carousel_slider_items_register');

    function carousel_slider_items_register() {
        $args = array(
            'label' => 'Carousel Slider',
            'public' => FALSE,
            'show_ui' => TRUE,
            'menu_position' => null,
            'rewrite' => true,
            'capability_type' => 'page',
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'labels' => array(
                'add_new_item' => 'Add New Slider',
                'edit' => 'Edit',
                'edit_item' => 'Edit Slider',
                'new_item' => 'New Slider',
            ),
            'menu_icon' => 'dashicons-analytics'
        );
        register_post_type('carousel-slider', $args);
    }

    add_filter("manage_edit-carousel_slider_columns", "carousel_slider_edit_columns");
    add_action("manage_posts_custom_column", "carousel_slider_columns_display");

    function carousel_slider_edit_columns($slider_columns) {
        $slider_columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Slide Title",
            "description" => "Description",
            'slider_image' => 'Image',
        );
        return $slider_columns;
    }

    function carousel_slider_columns_display($slider_columns) {
        switch ($slider_columns) {
            case "description":
                the_excerpt();
                break;
            case 'slider_image':
                the_post_thumbnail(array(60, 60));
                break;
        }
    }

    return true;
}

add_action('plugins_loaded', 'crazy_carousel_slider_load_plugin', 20);

