<?php

/*
  Plugin Name: Binary Go Web
  Description: 自定义文章类型：公司产品，支持短代码.
  Version: 1.0
  Author: BINaryGO Infomation
  Author URI: http://bin-go.cc
 */

function bingo_web_load_plugin() {

    define('BINGO_WEB_PLUGIN_DIR', plugin_dir_path(__FILE__));
    load_plugin_textdomain('bin-go-web', false, 'bin-go-web/languages/');

    require_once BINGO_WEB_PLUGIN_DIR . '/includes/post_type_product.php';
    require_once BINGO_WEB_PLUGIN_DIR . '/includes/post_type_scheme.php';
    require_once BINGO_WEB_PLUGIN_DIR . '/includes/shortcode.php';
    return true;
}
add_action('plugins_loaded', 'bingo_web_load_plugin', 20);

add_filter( 'gettext_with_context', 'bingo_filter_gettext_with_context', 10, 4 );
function bingo_filter_gettext_with_context( $translated, $original, $context, $domain ) {
  // Use the text string exactly as it is in the translation file
  if ( $translated == '文章' ) {
    // var_dump(sprintf( '%s, %s, %s', __( $original, $context, 'bin-go-web'), $original, $context ));
    $translated = '公司新闻';
  }

  return $translated;
}
