<?php
//INCLUDE FILES
require get_template_directory() . '/admin/theme_options.php';
require get_template_directory() . '/lib/custom-fields.php';
require get_template_directory() . '/lib/class-tgm-plugin-activation.php';

// Cleaning up the Wordpress Head
function assan_head_cleanup() {
// remove header links
    remove_action('wp_head', 'feed_links_extra', 3);                    // Category Feeds
    remove_action('wp_head', 'feed_links', 2);                          // Post and Comment Feeds
    remove_action('wp_head', 'rsd_link');                               // EditURI link
    remove_action('wp_head', 'wlwmanifest_link');                       // Windows Live Writer
    remove_action('wp_head', 'index_rel_link');                         // index link
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);            // previous link
    remove_action('wp_head', 'start_post_rel_link', 10, 0);             // start link
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // Links for Adjacent Posts
    remove_action('wp_head', 'wp_generator');                           // WP version
}

// launching operation cleanup
add_action('init', 'assan_head_cleanup');

//READ MORE LINK
if (!function_exists('assan_excerpt_more') && !is_admin()) :

    function assan_excerpt_more($more) {
        $link = sprintf('<p><br/><a href="%1$s" class="read-more-link">%2$s</a></p>', esc_url(get_permalink(get_the_ID())), sprintf(__('Read more...', 'assan')));
        return $link;
    }

    add_filter('excerpt_more', 'assan_excerpt_more');

endif;

function custom_excerpt_length($length) {
    return 100;
}

add_filter('excerpt_length', 'custom_excerpt_length', 999);

// Numeric Page Navi (built into the theme by default)
function assan_page_navi($before = '', $after = '') {
    global $wpdb, $wp_query;
    $request = $wp_query->request;
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $paged = intval(get_query_var('paged'));
    $numposts = $wp_query->found_posts;
    $max_page = $wp_query->max_num_pages;
    if ($numposts <= $posts_per_page) {
        return;
    }
    if (empty($paged) || $paged == 0) {
        $paged = 1;
    }
    $pages_to_show = 7;
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor($pages_to_show_minus_1 / 2);
    $half_page_end = ceil($pages_to_show_minus_1 / 2);
    $start_page = $paged - $half_page_start;
    if ($start_page <= 0) {
        $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if (($end_page - $start_page) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }
    if ($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }
    if ($start_page <= 0) {
        $start_page = 1;
    }
    echo $before . '<ul class="pagination">' . "";
    if ($paged > 1) {
        $first_page_text = "&laquo";
        echo '<li class="prev"><a href="' . get_pagenum_link() . '" title="First">' . $first_page_text . '</a></li>';
    }
    $prevposts = get_previous_posts_link('&larr; Previous');
    if ($prevposts) {
        echo '<li>' . $prevposts . '</li>';
    } else {
        echo '<li class="disabled"><a href="#">&larr; Previous</a></li>';
    }
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $paged) {
            echo '<li class="active"><a href="#">' . $i . '</a></li>';
        } else {
            echo '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
        }
    }
    echo '<li class="">';
    next_posts_link('Next &rarr;');
    echo '</li>';
    if ($end_page < $max_page) {
        $last_page_text = "&raquo;";
        echo '<li class="next"><a href="' . get_pagenum_link($max_page) . '" title="Last">' . $last_page_text . '</a></li>';
    }
    echo '</ul>' . $after . "";
}

//MENU START
function assan_main_nav() {
/*    $main_menu_key='primary_nav';
    
    if (get_locale() == 'en_US') {
        $main_menu_key = 'english_nav';
    }*/  //2016年12月23日09:19:22

    wp_nav_menu(
            array(
                'menu' => 'primary_nav', /* menu name */
                'menu_class' => 'nav navbar-nav navbar-right',
                'theme_location' => 'primary_nav', /* where in the theme it's assigned */
                'container' => 'false', /* container class */
                // 'depth' => '3',
                'walker' => new assan_Bootstrap_walker()
            )
    );
}

function assan_main_center_nav() {
    wp_nav_menu(
            array(
                'menu' => 'primary_nav', /* menu name */
                'menu_class' => 'nav navbar-nav',
                'theme_location' => 'primary_nav', /* where in the theme it's assigned */
                'container' => 'false', /* container class */
                // 'depth' => '3',
                'walker' => new assan_Bootstrap_walker()
            )
    );
}

