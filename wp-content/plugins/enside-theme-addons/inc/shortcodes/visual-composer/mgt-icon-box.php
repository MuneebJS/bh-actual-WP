<?php

// VC [mgt_icon_box_wp]

vc_map(array(
   "name" 			=> "MGT Icon Box & MGT Icon",
   "category" 		=> 'Enside Content',
   "description"	=> "Block with icon and optional title, subtitle and content",
   "base" 			=> "mgt_icon_box_wp",
   "class" 			=> "",
   "icon" 			=> "vc_mgt_icon_box",
   
   "params" 	=> array(
   		/* Content */
   		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Does not need content?",
		),
   		array(
			'type' => 'checkbox',
			'heading' => 'Disable all text content (show just icon)?',
			'param_name' => 'disable_content',
			"description"	=> "Use this option to have only icon and disable all text content in block. This option will disable all options below. You can configure icon settings on Icon tab.",
		),
   		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Content settings",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Title/Subtitle position",
			"param_name"	=> "title_position",
			"value"			=> array(
				"Below icon (Top)"	=> "top",
				"In content (Right)"	=> "right",
				"Below icon with text (align all centered)"	=> "centered",
				"Below icon with text (align all left)"	=> "left",
				"Below icon with text (align all right)"	=> "textright"
			),
			"description"	=> "Change icon box layout.",
			"std"			=> "top",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Subtitle",
			"param_name"	=> "subtitle",
			"std"			=> "",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Title",
			"param_name"	=> "title",
			"std"			=> "Title",
		),
		array(
			'type' => 'checkbox',
			'heading' => 'Add link to title?',
			'param_name' => 'title_link_enable',
			"description"	=> "",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Title link url",
			"param_name"	=> "title_url",
			"description"	=> "Add url if you want to have link in title. Leave empty if you does not need link in title.",
			"std"			=> "",
			"edit_field_class" => "vc_col-xs-6",
			'dependency' => array(
				'element' => 'title_link_enable',
				'value' => 'true',
			),
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Title url target",
			"param_name"	=> "title_url_target",
			"value"			=> array(
				"Same page/tab"	=> "_self",
				"New page/tab"	=> "_blank",
			),
			"description"	=> "",
			"description"	=> "Change title url target.",
			"std"			=> "_self",
			"edit_field_class" => "vc_col-xs-6",
			'dependency' => array(
				'element' => 'title_link_enable',
				'value' => 'true',
			),
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Title font weight",
			"param_name"	=> "title_fontweight",
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
			"std"			=> "bold",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Title font size",
			"param_name"	=> "title_fontsize",
			"description"	=> "Override title font size. Leave empty to use theme element font size. For example: 20px",
			"std"			=> "",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Title color",
			"param_name"	=> "title_color",
			"description"	=> "Override title color. Leave empty to use default theme color.",
			"std"			=> "",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Content text color",
			"param_name"	=> "color",
			"value"			=> array(
				"Black"	=> "black",
				"White"	=> "white"
			),
			"description"	=> "Change to white if you use icon box on dark background.",
			"std"			=> "black",
		),
		array(
			"type"			=> "textarea_html",
			"holder"		=> "div",
			"class" 		=> "",
			"admin_label" 	=> false,
			"heading"		=> "Box content",
			"param_name"	=> "content",
			"std"			=> 'Sample text',
		),
		// CSS Animations
		vc_map_add_css_animation( true ),
		/* Icon */
		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Icon settings",
			"group"			=> "Icon",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Icon type",
			"param_name"	=> "iconbox_icon_type",
			"value"			=> array(
				"Icon font"	=> "font",
				"Image"	=> "image"
			),
			"description"	=> "",
			"std"			=> "font",
			"group"			=> "Icon",
		),
		array(
			"type"			=> "attach_image",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Upload icon image",
			"description"	=> "Image will be scaled to icon size selected below.",
			"param_name"	=> "icon_image_id",
			"description"   => "Use PNG transparent icon image.",
			"std"			=> "",
			"group"			=> "Icon",
			'dependency' => array(
				'element' => 'iconbox_icon_type',
				'value' => 'image',
			),
		),
		/* Select icon */
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon library', 'js_composer' ),
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
				'element' => 'iconbox_icon_type',
				'value' => 'font',
			),
			'admin_label' => true,
			'param_name' => 'icon_type',
			'description' => __( 'Select icon library.', 'js_composer' ),
			"std"		=> "fontawesome",
			"group"			=> "Icon",
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_fontawesome',
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
				'element' => 'icon_type',
				'value' => 'fontawesome',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
			"group"			=> "Icon",
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_pe7stroke',
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
				'element' => 'icon_type',
				'value' => 'pe7stroke',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
			"group"			=> "Icon",
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_openiconic',
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
				'element' => 'icon_type',
				'value' => 'openiconic',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
			"group"			=> "Icon",
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_typicons',
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
				'element' => 'icon_type',
				'value' => 'typicons',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
			"group"			=> "Icon",
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_entypo',
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
				'element' => 'icon_type',
				'value' => 'entypo',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
			"group"			=> "Icon",
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_linecons',
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
				'element' => 'icon_type',
				'value' => 'linecons',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
			"group"			=> "Icon",
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_monosocial',
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
				'element' => 'icon_type',
				'value' => 'monosocial',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
			"group"			=> "Icon",
		),
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_material',
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
				'element' => 'icon_type',
				'value' => 'material',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
			"group"			=> "Icon",
		),
		/* END select icon */
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Icon align",
			"param_name"	=> "icon_align",
			"value"			=> array(
				"Left"	=> "left",
				"Center"	=> "center",
				"Right"	=> "right",
			),
			"description"	=> "Change icon align.",
			"std"			=> "left",
			'dependency' => array(
				'element' => 'disable_content',
				'value' => 'true',
			),
			"group"			=> "Icon",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Custom icon color",
			"param_name"	=> "icon_color",
			"description"	=> "Override icon color. Leave empty to use default icon color.",
			"std"			=> "",
			"group"			=> "Icon",
			'dependency' => array(
				'element' => 'iconbox_icon_type',
				'value' => 'font',
			),
		),
		array(
			'type' => 'dropdown',
			'heading' =>  'Icon size',
			'param_name' => 'icon_size',
			'value' => array(
				'Mini' => 'mini',
				'Small' => 'small',
				'Normal' => 'normal',
				'Large' => 'large',
				'Extra large' => 'extralarge',
			),
			'std' => 'normal',
			"group"			=> "Icon",
		),
		array(
			'type' => 'checkbox',
			'heading' => 'Use original image size?',
			'param_name' => 'icon_image_noresize',
			"group"			=> "Icon",
			'dependency' => array(
				'element' => 'iconbox_icon_type',
				'value' => 'image',
			),
			"description"	=> "Use this option to keep original uploaded icon image size. This option will work only for image icon without background.",
		),
		array(
			'type' => 'checkbox',
			'heading' => 'Add icon animation on mouse hover?',
			'param_name' => 'icon_animation_enable',
			"group"			=> "Icon",
		),
		array(
			'type' => 'dropdown',
			'heading' =>  'Icon animation',
			'param_name' => 'icon_animation',
			'value' => array(
				"Background fade dark"	=> "mgt-iconbox-animation-backgroundfadedark",
				"Background fade light"	=> "mgt-iconbox-animation-backgroundfadelight",
				"Background fade border"	=> "mgt-iconbox-animation-backgroundfadeborder",
				"Icon Back"	=> "hvr-icon-back",
				"Icon Forward"	=> "hvr-icon-forward",
				"Icon Down"	=> "hvr-icon-down",
				"Icon Up"	=> "hvr-icon-up",
				"Icon Spin"	=> "hvr-icon-spin",
				"Icon Grow"	=> "hvr-icon-grow",
				"Icon Shrink"	=> "hvr-icon-shrink",
				"Icon Pulse"	=> "hvr-icon-pulse",
				"Icon Pulse Grow"	=> "hvr-icon-pulse-grow",
				"Icon Pulse Shrink"	=> "hvr-icon-pulse-shrink",
				"Icon Push"	=> "hvr-icon-push",
				"Icon Pop"	=> "hvr-icon-pop",
				"Icon Rotate"	=> "hvr-icon-rotate",
				"Icon Float"	=> "hvr-icon-float",
				"Icon Sink"	=> "hvr-icon-sink",
				"Icon Bob"	=> "hvr-icon-bob",
				"Icon Hang"	=> "hvr-icon-hang",
				"Icon Wobble Horizontal"	=> "hvr-icon-wobble-horizontal",
				"Icon Wobble Vertical"	=> "hvr-icon-wobble-vertical",
				"Icon Buzz Out"	=> "hvr-icon-buzz-out",
			),
			'std' => 'hvr-icon-push',
			"group"			=> "Icon",
			"dependency"	=> array(
				"element"	=> "icon_animation_enable",
				"value"		=> 'true',
			),
		),
		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Icon background settings",
			"group"			=> "Icon",
		),
		array(
			'type' => 'checkbox',
			'heading' => 'Add icon background?',
			'param_name' => 'icon_background',
			"group"			=> "Icon",
		),
		array(
			'type' => 'dropdown',
			'heading' => 'Background shape',
			'param_name' => 'icon_background_style',
			'value' => array(
				'None' => 'none',
				'Circle' => 'rounded',
				'Square' => 'boxed',
				'Rounded' => 'rounded-less',
				'Outline Circle' => 'rounded-outline',
				'Outline Square' => 'boxed-outline',
				'Outline Rounded' => 'rounded-less-outline',
			),
			"dependency"	=> array(
				"element"	=> "icon_background",
				"value"		=> 'true',
			),
			'description' => 'Select background shape and style for icon.',
			"group"			=> "Icon",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Custom icon background color",
			"param_name"	=> "icon_background_color",
			"description"	=> "Override icon background color. Leave empty to use default theme color.",
			"std"			=> "",
			"group"			=> "Icon",
			"dependency"	=> array(
				"element"	=> "icon_background",
				"value"		=> 'true',
			),
		),
		/* Custom CSS */	
		array(
		    'type' => 'css_editor',
		    'heading' => 'Css',
		    'param_name' => 'css',
		    'group' => 'Content Design options',
		),
		
   )
   
));