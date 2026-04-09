<?php

// VC [mgt_signup_block_wp]

vc_map(array(
   "name" 			=> "MGT Signup Block",
   "category" 		=> 'Enside Content',
   "description"	=> "Newsletter subscribe form block for Mailchimp service",
   "base" 			=> "mgt_signup_block_wp",
   "class" 			=> "",
   "icon" 			=> "vc_mgt_signup_block",
   
   "params" 	=> array(
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Background color",
			"param_name"	=> "background_color",
			"std"			=> "",
		),
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> false,
			"heading"		=> "Text color",
			"description"	=> "Use white color if you selected dark background color.",
			"param_name"	=> "text_color",
			"value"			=> array(
				"Black"	=> "black",
				"White"	=> "white"
			),
			"std"			=> "black",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Signup text",
			"param_name"	=> "text",
			"std"			=> "Newsletter Sign Up",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Signup button text",
			"param_name"	=> "button_text",
			"std"			=> "Sign Up",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Mailchimp subscribe form ACTION url",
			"param_name"	=> "form_url",
			"std"			=> "",
			"description"	=> "You can obtain your Mailchimp List subscribe form action url on Mailchimp.com website, read theme documentation for more details.",
		),
		// CSS Animations
		vc_map_add_css_animation( true )

		
   )

   
));