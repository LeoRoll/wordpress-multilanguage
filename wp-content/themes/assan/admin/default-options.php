<?php

global $themeoption;
$themeoption = array(
    array('name' => 'General',
        'id' => 'general-section',
        'sec' => 'start',
        'type' => 'menu-tabs-content'),
    array('name' => 'Logo',
        'id' => 'logo_image',
        'type' => 'upload',
        'default' => '',
        'description' => 'Upload Logo'),
    array('name' => 'Logo alt',
        'id' => 'logo_alt',
        'type' => 'text',
        'default' => 'assan',
        'description' => 'Logo Alt text'),
    array('name' => 'Favicon',
        'id' => 'favi_image',
        'type' => 'upload',
        'default' => '',
        'description' => 'Uplode favicon Icon'),
    array('name' => 'General',
        'sec' => 'end',
        'type' => 'menu-tabs-content'),
    //HEADER SECTION
    array('name' => 'Header',
        'id' => 'header-section',
        'sec' => 'start',
        'type' => 'menu-tabs-content'),
    array('name' => 'Top Bar',
        'id' => 'top_bar',
        'type' => 'select',
        'options' => array('Yes' => 'YES', 'No' => 'NO'),
        'default' => 'YES',
        'description' => 'Select Yes to show Top Bar'),
    array('name' => 'Header Layout',
        'id' => 'header_layout',
        'type' => 'select',
        'options' => array('Default' => 'h_default', 'Header Dark' => 'h_dark', 'Center logo' => 'h_center'),
        'default' => 'h_default',
        'description' => 'Select Layout for header'),
    array('name' => 'Header',
        'sec' => 'end',
        'type' => 'menu-tabs-content'),
    //THEME SECTION
    array('name' => 'Theme',
        'id' => 'theme-section',
        'sec' => 'start',
        'type' => 'menu-tabs-content'),
    array('name' => 'Theme Layout',
        'id' => 'themes_layout',
        'type' => 'select',
        'options' => array('Fullwidth' => 'FULL', 'Box' => 'BOXED'),
        'default' => 'Full',
        'description' => 'Select Theme Layout'),
    array('name' => 'Themes Pattern',
        'id' => 'themes_box_pattern',
        'type' => 'select',
        'options' => array('Pattern 1' => 'p_1', 'Pattern 2' => 'p_2', 'Pattern 3' => 'p_3', 'Pattern 4' => 'p_4',
            'Pattern 5' => 'p_5'),
        'default' => 'styles',
        'description' => 'Select Themes Background Pattern For Box Layout'),
    array('name' => 'Background Image',
        'id' => 'themes_box_background',
        'type' => 'upload',
        'default' => '',
        'description' => 'Uplode Background Image For Box Layout'),
    array('name' => 'Theme Color',
        'id' => 'theme_skin_color',
        'type' => 'color',
        'default' => '',
        'description' => 'Theme primary color'),
    array('name' => 'Theme',
        'sec' => 'end',
        'type' => 'menu-tabs-content'),
    //PORTFOLIO SECTION
    array('name' => 'Portfolio',
        'id' => 'portfolio-section',
        'sec' => 'start',
        'type' => 'menu-tabs-content'),
    array('name' => 'Filterable',
        'id' => 'portfolio_filter',
        'type' => 'select',
        'options' => array('Yes' => 'YES', 'No' => 'NO'),
        'default' => 'YES',
        'description' => 'Display portfolio filter'),
    array('name' => 'Portfolio per page',
        'id' => 'portfolio_per_page',
        'type' => 'text',
        'default' => '10',
        'description' => ''),
    array('name' => 'Portfolio',
        'sec' => 'end',
        'type' => 'menu-tabs-content'),
    //MAP
    array('name' => 'Map',
        'id' => 'map_section',
        'sec' => 'start',
        'type' => 'menu-tabs-content'),
    array('name' => 'Type',
        'id' => 'map_type',
        'type' => 'select',
        'options' => array('Roadmap' => 'ROADMAP', 'Satellite' => 'SATELLITE', 'Hybrid' => 'HYBRID', 'Terrain' => 'TERRAIN'),
        'default' => 'ROADMAP',
        'description' => ''),
    array('name' => 'Latitude',
        'id' => 'map_latitude',
        'type' => 'text',
        'default' => '-33.7969235',
        'description' => 'Eg. 33.7969235 '),
    array('name' => 'Longitude',
        'id' => 'map_longitude',
        'type' => 'text',
        'default' => '150.9224326',
        'description' => 'Eg. 150.9224326 '),
    array('name' => 'Map Height',
        'id' => 'map_height',
        'type' => 'text',
        'default' => '350',
        'description' => ''),
    array('name' => 'Zoom',
        'id' => 'map_zoom',
        'type' => 'select',
        'options' => array('4' => '4', '6' => '6', '8' => '8', '10' => '10', '12' => '12', '14' => '14', '16' => '16', '18' => '18'),
        'default' => '8',
        'description' => ''),
    array('name' => 'Marker Text',
        'id' => 'map_marker_text',
        'type' => 'text',
        'default' => '',
        'description' => ''),
    array('name' => 'Map',
        'sec' => 'end',
        'type' => 'menu-tabs-content'),
    //COMING SOON
    array('name' => 'Coming Soon',
        'id' => 'coming-soon-section',
        'sec' => 'start',
        'type' => 'menu-tabs-content'),
    array('name' => 'Hero Image',
        'id' => 'cs_header_bg_image',
        'type' => 'upload',
        'default' => '',
        'description' => 'Uplode Header Image'),
    array('name' => 'Launch Date',
        'id' => 'cs_launch_ate',
        'type' => 'text',
        'default' => '2018/01/01',
        'description' => 'Enter Launch Date (eg. 2017/01/01) YYYY/MM/DD'),
    array('name' => 'Facebook',
        'id' => 'cs_facebook',
        'type' => 'text',
        'default' => '#',
        'description' => 'Enter Facebook URL'),
    array('name' => 'Twitter',
        'id' => 'cs_twitter',
        'type' => 'text',
        'default' => '#',
        'description' => 'Enter Twitter URL'),
    array('name' => 'Google-plus',
        'id' => 'cs_google_plus',
        'type' => 'text',
        'default' => '#',
        'description' => 'Enter Google-plus URL'),
    array('name' => 'Linkedin',
        'id' => 'cs_linkedin',
        'type' => 'text',
        'default' => '#',
        'description' => 'Enter Linkedin URL'),
    array('name' => 'Coming Soon',
        'sec' => 'end',
        'type' => 'menu-tabs-content'),
    //FOOTER
    array('name' => 'Footer',
        'id' => 'footer-section',
        'sec' => 'start',
        'type' => 'menu-tabs-content'),
    array('name' => 'Footer Skin',
        'id' => 'footer_skin',
        'type' => 'select',
        'options' => array('Default(dark)' => 'default', 'Light' => 'light'),
        'default' => "default",
        'description' => ''),
    array('name' => 'Layout',
        'id' => 'footer_layout',
        'type' => 'select',
        'options' => array('2' => '2', '3' => '3', '4' => '4'),
        'default' => 4,
        'description' => ''),
    array('name' => 'Copy Right Text',
        'id' => 'footer_copy_write',
        'type' => 'textarea',
        'default' => '&copy; 2014. Assan theme design by Crazy-themes',
        'description' => ''),
    array('name' => 'Footer',
        'sec' => 'end',
        'type' => 'menu-tabs-content'),
    //CUSTOM JS/CSS
    array('name' => 'CUSTOM JS/CSS',
        'id' => 'custom-section',
        'sec' => 'start',
        'default' => '',
        'type' => 'menu-tabs-content'),
    array('name' => 'CSS',
        'id' => 'custom_css',
        'type' => 'textarea',
        'default' => '',
        'description' => ''),
    array('name' => 'JS',
        'id' => 'custom_js',
        'default' => '',
        'type' => 'textarea',
        'description' => ''),
    array('name' => 'CUSTOM JS/CSS',
        'sec' => 'end',
        'type' => 'menu-tabs-content'),
);