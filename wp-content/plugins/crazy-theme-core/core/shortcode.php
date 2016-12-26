<?php

//SHORTCODE
add_shortcode('container', 'crazy_container');
add_shortcode('row', 'crazy_row');
add_shortcode('one_full', 'crazy_one_full');
add_shortcode('one_half', 'crazy_one_half');
add_shortcode('one_third', 'crazy_one_third');
add_shortcode('one_fourth', 'crazy_one_fourth');
add_shortcode('one_sixth', 'crazy_one_sixth');
add_shortcode('two_third', 'crazy_two_third');
add_shortcode('three_fourth', 'crazy_three_fourth');
add_shortcode('five_sixth', 'crazy_five_sixth');
add_shortcode('list', 'crazy_list_shortcode'); //
add_shortcode('list_item', 'crazy_list_item_shortcode'); //
add_shortcode('accordion', 'crazy_accordion_shortcode'); //
add_shortcode('accordion_item', 'crazy_accordion_item_shortcode'); //
add_shortcode('pricetable', 'crazy_price_table_shortcode'); //
add_shortcode('faq', 'crazy_faq_shortcode'); //
add_shortcode('faq_item', 'crazy_faq_item_shortcode'); //
add_shortcode('team', 'crazy_team_shortcode'); //
add_shortcode('counter', 'crazy_counter_shortcode'); //
add_shortcode('justified_tabs', 'crazy_justified_tabs_shortcode'); //
add_shortcode('classic_tabs', 'crazy_classic_tabs_shortcode'); //
add_shortcode('tab', 'crazy_tab_shortcode'); //
add_shortcode('sbox', 'crazy_sbox_shortcode'); //
add_shortcode('feature_box', 'crazy_feature_box_shortcode'); //
add_shortcode('servicebox', 'crazy_servicebox_shortcode'); //
add_shortcode('servicebox2', 'crazy_servicebox2_shortcode'); //
add_shortcode('colored_box', 'crazy_colored_box_shortcode');
add_shortcode('googlemap', 'crazy_map_shortcode'); //
add_shortcode('quote', 'crazy_quote_shortcode'); //
add_shortcode('progressbar', 'crazy_progress_bar_shortcode'); //
add_shortcode('latest_posts', 'crazy_latest_posts_shortcode'); //
add_shortcode('posts_carousel', 'crazy_posts_carousel_shortcode'); //
add_shortcode('portfolio', 'crazy_portfolio_shortcode'); //
add_shortcode('portfolio_carousel', 'crazy_portfolio_carousel_shortcode'); //
add_shortcode('featured_portfolio_carousel', 'crazy_featured_portfolio_carousel_shortcode'); //
add_shortcode('testimonial', 'crazy_testimonial_shortcode'); //
add_shortcode('testimonial_slider', 'crazy_testimonial_slider_shortcode'); //
add_shortcode('blockquote', 'crazy_blockquote_shortcode');
add_shortcode('client_slider', 'crazy_client_slider_shortcode'); //
add_shortcode('client', 'crazy_client_shortcode'); //
add_shortcode('htitle', 'crazy_title_shortcode'); //
add_shortcode('social_icon', 'crazy_social_icon_shortcode'); //
add_shortcode('social_list', 'crazy_social_list_shortcode'); //
add_shortcode('mid_heading_sec', 'crazy_heading_sec_shortcode'); //
add_shortcode('full_section', 'crazy_full_section_shortcode');
add_shortcode('embed_media', 'crazy_embed_media_shortcode');
add_shortcode('section', 'crazy_section_shortcode');
add_shortcode('pre_shortcode', 'crazy_pre_shortcode_section');

