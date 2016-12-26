<?php

/***********
 * 产品管理 *
 ***********/
add_action('init', 'product_register');

function product_register() {
    register_post_type('product', array(
        'label' => __('Product', 'bin-go-web'),
        'singular_label' => __('Product', 'bin-go-web'),
        'public' => true,
        'menu_position' => 6,
        'query_var' => true,
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'products', 'with_front' => false),
        'edit_item' => __('Edit Product', 'bin-go-web'),
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'revisions'),
        'labels' => array('all_items' => __('All products', 'bin-go-web'), 'add_new' => __('Add new product', 'bin-go-web'),  'add_new_item' => __('Add new product', 'bin-go-web'), 'edit' => __('Edit', 'bin-go-web'), 'edit_item' => __('Edit product', 'bin-go-web'), 'new_item' => __('New product', 'bin-go-web'), 'view_item' => __('View', 'bin-go-web')),
        'menu_icon' => 'dashicons-lightbulb'
        )
    );

    register_taxonomy('product_category', 'product', array('hierarchical' => true,
        'label' => __('Product Categories', 'bin-go-web'),
        'singular_label' => __('Product Category', 'bin-go-web'),
        'public' => true,
        'show_in_nav_menus' => TRUE,
        'show_tagcloud' => false,
        'query_var' => true,
        'rewrite' => array('slug' => 'product_category', 'with_front' => false)
        )
    );
}

add_filter('manage_edit-product_columns', 'product_edit_columns');

add_action('manage_posts_custom_column', 'product_custom_columns');

function product_edit_columns($columns) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title', 'bin-go-web'),
        'product_category' => __('Category', 'bin-go-web'),
        'product_image' => __('Image Preview', 'bin-go-web')
    );
    return $columns;
}

function product_custom_columns($column) {
    global $post;
    switch ($column) {
        case "product_category":
            echo get_the_term_list($post->ID, 'product_category', '', ', ', '');
            break;
        case 'product_image':
            the_post_thumbnail(array(60, 60));
            break;
    }
}

function product_post_type_link_filter_function($post_link, $id = 0, $leavename = FALSE) {
    if (strpos('%product_category%', $post_link) < 0) {
        return $post_link;
    }
    $post = get_post($id);
    if (!is_object($post) || $post->post_type != 'product') {
        return $post_link;
    }

    $terms = wp_get_object_terms($post->ID, 'product_category');

    if (!$terms) {

        return str_replace('product_page/category/%product_category%/', '', $post_link);
    }

    return str_replace('%product_category%', $terms[0]->slug, $post_link);
}

add_filter('post_type_link', 'product_post_type_link_filter_function', 1, 3);

/**
 * Adds a meta box to the post editing screen
 */
function products_custom_meta() {
    add_meta_box( 'product_meta', __( '关联行业案例', 'bin-go-web' ), 'products_meta_callback', 'product', 'side', 'high');
}
add_action( 'add_meta_boxes', 'products_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function products_meta_callback( $post ) {
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

    $product_portfolios = get_post_meta($post->ID, 'product_portfolios');
    if ($product_portfolios && $product_portfolios[0]) {
        foreach ( $portfolios as $k => $v) {
            if ( in_array( $v->ID, $product_portfolios[0]) ) {
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
        <li style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" id="portfolio-<?php echo $portfolio->ID; ?>" class="popular-category"><label class="selectit"><input value="<?php echo $portfolio->ID; ?>" type="checkbox" name="product_portfolios[]" id="in-portfolio-<?php echo $portfolio->ID; ?>" checked> <?php echo $portfolio->post_title; ?></label></li>
    <?php
    endforeach;
    ?>
    <?php
    foreach ($portfolios as $key => $portfolio) :
    ?>
        <li style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" id="portfolio-<?php echo $portfolio->ID; ?>" class="popular-category"><label class="selectit"><input value="<?php echo $portfolio->ID; ?>" type="checkbox" name="product_portfolios[]" id="in-portfolio-<?php echo $portfolio->ID; ?>"> <?php echo $portfolio->post_title; ?></label></li>
    <?php
    endforeach;
    ?>
        </ul>
      </div>
    </div>
<?php
}

function save_product_portfolios($post_id) {
    if (wp_is_post_revision($post_id) or wp_is_post_autosave($post_id))
        return $post_id;

    if (isset($_POST['product_portfolios']))
        $data = $_POST['product_portfolios'];

    // var_dump($data);

    if (get_post_meta($post_id, 'product_portfolios') == "")
        add_post_meta($post_id, 'product_portfolios', $data, true);
    elseif ($data != get_post_meta($post_id, 'product_portfolios', true))
        update_post_meta($post_id, 'product_portfolios', $data);
    elseif ($data == "")
        delete_post_meta($post_id, 'product_portfolios', get_post_meta($post_id, 'product_portfolios', true));
}
add_action('save_post', 'save_product_portfolios');

