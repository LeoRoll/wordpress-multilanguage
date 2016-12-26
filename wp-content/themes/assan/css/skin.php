<?php

// Content type
header("Content-type: text/css; charset: UTF-8");

// Include WordPress core files for WP function access
$absolute_path = __FILE__;
$path_to_file = explode('wp-content', $absolute_path);
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp . '/wp-load.php' );
global $ctassan_data;
$skin_color = $ctassan_data['theme_skin_color'];
$theme_layout = $ctassan_data['themes_layout'];
$theme_pattern = $ctassan_data['themes_box_pattern'];
$theme_img_bg = $ctassan_data['themes_box_background'];

if ($skin_color != '' && $skin_color != null && !empty($skin_color)) {

    echo 'a:hover,a:focus  { color:' . $skin_color . '}' . "\n";

    echo '.colored-text{ color:' . $skin_color . ';}' . "\n";

    echo '.colored-text a{ color:' . $skin_color . ';}' . "\n";

    echo 'blockquote{border-color: ' . $skin_color . '}' . "\n";

    echo '.badge {background-color: ' . $skin_color . ';}' . "\n";

    echo '.btn-theme-bg{border-color: ' . $skin_color . ' ;color: #fff ;background-color: ' . $skin_color . ' ;}' . "\n";

    echo '.btn-theme-dark:hover{color:#fff;background-color: ' . $skin_color . ';}' . "\n";

    echo '.border-theme{border-color:' . $skin_color . ';color:' . $skin_color . ';}' . "\n";

    echo '.border-theme:hover{background-color: ' . $skin_color . ';border-color: ' . $skin_color . ';color:#fff;}' . "\n";

    echo '.btn-link:hover{color:' . $skin_color . ';}' . "\n";

    echo '.btn-shop-bg{border-color: ' . $skin_color . ' !important; background-color: ' . $skin_color . ' !important; }' . "\n";
    echo '.btn-shop-sm{border-color: ' . $skin_color . ' !important;background-color: ' . $skin_color . ' !important;}' . "\n";

    // echo '.navbar-default .navbar-nav>.current-menu-item>a, .navbar-default .navbar-nav>.current-menu-item>a:hover, .navbar-default .navbar-nav>.current-menu-item>a:focus, .navbar-default .navbar-nav>.current-menu-parent>a {
    // color: ' . $skin_color . ';background-color: transparent;}' . "\n";

    echo '.navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:hover, .navbar-default .navbar-nav>.open>a:focus {
    color: ' . $skin_color . ';background-color: transparent;}' . "\n";

    // echo '.navbar-default .navbar-nav>li>a:hover {color: ' . $skin_color . ';}' . "\n";

    echo '.top-bar-light .top-dark-right li a:hover {color: ' . $skin_color . ';}' . "\n";

    echo '.nav.mega-vertical-nav li a:hover {background-color:transparent;color:' . $skin_color . ';}' . "\n";

    echo '.mega-contact i{color:' . $skin_color . ';}' . "\n";

    // echo '.navbar-nav > li > .dropdown-menu,.navbar-nav .dropdown-submenu .dropdown-menu{border-top: 2px solid ' . $skin_color . ';}' . "\n";

    echo '.navbar-inverse .navbar-nav>.current-menu-item>a,.navbar-inverse .navbar-nav>.current-menu-parent>a,
        .navbar-inverse .navbar-nav>.current-menu-item>a:hover,.navbar-inverse .navbar-nav>.current-menu-item>a:focus {color: ' . $skin_color . ';background-color: transparent;}' . "\n";

    echo '.navbar-inverse .navbar-nav > .open > a,.navbar-inverse .navbar-nav > .open > a:hover,
        .navbar-inverse .navbar-nav > .open > a:focus {color: ' . $skin_color . ';background-color: transparent;}' . "\n";

    echo '.navbar-inverse .navbar-nav > li > a:hover {color: ' . $skin_color . ';}' . "\n";

    echo '.footer-col a:hover,.footer-col .popular-desc h5 a:hover{color: ' . $skin_color . ';}' . "\n";

    echo '.contact a:hover{color:' . $skin_color . ';}' . "\n";

    echo '.f2-work li a:hover img {border-color: ' . $skin_color . ';}' . "\n";

    echo '#footer-option .contact a:hover {color: ' . $skin_color . ';}' . "\n";

    echo '.tweet ul li:before {color: ' . $skin_color . ';}' . "\n";

    echo '.tweet li a:hover {color: ' . $skin_color . ';}' . "\n";

    echo '.footer-light-1 .footer-col a:hover,.footer-light-1 footer-col .popular-desc h5 a:hover{color: ' . $skin_color . ';}' . "\n";

    echo '.footer-light-1 .info li i {color: ' . $skin_color . ';}' . "\n";

    echo '.shop-services i {color: ' . $skin_color . ';}' . "\n";

    echo '.colored-box {background-color: ' . $skin_color . ';}' . "\n";

    echo '.colored-box i {background-color: #fff;color: ' . $skin_color . ';}' . "\n";

    echo '.login-link a {color: ' . $skin_color . ';}' . "\n";

    echo '.items-list .rate {color: ' . $skin_color . ';}' . "\n";

    echo '.carousel-item-content h1 {color: #fff;background-color: ' . $skin_color . ';}' . "\n";

    echo '.main-flex-slider .flex-control-paging li a.flex-active{background-color:' . $skin_color . ' !important;}' . "\n";

    echo '.typed-cursor {color: ' . $skin_color . ';}' . "\n";

    echo '.typed-text .element {color: ' . $skin_color . ';}' . "\n";

    echo '.services-box-icon i{background-color: ' . $skin_color . ';color:#fff;}' . "\n";

    echo '.service-box i{color:' . $skin_color . '; border:' . $skin_color . ' 1px solid;}' . "\n";

    echo '.service-box:hover i {color: #fff;background-color: ' . $skin_color . ';}' . "\n";

    echo '.blue-bg{ background-color:' . $skin_color . ';}' . "\n";

    echo '.special-feature i{color:' . $skin_color . ';}' . "\n";

    echo '.service-ico i{color:' . $skin_color . ';}' . "\n";

    echo '.service-text a{color:' . $skin_color . ';}' . "\n";

    echo '.colored-boxed.green i{color: ' . $skin_color . ';border-color: ' . $skin_color . ';}' . "\n";

    echo '.progress-bar {background:' . $skin_color . ';}' . "\n";

    echo '.timeline > li > .timeline-badge i:hover {color: ' . $skin_color . ';}' . "\n";

    echo '.testimonials  h4 i{color:' . $skin_color . ';}' . "\n";

    echo '.testimonials p{color:' . $skin_color . ';}' . "\n";

    echo '.testi-slide i{color:' . $skin_color . ';}' . "\n";

    echo '.testi-slide .flex-control-paging li a.flex-active{background: transparent !important;border: 2px solid ' . $skin_color . ';}' . "\n";

    echo '.quote.green blockquote{background-color:' . $skin_color . ';}' . "\n";

    echo '.quote.green blockquote:before{border-top-color: ' . $skin_color . ';}' . "\n";

    echo '.panel-title i{color:' . $skin_color . ';}' . "\n";

    echo '.purchase-sec{background: ' . $skin_color . ';}' . "\n";

    echo '.facts-in h3 i{color:' . $skin_color . ';}' . "\n";

    // echo '.owl-theme .owl-controls .owl-page span {background: ' . $skin_color . ' !important;}' . "\n";

    echo '.highlight-list li i{color:' . $skin_color . ';}' . "\n";

    echo '.pricing-simple ul li i {color: ' . $skin_color . ';}' . "\n";

    echo '.popular .ribbon{background: ' . $skin_color . ';color:#fff;}' . "\n";

    echo '.me-hobbies h4 i{color:' . $skin_color . ';}' . "\n";

    echo '.services-me li i{background-color: #e5e5e5;color:' . $skin_color . ';}' . "\n";

    echo 'p.dropcap:first-letter{color:' . $skin_color . ';}' . "\n";

    echo '.sidebar-box li a:hover{color:' . $skin_color . ';}' . "\n";

    echo '.popular-desc h5 a:hover {color: ' . $skin_color . ';}' . "\n";

    echo '.tagcloud a:hover {background-color: ' . $skin_color . ';color: #fff;}' . "\n";

    echo '#cta-1{background-color: ' . $skin_color . ';}' . "\n";

    echo '.panel-ico.active:after {color: ' . $skin_color . ';}' . "\n";

    echo '.panel-ico.active a {color: ' . $skin_color . ';}' . "\n";

    echo '.panel-primary .panel-heading {background: ' . $skin_color . ';}' . "\n";

    echo 'nav-tabs > li.active > a,.nav-tabs > li.active > a:focus,.nav-tabs > li.active > a:hover {background-color: ' . $skin_color . ';color: #fff;}' . "\n";

    echo '.tabs .nav-tabs  li.active  a {color: ' . $skin_color . ';border-left-color: #eee;border-right-color: #eee;background: #fff;}' . "\n";

    echo '.tabs .nav-tabs  li.active  a:after {background: ' . $skin_color . ';}' . "\n";

    echo '.latest-tweets .tweet li a{color:' . $skin_color . ';}' . "\n";

    echo '.side-nav li a.active{color:' . $skin_color . ';}' . "\n";

    echo '.pagination>.active>a,.pagination>.active>span,.pagination>.active>a:hover,.pagination>.active>span:hover,.pagination>.active>a:focus,