function shortcodes_cleanup($content) {
    $shortcodes = join("|", array("container", "row", "one_half", "one_full", "one_third", "one_fourth", "one_sixth", "two_third", "three_fourth", "five_sixth",
        "list", "list_item", "counter", "sbox", "feature_box", "servicebox", "servicebox2", "mixslider", "mixslide", "testimonial", "testimonial_slider", "quote_slider", "quote", "button", "justified_tabs", "classic_tabs", "tab", "accordion",
        'accordion_item', 'pricetable', "colored_box", 'progressbar', 'latest_posts', "posts_carousel", 'portfolio', "portfolio_carousel", "featured_portfolio_carousel", 'googlemap', 'title_big', 'title_small', 'htitle', 'icon', 'blockquote',
        'faq', 'faq_item', 'team', "client_slider", "client", "social_list", "social_icon", "full_section", "mid_heading_sec", "embed_media", "section", "pre_shortcode"));

    $output = preg_replace("/(<p>)?\[($shortcodes)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);

    $output = preg_replace("/(<p>)?\[\/($shortcodes)](<\/p>|<br \/>)/", "[/$2]", $output);

    return $output;
}

add_filter('the_content', 'shortcodes_cleanup');
add_filter('widget_text', 'shortcodes_cleanup');
add_filter('widget_title', 'shortcodes_cleanup');

function crazy_row($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => " ",
                    ), $atts));
    return '<div class="row ' . $class . '">' . do_shortcode($content) . '</div>';
}

function crazy_container($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => " ",
                    ), $atts));
    return '<div class="container ' . $class . '">' . do_shortcode($content) . '</div>';
}

// Full
function crazy_one_full($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => " ",
                    ), $atts));
    return '<div class="col-md-12 ' . $class . '">' . do_shortcode($content) . '</div>';
}

// Half
function crazy_one_half($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => " ",
                    ), $atts));
    return '<div class="col-md-6 ' . $class . '">' . do_shortcode($content) . '</div>';
}

// Third
function crazy_one_third($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => " ",
                    ), $atts));
    return '<div class="col-md-4 ' . $class . '">' . do_shortcode($content) . '</div>';
}

function crazy_two_third($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => " ",
                    ), $atts));
    return '<div class="col-md-8 ' . $class . '">' . do_shortcode($content) . '</div>';
}

// Fourth
function crazy_one_fourth($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => " ",
                    ), $atts));
    return '<div class="col-md-3 ' . $class . '">' . do_shortcode($content) . '</div>';
}

function crazy_three_fourth($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => " ",
                    ), $atts));
    return '<div class="col-md-9 ' . $class . '">' . do_shortcode($content) . '</div>';
}

// Sixth
function crazy_one_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => " ",
                    ), $atts));
    return '<div class="col-md-2 ' . $class . '">' . do_shortcode($content) . '</div>';
}

function crazy_five_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => " ",
                    ), $atts));
    return '<div class="col-md-10 ' . $class . '">' . do_shortcode($content) . '</div>';
}

// List Shortcodes


function crazy_list_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "style" => " ",
                    ), $atts));
    return '<ul class="list-icon ' . $style . '">' . do_shortcode($content) . '</ul>';
}

// List Shortcodes


function crazy_list_item_shortcode($atts, $content = null) {
    return '<li>' . $content . '</li>';
}

// Slide Shortcode


function content_slider_shortcode($atts, $content = null) {
    $output = '<div class="slide_wrap flexslider"><ul class="slides">';
    $output .= do_shortcode($content);
    $output .= '</ul></div>';

    return $output;
}

function content_slides_shortcode($atts, $content = null) {
    return '<li>' . $content . '</li>';
}

// Testimonials Shortcode


function crazy_testimonial_shortcode($atts, $content = null) {
    global $post;
    extract(shortcode_atts(array(
        "author" => "",
        "pic" => ""
                    ), $atts));
    $output = '<div class="testimonial-item">';
    if ($pic):
        $output .= '<img src="' . $pic . '" class="customer-img img-responsive" alt="' . $author . '">';
    else:
        $output .= '<i class="fa fa-user"></i>';
    endif;
    $output .= '<h4><i class="fa fa-quote-left"></i> ' . do_shortcode($content) . ' <i class="fa fa-quote-right"></i> </h4>';
    $output .='<p>-' . $author . '</p>';
    $output .='</div>';

    return $output;
}

