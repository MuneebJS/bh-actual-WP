<?php
// VC [mgt_item_price_wp]
vc_map(array(
   "name" 			=> "MGT Item Price",
   "category" 		=> 'Enside Content',
   "description"	=> "Single item with description and price",
   "base" 			=> "mgt_item_price_wp",
   "class" 			=> "",
   "icon" 			=> "vc_mgt_item_price",
   "params" 	=> array(
   		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Item settings",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Item title",
			"description"	=> "For example: Pizza Margeritta",
			"param_name"	=> "item_title",
			"std"			=> "",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Item price",
			"description"	=> "For example: $29.90",
			"param_name"	=> "item_price",
			"std"			=> "",
		),
		array(
			"type"			=> "attach_image",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Upload item image",
			"description"	=> "You can show small menu item image at the left from item details. Resize your image before uploading (image size should be 150x150px or less).",
			"param_name"	=> "item_image_id",
			"std"			=> "",
		),
		array(
			"type"			=> "textarea_html",
			"holder"		=> "div",
			"class" 		=> "",
			"admin_label" 	=> false,
			"heading"		=> "Item description",
			"description"	=> "For example: tomato sauce, fresh mozzarella and verdant basil leaves.",
			"param_name"	=> "content",
			"std"			=> '',
		),
		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Item badge",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Item badge title (optional)",
			"description"	=> "For example: New. Leave empty to disable badge.",
			"param_name"	=> "item_badge_title",
			"std"			=> "",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Item badge color",
			"param_name"	=> "item_badge_color",
			"value"			=> array(
				"Main theme color"	=> "theme",
				"Red"	=> "red",
				"Green"	=> "green",
				"Orange"	=> "orange",
				"Black"	=> "black",
				"Main theme color"	=> "theme"
			),
			"description"	=> "Change badge background color.",
			"std"			=> "theme",
			"edit_field_class" => "vc_col-xs-6",
		),
		array(
			"type"			=> "mgt_separator",
			"param_name"	=> generate_separator_name(),
			"heading"		=> "Animation and effects",
		),
		// CSS Animations
		vc_map_add_css_animation( true ),
		
   )
   
));