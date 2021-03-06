<?php
/*
Plugin Name: GTranslate
Plugin URI: https://gtranslate.io/?xyz=998
Description: Makes your website <strong>multilingual</strong> and available to the world using Google Translate. For support visit <a href="https://wordpress.org/support/plugin/gtranslate">GTranslate Support</a>.
Version: 2.8.2
Author: Edvard Ananyan
Author URI: https://gtranslate.io
Text Domain: gtranslate

*/

/*  Copyright 2010 - 2016 Edvard Ananyan  (email : edo888@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('widgets_init', array('GTranslate', 'register'));
register_activation_hook(__FILE__, array('GTranslate', 'activate'));
register_deactivation_hook(__FILE__, array('GTranslate', 'deactivate'));
add_filter('plugin_action_links_' . plugin_basename(__FILE__), array('GTranslate', 'settings_link'));
add_action('admin_menu', array('GTranslate', 'admin_menu'));
add_action('init', array('GTranslate', 'enqueue_scripts'));
add_action('plugins_loaded', array('GTranslate', 'load_textdomain'));
add_shortcode('GTranslate', array('GTranslate', 'get_widget_code'));
add_shortcode('gtranslate', array('GTranslate', 'get_widget_code'));

if(is_admin()) {
    global $pagenow;

    if(!defined('DOING_AJAX') or !DOING_AJAX)
        new GTranslate_Notices();
}

$data = get_option('GTranslate');
GTranslate::load_defaults($data);

if($data['show_in_primary_menu']) {
    add_filter('wp_nav_menu_items', 'gtranslate_menu_item', 10, 2);
    function gtranslate_menu_item($items, $args) {
        if($args->theme_location == 'primary')
            $items .= '<li style="position:relative;" class="menu-item menu-item-gtranslate"><div style="position:absolute;">'.GTranslate::get_widget_code(false).'</div></li>';
        return $items;
    }
}

if($data['floating_language_selector'] != 'no' and !$data['show_in_primary_menu'] and !is_admin()) {
    add_action('wp_footer', 'gtranslate_display_floating');
    function gtranslate_display_floating() {
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        if($data['widget_look'] == 'dropdown_with_flags')
            $vertical_location = '0';
        else
            $vertical_location = '5%';

        switch($data['floating_language_selector']) {
            case 'top_left': $html = '<div style="position:fixed;top:'.$vertical_location.';left:8%;z-index:999999;">'.GTranslate::get_widget_code(false).'</div>'; break;
            case 'top_right': $html = '<div style="position:fixed;top:'.$vertical_location.';right:8%;z-index:999999;">'.GTranslate::get_widget_code(false).'</div>'; break;
            case 'bottom_left': $html = '<div style="position:fixed;bottom:'.$vertical_location.';left:8%;z-index:999999;">'.GTranslate::get_widget_code(false).'</div>'; break;
            case 'bottom_right': $html = '<div style="position:fixed;bottom:'.$vertical_location.';right:8%;z-index:999999;">'.GTranslate::get_widget_code(false).'</div>'; break;
            default: $html = ''; break;
        }

        echo $html;
    }
}

class GTranslate extends WP_Widget {
    public static function activate() {
        $data = array(
            'gtranslate_title' => __('Website Translator', 'gtranslate'),
        );
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        add_option('GTranslate', $data);
    }

    public static function deactivate() {
        // delete_option('GTranslate');
    }

    public static function settings_link($links) {
        $settings_link = array('<a href="' . admin_url('options-general.php?page=gtranslate_options') . '">'.__('Settings', 'gtranslate').'</a>');
        return array_merge($links, $settings_link);
    }

    public static function control() {
        $data = get_option('GTranslate');
        ?>
        <p><label><?php _e('Title', 'gtranslate'); ?>: <input name="gtranslate_title" type="text" class="widefat" value="<?php echo $data['gtranslate_title']; ?>"/></label></p>
        <p><?php _e('Please go to Settings -> GTranslate for configuration.', 'gtranslate'); ?></p>
        <?php
        if (isset($_POST['gtranslate_title'])){
            $data['gtranslate_title'] = esc_attr($_POST['gtranslate_title']);
            update_option('GTranslate', $data);
        }
    }

    public static function enqueue_scripts() {
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        wp_enqueue_style( 'gtranslate-style', plugins_url('gtranslate-style'.$data['flag_size'].'.css', __FILE__) );
        wp_enqueue_script('jquery');
    }

    public static function load_textdomain() {
        load_plugin_textdomain('gtranslate');
    }

    public function widget($args, $instance) {
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        echo $args['before_widget'];
        echo $args['before_title'] . $data['gtranslate_title'] . $args['after_title'];
        if(empty($data['widget_code']))
            _e('<b>Notice:</b> Please configure GTranslate from WP-Admin -> Settings -> GTranslate to see it in action.', 'gtranslate');
        else
            echo $data['widget_code'];

        if(isset($_SERVER['HTTP_X_GT_LANG']) and in_array($_SERVER['HTTP_X_GT_LANG'], array('en','ar','bg','zh-CN','zh-TW','zh-cn','zh-tw','hr','cs','da','nl','fi','fr','de','el','hi','it','ja','ko','no','pl','pt','ro','ru','es','sv','ca','tl','iw','id','lv','lt','sr','sk','sl','uk','vi','sq','et','gl','hu','mt','th','tr','fa','af','ms','sw','ga','cy','be','is','mk','yi','hy','az','eu','ka','ht','ur','bn','bs','ceb','eo','gu','ha','hmn','ig','jw','kn','km','lo','la','mi','mr','mn','ne','pa','so','ta','te','yo','zu','my','ny','kk','mg','ml','si','st','su','tg','uz','am','co','haw','ku','ky','lb','ps','sm','gd','sn','sd','fy','xh'))) {
            echo '<script>jQuery(document).ready(function() {jQuery(\'.switcher div.selected a\').html(jQuery(".switcher div.option a[onclick*=\'|'.esc_js($_SERVER['HTTP_X_GT_LANG']).'\']").html())});</script>';
        }

        echo $args['after_widget'];
    }

    public static function widget2($args) {
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        echo $args['before_widget'];
        echo $args['before_title'] . $data['gtranslate_title'] . $args['after_title'];
        if(empty($data['widget_code']))
            _e('<b>Notice:</b> Please configure GTranslate from WP-Admin -> Settings -> GTranslate to see it in action.', 'gtranslate');
        else
            echo $data['widget_code'];

        if(isset($_SERVER['HTTP_X_GT_LANG']) and in_array($_SERVER['HTTP_X_GT_LANG'], array('en','ar','bg','zh-CN','zh-TW','zh-cn','zh-tw','hr','cs','da','nl','fi','fr','de','el','hi','it','ja','ko','no','pl','pt','ro','ru','es','sv','ca','tl','iw','id','lv','lt','sr','sk','sl','uk','vi','sq','et','gl','hu','mt','th','tr','fa','af','ms','sw','ga','cy','be','is','mk','yi','hy','az','eu','ka','ht','ur','bn','bs','ceb','eo','gu','ha','hmn','ig','jw','kn','km','lo','la','mi','mr','mn','ne','pa','so','ta','te','yo','zu','my','ny','kk','mg','ml','si','st','su','tg','uz','am','co','haw','ku','ky','lb','ps','sm','gd','sn','sd','fy','xh'))) {
            echo '<script>jQuery(document).ready(function() {jQuery(\'.switcher div.selected a\').html(jQuery(".switcher div.option a[onclick*=\'|'.esc_js($_SERVER['HTTP_X_GT_LANG']).'\']").html())});</script>';
        }

        echo $args['after_widget'];
    }

    function get_widget_code($atts) {
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        if(empty($data['widget_code']))
            return __('<b>Notice:</b> Please configure GTranslate from WP-Admin -> Settings -> GTranslate to see it in action.', 'gtranslate');
        else {
            if(isset($_SERVER['HTTP_X_GT_LANG']) and in_array($_SERVER['HTTP_X_GT_LANG'], array('en','ar','bg','zh-CN','zh-TW','zh-cn','zh-tw','hr','cs','da','nl','fi','fr','de','el','hi','it','ja','ko','no','pl','pt','ro','ru','es','sv','ca','tl','iw','id','lv','lt','sr','sk','sl','uk','vi','sq','et','gl','hu','mt','th','tr','fa','af','ms','sw','ga','cy','be','is','mk','yi','hy','az','eu','ka','ht','ur','bn','bs','ceb','eo','gu','ha','hmn','ig','jw','kn','km','lo','la','mi','mr','mn','ne','pa','so','ta','te','yo','zu','my','ny','kk','mg','ml','si','st','su','tg','uz','am','co','haw','ku','ky','lb','ps','sm','gd','sn','sd','fy','xh'))) {
                return $data['widget_code'] . '<script>jQuery(document).ready(function() {jQuery(\'.switcher div.selected a\').html(jQuery(".switcher div.option a[onclick*=\'|'.esc_js($_SERVER['HTTP_X_GT_LANG']).'\']").html())});</script>';
            } else
                return $data['widget_code'];
        }
    }

    public static function register() {
        wp_register_sidebar_widget('gtranslate', 'GTranslate', array('GTranslate', 'widget2'), array('description' => __('Google Automatic Translations')));
        wp_register_widget_control('gtranslate', 'GTranslate', array('GTranslate', 'control'));
    }

    public static function admin_menu() {
        add_options_page(__('GTranslate Options', 'gtranslate'), 'GTranslate', 'administrator', 'gtranslate_options', array('GTranslate', 'options'));
    }

    public static function options() {
        ?>
        <div class="wrap">
        <div id="icon-options-general" class="icon32"><br/></div>
        <h2><img src="<?php echo plugins_url('gt-logo.png', __FILE__); ?>" border="0" title="<?php _e('GTranslate - your window to the world', 'gtranslate'); ?>" alt="GTranslate"></h2>
        <?php
        if(isset($_POST['save']) and $_POST['save'])
            GTranslate::control_options();
        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        wp_enqueue_script('jquery-ui-sortable');

        $site_url = site_url();
        $wp_plugin_url = plugins_url() . '/gtranslate';

        extract($data);

        $gt_lang_array_json = '{"af":"Afrikaans","sq":"Albanian","am":"Amharic","ar":"Arabic","hy":"Armenian","az":"Azerbaijani","eu":"Basque","be":"Belarusian","bn":"Bengali","bs":"Bosnian","bg":"Bulgarian","ca":"Catalan","ceb":"Cebuano","ny":"Chichewa","zh-CN":"Chinese (Simplified)","zh-TW":"Chinese (Traditional)","co":"Corsican","hr":"Croatian","cs":"Czech","da":"Danish","nl":"Dutch","en":"English","eo":"Esperanto","et":"Estonian","tl":"Filipino","fi":"Finnish","fr":"French","fy":"Frisian","gl":"Galician","ka":"Georgian","de":"German","el":"Greek","gu":"Gujarati","ht":"Haitian Creole","ha":"Hausa","haw":"Hawaiian","iw":"Hebrew","hi":"Hindi","hmn":"Hmong","hu":"Hungarian","is":"Icelandic","ig":"Igbo","id":"Indonesian","ga":"Irish","it":"Italian","ja":"Japanese","jw":"Javanese","kn":"Kannada","kk":"Kazakh","km":"Khmer","ko":"Korean","ku":"Kurdish (Kurmanji)","ky":"Kyrgyz","lo":"Lao","la":"Latin","lv":"Latvian","lt":"Lithuanian","lb":"Luxembourgish","mk":"Macedonian","mg":"Malagasy","ms":"Malay","ml":"Malayalam","mt":"Maltese","mi":"Maori","mr":"Marathi","mn":"Mongolian","my":"Myanmar (Burmese)","ne":"Nepali","no":"Norwegian","ps":"Pashto","fa":"Persian","pl":"Polish","pt":"Portuguese","pa":"Punjabi","ro":"Romanian","ru":"Russian","sm":"Samoan","gd":"Scottish Gaelic","sr":"Serbian","st":"Sesotho","sn":"Shona","sd":"Sindhi","si":"Sinhala","sk":"Slovak","sl":"Slovenian","so":"Somali","es":"Spanish","su":"Sudanese","sw":"Swahili","sv":"Swedish","tg":"Tajik","ta":"Tamil","te":"Telugu","th":"Thai","tr":"Turkish","uk":"Ukrainian","ur":"Urdu","uz":"Uzbek","vi":"Vietnamese","cy":"Welsh","xh":"Xhosa","yi":"Yiddish","yo":"Yoruba","zu":"Zulu"}';
        $gt_lang_array = get_object_vars(json_decode($gt_lang_array_json));

        if(!empty($language_codes))
            $gt_lang_codes_json = json_encode(explode(',', $language_codes));
        else
            $gt_lang_codes_json = '[]';

        if(!empty($language_codes2))
            $gt_lang_codes2_json = json_encode(explode(',', $language_codes2));
        else
            $gt_lang_codes2_json = '[]';


        #unset($data['widget_code']);
        #echo '<pre>', print_r($data, true), '</pre>';

$script = <<<EOT

var gt_lang_array = $gt_lang_array_json;
var languages = [], language_codes = $gt_lang_codes_json, language_codes2 = $gt_lang_codes2_json;

//for(var key in gt_lang_array)
//  languages.push(gt_lang_array[key]);
if(language_codes.length == 0)
    for(var key in gt_lang_array)
        language_codes.push(key);
if(language_codes2.length == 0)
    for(var key in gt_lang_array)
        language_codes2.push(key);

var languages_map = {en_x: 0, en_y: 0, ar_x: 100, ar_y: 0, bg_x: 200, bg_y: 0, zhCN_x: 300, zhCN_y: 0, zhTW_x: 400, zhTW_y: 0, hr_x: 500, hr_y: 0, cs_x: 600, cs_y: 0, da_x: 700, da_y: 0, nl_x: 0, nl_y: 100, fi_x: 100, fi_y: 100, fr_x: 200, fr_y: 100, de_x: 300, de_y: 100, el_x: 400, el_y: 100, hi_x: 500, hi_y: 100, it_x: 600, it_y: 100, ja_x: 700, ja_y: 100, ko_x: 0, ko_y: 200, no_x: 100, no_y: 200, pl_x: 200, pl_y: 200, pt_x: 300, pt_y: 200, ro_x: 400, ro_y: 200, ru_x: 500, ru_y: 200, es_x: 600, es_y: 200, sv_x: 700, sv_y: 200, ca_x: 0, ca_y: 300, tl_x: 100, tl_y: 300, iw_x: 200, iw_y: 300, id_x: 300, id_y: 300, lv_x: 400, lv_y: 300, lt_x: 500, lt_y: 300, sr_x: 600, sr_y: 300, sk_x: 700, sk_y: 300, sl_x: 0, sl_y: 400, uk_x: 100, uk_y: 400, vi_x: 200, vi_y: 400, sq_x: 300, sq_y: 400, et_x: 400, et_y: 400, gl_x: 500, gl_y: 400, hu_x: 600, hu_y: 400, mt_x: 700, mt_y: 400, th_x: 0, th_y: 500, tr_x: 100, tr_y: 500, fa_x: 200, fa_y: 500, af_x: 300, af_y: 500, ms_x: 400, ms_y: 500, sw_x: 500, sw_y: 500, ga_x: 600, ga_y: 500, cy_x: 700, cy_y: 500, be_x: 0, be_y: 600, is_x: 100, is_y: 600, mk_x: 200, mk_y: 600, yi_x: 300, yi_y: 600, hy_x: 400, hy_y: 600, az_x: 500, az_y: 600, eu_x: 600, eu_y: 600, ka_x: 700, ka_y: 600, ht_x: 0, ht_y: 700, ur_x: 100, ur_y: 700};

function RefreshDoWidgetCode() {
    var new_line = "\\n";
    var widget_preview = '<!-- GTranslate: https://gtranslate.io/ -->'+new_line;
    var widget_code = '';
    var translation_method = 'onfly'; //jQuery('#translation_method').val();
    var widget_look = jQuery('#widget_look').val();
    var default_language = jQuery('#default_language').val();
    var flag_size = jQuery('#flag_size').val();
    var pro_version = jQuery('#pro_version:checked').length > 0 ? true : false;
    var enterprise_version = jQuery('#enterprise_version:checked').length > 0 ? true : false;
    var new_window = jQuery('#new_window:checked').length > 0 ? true : false;
    var show_in_primary_menu = jQuery('#show_in_primary_menu:checked').length > 0 ? true : false;
    var floating_language_selector = jQuery('#floating_language_selector').val();
    var analytics = jQuery('#analytics:checked').length > 0 ? true : false;

    if(pro_version || enterprise_version) {
        translation_method = 'redirect';
        jQuery('#new_window_option').show();
    } else {
        jQuery('#new_window_option').hide();
    }

    if(widget_look == 'dropdown' || widget_look == 'flags_dropdown' || widget_look == 'globe') {
        jQuery('#dropdown_languages_option').show();
    } else {
        jQuery('#dropdown_languages_option').hide();
    }

    if(widget_look == 'globe') {
        jQuery('#alternative_flags_option').show();
    } else {
        jQuery('#alternative_flags_option').hide();
    }

    if(widget_look == 'flags' || widget_look == 'flags_dropdown' || widget_look == 'dropdown_with_flags') {
        jQuery('#flag_languages_option').show();
        jQuery('#alternative_flags_option').show();
    } else {
        jQuery('#flag_languages_option').hide();
        if(widget_look != 'globe')
            jQuery('#alternative_flags_option').hide();
    }

    if(widget_look == 'flags' || widget_look == 'dropdown' || widget_look == 'dropdown_with_flags') {
        jQuery('#line_break_option').hide();
    } else {
        jQuery('#line_break_option').show();
    }

    if(widget_look == 'dropdown_with_flags' || widget_look == 'dropdown') {
        jQuery('#flag_size_option').hide();
    } else {
        jQuery('#flag_size_option').show();
    }

    if(show_in_primary_menu) {
        jQuery('#floating_option').hide();
    } else {
        jQuery('#floating_option').show();
    }

    if(pro_version && enterprise_version)
        pro_version = false;

    if(translation_method == 'google_default') {
        included_languages = '';
        jQuery.each(language_codes2, function(i, val) {
            lang = language_codes2[i];
            if(jQuery('#incl_langs'+lang+':checked').length) {
                lang_name = gt_lang_array[lang];
                included_languages += ','+lang;
            }
        });

        widget_preview += '<div id="google_translate_element"></div>'+new_line;
        widget_preview += '<script type="text/javascript">'+new_line;
        widget_preview += 'function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage: \'';
        widget_preview += default_language;
        widget_preview += '\', layout: google.translate.TranslateElement.InlineLayout.SIMPLE';
        widget_preview += ', autoDisplay: false';
        widget_preview += ', includedLanguages: \'';
        widget_preview += included_languages;
        widget_preview += "'}, 'google_translate_element');}"+new_line;
        widget_preview += '<\/script>';
        widget_preview += '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"><\/script>'+new_line;
    } else if(translation_method == 'on_fly' || translation_method == 'redirect' || translation_method == 'onfly') {
        // Adding flags
        if(widget_look == 'flags' || widget_look == 'flags_dropdown' /* jQuery('#show_flags:checked').length */) {
            //console.log('adding flags');
            jQuery.each(language_codes, function(i, val) {
                lang = language_codes[i];
                if(jQuery('#fincl_langs'+lang+':checked').length) {
                    lang_name = gt_lang_array[lang];
                    flag_x = languages_map[lang.replace('-', '')+'_x'];
                    flag_y = languages_map[lang.replace('-', '')+'_y'];

                    var href = '#';
                    if(pro_version)
                        href = (lang == default_language) ? '$site_url' : '$site_url'.replace('$site_url'.split('/').slice(0, 3).join('/'), '$site_url'.split('/').slice(0, 3).join('/')+'/'+lang);
                    else if(enterprise_version)
                        href = (lang == default_language) ? '$site_url' : '$site_url'.replace('$site_url'.split('/').slice(2, 3)[0].replace('www.', ''), lang + '.' + '$site_url'.split('/').slice(2, 3)[0].replace('www.', '')).replace('://www.', '://');

                    if(lang == 'en' && jQuery('#alt_us:checked').length)
                        widget_preview += '<a href="'+href+'" onclick="doGTranslate(\''+default_language+'|'+lang+'\');return false;" title="'+lang_name+'" class="gflag nturl alt_flag us_flag"><img src="{$wp_plugin_url}/blank.png" height="'+flag_size+'" width="'+flag_size+'" alt="'+lang_name+'" /></a>';
                    else if(lang == 'pt' && jQuery('#alt_br:checked').length)
                        widget_preview += '<a href="'+href+'" onclick="doGTranslate(\''+default_language+'|'+lang+'\');return false;" title="'+lang_name+'" class="gflag nturl alt_flag br_flag"><img src="{$wp_plugin_url}/blank.png" height="'+flag_size+'" width="'+flag_size+'" alt="'+lang_name+'" /></a>';
                    else if(lang == 'es' && jQuery('#alt_mx:checked').length)
                        widget_preview += '<a href="'+href+'" onclick="doGTranslate(\''+default_language+'|'+lang+'\');return false;" title="'+lang_name+'" class="gflag nturl alt_flag mx_flag"><img src="{$wp_plugin_url}/blank.png" height="'+flag_size+'" width="'+flag_size+'" alt="'+lang_name+'" /></a>';
                    else
                        widget_preview += '<a href="'+href+'" onclick="doGTranslate(\''+default_language+'|'+lang+'\');return false;" title="'+lang_name+'" class="gflag nturl" style="background-position:-'+flag_x+'px -'+flag_y+'px;"><img src="{$wp_plugin_url}/blank.png" height="'+flag_size+'" width="'+flag_size+'" alt="'+lang_name+'" /></a>';
                }
            });
        }

        // Adding dropdown
        if(widget_look == 'dropdown' || widget_look == 'flags_dropdown' /* jQuery('#show_dropdown:checked').length */) {
            //console.log('adding dropdown');
            if(/* jQuery('#show_flags:checked').length*/ (widget_look == 'flags' || widget_look == 'flags_dropdown') && jQuery('#add_new_line:checked').length)
                widget_preview += '<br />';
            else
                widget_preview += ' ';
            widget_preview += '<select onchange="doGTranslate(this);">';
            widget_preview += '<option value="">Select Language</option>';
            jQuery.each(language_codes2, function(i, val) {
                lang = language_codes2[i];
                if(jQuery('#incl_langs'+lang+':checked').length) {
                    lang_name = gt_lang_array[lang];
                    widget_preview += '<option value="'+default_language+'|'+lang+'">'+lang_name+'</option>';
                }
            });
            widget_preview += '</select>';
        }

        // Adding onfly html and css
        if(translation_method == 'onfly') {
            //console.log('adding onfly html, css and javascript');

            widget_code += '<style type="text/css">'+new_line;
            widget_code += '<!--'+new_line;
            widget_code += "#goog-gt-tt {display:none !important;}"+new_line;
            widget_code += ".goog-te-banner-frame {display:none !important;}"+new_line;
            widget_code += ".goog-te-menu-value:hover {text-decoration:none !important;}"+new_line;
            widget_code += "body {top:0 !important;}"+new_line;
            widget_code += "#google_translate_element2 {display:none!important;}"+new_line;
            widget_code += '-->'+new_line;
            widget_code += '</style>'+new_line+new_line;
            widget_code += '<div id="google_translate_element2"></div>'+new_line;
            widget_code += '<script type="text/javascript">'+new_line;
            widget_code += 'function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: \'';
            widget_code += default_language;
            widget_code += '\',autoDisplay: false';
            //if(analytics)
            //  widget_code += ",gaTrack: (typeof ga!='undefined'),gaId: (typeof ga!='undefined' ? ga.getAll()[0].get('trackingId') : '')";
            widget_code += "}, 'google_translate_element2');}"+new_line;
            widget_code += '<\/script>';
            widget_code += '<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"><\/script>'+new_line;
        }

        if(widget_look == 'globe') {
            widget_preview += '<span class="gsatelites"></span><span class="gglobe"></span>';

            // Adding css
            widget_preview += '<style type="text/css">'+new_line;
            widget_preview += '.gglobe {background-image:url($wp_plugin_url/gtglobe.svg);opacity:0.8;border-radius:50%;height:40px;width:40px;cursor:pointer;display:block;-moz-transition: all 0.3s;-webkit-transition: all 0.3s;transition: all 0.3s;}'+new_line;
            widget_preview += '.gglobe:hover {opacity:1;-moz-transform: scale(1.2);-webkit-transform: scale(1.2);transform: scale(1.2);}'+new_line;
            //widget_preview += '.gsatelites {position:relative;}'+new_line;
            widget_preview += '.gsatelite {background-color:#777777;opacity:0.95;border-radius:50%;height:24px;width:24px;cursor:pointer;position:absolute;z-index:100000;display:none;-moz-transition: all 0.3s;-webkit-transition: all 0.3s;transition: all 0.3s;}'+new_line;
            widget_preview += '.gsatelite:hover {opacity:1;-moz-transform: scale(1.3);-webkit-transform: scale(1.3);transform: scale(1.3);}'+new_line;
            widget_preview += '</style>'+new_line+new_line;

            // Adding javascript
            widget_preview += '<script type="text/javascript">'+new_line;
            widget_preview += `function renderGSatelites($, e) {
    $('.gsatelite').remove();

    var centerPosition = $('.gglobe').position();
    centerPosition.left += Math.floor($('.gglobe').width() / 2) - 10;
    centerPosition.top += Math.floor($('.gglobe').height() / 2) - 10;

    var language_codes = `+JSON.stringify(jQuery(".connectedSortable2 li input:checked").map(function() {return jQuery(this).val();}).toArray())+`;
    var languages = `+JSON.stringify((function(){var langs = [], selected_lang_codes = jQuery(".connectedSortable2 li input:checked").map(function() {return jQuery(this).val();}).toArray();for(var key in selected_lang_codes)langs.push(gt_lang_array[selected_lang_codes[key]]);return langs;})())+`;
    var us_flag = `+(jQuery('#alt_us:checked').length ? 'true' : 'false')+`;
    var br_flag = `+(jQuery('#alt_br:checked').length ? 'true' : 'false')+`;
    var mx_flag = `+(jQuery('#alt_mx:checked').length ? 'true' : 'false')+`;

    var count = language_codes.length, r0 = 55, r = r0, d = 34, cntpc = 12, nc = 0, m = 1.75;
    cntpc = 2 * Math.PI * r0 / 34;
    for (var i = 0, j = 0; i < count; i++, j++) {
        var x, y, angle;


        // circle
        do {

            if (j + 1 > Math.round(2 * r0 * Math.PI / d) * (nc + 1) * (nc + 2) / 2) {
                nc++;
                r = r + r0;
                cntpc = Math.floor(2 * Math.PI * r / d);
            }

            angle = j * 2 * Math.PI / cntpc + Math.PI / 4;
            x = centerPosition.left + Math.cos(angle) * r;
            y = centerPosition.top + Math.sin(angle) * r;

            var positionGSatelites = ($('.gsatelites').parent().css('position') == 'fixed' ? $('.gsatelites').parent().position() : $('.gsatelites').offset()),
                vpHeight = $(window).height(),
                vpWidth = $(window).width(),
                tpViz = positionGSatelites.top + y >= 0 && positionGSatelites.top + y < vpHeight,
                btViz = positionGSatelites.top + y + 24 > 0 && positionGSatelites.top + y + 24 <= vpHeight,
                ltViz = positionGSatelites.left + x >= 0 && positionGSatelites.left + x < vpWidth,
                rtViz = positionGSatelites.left + x + 24 > 0 && positionGSatelites.left + x + 24 <= vpWidth,
                vVisible = tpViz && btViz,
                hVisible = ltViz && rtViz;

            if (vVisible && hVisible) {
                break;
            } else {
                j++;
            }
        } while (j - i < 10 * count);


        $('.gsatelites').append('<span class="gsatelite gs' + (i + 1) + ' glang_' + language_codes[i] + '" onclick="doGTranslate(`+"\\\\'"+default_language+`|'+language_codes[i]+'`+"\\\\'"+`)" title="' + languages[i] + '" style="background-image:url($wp_plugin_url/24/' + (function(l){if(l == 'en' && us_flag)return 'en-us';if(l == 'pt' && br_flag)return 'pt-br';if(l == 'es' && mx_flag)return 'es-mx';return l;})(language_codes[i]) + '.png);left:' + x + 'px;top:' + y + 'px;"></span>');
        $('.gs' + (i + 1)).delay((i + 1) * 10).fadeIn('fast');

    }
}

function hideGSatelites($) {
    $('.gsatelite').each(function(i) {
        $(this).delay(($('.gsatelite').length - i - 1) * 10).fadeOut('fast');
    });
}
(function($) {
    $('body').click(function() {
        hideGSatelites($);
    });
    $('.gglobe').click(function(e) {
        e.stopPropagation();
        renderGSatelites($, e);
    });
})(jQuery);
`;
            widget_preview += '<\/script>'+new_line;
        }

        if(widget_look == 'dropdown_with_flags') {
            // Adding slider html
            widget_preview += '<div class="switcher notranslate">'+new_line;
            widget_preview += '<div class="selected">'+new_line;
            if(default_language == 'en' && jQuery('#alt_us:checked').length)
                widget_preview += '<a href="#" onclick="return false;"><span class="gflag" style="background-image:url($wp_plugin_url/alt_flags.png);background-position:-0px -0px;"><img src="$wp_plugin_url/blank.png" height="'+16+'" width="'+16+'" alt="'+default_language+'" /></span>'+gt_lang_array[default_language]+'</a>'+new_line;
            else if(default_language == 'pt' && jQuery('#alt_br:checked').length)
                widget_preview += '<a href="#" onclick="return false;"><span class="gflag" style="background-image:url($wp_plugin_url/alt_flags.png);background-position:-100px -0px;"><img src="$wp_plugin_url/blank.png" height="'+16+'" width="'+16+'" alt="'+default_language+'" /></span>'+gt_lang_array[default_language]+'</a>'+new_line;
            else if(default_language == 'es' && jQuery('#alt_mx:checked').length)
                widget_preview += '<a href="#" onclick="return false;"><span class="gflag" style="background-image:url($wp_plugin_url/alt_flags.png);background-position:-200px -0px;"><img src="$wp_plugin_url/blank.png" height="'+16+'" width="'+16+'" alt="'+default_language+'" /></span>'+gt_lang_array[default_language]+'</a>'+new_line;
            else
                widget_preview += '<a href="#" onclick="return false;"><span class="gflag" style="background-position:-'+languages_map[default_language.replace('-', '')+'_x']+'px -'+languages_map[default_language.replace('-', '')+'_y']+'px;"><img src="$wp_plugin_url/blank.png" height="'+16+'" width="'+16+'" alt="'+default_language+'" /></span>'+gt_lang_array[default_language]+'</a>'+new_line;
            widget_preview += '</div>'+new_line;
            widget_preview += '<div class="option">'+new_line;
            jQuery.each(language_codes, function(i, val) {
                lang = language_codes[i];
                if(jQuery('#fincl_langs'+lang+':checked').length) {
                    lang_name = gt_lang_array[lang];
                    flag_x = languages_map[lang.replace('-', '')+'_x'];
                    flag_y = languages_map[lang.replace('-', '')+'_y'];

                    var href = '#';
                    if(pro_version)
                        href = (lang == default_language) ? '$site_url' : '$site_url'.replace('$site_url'.split('/').slice(0, 3).join('/'), '$site_url'.split('/').slice(0, 3).join('/')+'/'+lang);
                    else if(enterprise_version)
                        href = (lang == default_language) ? '$site_url' : '$site_url'.replace('$site_url'.split('/').slice(2, 3)[0].replace('www.', ''), lang + '.' + '$site_url'.split('/').slice(2, 3)[0].replace('www.', '')).replace('://www.', '://');

                    if(lang == 'en' && jQuery('#alt_us:checked').length)
                        widget_preview += '<a href="'+href+'" onclick="doGTranslate(\''+default_language+'|'+lang+'\');jQuery(this).parent().parent().find(\'div.selected a\').html(jQuery(this).html());return false;" title="'+lang_name+'" class="nturl'+(default_language == lang ? ' selected' : '')+'"><span class="gflag" style="background-image:url($wp_plugin_url/alt_flags.png);background-position:-0px -0px;"><img src="$wp_plugin_url/blank.png" height="'+16+'" width="'+16+'" alt="'+lang+'" /></span>'+lang_name+'</a>';
                    else if(lang == 'pt' && jQuery('#alt_br:checked').length)
                        widget_preview += '<a href="'+href+'" onclick="doGTranslate(\''+default_language+'|'+lang+'\');jQuery(this).parent().parent().find(\'div.selected a\').html(jQuery(this).html());return false;" title="'+lang_name+'" class="nturl'+(default_language == lang ? ' selected' : '')+'"><span class="gflag" style="background-image:url($wp_plugin_url/alt_flags.png);background-position:-100px -0px;"><img src="$wp_plugin_url/blank.png" height="'+16+'" width="'+16+'" alt="'+lang+'" /></span>'+lang_name+'</a>';
                    else if(lang == 'es' && jQuery('#alt_mx:checked').length)
                        widget_preview += '<a href="'+href+'" onclick="doGTranslate(\''+default_language+'|'+lang+'\');jQuery(this).parent().parent().find(\'div.selected a\').html(jQuery(this).html());return false;" title="'+lang_name+'" class="nturl'+(default_language == lang ? ' selected' : '')+'"><span class="gflag" style="background-image:url($wp_plugin_url/alt_flags.png);background-position:-200px -0px;"><img src="$wp_plugin_url/blank.png" height="'+16+'" width="'+16+'" alt="'+lang+'" /></span>'+lang_name+'</a>';
                    else
                        widget_preview += '<a href="'+href+'" onclick="doGTranslate(\''+default_language+'|'+lang+'\');jQuery(this).parent().parent().find(\'div.selected a\').html(jQuery(this).html());return false;" title="'+lang_name+'" class="nturl'+(default_language == lang ? ' selected' : '')+'"><span class="gflag" style="background-position:-'+flag_x+'px -'+flag_y+'px;"><img src="$wp_plugin_url/blank.png" height="'+16+'" width="'+16+'" alt="'+lang+'" /></span>'+lang_name+'</a>';
                }
            });

            widget_preview += '</div>'+new_line;
            widget_preview += '</div>'+new_line;

            // Adding slider javascript
            widget_preview += '<script type="text/javascript">'+new_line;
            widget_preview += "jQuery('.switcher .selected').click(function() {if(!(jQuery('.switcher .option').is(':visible'))) {jQuery('.switcher .option').stop(true,true).delay(50).slideDown(500);jQuery('.switcher .selected a').toggleClass('open')}});"+new_line;
            widget_preview += "jQuery('body').not('.switcher .selected').mousedown(function() {if(jQuery('.switcher .option').is(':visible')) {jQuery('.switcher .option').stop(true,true).delay(50).slideUp(500);jQuery('.switcher .selected a').toggleClass('open')}});"+new_line;
            widget_preview += '<\/script>'+new_line;

            // Adding slider css
            widget_preview += '<style type="text/css">'+new_line;
            widget_preview += 'span.gflag {font-size:16px;padding:1px 0;background-repeat:no-repeat;background-image:url($wp_plugin_url/16.png);}'+new_line;
            widget_preview += 'span.gflag img {border:0;margin-top:2px;}'+new_line;
            widget_preview += '.switcher {font-family:Arial;font-size:10pt;text-align:left;cursor:pointer;overflow:hidden;width:163px;line-height:17px;}'+new_line;
            widget_preview += '.switcher a {text-decoration:none;display:block;font-size:10pt;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;}'+new_line;
            widget_preview += '.switcher a span.gflag {margin-right:3px;padding:0;display:block;float:left;}'+new_line;
            widget_preview += '.switcher .selected {background:#FFFFFF url($wp_plugin_url/switcher.png) repeat-x;position:relative;z-index:9999;}'+new_line;
            widget_preview += '.switcher .selected a {border:1px solid #CCCCCC;background:url($wp_plugin_url/arrow_down.png) 146px center no-repeat;color:#666666;padding:3px 5px;width:151px;}'+new_line;
            widget_preview += '.switcher .selected a.open {background-image:url($wp_plugin_url/arrow_up.png)}'+new_line;
            widget_preview += '.switcher .selected a:hover {background:#F0F0F0 url($wp_plugin_url/arrow_down.png) 146px center no-repeat;}'+new_line;
            widget_preview += '.switcher .option {position:relative;z-index:9998;border-left:1px solid #CCCCCC;border-right:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;background-color:#EEEEEE;display:none;width:161px;max-height:198px;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;overflow-y:auto;overflow-x:hidden;}'+new_line;
            widget_preview += '.switcher .option a {color:#000;padding:3px 5px;}'+new_line;
            widget_preview += '.switcher .option a:hover {background:#FFC;}'+new_line;
            widget_preview += '.switcher .option a.selected {background:#FFC;}'+new_line;
            widget_preview += '#selected_lang_name {float: none;}'+new_line;
            widget_preview += '.l_name {float: none !important;margin: 0;}'+new_line;
            widget_preview += '.switcher .option::-webkit-scrollbar-track{-webkit-box-shadow:inset 0 0 3px rgba(0,0,0,0.3);border-radius:5px;background-color:#F5F5F5;}'+new_line;
            widget_preview += '.switcher .option::-webkit-scrollbar {width:5px;}'+new_line;
            widget_preview += '.switcher .option::-webkit-scrollbar-thumb {border-radius:5px;-webkit-box-shadow: inset 0 0 3px rgba(0,0,0,.3);background-color:#888;}'+new_line;
            widget_preview += '</style>'+new_line+new_line;
        }

        // Adding javascript
        //console.log('adding doGTranslate javascript');

        widget_code += new_line+new_line;
        widget_code += '<script type="text/javascript">'+new_line;
        if(pro_version && translation_method == 'redirect' && new_window) {
            widget_code += "function openTab(url) {var form=document.createElement('form');form.method='post';form.action=url;form.target='_blank';document.body.appendChild(form);form.submit();}"+new_line;
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(typeof _gaq!='undefined'){_gaq.push(['_trackEvent', 'GTranslate', lang, location.pathname+location.search]);}else {if(typeof ga!='undefined')ga('send', 'event', 'GTranslate', lang, location.pathname+location.search);}var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang != 'zh-CN' && plang != 'zh-TW')plang='"+default_language+"';if(lang == '"+default_language+"')openTab(location.protocol+'//'+location.host+location.pathname.replace('/'+plang+'/', '/')+location.search);else openTab(location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang+'/', '/')+location.search);}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang != 'zh-CN' && plang != 'zh-TW')plang='"+default_language+"';if(lang == '"+default_language+"')openTab(location.protocol+'//'+location.host+location.pathname.replace('/'+plang+'/', '/')+location.search);else openTab(location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang+'/', '/')+location.search);}"+new_line;
        } else if(pro_version && translation_method == 'redirect') {
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(typeof _gaq!='undefined'){_gaq.push(['_trackEvent', 'GTranslate', lang, location.pathname+location.search]);}else {if(typeof ga!='undefined')ga('send', 'event', 'GTranslate', lang, location.pathname+location.search);}var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang != 'zh-CN' && plang != 'zh-TW')plang='"+default_language+"';if(lang == '"+default_language+"')location.href=location.protocol+'//'+location.host+location.pathname.replace('/'+plang+'/', '/')+location.search;else location.href=location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang+'/', '/')+location.search;}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.pathname.split('/')[1];if(plang.length !=2 && plang != 'zh-CN' && plang != 'zh-TW')plang='"+default_language+"';if(lang == '"+default_language+"')location.href=location.protocol+'//'+location.host+location.pathname.replace('/'+plang+'/', '/')+location.search;else location.href=location.protocol+'//'+location.host+'/'+lang+location.pathname.replace('/'+plang+'/', '/')+location.search;}"+new_line;
        } else if(enterprise_version && translation_method == 'redirect' && new_window) {
            widget_code += "function openTab(url) {var form=document.createElement('form');form.method='post';form.action=url;form.target='_blank';document.body.appendChild(form);form.submit();}"+new_line;
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(typeof _gaq!='undefined'){_gaq.push(['_trackEvent', 'GTranslate', lang, location.hostname+location.pathname+location.search]);}else {if(typeof ga!='undefined')ga('send', 'event', 'GTranslate', lang, location.hostname+location.pathname+location.search);}var plang=location.hostname.split('.')[0];if(plang.length !=2 && plang.toLowerCase() != 'zh-cn' && plang.toLowerCase() != 'zh-tw')plang='"+default_language+"';openTab(location.protocol+'//'+(lang == '"+default_language+"' ? '' : lang+'.')+location.hostname.replace('www.', '').replace(RegExp('^' + plang + '\.'), '')+location.pathname+location.search);}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.hostname.split('.')[0];if(plang.length !=2 && plang.toLowerCase() != 'zh-cn' && plang.toLowerCase() != 'zh-tw')plang='"+default_language+"';openTab(location.protocol+'//'+(lang == '"+default_language+"' ? '' : lang+'.')+location.hostname.replace('www.', '').replace(RegExp('^' + plang + '\.'), '')+location.pathname+location.search);}"+new_line;
        } else if(enterprise_version && translation_method == 'redirect') {
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(typeof _gaq!='undefined'){_gaq.push(['_trackEvent', 'GTranslate', lang, location.hostname+location.pathname+location.search]);}else {if(typeof ga!='undefined')ga('send', 'event', 'GTranslate', lang, location.hostname+location.pathname+location.search);}var plang=location.hostname.split('.')[0];if(plang.length !=2 && plang.toLowerCase() != 'zh-cn' && plang.toLowerCase() != 'zh-tw')plang='"+default_language+"';location.href=location.protocol+'//'+(lang == '"+default_language+"' ? '' : lang+'.')+location.hostname.replace('www.', '').replace(RegExp('^' + plang + '\.'), '')+location.pathname+location.search;}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var plang=location.hostname.split('.')[0];if(plang.length !=2 && plang.toLowerCase() != 'zh-cn' && plang.toLowerCase() != 'zh-tw')plang='"+default_language+"';location.href=location.protocol+'//'+(lang == '"+default_language+"' ? '' : lang+'.')+location.hostname.replace('www.', '').replace(RegExp('^' + plang + '\.'), '')+location.pathname+location.search;}"+new_line;
        } else if(translation_method == 'redirect' && new_window) {
            widget_code += 'if(top.location!=self.location)top.location=self.location;'+new_line;
            widget_code += "window['_tipoff']=function(){};window['_tipon']=function(a){};"+new_line;
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;if(location.hostname!='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')return;var lang=lang_pair.split('|')[1];if(typeof _gaq!='undefined'){_gaq.push(['_trackEvent', 'GTranslate', lang, location.pathname+location.search]);}else {if(typeof ga!='undefined')ga('send', 'event', 'GTranslate', lang, location.pathname+location.search);}if(location.hostname=='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')openTab(unescape(gfg('u')));else if(location.hostname!='translate.googleusercontent.com' && lang_pair!='"+default_language+"|"+default_language+"')openTab('//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+escape(location.href));else openTab('//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+unescape(gfg('u')));}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(location.hostname!='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')return;else if(location.hostname=='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')openTab(unescape(gfg('u')));else if(location.hostname!='translate.googleusercontent.com' && lang_pair!='"+default_language+"|"+default_language+"')openTab('//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+escape(location.href));else openTab('//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+unescape(gfg('u')));}"+new_line;
            widget_code += 'function gfg(name) {name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");var regexS="[\\?&]"+name+"=([^&#]*)";var regex=new RegExp(regexS);var results=regex.exec(location.href);if(results==null)return "";return results[1];}'+new_line;
            widget_code += "function openTab(url) {var form=document.createElement('form');form.method='post';form.action=url;form.target='_blank';document.body.appendChild(form);form.submit();}"+new_line;
        } else if(translation_method == 'redirect') {
            widget_code += 'if(top.location!=self.location)top.location=self.location;'+new_line;
            widget_code += "window['_tipoff']=function(){};window['_tipon']=function(a){};"+new_line;
            if(analytics)
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;if(location.hostname!='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')return;var lang=lang_pair.split('|')[1];if(typeof _gaq!='undefined'){_gaq.push(['_trackEvent', 'GTranslate', lang, location.pathname+location.search]);}else {if(typeof ga!='undefined')ga('send', 'event', 'GTranslate', lang, location.pathname+location.search);}if(location.hostname=='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')location.href=unescape(gfg('u'));else if(location.hostname!='translate.googleusercontent.com' && lang_pair!='"+default_language+"|"+default_language+"')location.href='//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+escape(location.href);else location.href='//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+unescape(gfg('u'));}"+new_line;
            else
                widget_code += "function doGTranslate(lang_pair) {if(lang_pair.value)lang_pair=lang_pair.value;if(location.hostname!='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')return;else if(location.hostname=='translate.googleusercontent.com' && lang_pair=='"+default_language+"|"+default_language+"')location.href=unescape(gfg('u'));else if(location.hostname!='translate.googleusercontent.com' && lang_pair!='"+default_language+"|"+default_language+"')location.href='//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+escape(location.href);else location.href='//translate.google.com/translate?client=tmpg&hl=en&langpair='+lang_pair+'&u='+unescape(gfg('u'));}"+new_line;
            widget_code += 'function gfg(name) {name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");var regexS="[\\?&]"+name+"=([^&#]*)";var regex=new RegExp(regexS);var results=regex.exec(location.href);if(results==null)return "";return results[1];}'+new_line;
        } else if(translation_method == 'onfly') {
            widget_code += "function GTranslateFireEvent(element,event){try{if(document.createEventObject){var evt=document.createEventObject();element.fireEvent('on'+event,evt)}else{var evt=document.createEvent('HTMLEvents');evt.initEvent(event,true,true);element.dispatchEvent(evt)}}catch(e){}}function doGTranslate(lang_pair){if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];var teCombo;var sel=document.getElementsByTagName('select');for(var i=0;i<sel.length;i++)if(sel[i].className=='goog-te-combo')teCombo=sel[i];if(document.getElementById('google_translate_element2')==null||document.getElementById('google_translate_element2').innerHTML.length==0||teCombo.length==0||teCombo.innerHTML.length==0){setTimeout(function(){doGTranslate(lang_pair)},500)}else{teCombo.value=lang;GTranslateFireEvent(teCombo,'change');GTranslateFireEvent(teCombo,'change')}}"+new_line;
            if(widget_look == 'dropdown_with_flags') {
                widget_code += "function GTranslateGetCurrentLang() {var keyValue = document.cookie.match('(^|;) ?googtrans=([^;]*)(;|$)');return keyValue ? keyValue[2].split('/')[2] : null;}"+new_line;
                widget_code += "if(GTranslateGetCurrentLang() != null)jQuery(document).ready(function() {jQuery('div.switcher div.selected a').html(jQuery('div.switcher div.option').find('span.gflag img[alt=\"'+GTranslateGetCurrentLang()+'\"]').parent().parent().html());});"+new_line;
            }
        }

        widget_code += '<\/script>'+new_line;

    }

    widget_code = widget_preview + widget_code;

    jQuery('#widget_code').val(widget_code);

    ShowWidgetPreview(widget_preview);

}