//
function crazy_testimonial_slider_shortcode($atts, $content = null) {
    $output = '<div id="testi-carousel" class="owl-carousel owl-spaced">';
    $output .= do_shortcode($content);
    $output .= '</div>';

    return $output;
}

// Button Shortcodes


function crazy_button_shortcode($atts) {
    extract(shortcode_atts(array(
        "text" => "Button",
        "size" => "", // xs, lg
        "txtcolor" => "",
        "bgcolor" => "",
                    ), $atts));
    return '<button class="btn btn-theme btn-' . $size . '" style="background:' . $bgcolor . ';color:' . $txtcolor . '">' . $text . '</button>';
}

// Quote Shortcode
function crazy_quote_slider_shortcode($atts, $content = null) {
    return '<div class="testimonials-big text-center marginbtm30"><ul class="slides">' . do_shortcode($content) . '</ul></div>';
}

function crazy_quote_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "author" => "",
        "pic" => "",
        "company" => "",
        "bgcolor" => "dark"
                    ), $atts));
    $output = '<div class="quote ' . $bgcolor . '"><blockquote><p>' . do_shortcode($content) . '</p></blockquote></div>';
    $output .= '<div class="quote-footer text-right"><div class="quote-author-img">';
    if ($pic):
        $output .= '<img src="' . $pic . '">';
    else:
        $output .= '<i class="fa fa-user"></i>';
    endif;
    $output .= '</div>';
    $output .= '<h4>' . $author . '</h4>';
    $output .= ' <p><strong>' . $company . '</strong></p>';
    $output .='</div>';

    return $output;
}

// Big Title Shortcode


function crazy_title_big_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => ""
                    ), $atts));
    $output = '<div class="section-heading text-center wow bounceIn"><h1>' . $title . '</h1>';
    $output .='<p>' . $content . '</p>';
    $output .= '<span class="heading-line"></span></div >';
    return $output;
}

// Small Title Shortcode


function crazy_title_small_shortcode($atts) {
    extract(shortcode_atts(array(
        "title" => "",
        "slogan" => ""
                    ), $atts));
    $output = '<div class = "col-heading"><h3>' . $title . '</h3>';
    if ($slogan)
        $output .= '<p>' . $slogan . '</p>';
    $output .= '<span class = "col-line"></span></div >';
    return $output;
}

// Heading Title Shortcode
function crazy_title_shortcode($atts, $content = null) {
    return '<h3 class="heading">' . do_shortcode($content) . '</h3>';
}

// Tab Shortcode
//justified TABS
function crazy_justified_tabs_shortcode($atts, $content = null) {
    $GLOBALS['tab_count'] = 0;
    do_shortcode($content);
    if (is_array($GLOBALS['tabs'])) {
        $i = 1;
        foreach ($GLOBALS['tabs'] as $tab) {
            $class = '';
            if ($i == 1)
                $class = "active";
            $tabs[] = '<li class = "' . $class . '"><a href = "#tab' . $i . '" data-toggle = "tab">' . $tab['title'] . '</a></li>';
            $panes[] = '<div class = "tab-pane ' . $class . '" id = "tab' . $i . '"><p>' . $tab['content'] . '</p></div>';
            $i++;
        }
        $output = '<div class="tabs"><ul class="nav nav-tabs nav-justified">' . implode("\n", $tabs) . '</ul>
    <div class = "tab-content">' . implode("\n", $panes) . '</div></div>';
    }
    return $output;
}

// Classic
function crazy_classic_tabs_shortcode($atts, $content = null) {
    $GLOBALS['tab_count'] = 0;
    do_shortcode($content);
    if (is_array($GLOBALS['tabs'])) {
        $i = 21;
        foreach ($GLOBALS['tabs'] as $tab) {
            $class = '';
            if ($i == 21)
                $class = "active";
            $tabs[] = '<li class = "' . $class . '"><a href = "#tab' . $i . '" data-toggle = "tab"><i class="fa ' . $tab['icon'] . '"></i> ' . $tab['title'] . '</a></li>';
            $panes[] = '<div class = "tab-pane ' . $class . '" id = "tab' . $i . '"><p>' . $tab['content'] . '</p></div>';
            $i++;
        }
        $output = '<div class="tabs"><ul class="nav nav-tabs">' . implode("\n", $tabs) . '</ul>
    <div class = "tab-content">' . implode("\n", $panes) . '</div></div>';
    }
    return $output;
}

