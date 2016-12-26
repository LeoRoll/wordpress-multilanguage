<?php
if (!isset($content_width)) {
    $content_width = 660;
}
define('ASSAN_SKIN_PATH', get_template_directory_uri() . '/');
define('ASSAN_ADMIN_URL', get_template_directory_uri() . '/admin/');

if (!function_exists('assan_setup')) :

    function assan_setup() {
        global $themename, $ctassan_data;
        $themename = 'Assan';

        $ctassan_data = get_option('assan_theme_options');

        load_theme_textdomain('assan', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        add_theme_support('post-thumbnails');

        set_post_thumbnail_size(768, 512, true);

        add_image_size('assan-fullwidth', 1140, 512, true);

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary_nav' => __('Primary Menu', 'assan'),
            'onepage_nav' => __('OnePage Menu', 'assan'),
            //'english_nav' => __('English Menu', 'assan')//2016年12月23日09:17:56
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
        ));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/editor-style.css'));

        add_theme_support('woocommerce');
    }

endif; // assan_setup
add_action('after_setup_theme', 'assan_setup');

/**
 * Register widget area.
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function assan_widgets_init() {

    global $ctassan_data;
    $footer_layout = $ctassan_data['footer_layout'];

    require get_template_directory() . '/lib/widgets.php';
    register_widget('assan_Portfolio_widget');
    register_widget('assan_Social_Widgets');

    register_sidebar(array(
        'name' => __('Primary Sidebar', 'assan'),
        'id' => 'primary-sidebar',
        'description' => __('Main sidebar.', 'assan'),
        'before_widget' => '<div id="%1$s" class="widget sidebar-box margin40 %2$s ">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Sidebar 1', 'assan'),
        'id' => 'sidebar-1',
        'description' => __('Additional sidebar 1.', 'assan'),
        'before_widget' => '<div id="%1$s" class="widget sidebar-box margin40 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Sidebar 2', 'assan'),
        'id' => 'sidebar-2',
        'description' => __('Additional sidebar 2.', 'assan'),
        'before_widget' => '<div id="%1$s" class="widget sidebar-box margin40 %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
    register_sidebar(array(
        'name' => __('Left Header Top', 'assan'),
        'id' => 'leftpreheader',
        'description' => __('Left Pre Header Sidebar.', 'assan'),
        'before_widget' => '<div id="%1$s" class="top-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="header-top-title">',
        'after_title' => '</div>',
    ));
    register_sidebar(array(
        'name' => __('Right Header Top', 'assan'),
        'id' => 'rightpreheader',
        'description' => __('Right Pre Header Sidebar..', 'assan'),
        'before_widget' => '<div id="%1$s" class="top-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="header-top-title">',
        'after_title' => '</div>',
    ));
    for ($i = 1; $i <= $footer_layout; $i++) {
        register_sidebar(array(
            'name' => 'Footer Widget Area ' . $i,
            'id' => 'footer-' . $i,
            'description' => __('Appears in the footer section of the site.', 'assan'),
            'before_widget' => '<div id="%1$s" class="widget footer-col %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
    }
}

add_action('widgets_init', 'assan_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function assan_scripts() {
    wp_enqueue_style('bootstrap', ASSAN_SKIN_PATH . 'bootstrap/css/bootstrap.min.css', array(), '3.3.5');
    //wp_enqueue_style('font-Open-Sans', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700,800');
    // wp_enqueue_style('font-Source-Sans-Pro', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,900,700,600,400italic,300italic,300');
    //Font Awesome
    wp_enqueue_style('font-awesome', ASSAN_SKIN_PATH . 'font-awesome/css/font-awesome.min.css');
    //Flexslider
    wp_enqueue_style('flexslider', ASSAN_SKIN_PATH . 'css/flexslider.css');
    //Animate
    wp_enqueue_style('animate', ASSAN_SKIN_PATH . 'css/animate.css');
    //Owl carousel
    wp_enqueue_style('owl.carousel', ASSAN_SKIN_PATH . 'css/owl.carousel.css');
    wp_enqueue_style('owl.theme', ASSAN_SKIN_PATH . 'css/owl.theme.css');
    //magnific-popup
    wp_enqueue_style('magnific-popup', ASSAN_SKIN_PATH . 'css/magnific-popup.css');
    wp_enqueue_style('bootstrap-select', ASSAN_SKIN_PATH . 'css/bootstrap-select.min.css');
    //Main Style
    wp_enqueue_style('assan-main-style', ASSAN_SKIN_PATH . 'css/styles.css');
    //Theme skin color stylesheet
    wp_enqueue_style('assan-skin', ASSAN_SKIN_PATH . 'css/skin.php');
    // Load our main stylesheet.
    wp_enqueue_style('assan-style', get_stylesheet_uri());

    //SCRIPT
    wp_enqueue_script('jquery');
    wp_enqueue_script('masonry');
    wp_enqueue_script('bootstrap.min', ASSAN_SKIN_PATH . 'bootstrap/js/bootstrap.min.js', '', '', TRUE);
    wp_enqueue_script('jquery-easing', ASSAN_SKIN_PATH . 'js/jquery.easing.1.3.min.js', '', '', TRUE);
    wp_enqueue_script('jquery.sticky', ASSAN_SKIN_PATH . 'js/jquery.sticky.js', '', '', TRUE);
    wp_enqueue_script('flexslider.min', ASSAN_SKIN_PATH . 'js/jquery.flexslider-min.js', '', '', TRUE);
    wp_enqueue_script('owl.carousel.min', ASSAN_SKIN_PATH . 'js/owl.carousel.min.js', '', '', TRUE);
    wp_enqueue_script('isotope.min', ASSAN_SKIN_PATH . 'js/jquery.isotope.min.js', '', '', TRUE);
    wp_enqueue_script('waypoints.min', ASSAN_SKIN_PATH . 'js/waypoints.min.js', '', '', TRUE);
    wp_enqueue_script('jquery.countdown', ASSAN_SKIN_PATH . 'js/jquery.countdown.min.js', '', '', TRUE);
    wp_enqueue_script('jquery.counterup.min', ASSAN_SKIN_PATH . 'js/jquery.counterup.min.js', '', '', TRUE);
    wp_enqueue_script('jquery.stellar.min', ASSAN_SKIN_PATH . 'js/jquery.stellar.min.js', '', '', TRUE);
    wp_enqueue_script('jquery-magnific-popup', ASSAN_SKIN_PATH . 'js/jquery.magnific-popup.min.js', '', '', TRUE);
    wp_enqueue_script('bootstrap-hover-dropdown.min', ASSAN_SKIN_PATH . 'js/bootstrap-hover-dropdown.min.js', '', '', TRUE);
    wp_enqueue_script('wow.min', ASSAN_SKIN_PATH . 'js/wow.min.js', '', '', TRUE);
    wp_enqueue_script('assan-script', ASSAN_SKIN_PATH . 'js/scripts.js', array('jquery', 'masonry'), '', TRUE);
    // wp_enqueue_script('google_map', 'https://maps.googleapis.com/maps/api/js', array('jquery'));

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'assan_scripts');

function assan_body_classes($classes) {
    global $ctassan_data;
    $layout = $ctassan_data['themes_layout'];
    if ($layout == 'BOXED') {
        $classes[] = 'narrow-box';
    }
    return $classes;
}

add_filter('body_class', 'assan_body_classes');

if (!function_exists('assan_post_thumbnail')) :

    function assan_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }
        if (is_singular()) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('assan-fullwidth', array('alt' => get_the_title(), 'class' => 'img-responsive')); ?>
            </div>
        <?php else : ?>
            <?php  if( '' !== get_post()->post_content ): ?>
            <a href="<?php the_permalink(); ?>">
                <div class="item-img-wrap">
                    <?php the_post_thumbnail('post-thumbnail', array('alt' => get_the_title(), 'class' => 'img-responsive')); ?>
                    <div class="item-img-overlay">
                        <span></span>
                    </div>
                </div>
            </a>
            <?php else :
                $big_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'assan-fullwidth');
                $big_image_url = $big_image[0];
            ?>
            <div class="item-img-wrap">
                <?php the_post_thumbnail('post-thumbnail', array('alt' => get_the_title(), 'class' => 'img-responsive')); ?>
                <div class="item-img-overlay">
                    <a href="<?php echo $big_image_url; ?>" class="show-image"><span></span></a>
                </div>
            </div>
            <?php endif; ?>
        <?php
        endif; // End is_singular()
    }

endif;

//FILES
require get_template_directory() . '/lib/function.php';