function ShowWidgetPreview(widget_preview) {
    widget_preview = widget_preview.replace(/javascript:doGTranslate/g, 'javascript:void')
    widget_preview = widget_preview.replace('onchange="doGTranslate(this);"', '');
    widget_preview = widget_preview.replace('if(jQuery.cookie', 'if(false && jQuery.cookie');

    jQuery('head').append( jQuery('<link rel="stylesheet" type="text/css" />').attr('href', '$wp_plugin_url/gtranslate-style'+jQuery('#flag_size').val()+'.css') );
    jQuery('#widget_preview').html(widget_preview);
}

jQuery('#pro_version').attr('checked', '$pro_version'.length > 0);
jQuery('#enterprise_version').attr('checked', '$enterprise_version'.length > 0);
jQuery('#new_window').attr('checked', '$new_window'.length > 0);
jQuery('#show_in_primary_menu').attr('checked', '$show_in_primary_menu'.length > 0);
jQuery('#floating_language_selector').val('$floating_language_selector');
jQuery('#analytics').attr('checked', '$analytics'.length > 0);
jQuery('#load_jquery').attr('checked', '$load_jquery'.length > 0);
jQuery('#add_new_line').attr('checked', '$add_new_line'.length > 0);

jQuery('#default_language').val('$default_language');
//jQuery('#translation_method').val('$translation_method');
jQuery('#widget_look').val('$widget_look');
jQuery('#flag_size').val('$flag_size');