function crazy_tab_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'tab' => '1',
        'icon' => 'fa-twitter',
                    ), $atts));

    $i = $GLOBALS['tab_count'];
    $GLOBALS['tabs'][$i] = array('title' => sprintf($title, $GLOBALS['tab_count']), 'content' => $content, 'icon' => $icon);
    $GLOBALS['tab_count'] ++;
}

// Accordion Shortcode


function crazy_accordion_shortcode($atts, $content = null) {
    $output = '<div id="accordion" class="panel-group">';
    $output .= do_shortcode($content);
    $output .= '</div>';

    return $output;
}

function crazy_accordion_item_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
        'icon' => 'fa-desktop'
                    ), $atts));
    $rand = rand(1, 10000);
    $active_class = '';
    $coll = 'collapsed';
    if ($title && in_array('open', $atts)) {
        $active_class = 'in';
        $coll = '';
    }
    $output = '<div class="panel panel-default">';
    $output.='<div class="panel-heading"><h4 class="panel-title">
        <a href="#' . $rand . '" data-parent="#accordion" data-toggle="collapse" aria-expanded="true" class="' . $coll . '">
        <i class="fa ' . $icon . '"></i>' . $title . '</a></h4></div>';
    $output.='<div class="panel-collapse collapse ' . $active_class . '" id="' . $rand . '" aria-expanded="true" role="tabpanel">
        <div class="panel-body"><p>' . $content . '</p></div></div>';
    $output.='</div>';


    return $output;
}

// Price Table Shortcode


function crazy_price_table_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "plan" => "PM",
        "url" => "#",
        "btn_text" => "Learn More",
        "price" => "0.00",
                    ), $atts));

    $active_class = '';
    $color_class = '';
    if ($plan && in_array('active', $atts)) {
        $active_class = 'popular';
        $color_class = 'btn-theme-bg';
    }
    $output = '<div class="pricing-simple ' . $active_class . '">';
    if ($active_class) {
        $output .= '<span class="ribbon">Popular</span>';
    }
    $output .= '<h4 class="price-title">' . $plan . '</h4>';
    $output .= '<h3><sup>$</sup> ' . $price . '<sub>/' . $plan . '</sub></h3>';
    $output .='<div class="price-features">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    $output .= ' <div class="bottom"><a href="' . $url . '" class="btn btn-default btn-lg btn-ico ' . $color_class . '">' . $btn_text . ' <i class="fa fa-angle-right"></i></a></div>';
    $output .= '</div>';
    return $output;
}

// Progress Bar Shortcode


function crazy_progress_bar_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => "",
        "value" => ""
                    ), $atts));
    $output = '<h3 class="heading-progress">' . $title . ' <span class="pull-right">' . $value . '%</span></h3>';
    $output .= '<div class="progress">';
    $output .= '<div class="progress-bar" style="width: ' . $value . '%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="' . $value . '" role="progressbar">';
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}