function assan_onepage_nav() {
    wp_nav_menu(
            array(
                'menu' => 'onepage_nav', /* menu name */
                'menu_class' => 'nav navbar-nav navbar-right scroll-to',
                'theme_location' => 'onepage_nav', /* where in the theme it's assigned */
                'container' => 'false', /* container class */
                // 'depth' => '2',  suppress lower levels for now
                'walker' => new Assan_OnePage_Bootstrap_walker()
            )
    );
}

class assan_Bootstrap_walker extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = Array()) {
        $tabs = str_repeat("\t", $depth);
// If we are about to start the first submenu, we need to give it a dropdown-menu class
        if ($depth == 0 || $depth == 1) { //really, level-1 or level-2, because $depth is misleading here (see note above)
            $output .= "\n{$tabs}<ul class=\"dropdown-menu\">\n";
        } else {
            $output .= "\n{$tabs}<ul>\n";
        }
        return;
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth == 0) { // This is actually the end of the level-1 submenu ($depth is misleading here too!)
// we don't have anything special for Bootstrap, so we'll just leave an HTML comment for now
            $output .= '<!--.dropdown-->';
        }
        $tabs = str_repeat("\t", $depth);
        $output .= "\n{$tabs}</ul>\n";
        return;
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
        $class_names = $value = '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        /* If this item has a dropdown menu, add the 'dropdown' class for Bootstrap */
        if ($item->hasChildren) {
            $classes[] = 'dropdown';
// level-1 menus also need the 'dropdown-submenu' class
            if ($depth == 1) {
                $classes[] = 'dropdown-submenu';
            }
        }

        /* This is the stock Wordpress code that builds the <li> with all of its attributes */
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
        $class_names = ' class="' . esc_attr($class_names) . '"';
        $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $item_output = $args->before;

        /* If this item has a dropdown menu, make clicking on this link toggle it */
        if ($item->hasChildren && $depth == 0) {
            $item_output .= '<a' . $attributes . ' class="dropdown-toggle" data-toggle="dropdown">';
        } else {
            $item_output .= '<a' . $attributes . '>';
        }

        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;

        /* Output the actual caret for the user to click on to toggle the menu */
        if ($item->hasChildren && $depth == 0) {
//$item_output .= '<b class="caret"></b></a>';
            $item_output .= '</a>';
        } else {
            $item_output .= '</a>';
        }

        $item_output .= $args->after;
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        return;
    }

    function end_el(&$output, $item, $depth = 0, $args = array()) {
        $output .= '</li>';
        return;
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
// check whether this item has children, and set $item->hasChildren accordingly
        $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

// continue with normal behavior
        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

}

class Assan_OnePage_Bootstrap_walker extends Walker_Nav_Menu {

    function start_el(&$output, $object, $depth = 0, $args = Array(), $current_object_id = 0) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
        $class_names = $value = '';
        $drop_class = "";
        if ($args->has_children) {
            $class_names = "dropdown ";
            $drop_class = "dropdown-toggle";
        }
        $classes = empty($object->classes) ? array() : (array) $object->classes;
        $class_names .= join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $object));
        $class_names = ' class="' . esc_attr($class_names) . '"';
        $attributes = !empty($object->attr_title) ? ' title="' . esc_attr($object->attr_title) . '"' : '';
        $attributes .=!empty($object->target) ? ' target="' . esc_attr($object->target) . '"' : '';
        $attributes .=!empty($object->xfn) ? ' rel="' . esc_attr($object->xfn) . '"' : '';
        $item_output = $args->before;
        if ($object->object == 'onepage') {
            $post_object = get_post($object->object_id);
            $enable_item = get_post_meta($object->object_id, "_assan_onepage_disable_menu", true);
            if ($enable_item != 'Y') {
                $output .= $indent . '<li id="menu-item-' . $object->ID . '"' . $value . $class_names . '>';
                $attributes .= ' href="#' . $post_object->post_name . '" class="' . $drop_class . '"';
                if ($args->has_children) {
                    $attributes .= ' data-toggle="dropdxown"';
                }
                $item_output .= '<a' . $attributes . '>';
                $item_output .= $args->link_before . apply_filters('the_title', $object->title, $object->ID);
                $item_output .= $args->link_after;
                $item_output .= '</a>';
                $item_output .= $args->after;
            }
        } else {
            $output .= $indent . '<li id="menu-item-' . $object->ID . '"' . $value . $class_names . '>';
            $attributes .=!empty($object->url) ? ' href="' . esc_attr($object->url) . '" class="' . $drop_class . '"' : '';
            if ($args->has_children) {
                $attributes .= ' data-toggle="dropdown"';
            }
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters('the_title', $object->title, $object->ID);
            $item_output .= $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
        }
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $object, $depth, $args);
    }

    function end_el(&$output, $object, $depth = 0, $args = Array()) {
        $enable_item = get_post_meta($object->object_id, "_assan_onepage_disable_menu", true);
        if ($enable_item != 'Y')
            $output .= "</li>\n";
    }

    function start_lvl(&$output, $depth = 0, $args = Array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
        $id_field = $this->db_fields['id'];
        if (is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);
        }
        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

}