if(jQuery('#pro_version:checked').length || jQuery('#enterprise_version:checked').length)
    jQuery('#new_window_option').show();

if('$widget_look' == 'dropdown' || '$widget_look' == 'flags_dropdown' || '$widget_look' == 'globe') {
    jQuery('#dropdown_languages_option').show();
} else {
    jQuery('#dropdown_languages_option').hide();
}

if('$widget_look' == 'globe') {
    jQuery('#alternative_flags_option').show();
} else {
    jQuery('#alternative_flags_option').hide();
}

if('$widget_look' == 'flags' || '$widget_look' == 'flags_dropdown' || '$widget_look' == 'dropdown_with_flags') {
    jQuery('#flag_languages_option').show();
    jQuery('#alternative_flags_option').show();
} else {
    jQuery('#flag_languages_option').hide();
    if('$widget_look' != 'globe')
        jQuery('#alternative_flags_option').hide();
}

if('$widget_look' == 'flags' || '$widget_look' == 'dropdown' || '$widget_look' == 'dropdown_with_flags') {
    jQuery('#line_break_option').hide();
} else {
    jQuery('#line_break_option').show();
}

if('$widget_look' == 'dropdown_with_flags' || '$widget_look' == 'dropdown') {
    jQuery('#flag_size_option').hide();
} else {
    jQuery('#flag_size_option').show();
}