// Latest Posts Shortcode
function crazy_posts_carousel_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "limit" => "-1",
        "cats" => ""
                    ), $atts));
    $output = '<div id="news-carousel" class="owl-carousel owl-spaced">';
    if ($cats != '')
        $cats = explode(', ', $cats);
    $posts = new WP_Query(array('post_type' => 'post', 'posts_per_page' => $limit, 'category__in' => $cats));
    if ($posts->have_posts()):while ($posts->have_posts()):$posts->the_post();
            $pcats = get_the_category($posts->ID);
            $cat_name = '';
            $i = 1;
            $catcount = count($pcats);
            if ($pcats) {
                foreach ($pcats as $pcat) {
                    if ($i != $catcount) {
                        $cat_name .= $pcat->name . ", ";
                    } else {
                        $cat_name .= $pcat->name . "";
                    }
                    $i++;
                }
            }
            $output.= '<div class="margin30">';
            $output.= '<a href="' . get_permalink() . '"><div class="item-img-wrap">';
            $output.= get_the_post_thumbnail(get_the_ID(), 'post-thumbnail', array('class' => 'img-responsive'));
            $output.= '<div class="item-img-overlay"><span></span></div>';
            $output.= '</div></a>';
            $output.= '<div class="news-desc">';
            $output.= '<span>' . $cat_name . '</span><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
            $output.= '<span>By <a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . get_the_author() . '</a> on ' . get_the_date() . '</span> <span><a href="' . get_permalink() . '">Read more...</a></span>';
            $output.= '</div>';
            $output.= '</div>';
        endwhile;
    endif;
    wp_reset_query();
    $output .= '</div>';
    return $output;
}

function crazy_latest_posts_shortcode($atts) {
    extract(shortcode_atts(array(
        "limit" => "-1",
        "cats" => ""
                    ), $atts));
    $output = '';
    if ($cats != '')
        $cats = explode(', ', $cats);
    $posts = new WP_Query(array('post_type' => 'post', 'posts_per_page' => $limit, 'category__in' => $cats));
    if ($posts->have_posts()):while ($posts->have_posts()):$posts->the_post();
            $pcats = get_the_category($posts->ID);
            $cat_name = '';
            $i = 1;
            $catcount = count($pcats);
            if ($pcats) {
                foreach ($pcats as $pcat) {
                    if ($i != $catcount) {
                        $cat_name .= $pcat->name . ", ";
                    } else {
                        $cat_name .= $pcat->name . "";
                    }
                    $i++;
                }
            }
            $output.= '<div class="col-sm-4 margin30">';
            $output.= '<a href="' . get_permalink() . '"><div class="item-img-wrap">';
            $output.= get_the_post_thumbnail(get_the_ID(), 'post-thumbnail', array('class' => 'img-responsive'));
            $output.= '<div class="item-img-overlay"><span></span></div>';
            $output.= '</div></a>';
            $output.= '<div class="news-desc">';
            $output.= '<span>' . $cat_name . '</span><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
            $output.= '<span>By <a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . get_the_author() . '</a> on ' . get_the_date() . '</span> <span><a href="' . get_permalink() . '">Read more...</a></span>';
            $output.= '</div>';
            $output.= '</div>';
        endwhile;
    endif;
    wp_reset_query();
    return $output;
}

function crazy_portfolio_shortcode($atts) {
    extract(shortcode_atts(array(
        "limit" => "-1",
        "cat_align" => "center",
        "section_title" => ""
                    ), $atts));
    $portfolio_cats = get_categories(array('type' => 'portfolio', 'taxonomy' => 'portfolio_category', 'hierarchical' => 3));
    $output = '<div class="recent-project">';
    $output.= '<ul class="portfolio-filter filter list-inline" style="text-align:' . $cat_align . '">';
    $output.= '<li><a class="active" href="javascript:void(0)" data-filter="*">Show All</a></li>';
    if ($portfolio_cats) {
        foreach ($portfolio_cats as $portfolio_cat) {
            $output.= '<li><a data-filter=".' . $portfolio_cat->slug . '" href="javascript:void(0)">' . $portfolio_cat->name . '</a></li>';
        }
    }
    $output.= '</ul>';
    $portfolios = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => $limit));
    $output.= ' <div class="portfolio-box portfolio-wrap col-4-space">';
    if ($portfolios->have_posts()):
        while ($portfolios->have_posts()):$portfolios->the_post();
            $cats = wp_get_object_terms(get_the_ID(), 'portfolio_category');
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
            $big_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'assan-fullwidth');
            $big_image_url = $big_image[0];
            $output .='<div class="project-post ' . $cat_slugs . '">';
            $output .='<div class="img-icon">';
            $output .=get_the_post_thumbnail(get_the_ID(), 'post-thumbnail', array('class' => 'img-responsive', 'alt' => get_the_ID()));
            $output .='<div class="img-icon-overlay">';
            $output .='<p><a href="' . $big_image_url . '" class="show-image"><i class="fa fa-eye"></i></a><a href="' . get_permalink() . '"><i class="fa fa-sliders"></i></a></p>';
            $output .='</div>';
            $output .='</div>';
            $output .='<div class="work-desc">';
            $output .='<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            $output .='<span>' . $cat_name . '</span>';
            $output .='</div>';
            $output .='</div>';
        endwhile;
    endif;
    wp_reset_query();
    $output.= '</div></div>';
    return $output;
}

