<?php
add_action('admin_enqueue_scripts', 'assan_admin_scripts');

function assan_admin_scripts() {
    wp_enqueue_script('jquery-form');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('assan-option-script', ASSAN_ADMIN_URL . 'js/upload-media.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('assan-color-picker-script', ASSAN_ADMIN_URL . 'js/color-picker.js', array('wp-color-picker'), false, true);
    wp_enqueue_script('VTabs', ASSAN_ADMIN_URL . 'js/jquery-jvert-tabs-1.1.4.js', array('jquery'), '1.1.4');

    wp_enqueue_script('assan_functions', ASSAN_ADMIN_URL . 'js/functions.js');
    wp_localize_script('assan_functions', 'assanSettings', array(
        'clearpath' => ASSAN_ADMIN_URL . '/admin/images/empty.png',
        'assan_saving_text' => esc_html__('Saving...', 'assan'),
        'ctassan_data_saved_text' => esc_html__('Options Saved.', 'assan'),
        'assan_nonce' => wp_create_nonce('assan_nonce')
    ));
    wp_enqueue_style('thickbox');
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_style('assan-option-style', ASSAN_ADMIN_URL . 'css/styles.css');
}

// Add theme option on admin
add_action('admin_menu', 'assan_add_menu');

function assan_add_menu() {
    global $themename;
    add_theme_page($themename . ' Options', ' Theme Options', 'switch_themes', basename(__FILE__), 'assan_build_options');
}

if (!function_exists('assan_build_options')) {

    function assan_build_options() {
        global $themename, $themeoption, $ctassan_data;
        assan_load_setting_array();
        ?>
        <div class="wrap">
            <div id="assan_theme_admin">
                <div id="top-container">
                    <div id="assan-title">
                        <h1><?php echo $themename; ?></h1>
                    </div>
                    <div class="clear-both"></div>
                </div>
                <div class="assan_wrap_box">
                    <div class="assan_box_opt">
                        <form enctype="multipart/form-data" id="main_options_form" method="post" encoding="multipart/form-data">
                            <div id="assan_tabs" class="assan_tabs">
                                <div class="assan_tabs-column">
                                    <ul>
                                        <li class="open"><a href="#general-section" class="open"><span>General</span></a></li>
                                        <li class="open"><a href="#header-section" class="closed"><span>Header</span></a></li>
                                        <li class="open"><a href="#theme-section" class="closed"><span>Theme</span></a></li>
                                        <li class="closed"><a href="#portfolio-section" class="closed"><span>Portfolio</span></a></li>
                                        <li class="closed"><a href="#map-section" class="closed"><span>Map</span></a></li>
                                        <li class="closed"><a href="#coming-soon" class="closed"><span>Coming Soon</span></a></li>
                                        <li class="closed"><a href="#footer-section" class="closed"><span>Footer</span></a></li>
                                        <li class="closed"><a href="#custom-section" class="closed"><span>Custom CSS/JS</span></a></li>
                                    </ul>
                                </div>
                                <!-- ---------------------- General settings ------------------------------ -->
                                <div class="assan_tabs-content-column">
                                    <?php
                                    foreach ($themeoption as $value) {
                                        if (in_array($value['type'], array('text', 'upload', 'select', 'textarea', 'sidebar', 'color'))) {
                                            ?>
                                            <div class="assan_input_box">
                                                <?php
                                                $input_value = $ctassan_data[$value['id']] ? stripslashes($ctassan_data[$value['id']]) : '';
                                                switch ($value['type']) {
                                                    case 'text':
                                                        echo '<label>' . esc_attr($value['name']) . '</label>
                                                        <input type="text" name="' . esc_attr($value['id']) . '" value="' . esc_attr($input_value) . '"/>
                                                        <small>' . esc_attr($value['description']) . '</small>
                                                        <div class="clearfix"></div>';
                                                        break;
                                                    case 'upload':
                                                        echo '<label>' . esc_attr($value['name']) . '</label>
                                                        <input id="assan_upload_' . esc_attr($value['id']) . '" type="text" size="90" name="' . esc_attr($value['id']) . '" value="' . esc_url($input_value) . '" />
                                                        <input class="button assan_upload_button" input-data="assan_upload_' . esc_attr($value['id']) . '" type="button" value="' . esc_attr('Upload Image', 'assan') . '" />
                                                        <small>' . esc_attr($value['description']) . '</small><div class="clearfix"></div>';
                                                        break;
                                                    case 'select':
                                                        echo '<label>' . esc_attr($value['name']) . '</label>
                                                        <select name="' . esc_attr($value['id']) . '" id="' . esc_attr($value['id']) . '">';
                                                        foreach ($value['options'] as $option_key => $option) {
                                                            $select_active = '';
                                                            if ($input_value && $input_value == $option)
                                                                $select_active = ' selected="selected"';
                                                            echo '<option value="' . esc_attr($option) . '" ' . $select_active . '>' . esc_html(trim($option_key)) . '</option>';
                                                        }
                                                        echo '</select>
                                                        <small>' . esc_attr($value['description']) . '</small>
                                                        <div class="clearfix"></div>';
                                                        break;
                                                    case 'color':
                                                        echo '<label>' . esc_attr($value['name']) . '</label>';
                                                        echo '<input type="text" name="' . esc_attr($value['id']) . '" value="' . esc_attr($input_value) . '" class="ctassan-color-picker" >';
                                                        echo '<div class="clearfix"></div>';
                                                        break;
                                                    case 'textarea':
                                                        echo '<label>' . esc_attr($value['name']) . '</label>
                                                        <textarea name="' . esc_attr($value['id']) . '" id="' . esc_attr($value['id']) . '">' . esc_textarea($input_value) . '</textarea>
                                                        <small>' . esc_attr($value['description']) . '</small>
                                                        <div class="clearfix"></div>';
                                                        break;
                                                    default:
                                                        break;
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        } elseif (in_array($value['type'], array('menu-tabs-content'))) {
                                            if ($value['sec'] == 'start') {
                                                echo ' <div id="' . esc_attr($value['id']) . '" class="assan_tabs-content-panel">';
                                            } elseif ($value['sec'] == 'end') {
                                                echo ' </div>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div id="submit-box">
                                <input type="hidden" name="action" value="save_ctassan_data" />
                                <input type="submit" id="assan_save" value="Save changes" name="assan_frm_submit">
                            </div>
                        </form>
                    </div>
                    <div id="options-ajax-saving">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/admin/images/saver.gif'); ?>" alt="loading" id="loading" />
                        <span><?php esc_html_e('Saving...', 'assan'); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}
add_action('wp_ajax_nopriv_save_ctassan_data', 'assan_option_save_callback');
add_action('wp_ajax_save_ctassan_data', 'assan_option_save_callback');

function assan_option_save_callback() {
    ctassan_data_save_data();
    die();
}

if (!function_exists('ctassan_data_save_data')) {

    function ctassan_data_save_data() {
        if (!current_user_can('switch_themes'))
            die('-1');
        assan_load_setting_array();
        if (isset($_POST['action'])) {
            if ('save_ctassan_data' == $_POST['action']) {
                update_option('assan_theme_options', $_POST);
            }
        }
    }

}

function assan_load_setting_array() {
    get_template_part('admin/default-options');
}

add_action('after_switch_theme', 'assan_setup_options');

function assan_setup_options() {
    global $themeoption;
    assan_load_setting_array();
    $default_theme_option = array();
    foreach ($themeoption as $optionvalue) {
        if (in_array($optionvalue['type'], array('text', 'upload', 'select', 'textarea', 'sidebar', 'color'))) {
            $default_theme_option[$optionvalue['id']] = $optionvalue['default'];
        }
    }

    if (!get_option("assan_theme_options")) {
        add_option("assan_theme_options", $default_theme_option);
    }
}
