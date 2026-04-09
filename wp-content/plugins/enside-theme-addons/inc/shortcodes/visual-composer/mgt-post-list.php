<?php

// VC [mgt_post_list_wp]
$categories = get_terms( 'category', array(
 	'hide_empty' => 0,
));

$category_list = array();
$category_list['Any category'] = '';

foreach ( $categories as $category ) {

	$id = esc_html($category->name);

	$category_list[$id] = esc_html($category->name);
}

vc_map(array(
   "name" 			=> "MGT Posts List",
   "category" 		=> 'Enside Content',
   "description"	=> "Show posts grid/slider with different layouts",
   "base" 			=> "mgt_post_list_wp",
   "class" 			=> "",
   "icon" 			=> "vc_mgt_post_list",
   
   "params" 	=> array(
   		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Layout settings",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Layout",
			"param_name"	=> "block_size",
			"value"			=> array(
				"4 columns"	=> "small",
				"3 columns"	=> "normal",
				"2 columns"	=> "medium",
				"1 column"	=> "large"
			),
			"std"			=> "small",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Elements style",
			"param_name"	=> "elements_style",
			"value"			=> array(
				"Square"	=> "square",
				"Rounded"	=> "rounded"
			),
			"description"	=> "",
			"std"			=> "square",
			"edit_field_class" => "vc_col-xs-6",
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
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Filters, order and limit",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Show Posts from specified Category ID's",
			"param_name"	=> "category",
			"description"	=> "Display posts from categories ID's specified in this field, comma separated",
			"std"			=> "",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Show Posts from specified category name only",
			"param_name"	=> "category_name",
			"value"			=> $category_list,
			"std"			=> "",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Exclude posts by ID's",
			"param_name"	=> "exclude",
			"description"	=> "Excludes one or more posts from the list. This parameter takes a comma-separated list of posts by unique ID, in ascending order.",
			"std"			=> "",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Include posts by ID's",
			"param_name"	=> "include",
			"description"	=> "Only include certain posts in the list. This parameter takes a comma-separated list of posts by unique ID, in ascending order.",
			"std"			=> "",
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
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Posts limit",
			"param_name"	=> "posts_per_page",
			"description"	=> "Only this number of posts will be show if specified.",
			"std"			=> "9",
		),
		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Animation and effects",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Animate block on hover",
			"param_name"	=> "animated",
			"value"			=> array(
				"Yes"	=> "1",
				"No"	=> "0"
			),
			"description"	=> "Block background will fade to black on mouse hover.",
			"std"			=> "1",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"dependency"	=> array(
				"element"	=> "showreadmore",
				"value"		=> Array("1"),
			),
			"heading"		=> "Read More Button hover effect",
			"param_name"	=> "hover_effect",
			"value"			=> array(
				"Default"	=> "default",
				"[Shape] Grow"	=> "grow",
				"[Shape] Shrink"	=> "shrink",
				"[Shape] Pulse"	=> "pulse",
				"[Shape] Pulse Grow"	=> "pulse-grow",
				"[Shape] Pulse Shrink"	=> "pulse-shrink",
				"[Shape] Push"	=> "push",
				"[Shape] Pop"	=> "pop",
				"[Shape] Bounce In"	=> "bounce-in",
				"[Shape] Bounce Out"	=> "bounce-out",
				"[Shape] Rotate"	=> "rotate",
				"[Shape] Grow Rotate"	=> "grow-rotate",
				"[Shape] Float"	=> "float",
				"[Shape] Sink"	=> "sink",
				"[Shape] Bob"	=> "bob",
				"[Shape] Hang"	=> "hang",
				"[Shape] Skew"	=> "skew",
				"[Shape] Skew Forward"	=> "skew-forward",
				"[Shape] Skew Backward"	=> "skew-backward",
				"[Shape] Wobble Horizontal"	=> "wobble-horizontal",
				"[Shape] Wobble Vertical"	=> "wobble-vertical",
				"[Shape] Wobble To Bottom Right"	=> "wobble-to-bottom-right",
				"[Shape] Wobble To Top Right"	=> "wobble-to-top-right",
				"[Shape] Wobble Top"	=> "wobble-top",
				"[Shape] Wobble Bottom"	=> "wobble-bottom",
				"[Shape] Wobble Skew"	=> "wobble-skew",
				"[Shape] Buzz"	=> "buzz",
				"[Shape] Buzz Out"	=> "buzz-out",

				"[Background] Sweep To Right"	=> "sweep-to-right",
				"[Background] Sweep To Left"	=> "sweep-to-left",
				"[Background] Sweep To Bottom"	=> "sweep-to-bottom",
				"[Background] Sweep To Top"	=> "sweep-to-top",
				"[Background] Bounce To Right"	=> "bounce-to-right",
				"[Background] Bounce To Left"	=> "bounce-to-left",
				"[Background] Bounce To Bottom"	=> "bounce-to-bottom",
				"[Background] Bounce To Top"	=> "bounce-to-top",

				"[Icon] Icon Back"	=> "icon-back",
				"[Icon] Icon Forward"	=> "icon-forward",
				"[Icon] Icon Down"	=> "icon-down",
				"[Icon] Icon Up"	=> "icon-up",
				"[Icon] Icon Spin"	=> "icon-spin",
				"[Icon] Icon Drop"	=> "icon-drop",
				"[Icon] Icon Grow"	=> "icon-grow",
				"[Icon] Icon Shrink"	=> "icon-shrink",
				"[Icon] Icon Pulse"	=> "icon-pulse",
				"[Icon] Icon Pulse Grow"	=> "icon-pulse-grow",
				"[Icon] Icon Pulse Shrink"	=> "icon-pulse-shrink",
				"[Icon] Icon Push"	=> "icon-push",
				"[Icon] Icon Pop"	=> "icon-pop",
				"[Icon] Icon Bounce"	=> "icon-bounce",
				"[Icon] Icon Rotate"	=> "icon-rotate",
				"[Icon] Icon Grow Rotate"	=> "icon-grow-rotate",
				"[Icon] Icon Float"	=> "icon-float",
				"[Icon] Icon Sink"	=> "icon-sink",
				"[Icon] Icon Bob"	=> "icon-bob",
				"[Icon] Icon Hang"	=> "icon-hang",
				"[Icon] Icon Wobble Horizontal"	=> "icon-wobble-horizontal",
				"[Icon] Icon Wobble Vertical"	=> "icon-wobble-vertical",
				"[Icon] Icon Buzz"	=> "icon-buzz",
				"[Icon] Icon Buzz Out"	=> "icon-buzz-out",
			),
			"description"	=> "Change button hover effect (<a href='http://ianlunn.github.io/Hover/' target='_blank'>Preview effects</a>).",
			"std"			=> "default",
		),
		// CSS Animations
		vc_map_add_css_animation( true ),
		/* Layout */
		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Post layout settings",
			"group"			=> "Post layout",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Show post category in posts",
			"param_name"	=> "showcategory",
			"group"			=> "Post layout",
			"value"			=> array(
				"Yes"	=> "1",
				"No"	=> "0"
			),
			"description"	=> "",
			"std"			=> "1",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Show exrcept in posts",
			"param_name"	=> "showexrcept",
			"group"			=> "Post layout",
			"value"			=> array(
				"Yes"	=> "1",
				"No"	=> "0"
			),
			"description"	=> "",
			"std"			=> "1",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Show Read More button in posts",
			"param_name"	=> "showreadmore",
			"group"			=> "Post layout",
			"value"			=> array(
				"Yes"	=> "1",
				"No"	=> "0"
			),
			"description"	=> "",
			"std"			=> "1",
		),
		
   )

  
));