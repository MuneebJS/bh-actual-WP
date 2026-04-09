<?php

// VC [mgt_client_reviews_wp]

vc_map(array(
   "name" 			=> "MGT Clients Reviews",
   "category" 		=> 'Enside Content',
   "description"	=> "Show clients reviews as slider or list",
   "base" 			=> "mgt_clients_reviews_wp",
   "class" 			=> "",
   "icon" 			=> "vc_mgt_clients_reviews",
   
   "params" 	=> array(
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Reviews display style",
			"description"	=> "",
			"param_name"	=> "reviews_style",
			"value"			=> array(
				"Box"	=> "box",
				"Wide"	=> "wide"
			),
			"std"			=> "box",
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Add shadow effect?', 'js_composer' ),
			'param_name' => 'shadow_effect',
			'dependency' => array(
				'element' => 'reviews_style',
				'value' => 'box',
			),
			"description"	=> "Use this to add shadow to overall review block.",
		),
		array(
			'type' => 'checkbox',
			'heading' => __( 'Add border around review box?', 'js_composer' ),
			'param_name' => 'border_effect',
			'dependency' => array(
				'element' => 'reviews_style',
				'value' => 'box',
			),
			"description"	=> "Use this to add border to overall review block.",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Text color",
			"description"	=> "",
			"param_name"	=> "text_color",
			"value"			=> array(
				"Black"	=> "text-dark",
				"White"	=> "text-white"
			),
			'dependency' => array(
				'element' => 'reviews_style',
				'value' => 'wide',
			),
			"std"			=> "text-dark",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Text align",
			"description"	=> "",
			"param_name"	=> "text_align",
			"value"			=> array(
				"Left"	=> "text-left",
				"Center"	=> "text-center"
			),
			"std"			=> "text-left",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Posts display",
			"description"	=> "",
			"param_name"	=> "use_slider",
			"value"			=> array(
				"Slider"	=> "1",
				"Grid"	=> "0"
			),
			"std"			=> "0",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Slider autoplay",
			"param_name"	=> "slider_autoplay",
			"dependency"	=> array(
				"element"	=> "use_slider",
				"value"		=> Array("1"),
			),
			"value"			=> array(
				"Yes"	=> "1",
				"No"	=> "0"
			),
			"std"			=> "0",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Items per row",
			"param_name"	=> "items_per_row",
			"dependency"	=> array(
				"element"	=> "use_slider",
				"value"		=> Array("1"),
			),
			"value"			=> array(
				"1"	=> "1",
				"2"	=> "2",
				"3"	=> "3",
				"4"	=> "4"
			),
			"std"			=> "1",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Slider show navigation arrows",
			"param_name"	=> "slider_navigation",
			"dependency"	=> array(
				"element"	=> "use_slider",
				"value"		=> Array("1"),
			),
			"value"			=> array(
				"Yes"	=> "1",
				"No"	=> "0"
			),
			"std"			=> "0",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Slider show navigation pagination",
			"param_name"	=> "slider_pagination",
			"dependency"	=> array(
				"element"	=> "use_slider",
				"value"		=> Array("1"),
			),
			"value"			=> array(
				"Yes"	=> "1",
				"No"	=> "0"
			),
			"std"			=> "1",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Order By",
			"param_name"	=> "orderby",
			"value"			=> array(
				"ID"	=> "id",
				"Title"	=> "title",
				"Date"	=> "date",
				"Random"	=> "rand"
			),
			"std"			=> "date",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Order",
			"param_name"	=> "order",
			"value"			=> array(
				"Desc"	=> "DESC",
				"Asc"	=> "ASC"
			),
			"std"			=> "DESC",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Reviews limit",
			"param_name"	=> "posts_per_page",
			"description"	=> "Only this number of reviews will be show if specified.",
			"std"			=> "9",
			"edit_field_class" => "vc_col-xs-6",
		),
		// CSS Animations
		vc_map_add_css_animation( true )
		
   )

  
));