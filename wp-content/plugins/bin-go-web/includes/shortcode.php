<?php

//SHORTCODE
add_shortcode('latest_text_posts', 'bingo_latest_text_posts_shortcode'); //
add_shortcode('图片新闻', 'bingo_latest_image_posts_shortcode'); //
add_shortcode('文字新闻', 'bingo_latest_text_posts_content_shortcode'); //
add_shortcode('clickable_title', 'bingo_clickable_title_shortcode'); //
add_shortcode('图片轮播', 'bingo_owl_carousel_shortcode'); //
add_shortcode('相关方案列表', 'bingo_portfolio_categories_shortcode'); //
add_shortcode('解决方案轮播', 'bingo_scheme_carousel_shortcode'); //

function the_shortcodes_cleanup($content) {
    $shortcodes = join("|", array("latest_text_posts", "latest_image_posts", "clickable_title"));

    $output = preg_replace("/(<p>)?\[($shortcodes)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);

    $output = preg_replace("/(<p>)?\[\/($shortcodes)](<\/p>|<br \/>)/", "[/$2]", $output);

    return $output;
}

add_filter('the_content', 'the_shortcodes_cleanup');
add_filter('widget_text', 'the_shortcodes_cleanup');
add_filter('widget_title', 'the_shortcodes_cleanup');

function bingo_latest_text_posts_content_shortcode($atts) {
    extract(shortcode_atts(array(
        "limit" => "-1",
        "cats" => ""), $atts));
    $output = '';
    $index = 0;
    $posts = new WP_Query(array('post_type' => 'post', 'posts_per_page' => $limit, 'category_name' => $cats));
    if ($posts->have_posts()):
      while ($posts->have_posts()):$posts->the_post();
        if (!has_post_thumbnail()) :
            if ($index > 0) :
            $output .= '<hr style="margin: 10px 0px; ">';
            endif;
            $index++;
            $output.= get_the_content();
        endif;
      endwhile;
    endif;
    wp_reset_query();
    return $output;
}

function bingo_latest_text_posts_shortcode($atts) {
    extract(shortcode_atts(array(
        "limit" => "-1",
        "cats" => ""), $atts));
    $output = '';
    $posts = new WP_Query(array('post_type' => 'post', 'posts_per_page' => $limit, 'category_name' => $cats));
    if ($posts->have_posts()):
      $output.= '<ul class="news-short-list">';
      while ($posts->have_posts()):$posts->the_post();
        $output.= '<li><a href="' . get_permalink() . '"><i class="fa fa-angle-right colored-text"></i>';
        $output.= get_the_title();
        $output.= '</a>';
        $output.= '<span class="pull-right">';
        $output.= '[' . get_the_date('m-d') . ']</span></li>';
      endwhile;
      $output.= '</ul>';
    endif;
    wp_reset_query();
    return $output;
}

function bingo_latest_image_posts_shortcode($atts) {
    extract(shortcode_atts(array(
        "limit" => "-1",
        "cats" => "",
        "interval" => "3000",
        "divid" => "image-news-carousel"), $atts));
    $output = '<div id="' . $divid . '" class="owl-carousel controlls-over">';
    $posts = new WP_Query(
      array('post_type' => 'post',
            'posts_per_page' => $limit,
            'category_name' => $cats,
            'meta_query' => array(array('key' => '_thumbnail_id'))
    ));
    if ($posts->have_posts()):
      while ($posts->have_posts()):$posts->the_post();
        $output.= '<div><div class="owl-caption text-left">';
        $output.= '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
        $output.= '<p class="hidden-xs">' . get_the_excerpt() . '</p></div>';
        $output.= get_the_post_thumbnail(get_the_ID(), 'post-thumbnail', array('class' => 'img-responsive'));
        $output.= '</div>';
      endwhile;
    endif;
    wp_reset_query();
    $output .= '</div>';
    return $output;
}

function bingo_clickable_title_shortcode($atts) {
    extract(shortcode_atts(array("slug" => ""), $atts));
    $cat = get_category_by_slug($slug);
    $output = '<div class="clickable-heading">';
    $output .= '<h3><span class="left-line"></span>';
    $output .= $cat->name;
    $output .= '</h3>';
    $output .= '<span class="more-btn"><a href="'. get_category_link($cat->cat_ID) . '">more&nbsp;<i class="fa fa-angle-double-right"></i></a></span>';
    $output .= '</div>';
    return  $output;
}

function bingo_owl_carousel_shortcode($atts) {
    extract(shortcode_atts(array(
        "limit" => "-1",
        "images" => "",
        "interval" => "3000",
        "divid" => "images-owl-carousel"), $atts));
    $images_arr = split(",", $images);
    $output = '<div id="' . $divid . '" class="owl-carousel controlls-over custom-owl-carousel">';
    foreach ($images_arr as $key => $image) {
        $output.= '<div>';
        $output.= '<img src="' . $image . '" class="img-responsive" />';
        $output.= '</div>';
    }
    $output .= '</div>';
    return $output;
}

function bingo_portfolio_categories_shortcode($atts) {
    extract(shortcode_atts(array(
        "columns" => "3"), $atts));
    global $post;
    $product_portfolios = get_post_meta($post->ID, 'product_portfolios');
    $object_terms = [];

    if ($product_portfolios && $product_portfolios[0]) {
        foreach ($product_portfolios[0] as $product_portfolio_id) {
            $product_portfolio = get_post($product_portfolio_id);
            $portfolio_terms = wp_get_object_terms($product_portfolio->ID, 'portfolio_category');

            foreach ($portfolio_terms as $portfolio_term) {
                $object_terms[$portfolio_term->term_id] = $portfolio_term;
            }
        }
    }

    // $object_terms = wp_get_object_terms($post->ID, 'portfolio_category');
    // var_dump($object_terms);
    $chunk_terms = array_chunk($object_terms, $columns);

    $output = '<ul class="list-icon list-check">';
    foreach ($chunk_terms as $terms) {
        $output .= '<li class="colored-text">';
        foreach ($terms as $key => $term) {
            if ($key > 0) {
                 $output .= __(', ', 'bin-go-web');
            }
            $output .= '<a href="' . get_category_link($term->term_id) . '" title="' . $term->name . '">' . $term->name . '</a>';
        }
        $output .= '</li>';
    }
    $output .= '</ul>';

    return $output;
}

function bingo_scheme_carousel_shortcode($atts) {
    extract(shortcode_atts(array(
        "limit" => "8"
                    ), $atts));
    $output = '<div id="work-carousel" class="owl-carousel owl-spaced">';
    $portfolios = new WP_Query(array('post_type' => 'scheme', 'posts_per_page' => $limit, 'orderby' => 'post_date', 'order' => 'DESC'));
    if ($portfolios->have_posts()):
        while ($portfolios->have_posts()):$portfolios->the_post();
            $pccats = wp_get_object_terms(get_the_ID(), 'scheme_category');
            $pcat_name = '';
            $i = 1;
            $catcount = count($pccats);
            if ($pccats) {
                foreach ($pccats as $pcat) {
                    if ($i != $catcount) {
                        $pcat_name .= $pcat->name . ", ";
                    } else {
                        $pcat_name .= $pcat->name . "";
                    }
                    $i++;
                }
            }
            $big_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'assan-fullwidth');
            $big_image_url = $big_image[0];
            $output .='<div>';
            $output .='<div class="item-img-wrap ">';
            $output .=get_the_post_thumbnail(get_the_ID(), 'post-thumbnail', array('class' => 'img-responsive', 'alt' => get_the_ID()));
            $output .='<div class="item-img-overlay">';
            $output .='<a href="' . get_permalink() . '"><span></span></a>';
            $output .='</div>';
            $output .='</div>';
            $output .=' <div class="work-desc"> <h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3><span>' . $pcat_name . '</span></div>';
            $output .='</div>';
        endwhile;
    endif;
    wp_reset_query();
    $output.= '</div>';
    return $output;
}

