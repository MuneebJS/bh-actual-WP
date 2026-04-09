<?php

// VC [vc_row] - Onepage location feature
$locations = get_nav_menu_locations();

// Main menu
$main_menu = wp_nav_menu(
    array (
        'theme_location'  => 'primary',
        'echo' => FALSE,
        'fallback_cb'    => false,
    )
);

if(($locations)&&!empty($main_menu)) {

	$menu = wp_get_nav_menu_object( $locations[ 'primary' ] );
    $menu_items = wp_get_nav_menu_items($menu->term_id);
    
} else {
	$menu_items = Array();
}

$onepage_menu_items_arr["-- Don't use this Row as Onepage section --"] = "";

foreach ( (array) $menu_items as $key => $menu_item ) {
    $title = esc_html($menu_item->title);
    $url = $menu_item->url;
    $onepage = esc_html($menu_item->onepage);

    if($onepage == 'on') {
    	$onepage_menu_items_arr[$title] = esc_url($menu_item->url);
    }
}

$attributes = array(
    'type' => 'dropdown',
    'heading' => "Use as Onepage section",
    'param_name' => 'row_onepage_id',
	'value' => $onepage_menu_items_arr,
	'std' => "",
    'description' => "Select link from main menu that will scroll down page to this Row content. This link should be checked as Onepage link in 'Appearance > Menus' first."
);

vc_add_param( 'vc_row', $attributes );

// Gradient background
$attributes =  array(
    'type' => 'checkbox',
    'heading' => __( 'Add color gradient to row background?', 'js_composer' ),
    'param_name' => 'vc_row_bg_grad',
    "description"   => "Use this to add color gradient to row background.",
);

vc_add_param( 'vc_row', $attributes );

$attributes = array(
    "type"          => "dropdown",
    "holder"        => "div",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => false,
    "heading"       => "Gradient style",
    "param_name"    => "vc_row_bg_grad_style",
    "value"         => array(
        "Horizontal" => "left",
        "Vertical"    => "top"
    ),
    'dependency' => array(
        'element' => 'vc_row_bg_grad',
        'value' => 'true',
    ),
    "description"   => "",
    "std"           => "left",
);

vc_add_param( 'vc_row', $attributes );

$attributes = array(
    "type"          => "colorpicker",
    "holder"        => "div",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => false,
    "heading"       => "First color for gradient",
    "param_name"    => "vc_row_color_bggradfrom",
    "description"   => "",
    "std"           => "",
    'dependency' => array(
        'element' => 'vc_row_bg_grad',
        'value' => 'true',
    ),
    "edit_field_class" => "vc_col-xs-6",
);

vc_add_param( 'vc_row', $attributes );

$attributes = array(
    "type"          => "colorpicker",
    "holder"        => "div",
    "class"         => "hide_in_vc_editor",
    "admin_label"   => false,
    "heading"       => "Second color for gradient",
    "param_name"    => "vc_row_color_bggradto",
    "description"   => "",
    "std"           => "",
    'dependency' => array(
        'element' => 'vc_row_bg_grad',
        'value' => 'true',
    ),
    "edit_field_class" => "vc_col-xs-6",
);

vc_add_param( 'vc_row', $attributes );