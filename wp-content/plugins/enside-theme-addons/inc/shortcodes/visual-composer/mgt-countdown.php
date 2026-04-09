<?php
// VC [mgt_countdown_wp]
vc_map(array(
   "name" 			=> "MGT Countdown",
   "category" 		=> 'Enside Content',
   "description"	=> "Animated coundown timer with custom format",
   "base" 			=> "mgt_countdown_wp",
   "class" 			=> "",
   "icon" 			=> "vc_mgt_countdown",
   
   "params" 	=> array(

		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Countdown display format",
			"description"	=> "You can change display format for timer and words. Use predefined constants for values: %Y - Years, %m - Months, %w - Weeks, %d - Days within week, %D - Total Days, %H - Hours, %S - Seconds. Use '-' modifier to display 0 before digit items, for example '%-H hours' will display '02 hours' instead of '2 hours'.",
			"param_name"	=> "counter_date_format",
			"std"			=> "%D days %H:%M:%S",
		),
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Countdown date",
			"description"	=> "Ending date for countdown timer. Must be in format YYYYY/MM/DD or YYYYY/MM/DD hh:mm:ss, for example 2018/12/01",
			"param_name"	=> "counter_value_to",
			"std"			=> "2017/06/01",
		),
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class" 		=> "hide_in_vc_editor",
			"admin_label" 	=> true,
			"heading"		=> "Text color",
			"param_name"	=> "text_color",
			"std"			=> "",
		),
		// CSS Animations
		vc_map_add_css_animation( true ),

   )
   
));