function crazy_portfolio_carousel_shortcode($atts) {
    extract(shortcode_atts(array(
        "limit" => "8"
                    ), $atts));
    $output = '<div id="work-carousel" class="owl-carousel owl-spaced">';
    $portfolios = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => $limit));
    if ($portfolios->have_posts()):
        while ($portfolios->have_posts()):$portfolios->the_post();
            $pccats = wp_get_object_terms(get_the_ID(), 'portfolio_category');
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
            $output .='<a href="' . $big_image_url . '" class="show-image"><span></span></a>';
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

function crazy_featured_portfolio_carousel_shortcode($atts) {
    extract(shortcode_atts(array(
        "limit" => "8"
                    ), $atts));
    $output = '<div id="featured-work">';
    $featured_portfolios = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => $limit));
    if ($featured_portfolios->have_posts()):
        while ($featured_portfolios->have_posts()):$featured_portfolios->the_post();
            $big_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'assan-fullwidth');
            $big_image_url = $big_image[0];
            $output .='<div class="item">';
            $output .='<div class="work-wrap">';
            $output .=get_the_post_thumbnail(get_the_ID(), 'post-thumbnail', array('class' => 'img-responsive', 'alt' => get_the_ID()));
            $output .='<div class = "img-overlay">';
            $output .='<div class = "inner-overlay">';
            $output .='<h2>' . get_the_title() . '</h2>';
            $output .='<p>' . get_the_date() . '</p>';
            $output .='<a class = "link" href = "' . get_permalink() . '"><i class = "fa fa-search"></i></a>';
            $output .='<a class = "zoom show-image" href = "' . $big_image_url . '"><i class = "fa fa-image"></i></a>';
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
            $output .='</div>';
        endwhile;
    endif;
    wp_reset_query();
    $output.= '</div>';
    return $output;
}

// Google Map Shortcode


function crazy_map_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "latitude" => "",
        "longitude" => "",
        "height" => ""
                    ), $atts));

    $latitude = $latitude ? $latitude : '38.8279255';
    $longitude = $longitude ? $longitude : '-104.814836';
    $height = $height ? $height : 'height:400px;
';

    $output = '<div id = "googlemapwrap" style = "width: 100%;' . $height . '"></div>';
    $output.="<script>
    function initialize() {
        var myLatlng = new google.maps.LatLng(" . $latitude . ", " . $longitude . ");
        var mapProp = {
            center: myLatlng,
            zoom: 8,
            scrollwheel: false,
            draggable: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP        };
        var map = new google.maps.Map(document.getElementById('googlemapwrap'), mapProp);
        marker = new google.maps.Marker({
            position: myLatlng,
            map: map
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>";
    return $output;
}

// Icon Shortcode


function crazy_icon_shortcode($atts) {
    extract(shortcode_atts(array(
        "class" => "fa-twitter",
                    ), $atts));
    return ' <i class = "fa ' . $class . ' "></i>';
}

// Service Box Shortcode


function crazy_feature_box_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => " ",
        "icon" => 'fa-heart-o'
                    ), $atts));
    $output = '<div class = "s-feature-box text-center">';
    $output.='<div class = "mask-top"><i class = "fa ' . $icon . '"></i><h4>' . $title . '</h4></div>';
    $output.='<div class = "mask-bottom"><i class = "fa ' . $icon . '"></i><h4>' . $title . '</h4><p>' . do_shortcode($content) . '</p></div>';
    $output.='</div>';

    return $output;
}

