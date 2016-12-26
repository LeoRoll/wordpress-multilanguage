<?php
get_header();
global $post;
// $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$portfolio_per_page = $ctassan_data['portfolio_per_page'];
$portfolio_categories = get_categories(array('type' => 'portfolio', 'taxonomy' => 'portfolio_category', 'hierarchical' => 3));
$show_filter = $ctassan_data['portfolio_filter'];
// product portfolios
$product_portfolios = get_post_meta($post->ID, 'product_portfolios');
?>

<div class="breadcrumb-wrap">
    <div class="container">
        <h3><?php the_title(); ?></h3>
        <ol class="breadcrumb">
            <?php the_breadcrumb(); ?>
        </ol>
    </div>
</div>
<div class="divide30"></div>
<div class="container">
    <?php
    if (have_posts()): while (have_posts()):the_post();
            $cats = wp_get_object_terms($post->ID, 'product_category');
            $cat_name = '';
            $i = 1;
            $catcount = count($cats);
            if ($cats) {
                foreach ($cats as $cat) {
                    if ($i != $catcount) {
                        $cat_name .= $cat->name . " / ";
                    } else {
                        $cat_name .= $cat->name . "";
                    }
                    $i++;
                }
            }
            ?>
            <div class="row">
                <div class="product-detail">
                    <?php
                    the_content();
                    ?>
                </div>
            </div>
            <?php
        endwhile;
    endif;
    ?>
    <?php
    if ($product_portfolios && $product_portfolios[0]) :
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="center-heading">
                <h2>产品相关案例</h2>
                <span class="center-line"></span>
            </div>
            <?php if ($show_filter == 'YES'): ?>
                <ul class="portfolio-filter filter list-inline">
                    <li><a href="javascript:void(0)" class="active" data-filter="*"><?php echo __('Show All', 'assan'); ?></a></li>
                    <?php
                    if ($portfolio_categories) {
                        foreach ($portfolio_categories as $portfolio_categorie) {
                            echo ' <li><a data-filter=".' . $portfolio_categorie->slug . '" href="javascript:void(0)">' . $portfolio_categorie->name . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="portfolio-box portfolio-wrap col-4-space">
            <?php
            foreach ($product_portfolios[0] as $key => $product_portfolio_id) {
                $product_portfolio = get_post($product_portfolio_id);

                $cats = wp_get_object_terms($product_portfolio->ID, 'portfolio_category');
                $cat_slugs = '';
                $cat_name = '';
                $i = 1;
                $catcount = count($cats);
                if ($cats) {
                    foreach ($cats as $cat) {
                        if ($i != $catcount) {
                            $cat_name .= $cat->name . ", ";
                        } else {
                            $cat_name .= $cat->name . "";
                        }
                        $cat_slugs .= $cat->slug . " ";
                        $i++;
                    }
                }
            ?>
            <div id="post-<?php echo $product_portfolio->ID; ?>" <?php post_class(array('project-post', $cat_slugs)); ?>>
                <div class="item-img-wrap ">
                    <?php
                    $big_image = wp_get_attachment_image_src(get_post_thumbnail_id($product_portfolio->ID), 'assan-fullwidth');
                    $big_image_url = $big_image[0];
                    echo get_the_post_thumbnail($product_portfolio->ID, 'post-thumbnail', array('class' => 'img-responsive'));
                    ?>
                    <div class="item-img-overlay">
                        <a href="<?php echo $big_image_url; ?>" class="show-image">
                            <span></span>
                        </a>
                    </div>
                </div>
                <div class="work-desc">
                    <?php if ($product_portfolio->post_content) : ?>
                    <h3><a href="<?php echo get_post_permalink($product_portfolio->ID); ?>"><?php echo $product_portfolio->post_title; ?></a></h3>
                    <?php else : ?>
                    <h3><?php echo $product_portfolio->post_title; ?></h3>
                    <?php endif; ?>
                    <span><?php echo $cat_name; ?></span>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<div class="divide30"></div>
<?php get_footer(); ?>
