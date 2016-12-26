<?php

/*
 * Portfolio
 */
add_action('init', 'portfolio_register');

function portfolio_register() {
    register_post_type('portfolio', array(
        'label' => __('Portfolio', 'assan'),
        'singular_label' => __('Portfolio', 'assan'),
        'public' => true,
        'menu_position' => 5,
        'query_var' => true,
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'portfolios', 'with_front' => false),
        'edit_item' => __('Edit Portfolio', 'assan'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'),
        'taxonomies' => array('post_tag'),
        'labels' => array('all_items' => __('All portfolios', 'assan'), 'add_new' => __('Add new portfolio', 'assan'), 'add_new_item' => __('Add new portfolio', 'assan'), 'edit' => __('Edit', 'assan'), 'edit_item' => __('Edit portfolio', 'assan'), 'new_item' => __('New portfolio', 'assan'), 'view_item' => __('View', 'assan')),
        'menu_icon' => 'dashicons-portfolio'
        )
    );

    register_taxonomy('portfolio_category', 'portfolio', array('hierarchical' => true,
        'label' => __('Portfolio Categories', 'assan'),
        'singular_label' => __('Portfolio Category', 'assan'),
        'public' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => false,
        'query_var' => true,
        'rewrite' => array('slug' => 'portfolio_category', 'with_front' => false, 'hierarchical' => true)
        )
    );
}

add_filter('manage_edit-portfolio_columns', 'portfolio_edit_columns');

add_action('manage_posts_custom_column', 'portfolio_custom_columns');

function portfolio_edit_columns($columns) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title', 'assan'),
        'portfolio_category' => __('Category', 'assan'),
        'portfolio_image' => __('Image Preview', 'assan'),
    );
    return $columns;
}

function portfolio_custom_columns($column) {
    global $post;
    switch ($column) {
        case "portfolio_category":
            echo get_the_term_list($post->ID, 'portfolio_category', '', ', ', '');
            break;
        case 'portfolio_image':
            the_post_thumbnail(array(60, 60));
            break;
    }
}

function my_post_type_link_filter_function($post_link, $id = 0, $leavename = FALSE) {
    if (strpos('%portfolio_category%', $post_link) < 0) {
        return $post_link;
    }

    $post = get_post($id);
    if (!is_object($post) || $post->post_type != 'portfolio') {
        return $post_link;
    }

    $terms = wp_get_object_terms($post->ID, 'portfolio_category');
    if (!$terms) {
        return str_replace('portfolio_page/category/%portfolio_category%/', '', $post_link);
    }

    return str_replace('%portfolio_category%', $terms[0]->slug, $post_link);
}

add_filter('post_type_link', 'my_post_type_link_filter_function', 1, 3);