.pagination>.active>span:focus{background-color: ' . $skin_color . ';}' . "\n";

    echo '.pagination > li > a,.pagination > li > span,.pagination > li > a:hover,.pagination > li > span:hover,.pagination > li > a:focus,
.pagination > li > span:focus{color: ' . $skin_color . ';}' . "\n";

    echo '.results-box h3  a{color:' . $skin_color . ';}' . "\n";

    echo '.link-ul li a:hover{color:' . $skin_color . ';}' . "\n";

    echo '.results-sidebar-box ul li a:hover{color:' . $skin_color . ';}' . "\n";

    echo '.step:hover .icon-square i {background-color: ' . $skin_color . ';color: #FFF;}' . "\n";

    echo '.login-regiter-tabs .nav-tabs > li.active > a,.login-regiter-tabs .nav-tabs > li.active > a:hover,
        .login-regiter-tabs .nav-tabs > li.active > a:focus {color: #fff;background-color: #fff;border-bottom-color: ' . $skin_color . ';
        background-color: ' . $skin_color . ';border-color: ' . $skin_color . ';}' . "\n";

    echo '.login-regiter-tabs .nav-tabs > li > a:hover {border-color: ' . $skin_color . ';background-color: transparent;}' . "\n";

    echo '.dropdown-login-box h4 em {color: ' . $skin_color . ';}' . "\n";

    echo '.dropdown-login-box p a {color: ' . $skin_color . ';}' . "\n";

    echo '.dropdown-login-box p a:hover {color: ' . $skin_color . ';}' . "\n";

    echo '.navbar .dropdown-menu.dark-dropdown li a:hover {color: ' . $skin_color . ';background-color: transparent;}' . "\n";

    echo '.intro-text-1 h4 strong{color:' . $skin_color . ';}' . "\n";

    echo '.featured-work .owl-theme .owl-controls .owl-buttons div {background: ' . $skin_color . ';}' . "\n";

    echo '.work-wrap .img-overlay .inner-overlay h2 {color: #434343;color: ' . $skin_color . ';}' . "\n";

    echo '.work-wrap .img-overlay .inner-overlay a {border: 1px solid ' . $skin_color . ';}' . "\n";

    echo '.work-wrap .img-overlay .inner-overlay a i {color: ' . $skin_color . ';}' . "\n";

    echo '.fun-facts-bg{background: ' . $skin_color . ';}' . "\n";

    echo '.event-box .time{color:#fff;background-color: ' . $skin_color . ';}' . "\n";

    echo '.filter li a:hover,.filter li a.active{color:' . $skin_color . ';border-color: ' . $skin_color . ';}' . "\n";

    echo '.img-icon-overlay p a:hover{color:' . $skin_color . ';}' . "\n";

    echo '.pace .pace-progress {background: ' . $skin_color . ';}' . "\n";

    echo '.pace .pace-progress-inner{box-shadow: 0 0 10px ' . $skin_color . ', 0 0 5px ' . $skin_color . ';}' . "\n";

    echo '.pace .pace-activity{border-top-color: ' . $skin_color . ';border-left-color: ' . $skin_color . ';}' . "\n";

    echo '.page-template-one-page .contact-info i{ background-color: ' . $skin_color . ';}' . "\n";

    echo '#back-to-top a{ background-color: ' . $skin_color . ';}' . "\n";

    echo 'ul.list-icon li:before{color: ' . $skin_color . ';}' . "\n";

    echo '.screen-reader-text{color: ' . $skin_color . ';}' . "\n";
}
if ($theme_layout == 'BOXED') {
    echo '.narrow-box .wrapper{margin:auto;max-width:1170px;box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);background:#fff;}' . "\n";
    echo '.narrow-box .navbar.navbar-default.navbar-static-top{max-width:1170px;margin: 0 auto;}' . "\n";
    if ($theme_pattern && !empty($theme_pattern) && $theme_img_bg == '') {
        echo 'body{background:url(' . get_template_directory_uri() . '/images/' . $theme_pattern . '.jpg) repeat scroll 0 0 rgba(0, 0, 0, 0)}' . "\n";
    }
    if ($theme_img_bg && !empty($theme_img_bg)) {
        echo 'body{background:url(' . $theme_img_bg . ');background-repeat: no-repeat;background-attachment: fixed;}' . "\n";
    }
}