//MENU END
//Breadcrumbs
function the_breadcrumb($post_type = '') {
    global $post;
    // $categories_list = get_the_category_list(_x(', ', 'Used between list items, there is a space after the comma.', 'assan'));
    $categories_list = '';
    $categories = [];
    $query_cats = array('category');
    $post_type = get_post_type($post);
    if ($post_type && $post_type != 'post') {
        $query_cats[] = $post_type . '_category';
    }

    $object_terms = wp_get_object_terms($post->ID, $query_cats);
    foreach ($object_terms as $index => $object_term) {
        $categories[] = '<a href="' . get_category_link($object_term -> term_id) . '" title="' . $object_term->name . '">' . $object_term->name . '</a>';
    }
    $categories_list = join(',', $categories);
    if (!is_front_page()) {
        echo '<li><a href="' . home_url() . '">' . __('Home', 'assan') . '</a></li>';
        if (is_home() && is_category()) {
            if (get_post_type() == 'post'):
                echo '<li>';
                single_cat_title('');
                echo '</li>';
            endif;
        }
        elseif (is_single()) {
            if ($post->post_type != 'post') {
                echo '<li>';
                printf('<span class="entry-cat"><a href="%2$s">%1$s</a></span>', __($post->post_type, 'assan'), get_post_type_archive_link($post->post_type));
                echo '</li>';
            }
            if ($categories_list) {
                echo '<li>';
                printf('<span class="entry-cat">%1$s</span>', $categories_list);
                echo '</li>';
            }
        } elseif (is_page()) {
            if ($post->post_parent) {
                $anc = get_post_ancestors($post->ID);
                $title = get_the_title();
                foreach ($anc as $ancestor) {
                    $output = '<li><a href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                }
                echo $output;
                echo '<li><strong title="' . $title . '"> ' . $title . '</strong></li>';
            } else {
                echo '<li><strong> ' . get_the_title() . '</strong></li>';
            }
        } elseif (is_home()) {
            echo '<li>' . get_the_title(get_option('page_for_posts')) . '</li>';
        } elseif (is_tag()) {
            single_tag_title();
        } elseif (is_day()) {
            echo"<li>Archive for " . get_the_date('F jS, Y') . '</li>';
        } elseif (is_month()) {
            echo"<li>Archive for " . get_the_date('F, Y') . '</li>';
        } elseif (is_year()) {
            echo"<li>Archive for " . get_the_date('Y') . '</li>';
        } elseif (is_author()) {
            echo"<li>Author Archive</li>";
        } elseif (is_search()) {
            echo '<li>'. __('Search Results', 'assan') .'</li>';
        } else {
            $queried_tax = get_queried_object()->taxonomy;
            if ($queried_tax) {
                $queried_post_type = split('_', $queried_tax)[0];
                echo '<li>';
                printf('<span class="entry-cat"><a href="%2$s">%1$s</a></span>', __($queried_post_type, 'assan'), get_post_type_archive_link($queried_post_type));
                echo '</li>';
            }
        }
    }
}

// ADD CUSTOM CSS/JS on head

function assan_custom_style() {
    global $ctassan_data;
    if ($ctassan_data['favi_image'])
        echo '<link rel="shortcut icon" href="' . $ctassan_data['favi_image'] . '" />' . "\n";
    if ($ctassan_data['custom_css'])
        echo '<style type="text/css">' . $ctassan_data['custom_css'] . '</style>' . "\n";
    if ($ctassan_data['custom_js'])
        echo '<script>' . $ctassan_data['custom_js'] . '</script>' . "\n";
}

add_action('wp_head', 'assan_custom_style');

//ADD SLIDER
function assan_render_themeslider_element() {
    global $post;
    if (is_single() || is_page()) :
        $active_slider = '';
        if ($post):
            $active_slider = get_post_meta($post->ID, '_assan_slider', TRUE);
        endif;
        if ($active_slider == 'flex') {
            if (function_exists('flex_slider_items_register')) {
                get_template_part('lib/flex', 'slider');
            } else {
                echo "Active Theme Flex slider";
            }
        }
        if ($active_slider == 'carousel'):
            get_template_part('lib/carousel', 'slider');
        endif;
        if ($active_slider == 'revolution') {
            $rev_slider_id = get_post_meta($post->ID, '_assan_rev_slider', TRUE);
            if ($rev_slider_id && class_exists('RevSlider')) {
                echo '<div id="rev-primary-slider">';
                echo do_shortcode("[rev_slider alias='$rev_slider_id']");
                echo '</div>';
                echo '<div class="row header-shadow"></div>';
            }
        }
    endif;
}

add_action('assan_theme_slider', 'assan_render_themeslider_element');

if (!function_exists('assan_posted_on')) :

    function assan_posted_on() {
        if (is_singular()) :
            assan_full_posted_on();
        else:
            assan_default_posted_on();
        endif;
    }

endif;

function assan_full_posted_on() {
    if ('post' == get_post_type()) {

        printf('<li class="byline"><i class = "fa fa-user"></i> <a href="%1$s">%2$s</a></li>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), get_the_author());

        printf('<li><span class="meta-separator">|</span><span class="entry-date"><i class="fa fa-calendar"></i> ' . get_the_date() . '</span></li>');

        $categories_list = get_the_category_list(_x(', ', 'Used between list items, there is a space after the comma.', 'assan'));
        if ($categories_list) {
            printf('<li><span class="meta-separator">|</span><span class="entry-cat"><i class="fa fa-folder-open"></i> %1$s</span></li>', $categories_list
            );
        }
        if (!post_password_required() && ( comments_open() || get_comments_number() )) {
            if (get_comments_number() == 0 || get_comments_number() == NULL):
                $commentno = 'No';
            else:
                $commentno = get_comments_number();
            endif;
            echo '<li><span class="meta-separator">|</span><span class="entry-comments"><i class="fa fa-comment"></i> ' . $commentno . ' Comments</span></li>';
        }
        $tags_list = get_the_tag_list('', _x(', ', 'Used between list items, there is a space after the comma.', 'assan'));
        if ($tags_list) {
            printf('<li><span class="meta-separator">|</span><span class="entry-cat"><i class="fa fa-tags"></i> %1$s</span></li>', $tags_list
            );
        }
    }
}

function assan_default_posted_on() {
    //if ('post' == get_post_type()) {

        printf('<li class="byline"><i class = "fa fa-user"></i> <a href="%1$s">%2$s</a></li>', esc_url(get_author_posts_url(get_the_author_meta('ID'))), get_the_author());

        printf('<li><span class="meta-separator">|</span><span class="entry-date"><i class="fa fa-calendar"></i> ' . get_the_date() . '</span></li>');

        $categories_list = get_the_category_list(_x(', ', 'Used between list items, there is a space after the comma.', 'assan'));
        if ($categories_list) {
            printf('<li><span class="meta-separator">|</span><span class="entry-cat"><i class="fa fa-folder-open"></i> %1$s</span></li>', $categories_list
            );
        }
    //}
}

//COMMENT FORM
function assan_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(array('col-md-12')); ?> id="li-comment-<?php comment_ID() ?>">
        <div class="comment-list">
            <h4><?php echo get_avatar($comment, $size = '70'); ?>
                By <?php comment_author($comment->comment_ID); ?> <span class="btn btn-xs btn-theme-dark"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
            </h4>
            <?php comment_text() ?>
        </div>
        <?php
    }

    if (!function_exists('assan_comment_nav')) :

        function assan_comment_nav() {
            // Are there comments to navigate through?
            if (get_comment_pages_count() > 1 && get_option('page_comments')) :
                ?>
                <ul class="pager comments-link">
                    <?php
                    if ($prev_link = get_previous_comments_link(__('Older Comments', 'assan'))) :
                        printf('<li class="previous">%s</li>', $prev_link);
                    endif;

                    if ($next_link = get_next_comments_link(__('Newer Comments', 'assan'))) :
                        printf('<li class="next">%s</li>', $next_link);
                    endif;
                    ?>
                </ul>
                <?php
            endif;
        }

    endif;

    /*     * **********************INSTALL PLUGIN********************************** */

    add_action('tgmpa_register', 'assan_register_required_plugins');

    function assan_register_required_plugins() {
        $plugins = array(
// This is an example of how to include a plugin pre-packaged with a theme.
            array(
                'name' => 'Crazy Theme Core', // The plugin name.
                'slug' => 'crazy-theme-core', // The plugin slug (typically the folder name).
                'source' => get_stylesheet_directory() . '/plugin/crazy-theme-core.zip', // The plugin source.
                'required' => true, // If false, the plugin is only 'recommended' instead of required.
                'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
                'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                'external_url' => '', // If set, overrides default API URL and points to an external URL.
            ),
            array(
                'name' => 'Revolution slider', // The plugin name.
                'slug' => 'revslider', // The plugin slug (typically the folder name).
                'source' => get_stylesheet_directory() . '/plugin/revslider.zip', // The plugin source.
                'required' => true, // If false, the plugin is only 'recommended' instead of required.
                'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
                'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                'external_url' => '', // If set, overrides default API URL and points to an external URL.
            ),
            array(
                'name' => 'Crazy-Themes Flex Slider', // The plugin name.
                'slug' => 'crazy-flex-slider', // The plugin slug (typically the folder name).
                'source' => get_stylesheet_directory() . '/plugin/crazy-flex-slider.zip', // The plugin source.
                'required' => true, // If false, the plugin is only 'recommended' instead of required.
                'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
                'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                'external_url' => '', // If set, overrides default API URL and points to an external URL.
            ),
            array(
                'name' => 'Crazy-Themes Slider Carousel', // The plugin name.
                'slug' => 'crazy-carousel-slider', // The plugin slug (typically the folder name).
                'source' => get_stylesheet_directory() . '/plugin/crazy-carousel-slider.zip', // The plugin source.
                'required' => true, // If false, the plugin is only 'recommended' instead of required.
                'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
                'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                'external_url' => '', // If set, overrides default API URL and points to an external URL.
            ),
            array(
                'name' => 'Crazy-Themes OnePage', // The plugin name.
                'slug' => 'crazy-one-page', // The plugin slug (typically the folder name).
                'source' => get_stylesheet_directory() . '/plugin/crazy-one-page.zip', // The plugin source.
                'required' => FALSE, // If false, the plugin is only 'recommended' instead of required.
                'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
                'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                'external_url' => '', // If set, overrides default API URL and points to an external URL.
            ),
            array(
                'name' => 'Contact Form 7',
                'slug' => 'contact-form-7',
                'required' => true,
            ),
            array(
                'name' => 'Mailchimp',
                'slug' => 'mailchimp-for-wp',
                'required' => FALSE,
            )
        );
        $config = array(
            'id' => 'assan_install_plugins', // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '', // Default absolute path to pre-packaged plugins.
            'menu' => 'assan-install-plugins', // Menu slug.
            'has_notices' => true, // Show admin notices or not.
            'dismissable' => true, // If false, a user cannot dismiss the nag message.
            'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false, // Automatically activate plugins after installation or not.
            'message' => '', // Message to output right before the plugins table.
            'strings' => array(
                'page_title' => __('Install Required Plugins', 'tgmpa'),
                'menu_title' => __('Install Plugins', 'tgmpa'),
                'installing' => __('Installing Plugin: %s', 'tgmpa'), // %s = plugin name.
                'oops' => __('Something went wrong with the plugin API.', 'tgmpa'),
                'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'tgmpa'), // %1$s = plugin name(s).
                'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'tgmpa'), // %1$s = plugin name(s).
                'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tgmpa'), // %1$s = plugin name(s).
                'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tgmpa'), // %1$s = plugin name(s).
                'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tgmpa'), // %1$s = plugin name(s).
                'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tgmpa'), // %1$s = plugin name(s).
                'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'tgmpa'), // %1$s = plugin name(s).
                'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tgmpa'), // %1$s = plugin name(s).
                'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins', 'tgmpa'),
                'activate_link' => _n_noop('Begin activating plugin', 'Begin activating plugins', 'tgmpa'),
                'return' => __('Return to Required Plugins Installer', 'tgmpa'),
                'plugin_activated' => __('Plugin activated successfully.', 'tgmpa'),
                'complete' => __('All plugins installed and activated successfully. %s', 'tgmpa'), // %s = dashboard link.
                'nag_type' => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            )
        );
        tgmpa($plugins, $config);
    }