if(jQuery('#widget_code').val() == '')
    RefreshDoWidgetCode();
else
    ShowWidgetPreview(jQuery('#widget_code').val());

jQuery(function(){
    jQuery(".connectedSortable1").sortable({connectWith: ".connectedSortable1"}).disableSelection();
    jQuery(".connectedSortable2").sortable({connectWith: ".connectedSortable2"}).disableSelection();
    jQuery(".connectedSortable1").on("sortstop", function(event, ui) {
        language_codes = jQuery(".connectedSortable1 li input").map(function() {return jQuery(this).val();}).toArray();
        //for(var i = 0; i < language_codes.length; i++)
            //languages[i] = gt_lang_array[language_codes[i]];

        jQuery('#language_codes_order').val(language_codes.join(','));
        RefreshDoWidgetCode();
    });

    jQuery(".connectedSortable2").on("sortstop", function(event, ui) {
        language_codes2 = jQuery(".connectedSortable2 li input").map(function() {return jQuery(this).val();}).toArray();
        //for(var i = 0; i < language_codes.length; i++)
            //languages[i] = gt_lang_array[language_codes[i]];

        jQuery('#language_codes_order2').val(language_codes2.join(','));
        RefreshDoWidgetCode();
    });
});
EOT;

// selected languages
if(count($incl_langs) > 0)
    $script .= "jQuery.each(languages, function(i, val) {jQuery('#incl_langs'+language_codes2[i]).attr('checked', false);});\n";
