<?php

/***********
 * 方案管理 *
 ***********/
add_action('init', 'scheme_register');

function scheme_register() {
    register_post_type('scheme', array(
        'label' => __('Scheme', 'bin-go-web'),
        'singular_label' => __('Scheme', 'bin-go-web'),
        'public' => true,
        'menu_position' => 7,
        'query_var' => true,
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'schemes', 'with_front' => false),
        'edit_item' => __('Edit Scheme', 'bin-go-web'),
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'revisions'),
        'labels' => array('all_items' => __('All schemes', 'bin-go-web'), 'add_new' => __('Add new scheme', 'bin-go-web'),  'add_new_item' => __('Add new scheme', 'bin-go-web'), 'edit' => __('Edit', 'bin-go-web'), 'edit_item' => __('Edit scheme', 'bin-go-web'), 'new_item' => __('New scheme', 'bin-go-web'), 'view_item' => __('View', 'bin-go-web')),
        'menu_icon' => 'dashicons-analytics'
        )
    );

    register_taxonomy('scheme_category', 'scheme', array('hierarchical' => true,
        'label' => __('Scheme Categories', 'bin-go-web'),
        'singular_label' => __('Scheme Category', 'bin-go-web'),
        'public' => true,
        'show_in_nav_menus' => TRUE,
        'show_tagcloud' => false,
        'query_var' => true,
        'rewrite' => array('slug' => 'scheme_category', 'with_front' => false)
        )
    );
}

add_filter('manage_edit-scheme_columns', 'scheme_edit_columns');

add_action('manage_posts_custom_column', 'scheme_custom_columns');

function scheme_edit_columns($columns) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title', 'bin-go-web'),
        'scheme_category' => __('Category', 'bin-go-web'),
        'scheme_image' => __('Image Preview', 'bin-go-web')
    );
    return $columns;
}

function scheme_custom_columns($column) {
    global $post;
    switch ($column) {
        case "scheme_category":
            echo get_the_term_list($post->ID, 'scheme_category', '', ', ', '');
            break;
        case 'scheme_image':
            the_post_thumbnail(array(60, 60));
            break;
    }
}

function scheme_post_type_link_filter_function($post_link, $id = 0, $leavename = FALSE) {
    if (strpos('%scheme_category%', $post_link) < 0) {
        return $post_link;
    }
    $post = get_post($id);
    if (!is_object($post) || $post->post_type != 'scheme') {
        return $post_link;
    }

    $terms = wp_get_object_terms($post->ID, 'scheme_category');

    if (!$terms) {

        return str_replace('scheme_page/category/%scheme_category%/', '', $post_link);
    }

    return str_replace('%scheme_category%', $terms[0]->slug, $post_link);
}

add_filter('post_type_link', 'scheme_post_type_link_filter_function', 1, 3);

/**
 * Adds a meta box to the post editing screen
 */
function schemes_custom_meta() {
    add_meta_box( 'scheme_meta', __( '关联行业案例', 'bin-go-web' ), 'schemes_meta_callback', 'scheme', 'side', 'high');
}
add_action( 'add_meta_boxes', 'schemes_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function schemes_meta_callback( $post ) {
    // get portfolio list
    $args = array(
      'post_type' => 'portfolio',
      'posts_per_page' => -1,
      'orderby' => 'post_date',
      'order' => 'DESC'
    );
    $portfolios = get_posts($args);

    // var_dump($portfolios);

    // checked portfolios
    $checked_portfolios = array();

    $scheme_portfolios = get_post_meta($post->ID, 'scheme_portfolios');
    if ($scheme_portfolios && $scheme_portfolios[0]) {
        foreach ( $portfolios as $k => $v) {
            if ( in_array( $v->ID, $scheme_portfolios[0]) ) {
                $checked_portfolios[] = $v;
                unset( $portfolios[$k] );
            }
        }
    }

    if ($checked_portfolios) {

    }
?>
    <div id="portfolio-for-<?php echo $post->ID; ?>" class="categorydiv">
      <div id="portfolio-all" class="tabs-panel">
        <ul id="portfolio-checklist" class="categorychecklist form-no-clear">
    <?php
    foreach ($checked_portfolios as $key => $portfolio) :
    ?>
        <li style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" id="portfolio-<?php echo $portfolio->ID; ?>" class="popular-category"><label class="selectit"><input value="<?php echo $portfolio->ID; ?>" type="checkbox" name="scheme_portfolios[]" id="in-portfolio-<?php echo $portfolio->ID; ?>" checked> <?php echo $portfolio->post_title; ?></label></li>
    <?php
    endforeach;
    ?>
    <?php
    foreach ($portfolios as $key => $portfolio) :
    ?>
        <li style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" id="portfolio-<?php echo $portfolio->ID; ?>" class="popular-category"><label class="selectit"><input value="<?php echo $portfolio->ID; ?>" type="checkbox" name="scheme_portfolios[]" id="in-portfolio-<?php echo $portfolio->ID; ?>"> <?php echo $portfolio->post_title; ?></label></li>
    <?php
    endforeach;
    ?>
        </ul>
      </div>
    </div>
<?php
}

function save_scheme_portfolios($post_id) {
    if (wp_is_post_revision($post_id) or wp_is_post_autosave($post_id))
        return $post_id;

    if (isset($_POST['scheme_portfolios']))
        $data = $_POST['scheme_portfolios'];

    // var_dump($data);

    if (get_post_meta($post_id, 'scheme_portfolios') == "")
        add_post_meta($post_id, 'scheme_portfolios', $data, true);
    elseif ($data != get_post_meta($post_id, 'scheme_portfolios', true))
        update_post_meta($post_id, 'scheme_portfolios', $data);
    elseif ($data == "")
        delete_post_meta($post_id, 'scheme_portfolios', get_post_meta($post_id, 'scheme_portfolios', true));
}
add_action('save_post', 'save_scheme_portfolios');