function crazy_servicebox_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => " ",
        "icon" => "fa-pencil"
                    ), $atts));
    $output = '<div class = "services-box wow animated fadeInUp" data-wow-delay = "0.1s">';
    $output .= '<div class = "services-box-icon"><h4>' . '<i class = "fa ' . $icon . '"></i>' . $title . '</h4></div>';
    $output .= '<div class = "services-box-info"><p>' . do_shortcode($content) . '</p></div>';
    $output .= '</div>';
    return $output;
}

function crazy_servicebox2_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => " ",
        "icon" => "fa-pencil"
                    ), $atts));
    $output = '<div class = "service-box text-center wow animated fadeInLeft animated" data-wow-delay = "0.2s">';
    $output .= '<i class = "fa ' . $icon . '"></i><h3 class="colored-text">' . $title . '</h3><span class = "section-line"></span>';
    $output .= '<p>' . do_shortcode($content) . '</p>';
    $output .= '</div>';
    return $output;
}

function crazy_colored_box_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => " ",
        "icon" => "fa-pencil",
        "icon_color" => "#2196f3"
                    ), $atts));
    $output = '<div class = "colored-boxed">';
    $output .= '<i class = "fa ' . $icon . '" style = "color:' . $icon_color . ';border-color:' . $icon_color . '"></i>';
    $output .= '<h3>' . $title . '</h3>';
    $output .= '<span class = "center-line"></span>';
    $output .= '<p>' . do_shortcode($content) . '</p>';
    $output .= '</div>';
    return $output;
}

// Blockquote Shortcode


function crazy_blockquote_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "author" => " "), $atts));
    return '<blockquote><p>' . $content . '</p><cite title = "' . $author . '" class = "small">' . $author . '</cite></blockquote>';
}

// Faq Shortcode

function crazy_faq_shortcode($atts, $content = null) {
    $output = '<div id = "accordion" class = "panel-group">';
    $output .= do_shortcode($content);
    $output .= '</div>';

    return $output;
}

function crazy_faq_item_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'title' => ''
                    ), $atts));
    $rand = rand(1, 10000);
    $active_class = '';
    $coll = 'collapsed';
    if ($title && in_array('open', $atts)) {
        $active_class = 'in';
        $coll = '';
    }
    $output = '<div class = "panel panel-default">';
    $output.='<div class = "panel-heading"><h4 class = "panel-title">
<a href = "#faq' . $rand . '" data-parent = "#accordion" data-toggle = "collapse" aria-expanded = "true" class = "' . $coll . '">' . $title . '</a></h4></div>';
    $output.='<div class = "panel-collapse collapse ' . $active_class . '" id = "faq' . $rand . '" aria-expanded = "true" role = "tabpanel">
<div class = "panel-body"><p>' . $content . '</p></div></div>';
    $output.='</div>';


    return $output;
}

//TEAM SHORTCODE
function crazy_team_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "name" => "",
        "pic" => "",
        "dept" => "",
        "facebook" => "#",
        "twitter" => "#",
        "google" => "#",
        "pinterest" => ""), $atts));
    $output = '<div class = "team-wrap">';
    if ($pic):
        $output.='<img src = "' . $pic . '" class = "img-responsive" alt = "' . $name . '">';
    endif;
    $output.='<h4>' . $name . '</h4>';
    $output.='<span>' . $dept . '</span>';
    $output.='<p>' . do_shortcode($content) . '</p>';
    $output.='<ul class = "list-inline">';
    if ($facebook):
        $output.='<li><a href = "' . $facebook . '" class = "social-icon social-icon-sm si-border si-facebook"><i class = "fa fa-facebook"></i><i class = "fa fa-facebook"></i></a></li>';
    endif;
    if ($twitter):
        $output.=' <li><a href = "' . $twitter . '" class = "social-icon social-icon-sm si-border si-twitter"><i class = "fa fa-twitter" ></i><i class = "fa fa-twitter" ></i></a></li>';
    endif;
    if ($google):
        $output.=' <li><a href = "' . $google . '" class = "social-icon social-icon-sm si-border si-g-plus"><i class = "fa fa-google-plus"></i><i class = "fa fa-google-plus"></i></a></li>';
    endif;
    $output.='</ul>';
    $output.='</div>';
    return $output;
}

