<?php
// VC [mgt_counter_wp]
vc_map(array(
   "name" 			=> "MGT Counter",
   "category" 		=> 'Enside Content',
   "description"	=> "Animated counter with title",
   "base" 			=> "mgt_counter_wp",
   "class" 			=> "",
   "icon" 			=> "vc_mgt_counter",
   
   "params" 	=> array(

		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Counter start value",
			"description"	=> "Integer. Usualy leave 0.",
			"param_name"	=> "counter_value_from",
			"std"			=> "0",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Counter end value",
			"description"	=> "Integer. Counter will count to this value.",
			"param_name"	=> "counter_value_to",
			"std"			=> "100",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Counter title (Optional)",
			"description"	=> "Title will be displayed below counter.",
			"param_name"	=> "counter_title",
			"std"			=> "",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Counter animation duration (msec)",
			"description"	=> "How long it should take to count between the target numbers. 1000 = 1 second.",
			"param_name"	=> "speed",
			"std"			=> "2000",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Decimals number",
			"description"	=> "Number of decimals after comma. For example - use 1 if you want to show counter from 1.0 to 9.5, use 2 if you want to show counter from 1.25 to 9.45, etc.",
			"param_name"	=> "decimals",
			"std"			=> "0",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Text size",
			"param_name"	=> "size",
			"value"			=> array(
				"Large"	=> "large",
				"Medium"	=> "medium",
				"Small"	=> "small"
			),
			"description"	=> "",
			"std"			=> "small",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Text color",
			"param_name"	=> "color",
			"value"			=> array(
				"Black"	=> "black",
				"White"	=> "white"
			),
			"description"	=> "",
			"std"			=> "black",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Text align",
			"param_name"	=> "align",
			"value"			=> array(
				"Left"	=> "left",
				"Center"	=> "center",
				"Right"	=> "right",
			),
			"description"	=> "",
			"std"			=> "left",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Text font weight",
			"param_name"	=> "fontweight",
				"value"			=> array(
				"Normal"	=> "normal",
				"Bold"	=> "bold",
				"100"	=> "100",
				"200"	=> "200",
				"300"	=> "300",
				"400"	=> "400",
				"500"	=> "500",
				"600"	=> "600",
				"700"	=> "700",
				"800"	=> "800",
				"900"	=> "900"
			),
			"description"	=> "Make sure you loaded font weight that you selected in Google Fonts settings for Header font in Theme Control Panel.",
			"std"			=> "normal",
			"edit_field_class" => "vc_col-xs-6",
		),
		/* Icon */
		array(
			'type' => 'checkbox',
			'heading' => __( 'Add counter icon?', 'js_composer' ),
			'param_name' => 'counter_icon',
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Counter icon library', 'js_composer' ),
			'value' => array(
				__( 'Font Awesome', 'js_composer' ) => 'fontawesome',
				__( 'Open Iconic', 'js_composer' ) => 'openiconic',
				__( 'Typicons', 'js_composer' ) => 'typicons',
				__( 'Entypo', 'js_composer' ) => 'entypo',
				__( 'Linecons', 'js_composer' ) => 'linecons',
				__( 'Mono Social', 'js_composer' ) => 'monosocial',
				__( 'Material', 'js_composer' ) => 'material',
				__( 'Pe7 Stroke', 'js_composer' ) => 'pe7stroke',
			),
			'dependency' => array(
				'element' => 'counter_icon',
				'value' => 'true',
			),
			'admin_label' => true,
			'param_name' => 'counter_icon_type',
			'description' => __( 'Select icon library.', 'js_composer' ),
			"std"		=> "fontawesome",
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Counter icon', 'js_composer' ),
			'param_name' => 'counter_icon_fontawesome',
			'value' => 'fa fa-adjust',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				'type' => 'fontawesome',
			),
			'dependency' => array(
				'element' => 'counter_icon_type',
				'value' => 'fontawesome',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Counter icon', 'js_composer' ),
			'param_name' => 'counter_icon_pe7stroke',
			'value' => 'pe-7s-album',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'iconsPerPage' => 4000,
				'type' => 'pe7stroke',
				// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
			),
			'dependency' => array(
				'element' => 'counter_icon_type',
				'value' => 'pe7stroke',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Counter icon', 'js_composer' ),
			'param_name' => 'counter_icon_openiconic',
			'value' => 'vc-oi vc-oi-dial',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'openiconic',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'counter_icon_type',
				'value' => 'openiconic',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Counter icon', 'js_composer' ),
			'param_name' => 'counter_icon_typicons',
			'value' => 'typcn typcn-adjust-brightness',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'typicons',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'counter_icon_type',
				'value' => 'typicons',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Counter icon', 'js_composer' ),
			'param_name' => 'counter_icon_entypo',
			'value' => 'entypo-icon entypo-icon-note',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'entypo',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'counter_icon_type',
				'value' => 'entypo',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Counter icon', 'js_composer' ),
			'param_name' => 'counter_icon_linecons',
			'value' => 'vc_li vc_li-heart',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'linecons',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'counter_icon_type',
				'value' => 'linecons',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Counter icon', 'js_composer' ),
			'param_name' => 'counter_icon_monosocial',
			'value' => 'vc-mono vc-mono-fivehundredpx',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'monosocial',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'counter_icon_type',
				'value' => 'monosocial',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Counter icon', 'js_composer' ),
			'param_name' => 'counter_icon_material',
			'value' => 'vc-material vc-material-cake',
			// default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				// default true, display an "EMPTY" icon?
				'type' => 'material',
				'iconsPerPage' => 4000,
				// default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'counter_icon_type',
				'value' => 'material',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Icon position",
			"param_name"	=> "icon_position",
			"value"			=> array(
				"Top"	=> "top",
				"Left"	=> "left"
			),
			"description"	=> "Icon position related to counter.",
			"std"			=> "top",
			'dependency' => array(
				'element' => 'counter_icon',
				'value' => 'true',
			),
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Icon color",
			"param_name"	=> "icon_color",
			"std"			=> "",
			'dependency' => array(
				'element' => 'counter_icon',
				'value' => 'true',
			),
		),
		// CSS Animations
		vc_map_add_css_animation( true ),
		
   )
   
));