if(count($fincl_langs) > 0)
    $script .= "jQuery.each(languages, function(i, val) {jQuery('#fincl_langs'+language_codes2[i]).attr('checked', false);});\n";
foreach($incl_langs as $lang)
    $script .= "jQuery('#incl_langs$lang').attr('checked', true);\n";
foreach($fincl_langs as $lang)
    $script .= "jQuery('#fincl_langs$lang').attr('checked', true);\n";

// alt flags
foreach($alt_flags as $flag)
    $script .= "jQuery('#alt_$flag').attr('checked', true);\n";
?>

        <form id="gtranslate" name="form1" method="post" action="<?php echo admin_url('options-general.php?page=gtranslate_options'); ?>">

        <div class="postbox-container og_left_col">

        <div id="poststuff">
            <div class="postbox">
                <h3 id="settings"><?php _e('Widget options', 'gtranslate'); ?></h3>
                <div class="inside">
                    <table style="width:100%;" cellpadding="4">
                    <!--tr>
                        <td class="option_name">Translation method:</td>
                        <td>
                            <select id="translation_method" name="translation_method" onChange="RefreshDoWidgetCode()">
                                <option value="google_default">Google Default</option>
                                <option value="redirect">Redirect</option>
                                <option value="onfly">On Fly</option>
                            </select>
                        </td>
                    </tr-->
                    <tr>
                        <td class="option_name"><?php _e('Widget look', 'gtranslate'); ?>:</td>
                        <td>
                            <select id="widget_look" name="widget_look" onChange="RefreshDoWidgetCode()">
                                <option value="flags_dropdown"><?php _e('Flags and dropdown', 'gtranslate'); ?></option>
                                <option value="dropdown_with_flags"><?php _e('Nice dropdown with flags', 'gtranslate'); ?></option>
                                <option value="dropdown"><?php _e('Dropdown', 'gtranslate'); ?></option>
                                <option value="flags"><?php _e('Flags', 'gtranslate'); ?></option>
                                <option value="globe"><?php _e('Globe', 'gtranslate'); ?> (beta)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="option_name"><?php _e('Translate from', 'gtranslate'); ?>:</td>
                        <td>
                            <select id="default_language" name="default_language" onChange="RefreshDoWidgetCode()">
                                <option value="af"><?php _e('Afrikaans', 'gtranslate'); ?></option>
                                <option value="sq"><?php _e('Albanian', 'gtranslate'); ?></option>
                                <option value="am"><?php _e('Amharic', 'gtranslate'); ?></option>
                                <option value="ar"><?php _e('Arabic', 'gtranslate'); ?></option>
                                <option value="hy"><?php _e('Armenian', 'gtranslate'); ?></option>
                                <option value="az"><?php _e('Azerbaijani', 'gtranslate'); ?></option>
                                <option value="eu"><?php _e('Basque', 'gtranslate'); ?></option>
                                <option value="be"><?php _e('Belarusian', 'gtranslate'); ?></option>
                                <option value="bn"><?php _e('Bengali', 'gtranslate'); ?></option>
                                <option value="bs"><?php _e('Bosnian', 'gtranslate'); ?></option>
                                <option value="bg"><?php _e('Bulgarian', 'gtranslate'); ?></option>
                                <option value="ca"><?php _e('Catalan', 'gtranslate'); ?></option>
                                <option value="ceb"><?php _e('Cebuano', 'gtranslate'); ?></option>
                                <option value="ny"><?php _e('Chichewa', 'gtranslate'); ?></option>
                                <option value="zh-CN"><?php _e('Chinese (Simplified)', 'gtranslate'); ?></option>
                                <option value="zh-TW"><?php _e('Chinese (Traditional)', 'gtranslate'); ?></option>
                                <option value="co"><?php _e('Corsican', 'gtranslate'); ?></option>
                                <option value="hr"><?php _e('Croatian', 'gtranslate'); ?></option>
                                <option value="cs"><?php _e('Czech', 'gtranslate'); ?></option>
                                <option value="da"><?php _e('Danish', 'gtranslate'); ?></option>
                                <option value="nl"><?php _e('Dutch', 'gtranslate'); ?></option>
                                <option value="en" selected="selected"><?php _e('English', 'gtranslate'); ?></option>
                                <option value="eo"><?php _e('Esperanto', 'gtranslate'); ?></option>
                                <option value="et"><?php _e('Estonian', 'gtranslate'); ?></option>
                                <option value="tl"><?php _e('Filipino', 'gtranslate'); ?></option>
                                <option value="fi"><?php _e('Finnish', 'gtranslate'); ?></option>
                                <option value="fr"><?php _e('French', 'gtranslate'); ?></option>
                                <option value="fy"><?php _e('Frisian', 'gtranslate'); ?></option>
                                <option value="gl"><?php _e('Galician', 'gtranslate'); ?></option>
                                <option value="ka"><?php _e('Georgian', 'gtranslate'); ?></option>
                                <option value="de"><?php _e('German', 'gtranslate'); ?></option>
                                <option value="el"><?php _e('Greek', 'gtranslate'); ?></option>
                                <option value="gu"><?php _e('Gujarati', 'gtranslate'); ?></option>
                                <option value="ht"><?php _e('Haitian Creole', 'gtranslate'); ?></option>
                                <option value="ha"><?php _e('Hausa', 'gtranslate'); ?></option>
                                <option value="haw"><?php _e('Hawaiian', 'gtranslate'); ?></option>
                                <option value="iw"><?php _e('Hebrew', 'gtranslate'); ?></option>
                                <option value="hi"><?php _e('Hindi', 'gtranslate'); ?></option>
                                <option value="hmn"><?php _e('Hmong', 'gtranslate'); ?></option>
                                <option value="hu"><?php _e('Hungarian', 'gtranslate'); ?></option>
                                <option value="is"><?php _e('Icelandic', 'gtranslate'); ?></option>
                                <option value="ig"><?php _e('Igbo', 'gtranslate'); ?></option>
                                <option value="id"><?php _e('Indonesian', 'gtranslate'); ?></option>
                                <option value="ga"><?php _e('Irish', 'gtranslate'); ?></option>
                                <option value="it"><?php _e('Italian', 'gtranslate'); ?></option>
                                <option value="ja"><?php _e('Japanese', 'gtranslate'); ?></option>
                                <option value="jw"><?php _e('Javanese', 'gtranslate'); ?></option>
                                <option value="kn"><?php _e('Kannada', 'gtranslate'); ?></option>
                                <option value="kk"><?php _e('Kazakh', 'gtranslate'); ?></option>
                                <option value="km"><?php _e('Khmer', 'gtranslate'); ?></option>
                                <option value="ko"><?php _e('Korean', 'gtranslate'); ?></option>
                                <option value="ku"><?php _e('Kurdish (Kurmanji)', 'gtranslate'); ?></option>
                                <option value="ky"><?php _e('Kyrgyz', 'gtranslate'); ?></option>
                                <option value="lo"><?php _e('Lao', 'gtranslate'); ?></option>
                                <option value="la"><?php _e('Latin', 'gtranslate'); ?></option>
                                <option value="lv"><?php _e('Latvian', 'gtranslate'); ?></option>
                                <option value="lt"><?php _e('Lithuanian', 'gtranslate'); ?></option>
                                <option value="lb"><?php _e('Luxembourgish', 'gtranslate'); ?></option>
                                <option value="mk"><?php _e('Macedonian', 'gtranslate'); ?></option>
                                <option value="mg"><?php _e('Malagasy', 'gtranslate'); ?></option>
                                <option value="ms"><?php _e('Malay', 'gtranslate'); ?></option>
                                <option value="ml"><?php _e('Malayalam', 'gtranslate'); ?></option>
                                <option value="mt"><?php _e('Maltese', 'gtranslate'); ?></option>
                                <option value="mi"><?php _e('Maori', 'gtranslate'); ?></option>
                                <option value="mr"><?php _e('Marathi', 'gtranslate'); ?></option>
                                <option value="mn"><?php _e('Mongolian', 'gtranslate'); ?></option>
                                <option value="my"><?php _e('Myanmar (Burmese)', 'gtranslate'); ?></option>
                                <option value="ne"><?php _e('Nepali', 'gtranslate'); ?></option>
                                <option value="no"><?php _e('Norwegian', 'gtranslate'); ?></option>
                                <option value="ps"><?php _e('Pashto', 'gtranslate'); ?></option>
                                <option value="fa"><?php _e('Persian', 'gtranslate'); ?></option>
                                <option value="pl"><?php _e('Polish', 'gtranslate'); ?></option>
                                <option value="pt"><?php _e('Portuguese', 'gtranslate'); ?></option>
                                <option value="pa"><?php _e('Punjabi', 'gtranslate'); ?></option>
                                <option value="ro"><?php _e('Romanian', 'gtranslate'); ?></option>
                                <option value="ru"><?php _e('Russian', 'gtranslate'); ?></option>
                                <option value="sm"><?php _e('Samoan', 'gtranslate'); ?></option>
                                <option value="gd"><?php _e('Scottish Gaelic', 'gtranslate'); ?></option>
                                <option value="sr"><?php _e('Serbian', 'gtranslate'); ?></option>
                                <option value="st"><?php _e('Sesotho', 'gtranslate'); ?></option>
                                <option value="sn"><?php _e('Shona', 'gtranslate'); ?></option>
                                <option value="sd"><?php _e('Sindhi', 'gtranslate'); ?></option>
                                <option value="si"><?php _e('Sinhala', 'gtranslate'); ?></option>
                                <option value="sk"><?php _e('Slovak', 'gtranslate'); ?></option>
                                <option value="sl"><?php _e('Slovenian', 'gtranslate'); ?></option>
                                <option value="so"><?php _e('Somali', 'gtranslate'); ?></option>
                                <option value="es"><?php _e('Spanish', 'gtranslate'); ?></option>
                                <option value="su"><?php _e('Sudanese', 'gtranslate'); ?></option>
                                <option value="sw"><?php _e('Swahili', 'gtranslate'); ?></option>
                                <option value="sv"><?php _e('Swedish', 'gtranslate'); ?></option>
                                <option value="tg"><?php _e('Tajik', 'gtranslate'); ?></option>
                                <option value="ta"><?php _e('Tamil', 'gtranslate'); ?></option>
                                <option value="te"><?php _e('Telugu', 'gtranslate'); ?></option>
                                <option value="th"><?php _e('Thai', 'gtranslate'); ?></option>
                                <option value="tr"><?php _e('Turkish', 'gtranslate'); ?></option>
                                <option value="uk"><?php _e('Ukrainian', 'gtranslate'); ?></option>
                                <option value="ur"><?php _e('Urdu', 'gtranslate'); ?></option>
                                <option value="uz"><?php _e('Uzbek', 'gtranslate'); ?></option>
                                <option value="vi"><?php _e('Vietnamese', 'gtranslate'); ?></option>
                                <option value="cy"><?php _e('Welsh', 'gtranslate'); ?></option>
                                <option value="xh"><?php _e('Xhosa', 'gtranslate'); ?></option>
                                <option value="yi"><?php _e('Yiddish', 'gtranslate'); ?></option>
                                <option value="yo"><?php _e('Yoruba', 'gtranslate'); ?></option>
                                <option value="zu"><?php _e('Zulu', 'gtranslate'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="option_name"><?php _e('Analytics', 'gtranslate'); ?>:</td>
                        <td><input id="analytics" name="analytics" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr>
                    <tr>
                        <td class="option_name">* <?php _e('Sub-directory URL structure', 'gtranslate'); ?>:<br><code><small>http://example.com/<b>ru</b>/</small></code></td>
                        <td><input id="pro_version" name="pro_version" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/> <a href="https://gtranslate.io/?xyz=998#pricing" target="_blank">* <?php _e('paid plans only', 'gtranslate'); ?></a></td>
                    </tr>
                    <tr>
                        <td class="option_name">* <?php _e('Sub-domain URL structure', 'gtranslate'); ?>:<br><code><small>http://<b>es</b>.example.com/</small></code></td>
                        <td><input id="enterprise_version" name="enterprise_version" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/> <a href="https://gtranslate.io/?xyz=998#pricing" target="_blank">* <?php _e('paid plans only', 'gtranslate'); ?></a></td>
                    </tr>
                    <tr id="new_window_option" style="display:none;">
                        <td class="option_name"><?php _e('Open in new window', 'gtranslate'); ?>:</td>
                        <td><input id="new_window" name="new_window" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr>
                    <tr>
                        <td class="option_name"><?php _e('Show in primary menu', 'gtranslate'); ?>:</td>
                        <td><input id="show_in_primary_menu" name="show_in_primary_menu" value="1" type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr>
                    <tr id="floating_option">
                        <td class="option_name"><?php _e('Show floating language selector', 'gtranslate'); ?>:</td>
                        <td>
                            <select id="floating_language_selector" name="floating_language_selector">
                                <option value="no"><?php _e('No', 'gtranslate'); ?></option>
                                <option value="top_left"><?php _e('Top left', 'gtranslate'); ?></option>
                                <option value="top_right"><?php _e('Top right', 'gtranslate'); ?></option>
                                <option value="bottom_left"><?php _e('Bottom left', 'gtranslate'); ?></option>
                                <option value="bottom_right"><?php _e('Bottom right', 'gtranslate'); ?></option>
                            </select>
                        </td>
                    </tr>

                    <!--tr>
                        <td class="option_name">Show flags:</td>
                        <td><input id="show_flags" name="show_flags" value="1" type="checkbox" checked="checked" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr-->
                    <tr id="flag_size_option">
                        <td class="option_name"><?php _e('Flag size', 'gtranslate'); ?>:</td>
                        <td>
                        <select id="flag_size"  name="flag_size" onchange="RefreshDoWidgetCode()">
                            <option value="16" selected>16px</option>
                            <option value="24">24px</option>
                            <option value="32">32px</option>
                        </select>
                        </td>
                    </tr>
                    <tr id="flag_languages_option" style="display:none;">
                        <td class="option_name" colspan="2"><?php _e('Flag languages', 'gtranslate'); ?>: <a onclick="jQuery('.connectedSortable1 input').attr('checked', true);RefreshDoWidgetCode()" style="cursor:pointer;text-decoration:underline;"><?php _e('Check All', 'gtranslate'); ?></a> | <a onclick="jQuery('.connectedSortable1 input').attr('checked', false);RefreshDoWidgetCode()" style="cursor:pointer;text-decoration:underline;"><?php _e('Uncheck All', 'gtranslate'); ?></a><br /><br />

                        <div style="overflow:hidden;">
                        <?php $gt_lang_codes = explode(',', $language_codes); ?>
                        <?php for($i = 0; $i < 58 / 15; $i++): ?>
                        <ul style="list-style-type:none;width:25%;float:left;" class="connectedSortable1">
                            <?php for($j = $i * 15; $j < 15 * ($i+1); $j++): ?>
                            <?php if(isset($gt_lang_codes[$j])): ?>
                            <li><input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="fincl_langs<?php echo $gt_lang_codes[$j]; ?>" name="fincl_langs[]" value="<?php echo $gt_lang_codes[$j]; ?>"><label for="fincl_langs<?php echo $gt_lang_codes[$j]; ?>"><?php _e($gt_lang_array[$gt_lang_codes[$j]], 'gtranslate'); ?></label></li>
                            <?php endif; ?>
                            <?php endfor; ?>
                        </ul>
                        <?php endfor; ?>
                        </div>
                        </td>
                    </tr>
                    <tr id="alternative_flags_option" style="display:none;">
                        <td class="option_name" colspan="2"><?php _e('Alternative flags', 'gtranslate'); ?>:<br /><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="alt_us" name="alt_flags[]" value="us"><label for="alt_us"><?php _e('USA flag', 'gtranslate'); ?></label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="alt_br" name="alt_flags[]" value="br"><label for="alt_br"><?php _e('Brazil flag', 'gtranslate'); ?></label><br />
                        <input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="alt_mx" name="alt_flags[]" value="mx"><label for="alt_mx"><?php _e('Mexico flag', 'gtranslate'); ?></label><br />
                        </td>
                    </tr>
                    <tr id="line_break_option" style="display:none;">
                        <td class="option_name"><?php _e('Line break after flags', 'gtranslate'); ?>:</td>
                        <td><input id="add_new_line" name="add_new_line" value="1" type="checkbox" checked="checked" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr>
                    <!--tr>
                        <td class="option_name">Show dropdown:</td>
                        <td><input id="show_dropdown" name="show_dropdown" value="1" type="checkbox" checked="checked" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()"/></td>
                    </tr-->
                    <tr id="dropdown_languages_option" style="display:none;">
                        <td class="option_name" colspan="2"><?php _e('Languages', 'gtranslate'); ?>: <a onclick="jQuery('.connectedSortable2 input').attr('checked', true);RefreshDoWidgetCode()" style="cursor:pointer;text-decoration:underline;"><?php _e('Check All', 'gtranslate'); ?></a> | <a onclick="jQuery('.connectedSortable2 input').attr('checked', false);RefreshDoWidgetCode()" style="cursor:pointer;text-decoration:underline;"><?php _e('Uncheck All', 'gtranslate'); ?></a><br /><br />
                        <div>
                        <?php $gt_lang_codes = explode(',', $language_codes2); ?>
                        <?php for($i = 0; $i < count($gt_lang_array) / 26; $i++): ?>
                        <ul style="list-style-type:none;width:25%;float:left;" class="connectedSortable2">
                            <?php for($j = $i * 26; $j < 26 * ($i+1); $j++): ?>
                            <?php if(isset($gt_lang_codes[$j])): ?>
                            <li><input type="checkbox" onclick="RefreshDoWidgetCode()" onchange="RefreshDoWidgetCode()" id="incl_langs<?php echo $gt_lang_codes[$j]; ?>" name="incl_langs[]" value="<?php echo $gt_lang_codes[$j]; ?>"><label for="incl_langs<?php echo $gt_lang_codes[$j]; ?>"><?php _e($gt_lang_array[$gt_lang_codes[$j]], 'gtranslate'); ?></label></li>
                            <?php endif; ?>
                            <?php endfor; ?>
                        </ul>
                        <?php endfor; ?>
                        </div>
                        </td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>

        <div id="poststuff">
            <div class="postbox">
                <h3 id="settings"><?php _e('Widget code', 'gtranslate'); ?></h3>
                <div class="inside">
                    <?php _e('You can edit this if you wish', 'gtranslate'); ?>:<br />
                    <textarea id="widget_code" name="widget_code" onchange="ShowWidgetPreview(this.value)" style="font-family:Monospace;font-size:11px;height:150px;width:565px;"><?php echo $widget_code; ?></textarea><br />
                    <span style="color:red;"><?php _e('DO NOT COPY THIS INTO YOUR POSTS OR PAGES! Use [GTranslate] shortcode inside the post/page <br />or add a GTranslate widget into your sidebar from Appearance -> Widgets instead.', 'gtranslate'); ?></span><br /><br />
                    <?php _e('You can also use <code>&lt;?php echo do_shortcode(\'[gtranslate]\'); ?&gt;</code> in your template header/footer files.', 'gtranslate'); ?>
                </div>
            </div>
        </div>

        <input type="hidden" id="language_codes_order" name="language_codes" value="<?php echo $language_codes; ?>" />
        <input type="hidden" id="language_codes_order2" name="language_codes2" value="<?php echo $language_codes2; ?>" />
        <?php wp_nonce_field('gtranslate-save'); ?>
        <p class="submit"><input type="submit" class="button-primary" name="save" value="<?php _e('Save Changes'); ?>" /></p>

        </div>

        </form>

        <div class="postbox-container og_right_col">
            <div id="poststuff">
                <div class="postbox">
                    <h3 id="settings"><?php _e('Widget preview', 'gtranslate'); ?></h3>
                    <div class="inside">
                        <div id="widget_preview"></div>
                    </div>
                </div>
            </div>

            <div id="poststuff">
                <div class="postbox">
                    <h3 id="settings"><?php _e('Do you like GTranslate?', 'gtranslate'); ?></h3>
                    <div class="inside">
                        <p><?php _e('Please write a review on', 'gtranslate'); ?> <a href="https://wordpress.org/support/view/plugin-reviews/gtranslate?filter=5">WordPress.org</a>.</p>

                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                          var js, fjs = d.getElementsByTagName(s)[0];
                          if (d.getElementById(id)) return;
                          js = d.createElement(s); js.id = id;
                          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=231165476898475";
                          fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>

                        <div class="fb-page" data-href="https://www.facebook.com/gtranslate" data-width="450" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/gtranslate"><a href="https://www.facebook.com/gtranslate">GTranslate</a></blockquote></div></div>

                    </div>
                </div>
            </div>

            <div id="poststuff">
                <div class="postbox">
                    <h3 id="settings"><?php _e('Useful info', 'gtranslate'); ?></h3>
                    <div class="inside">
                        <?php _e('Upgrade to <a href="https://gtranslate.io/?xyz=998#pricing" target="_blank">GTranslate Enterprise</a> to have the following features', 'gtranslate'); ?>:
                        <ul style="list-style-type: square;padding-left:40px;">
                            <li><?php _e('Enable search engine indexing', 'gtranslate'); ?></li>
                            <li><?php _e('Search engine friendly (SEF) URLs', 'gtranslate'); ?></li>
                            <li><?php _e('Increase traffic and AdSense revenue', 'gtranslate'); ?></li>
                            <li><?php _e('Meta data translation', 'gtranslate'); ?></li>
                            <li><?php _e('Edit translations manually', 'gtranslate'); ?></li>
                            <li><?php _e('URL translation', 'gtranslate'); ?></li>
                            <li><?php _e('Language hosting', 'gtranslate'); ?></li>
                            <li><?php _e('Seamless updates', 'gtranslate'); ?></li>
                            <li><?php _e('SSL support', 'gtranslate'); ?></li>
                        </ul>

                        <a href="https://gtranslate.io/?xyz=998#pricing" target="_blank"><?php _e('More Info', 'gtranslate'); ?></a>
                    </div>
                </div>
            </div>
            <div id="poststuff">
                <div class="postbox">
                    <h3 id="settings"><?php _e('GTranslate Tour Video', 'gtranslate'); ?></h3>
                    <div class="inside">
                        <iframe src="//player.vimeo.com/video/30132555?title=1&amp;byline=0&amp;portrait=0" width="568" height="360" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    </div>
                </div>
            </div>
            <div id="poststuff">
                <div class="postbox">
                    <h3 id="settings"><?php _e('Translation Delivery Network', 'gtranslate'); ?></h3>
                    <div class="inside">
                        <iframe src="//player.vimeo.com/video/38686858?title=1&amp;byline=0&amp;portrait=0" width="568" height="360" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript"><?php echo $script; ?></script>
        <style type="text/css">
        .postbox #settings {padding-left:12px;}
        .og_left_col {      width: 59%;     }
        .og_right_col {     width: 39%;     float: right;       }
        .og_left_col #poststuff,        .og_right_col #poststuff {      min-width: 0;       }
        table.form-table tr th,     table.form-table tr td {        line-height: 1.5;       }
        table.form-table tr th {        font-weight: bold;      }
        table.form-table tr th[scope=row] { min-width: 300px;       }
        table.form-table tr td hr {     height: 1px;        margin: 0px;        background-color: #DFDFDF;      border: none;       }
        table.form-table .dashicons-before {        margin-right: 10px;     font-size: 12px;        opacity: 0.5;       }
        table.form-table .dashicons-facebook-alt {      color: #3B5998;     }
        table.form-table .dashicons-googleplus {        color: #D34836;     }
        table.form-table .dashicons-twitter {       color: #55ACEE;     }
        table.form-table .dashicons-rss {       color: #FF6600;     }
        table.form-table .dashicons-admin-site,     table.form-table .dashicons-admin-generic {     color: #666;        }

        .connectedSortable1, .connectedSortable1 li, .connectedSortable2, .connectedSortable2 li {margin:0;padding:0;}
        .connectedSortable1 li label, .connectedSortable2 li label {cursor:move;}
        </style>

        <!-- Live Chat for GTranslate -->
        <script>var _glc =_glc || [];_glc.push('all_ag9zfmNsaWNrZGVza2NoYXRyDgsSBXVzZXJzGM3hxwQM');var glcpath = (('https:' == document.location.protocol) ? 'https://my.clickdesk.com/clickdesk-ui/browser/' : 'http://my.clickdesk.com/clickdesk-ui/browser/');var glcp = (('https:' == document.location.protocol) ? 'https://' : 'http://');var glcspt = document.createElement('script'); glcspt.type = 'text/javascript'; glcspt.async = true; glcspt.src = glcpath + 'livechat-new.js';var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(glcspt, s);</script>
        <?php
    }

    public static function control_options() {
        check_admin_referer('gtranslate-save');

        $data = get_option('GTranslate');

        $data['pro_version'] = isset($_POST['pro_version']) ? intval($_POST['pro_version']) : '';
        $data['enterprise_version'] = isset($_POST['enterprise_version']) ? intval($_POST['enterprise_version']) : '';
        $data['new_window'] = isset($_POST['new_window']) ? intval($_POST['new_window']) : '';
        $data['show_in_primary_menu'] = isset($_POST['show_in_primary_menu']) ? intval($_POST['show_in_primary_menu']) : '';
        $data['floating_language_selector'] = isset($_POST['floating_language_selector']) ? sanitize_text_field($_POST['floating_language_selector']) : 'no';
        $data['analytics'] = isset($_POST['analytics']) ? intval($_POST['analytics']) : '';
        $data['load_jquery'] = isset($_POST['load_jquery']) ? intval($_POST['load_jquery']) : '';
        $data['add_new_line'] = isset($_POST['add_new_line']) ? intval($_POST['add_new_line']) : '';
        $data['default_language'] = isset($_POST['default_language']) ? sanitize_text_field($_POST['default_language']) : 'en';
        $data['translation_method'] = 'onfly';
        $data['widget_look'] = isset($_POST['widget_look']) ? sanitize_text_field($_POST['widget_look']) : 'flags_dropdown';
        $data['flag_size'] = isset($_POST['flag_size']) ? intval($_POST['flag_size']) : '16';
        $data['widget_code'] = isset($_POST['widget_code']) ? stripslashes($_POST['widget_code']) : '';
        $data['incl_langs'] = (isset($_POST['incl_langs']) and is_array($_POST['incl_langs'])) ? $_POST['incl_langs'] : array('en');
        $data['fincl_langs'] = (isset($_POST['fincl_langs']) and is_array($_POST['fincl_langs'])) ? $_POST['fincl_langs'] : array('en');
        $data['alt_flags'] = (isset($_POST['alt_flags']) and is_array($_POST['alt_flags'])) ? $_POST['alt_flags'] : array();
        $data['language_codes'] = (isset($_POST['language_codes']) and !empty($_POST['language_codes'])) ? sanitize_text_field($_POST['language_codes']) : 'af,sq,ar,hy,az,eu,be,bg,ca,zh-CN,zh-TW,hr,cs,da,nl,en,et,tl,fi,fr,gl,ka,de,el,ht,iw,hi,hu,is,id,ga,it,ja,ko,lv,lt,mk,ms,mt,no,fa,pl,pt,ro,ru,sr,sk,sl,es,sw,sv,th,tr,uk,ur,vi,cy,yi';
        $data['language_codes2'] = (isset($_POST['language_codes2']) and !empty($_POST['language_codes2'])) ? sanitize_text_field($_POST['language_codes2']) : 'af,sq,am,ar,hy,az,eu,be,bn,bs,bg,ca,ceb,ny,zh-CN,zh-TW,co,hr,cs,da,nl,en,eo,et,tl,fi,fr,fy,gl,ka,de,el,gu,ht,ha,haw,iw,hi,hmn,hu,is,ig,id,ga,it,ja,jw,kn,kk,km,ko,ku,ky,lo,la,lv,lt,lb,mk,mg,ms,ml,mt,mi,mr,mn,my,ne,no,ps,fa,pl,pt,pa,ro,ru,sm,gd,sr,st,sn,sd,si,sk,sl,so,es,su,sw,sv,tg,ta,te,th,tr,uk,ur,uz,vi,cy,xh,yi,yo,zu';

        echo '<p style="color:red;">' . __('Changes Saved') . '</p>';
        update_option('GTranslate', $data);
    }

    public static function load_defaults(& $data) {
        $data['pro_version'] = isset($data['pro_version']) ? $data['pro_version'] : '';
        $data['enterprise_version'] = isset($data['enterprise_version']) ? $data['enterprise_version'] : '';
        $data['new_window'] = isset($data['new_window']) ? $data['new_window'] : '';
        $data['show_in_primary_menu'] = isset($data['show_in_primary_menu']) ? $data['show_in_primary_menu'] : '';
        $data['floating_language_selector'] = isset($data['floating_language_selector']) ? $data['floating_language_selector'] : 'no';
        $data['analytics'] = isset($data['analytics']) ? $data['analytics'] : '';
        $data['load_jquery'] = isset($data['load_jquery']) ? $data['load_jquery'] : '1';
        $data['add_new_line'] = isset($data['add_new_line']) ? $data['add_new_line'] : '1';
        //$data['show_dropdown'] = isset($data['show_dropdown']) ? $data['show_dropdown'] : '1';
        //$data['show_flags'] = isset($data['show_flags']) ? $data['show_flags'] : '1';
        $data['default_language'] = isset($data['default_language']) ? $data['default_language'] : 'en';
        $data['translation_method'] = isset($data['translation_method']) ? $data['translation_method'] : 'onfly';
        if($data['translation_method'] == 'on_fly') $data['translation_method'] = 'redirect';
        $data['widget_look'] = isset($data['widget_look']) ? $data['widget_look'] : 'flags_dropdown';
        $data['flag_size'] = isset($data['flag_size']) ? $data['flag_size'] : '16';
        $data['widget_code'] = isset($data['widget_code']) ? $data['widget_code'] : '';
        $data['incl_langs'] = isset($data['incl_langs']) ? $data['incl_langs'] : array();
        $data['fincl_langs'] = isset($data['fincl_langs']) ? $data['fincl_langs'] : array();
        $data['alt_flags'] = isset($data['alt_flags']) ? $data['alt_flags'] : array();
        $data['language_codes'] = (isset($data['language_codes']) and !empty($data['language_codes'])) ? $data['language_codes'] : 'af,sq,ar,hy,az,eu,be,bg,ca,zh-CN,zh-TW,hr,cs,da,nl,en,et,tl,fi,fr,gl,ka,de,el,ht,iw,hi,hu,is,id,ga,it,ja,ko,lv,lt,mk,ms,mt,no,fa,pl,pt,ro,ru,sr,sk,sl,es,sw,sv,th,tr,uk,ur,vi,cy,yi';
        $data['language_codes2'] = (isset($data['language_codes2']) and !empty($data['language_codes2'])) ? $data['language_codes2'] : 'af,sq,am,ar,hy,az,eu,be,bn,bs,bg,ca,ceb,ny,zh-CN,zh-TW,co,hr,cs,da,nl,en,eo,et,tl,fi,fr,fy,gl,ka,de,el,gu,ht,ha,haw,iw,hi,hmn,hu,is,ig,id,ga,it,ja,jw,kn,kk,km,ko,ku,ky,lo,la,lv,lt,lb,mk,mg,ms,ml,mt,mi,mr,mn,my,ne,no,ps,fa,pl,pt,pa,ro,ru,sm,gd,sr,st,sn,sd,si,sk,sl,so,es,su,sw,sv,tg,ta,te,th,tr,uk,ur,uz,vi,cy,xh,yi,yo,zu';
    }
}

class GTranslate_Notices {
    protected $prefix = 'gtranslate';
    public $notice_spam = 0;
    public $notice_spam_max = 1;

    // Basic actions to run
    public function __construct() {
        // Runs the admin notice ignore function incase a dismiss button has been clicked
        add_action('admin_init', array($this, 'admin_notice_ignore'));
        // Runs the admin notice temp ignore function incase a temp dismiss link has been clicked
        add_action('admin_init', array($this, 'admin_notice_temp_ignore'));

        // Adding notices
        add_action('admin_notices', array($this, 'gt_admin_notices'));
    }

    // Checks to ensure notices aren't disabled and the user has the correct permissions.
    public function gt_admin_notice() {

        $gt_settings = get_option($this->prefix . '_admin_notice');
        if (!isset($gt_settings['disable_admin_notices']) || (isset($gt_settings['disable_admin_notices']) && $gt_settings['disable_admin_notices'] == 0)) {
            if (current_user_can('manage_options')) {
                return true;
            }
        }
        return false;
    }

    // Primary notice function that can be called from an outside function sending necessary variables
    public function admin_notice($admin_notices) {

        // Check options
        if (!$this->gt_admin_notice()) {
            return false;
        }

        foreach ($admin_notices as $slug => $admin_notice) {
            // Call for spam protection

            if ($this->anti_notice_spam()) {
                return false;
            }

            // Check for proper page to display on
            if (isset( $admin_notices[$slug]['pages']) and is_array( $admin_notices[$slug]['pages'])) {

                if (!$this->admin_notice_pages($admin_notices[$slug]['pages'])) {
                    return false;
                }

            }

            // Check for required fields
            if (!$this->required_fields($admin_notices[$slug])) {

                // Get the current date then set start date to either passed value or current date value and add interval
                $current_date = current_time("n/j/Y");
                $start = (isset($admin_notices[$slug]['start']) ? $admin_notices[$slug]['start'] : $current_date);
                $start = date("n/j/Y", strtotime($start));
                $end = ( isset( $admin_notices[ $slug ]['end'] ) ? $admin_notices[ $slug ]['end'] : $start );
                $end = date( "n/j/Y", strtotime( $end ) );
                $date_array = explode('/', $start);
                $interval = (isset($admin_notices[$slug]['int']) ? $admin_notices[$slug]['int'] : 0);
                $date_array[1] += $interval;
                $start = date("n/j/Y", mktime(0, 0, 0, $date_array[0], $date_array[1], $date_array[2]));
                // This is the main notices storage option
                $admin_notices_option = get_option($this->prefix . '_admin_notice', array());
                // Check if the message is already stored and if so just grab the key otherwise store the message and its associated date information
                if (!array_key_exists( $slug, $admin_notices_option)) {
                    $admin_notices_option[$slug]['start'] = $start;
                    $admin_notices_option[$slug]['int'] = $interval;
                    update_option($this->prefix . '_admin_notice', $admin_notices_option);
                }

                // Sanity check to ensure we have accurate information
                // New date information will not overwrite old date information
                $admin_display_check = (isset($admin_notices_option[$slug]['dismissed']) ? $admin_notices_option[$slug]['dismissed'] : 0);
                $admin_display_start = (isset($admin_notices_option[$slug]['start']) ? $admin_notices_option[$slug]['start'] : $start);
                $admin_display_interval = (isset($admin_notices_option[$slug]['int']) ? $admin_notices_option[$slug]['int'] : $interval);
                $admin_display_msg = (isset($admin_notices[$slug]['msg']) ? $admin_notices[$slug]['msg'] : '');
                $admin_display_title = (isset($admin_notices[$slug]['title']) ? $admin_notices[$slug]['title'] : '');
                $admin_display_link = (isset($admin_notices[$slug]['link']) ? $admin_notices[$slug]['link'] : '');
                $output_css = false;

                // Ensure the notice hasn't been hidden and that the current date is after the start date
                if ($admin_display_check == 0 and strtotime($admin_display_start) <= strtotime($current_date)) {
                    // Get remaining query string
                    $query_str = esc_url(add_query_arg($this->prefix . '_admin_notice_ignore', $slug));

                    // Admin notice display output
                    echo '<div class="update-nag gt-admin-notice">';
                    echo '<div class="gt-notice-logo"></div>';
                    echo ' <p class="gt-notice-title">';
                    echo $admin_display_title;
                    echo ' </p>';
                    echo ' <p class="gt-notice-body">';
                    echo $admin_display_msg;
                    echo ' </p>';
                    echo '<ul class="gt-notice-body gt-red">
                          ' . $admin_display_link . '
                        </ul>';
                    echo '<a href="' . $query_str . '" class="dashicons dashicons-dismiss"></a>';
                    echo '</div>';

                    $this->notice_spam += 1;
                    $output_css = true;
                }

                if ($output_css) {
                    wp_enqueue_style($this->prefix . '-admin-notices', plugins_url(plugin_basename(dirname(__FILE__))) . '/gtranslate-notices.css', array());
                }
            }

        }
    }

    // Spam protection check
    public function anti_notice_spam() {
        if ($this->notice_spam >= $this->notice_spam_max) {
            return true;
        }
        return false;
    }

    // Ignore function that gets ran at admin init to ensure any messages that were dismissed get marked
    public function admin_notice_ignore() {
        // If user clicks to ignore the notice, update the option to not show it again
        if (isset($_GET[$this->prefix . '_admin_notice_ignore'])) {
            $admin_notices_option = get_option($this->prefix . '_admin_notice', array());
            $admin_notices_option[$_GET[$this->prefix . '_admin_notice_ignore']]['dismissed'] = 1;
            update_option($this->prefix . '_admin_notice', $admin_notices_option);
            $query_str = remove_query_arg($this->prefix . '_admin_notice_ignore');
            wp_redirect($query_str);
            exit;
        }
    }

    // Temp Ignore function that gets ran at admin init to ensure any messages that were temp dismissed get their start date changed
    public function admin_notice_temp_ignore() {
        // If user clicks to temp ignore the notice, update the option to change the start date - default interval of 14 days
        if (isset($_GET[$this->prefix . '_admin_notice_temp_ignore'])) {
            $admin_notices_option = get_option($this->prefix . '_admin_notice', array());
            $current_date = current_time("n/j/Y");
            $date_array   = explode('/', $current_date);
            $interval     = (isset($_GET['gt_int']) ? $_GET['gt_int'] : 14);
            $date_array[1] += $interval;
            $new_start = date("n/j/Y", mktime(0, 0, 0, $date_array[0], $date_array[1], $date_array[2]));

            $admin_notices_option[$_GET[$this->prefix . '_admin_notice_temp_ignore']]['start'] = $new_start;
            $admin_notices_option[$_GET[$this->prefix . '_admin_notice_temp_ignore']]['dismissed'] = 0;
            update_option($this->prefix . '_admin_notice', $admin_notices_option);
            $query_str = remove_query_arg(array($this->prefix . '_admin_notice_temp_ignore', 'gt_int'));
            wp_redirect( $query_str );
            exit;
        }
    }

    public function admin_notice_pages($pages) {
        foreach ($pages as $key => $page) {
            if (is_array($page)) {
                if (isset($_GET['page']) and $_GET['page'] == $page[0] and isset($_GET['tab']) and $_GET['tab'] == $page[1]) {
                    return true;
                }
            } else {
                if ($page == 'all') {
                    return true;
                }
                if (get_current_screen()->id === $page) {
                    return true;
                }

                if (isset($_GET['page']) and $_GET['page'] == $page) {
                    return true;
                }
            }
        }

        return false;
    }

    // Required fields check
    public function required_fields( $fields ) {
        if (!isset( $fields['msg']) or (isset($fields['msg']) and empty($fields['msg']))) {
            return true;
        }
        if (!isset( $fields['title']) or (isset($fields['title']) and empty($fields['title']))) {
            return true;
        }
        return false;
    }

    // Special parameters function that is to be used in any extension of this class
    public function special_parameters($admin_notices) {
        // Intentionally left blank
    }

    public function gt_admin_notices() {
        $one_week_support = esc_url(add_query_arg(array($this->prefix . '_admin_notice_ignore' => 'one_week_support')));

        $notices['one_week_support'] = array(
          'title' => __('Hey! How is it going?', 'gtranslate'),
          'msg' => __('Thank you for using GTranslate! We hope that you have found everything you need, but if you have any questions you can use our Live Chat or Forum:', 'gtranslate'),
          'link' => '<li><span class="dashicons dashicons-admin-comments"></span><a target="_blank" href="https://gtranslate.io/#contact">' . __('Get help', 'gtranslate') . '</a></li>' .
                    '<li><span class="dashicons dashicons-format-video"></span><a target="_blank" href="https://gtranslate.io/videos">'.__('Check videos', 'gtranslate') . '</a></li>' .
                    '<li><span class="dashicons dashicons-dismiss"></span><a href="' . $one_week_support . '">' . __('Never show again', 'gtranslate') . '</a></li>',
          'int' => 1
        );

        $two_week_review_ignore = esc_url(add_query_arg(array($this->prefix . '_admin_notice_ignore' => 'two_week_review')));
        $two_week_review_temp = esc_url(add_query_arg(array($this->prefix . '_admin_notice_temp_ignore' => 'two_week_review', 'gt_int' => 14)));

        $notices['two_week_review'] = array(
            'title' => __('Please Leave a Review', 'gtranslate'),
            'msg' => __("We hope you have enjoyed using GTranslate! Would you mind taking a few minutes to write a review on WordPress.org? <br>Just writing a simple <b>'thank you'</b> will make us happy!", 'gtranslate'),
            'link' => '<li><span class="dashicons dashicons-external"></span><a href="https://wordpress.org/support/plugin/gtranslate/reviews/?filter=5" target="_blank">' . __('Sure! I would love to!', 'gtranslate') . '</a></li>' .
                      '<li><span class="dashicons dashicons-smiley"></span><a href="' . $two_week_review_ignore . '">' . __('I have already left a review', 'gtranslate') . '</a></li>' .
                      '<li><span class="dashicons dashicons-calendar-alt"></span><a href="' . $two_week_review_temp . '">' . __('Maybe later', 'gtranslate') . '</a></li>' .
                      '<li><span class="dashicons dashicons-dismiss"></span><a href="' . $two_week_review_ignore . '">' . __('Never show again', 'gtranslate') . '</a></li>',
            'later_link' => $two_week_review_temp,
            'int' => 3
        );

        $data = get_option('GTranslate');
        GTranslate::load_defaults($data);

        $upgrade_tips_ignore = esc_url(add_query_arg(array($this->prefix . '_admin_notice_ignore' => 'upgrade_tips')));
        $upgrade_tips_temp = esc_url(add_query_arg(array($this->prefix . '_admin_notice_temp_ignore' => 'upgrade_tips', 'gt_int' => 5)));

        if($data['pro_version'] != '1' and $data['enterprise_version'] != '1') {
            $notices['upgrade_tips'][] = array(
                'title' => __('Did you know?', 'gtranslate'),
                'msg' => __('You can <b>increase</b> your international <b>traffic</b> by upgrading your GTranslate.', 'gtranslate'),
                'link' => '<li><span class="dashicons dashicons-external"></span><a href="https://gtranslate.io/?xyz=998#pricing" target="_blank">' . __('Learn more', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-calendar-alt"></span><a href="' . $upgrade_tips_temp . '">' . __('Maybe later', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-dismiss"></span><a href="' . $upgrade_tips_ignore . '">' . __('Never show again', 'gtranslate') . '</a></li>',
                'later_link' => $upgrade_tips_temp,
                'int' => 1
            );

            $notices['upgrade_tips'][] = array(
                'title' => __('Did you know?', 'gtranslate'),
                'msg' => __('You can have your <b>translated pages indexed</b> in search engines by upgrading your GTranslate.', 'gtranslate'),
                'link' => '<li><span class="dashicons dashicons-external"></span><a href="https://gtranslate.io/?xyz=998#pricing" target="_blank">' . __('Learn more', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-calendar-alt"></span><a href="' . $upgrade_tips_temp . '">' . __('Maybe later', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-dismiss"></span><a href="' . $upgrade_tips_ignore . '">' . __('Never show again', 'gtranslate') . '</a></li>',
                'later_link' => $upgrade_tips_temp,
                'int' => 1
            );

            $notices['upgrade_tips'][] = array(
                'title' => __('Did you know?', 'gtranslate'),
                'msg' => __('You can <b>increase</b> your <b>AdSense revenue</b> by upgrading your GTranslate.', 'gtranslate'),
                'link' => '<li><span class="dashicons dashicons-external"></span><a href="https://gtranslate.io/?xyz=998#pricing" target="_blank">' . __('Learn more', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-calendar-alt"></span><a href="' . $upgrade_tips_temp . '">' . __('Maybe later', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-dismiss"></span><a href="' . $upgrade_tips_ignore . '">' . __('Never show again', 'gtranslate') . '</a></li>',
                'later_link' => $upgrade_tips_temp,
                'int' => 1
            );

            $notices['upgrade_tips'][] = array(
                'title' => __('Did you know?', 'gtranslate'),
                'msg' => __('You can <b>edit translations</b> by upgrading your GTranslate.', 'gtranslate'),
                'link' => '<li><span class="dashicons dashicons-external"></span><a href="https://gtranslate.io/?xyz=998#pricing" target="_blank">' . __('Learn more', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-calendar-alt"></span><a href="' . $upgrade_tips_temp . '">' . __('Maybe later', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-dismiss"></span><a href="' . $upgrade_tips_ignore . '">' . __('Never show again', 'gtranslate') . '</a></li>',
                'later_link' => $upgrade_tips_temp,
                'int' => 1
            );

            $notices['upgrade_tips'][] = array(
                'title' => __('Did you know?', 'gtranslate'),
                'msg' => __('You can use our <b>Live Chat</b> or <b>Support Forum</b> if you have any questions.', 'gtranslate'),
                'link' => '<li><span class="dashicons dashicons-external"></span><a href="https://gtranslate.io/?xyz=998#contact" target="_blank">' . __('Live Chat', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-external"></span><a href="https://wordpress.org/support/plugin/gtranslate" target="_blank">' . __('Support Forum', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-calendar-alt"></span><a href="' . $upgrade_tips_temp . '">' . __('Maybe later', 'gtranslate') . '</a></li>' .
                          '<li><span class="dashicons dashicons-dismiss"></span><a href="' . $upgrade_tips_ignore . '">' . __('Never show again', 'gtranslate') . '</a></li>',
                'later_link' => $upgrade_tips_temp,
                'int' => 1
            );

            shuffle($notices['upgrade_tips']);
            $notices['upgrade_tips'] = $notices['upgrade_tips'][0];
        }

        $this->admin_notice($notices);
    }

}