//counter
function crazy_counter_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => "",
        'count' => "1465",
        "icon" => "fa-coffee"), $atts));
    $output = '<div class = "col-md-3 margin20 facts-in">
<h3><i class = "fa ' . $icon . '"></i><span class = "counter">' . $count . '</span></h3>
<h4>' . $title . '</h4>
</div>';
    return $output;
}

//Heading sec
function crazy_heading_sec_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => ""), $atts));

    $output = '<div class = "center-heading wow bounceIn">';
    $output.='<h2>' . $title . '</h2><span class = "center-line"></span>';
    $output.='<p class = "lead">' . $content . '</p>';
    $output.='</div>';
    return $output;
}

function crazy_social_list_shortcode($atts, $content = null) {
    $output = '<ul class = "list-inline social_icon_list">';
    $output.=do_shortcode($content);
    $output.='</ul>';
    return $output;
}

//Social Icons
function crazy_social_icon_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "url" => "#", "icon" => "", "size" => "", "style" => "", "bg" => ""), $atts));
    if ($bg == 'colored'):
        $bg = ' si-dark si-colored-' . $icon;
    endif;
    if ($icon == 'email') {
        $icon = 'envelope';
    }
    $output = '<li>';
    $output.='<a href = "' . $url . '" class = "social-icon ' . $size . ' ' . $style . ' ' . $bg . ' si-border si-' . $icon . '">';
    $output.='<i class = "fa fa-' . $icon . '"></i><i class = "fa fa-' . $icon . '"></i>';
    $output.=' </a>';
    $output.='</li>';
    return $output;
}

function crazy_sbox_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => "", "icon" => "fa-gamepad"), $atts));

    $output = '<div class = "me-hobbies">';
    $output.='<h4><i class = "fa ' . $icon . '"></i> ' . $title . '</h4>';
    $output.='<p>' . do_shortcode($content) . '</p>';
    $output.='</div>';
    return $output;
}

//FULLWIDTH SECTION

function crazy_full_section_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "bg_image" => "",
        "bg_color" => "",
        "height" => "",
        "padding" => "",
        "class" => "",
        "paddingbtm" => ""), $atts));
    if ($bg_image) {
        $style = 'background: url(' . $bg_image . ');
';
    } else {
        $style = 'background-color:' . $bg_color . ';
';
    }
    if ($height):
        $style .= 'height:' . $height . 'px;
';
    endif;
    if ($paddingbtm != ''):
        $style.='padding-top:' . $padding . 'px;
padding-bottom:' . $paddingbtm . 'px;
';
    else:
        $style.='padding:' . $padding . 'px 0px;
';
    endif;

    return '<section class = "parallax ' . $class . '" style = "' . $style . '" data-stellar-background-ratio = "0.5">' . do_shortcode($content) . '</section>';
}

//Heading sec
function crazy_embed_media_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "src" => "",
        "height" => "",
        "width" => ""), $atts));

    return '<div class = "embed-responsive embed-responsive-16by9"><iframe src = "' . $src . '" height = "' . $height . '" width = "' . $width . '"></iframe></div>';
}

function crazy_client_slider_shortcode($atts, $content = null) {
    return '<div id = "clients-slider"> ' . do_shortcode($content) . '</div>';
}

function crazy_client_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "img" => "", "url" => "#"), $atts));
    if ($img):
        return ' <div class = "item"><a href = "' . $url . '"><img src = "' . $img . '" alt = "client" class = "img-responsive"></a></div>';
    else :
        return TRUE;
    endif;
}

function crazy_section_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => "",
        "class" => ""), $atts));

    return '<div class = "' . $class . '" id = "' . $id . '">' . do_shortcode($content) . '</div>';
}

function crazy_pre_shortcode_section($atts, $content = null) {
    return $content;
}
