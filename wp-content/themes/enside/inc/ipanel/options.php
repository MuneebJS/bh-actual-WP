<?php
/**
 * SETTINGS TAB
 **/
$ipanel_enside_tabs[] = array(
	"name" => esc_html__('General Settings', 'enside'),
	'id' => 'main_settings'
);

$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "main_settings"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable theme CSS3 animations', 'enside'),
	"id" => "enable_theme_animations",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Enable colors and background colors fade effects', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show progress bar on page loading', 'enside'),
	"id" => "enable_progressbar",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Show page loading effect with page fade and top progress bar.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show scroll to top button', 'enside'),
	"id" => "scroll_to_top",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Show scroll to top button on bottom right pages corner after page scroll.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Scroll to top button style', 'enside'),
	"id" => "scroll_to_top_style",
	"std" => "square",
	"options" => array(
		"square" => esc_html__('Square', 'enside'),
		"rounded" => esc_html__('Rounded', 'enside'),
		"circle" => esc_html__('Circle', 'enside'),
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Scroll to top button shadow', 'enside'),
	"id" => "scroll_to_top_shadow",
	"std" => "noshadow",
	"options" => array(
		"shadow" => esc_html__('Enable', 'enside'),
		"noshadow" => esc_html__('Disable', 'enside'),
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"type" => "htmlpage",
	"name" => wp_kses_post(__('<div class="ipanel-label">
    <label>Favicon</label>
  </div><div class="ipanel-input">
    You can upload your website favicon (site icon) in <a href="customize.php" target="_blank">WordPress Customizer</a> (in "Site Identity" section at the left sidebar).<br/><br/><br/>
  </div>', 'enside'))
);

$ipanel_enside_option[] = array(
	"type" => "EndTab"
);
/**
 * Header TAB
 **/
$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Header, Logo, Menus', 'enside'),
	'id' => 'header_settings'
);

$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "header_settings"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Header and Logo settings', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true // Set true to show items by default.
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Header position style', 'enside'),   
	"id" => "header_position",
	"options" => array(
		'top' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/header_position_top.png',
			"label" => esc_html__('Top header', 'enside')
		),
		'left' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/header_position_left.png',
			"label" => esc_html__('Left side header', 'enside')
		),
	),
	"desc" => wp_kses_post(__('IMPORTANT: If you will use Left side header position option your site will have all header elements on the left (logo, menu, social icons, etc). Left side header is a simple header, and Top header is a complex header with a lot of options and layouts. Left side header have several limitations - you CAN NOT USE Top menu, Mega Menu, Menu options, Onepage menu, Mini Cart in header, Offcanvas menu, Change logo positions, Fixed sticky header and few other header options and features in Left side header.', 'enside')),
	"std" => "top",
	"type" => "image",
);
$ipanel_enside_option[] = array(
	"type" => "htmlpage",
	"name" => wp_kses_post(__('<div class="ipanel-label">
    <label>Logo upload</label>
  </div><div class="ipanel-input">
    You can upload your website logo in <a href="customize.php" target="_blank">WordPress Customizer</a> (in "Header Image" section at the left sidebar).<br/><br/><br/>
  </div>', 'enside'))
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Logo width (px)', 'enside'),
	"id" => "logo_width",
	"std" => "179",
	"desc" => wp_kses_post(__('Default: 219. Upload retina logo (2x size) and input your regular logo width here. For example if your retina logo have 400px width put 200 value here. If you does not use retina logo input regular logo width here (your logo image width).', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable text logo', 'enside'),
	"id" => "logo_text_enable",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Use this option to disable image logo on site and replace it with text specified below.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Text logo title', 'enside'),
	"id" => "logo_text",
	"std" => "",
	"desc" => wp_kses_post(__('Add your site text logo. HTML tags allowed.', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Text logo font', 'enside'),
	"id" => "logo_text_font",
	"std" => "body",
	"options" => array(
		"body" => esc_html__('Body font', 'enside'),
		"header" => esc_html__('Header font', 'enside'),
		"additional" => esc_html__('Additional font', 'enside')
	),
	"desc" => wp_kses_post(__('Choose font face that will be used for logo text. You can select fonts in Fonts tab at the left.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Logo position in header', 'enside'),   
	"id" => "header_logo_position",
	"options" => array(
		'left' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/header_logo_position_1.png',
			"label" => esc_html__('Left', 'enside')
		),
		'center' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/header_logo_position_2.png',
			"label" => esc_html__('Center', 'enside')
		),
	),
	"std" => "left",
	"type" => "image",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Header height in pixels', 'enside'),
	"id" => "header_height",
	"std" => "120",
	"desc" => wp_kses_post(__('Default: 120', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable fullwidth header', 'enside'),
	"id" => "header_fullwidth",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable sticky header', 'enside'),
	"id" => "enable_sticky_header",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Header with menus will be fixed to top on page scroll.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Sticky header display', 'enside'),
	"id" => "sticky_header_elements",
	"std" => "headeronly",
	"options" => array(
		"headeronly" => esc_html__('Only Header', 'enside'),
		"menuonly" => esc_html__('Only Menu below header', 'enside'),
		"headerandmenu" => esc_html__('Header with Menu below header', 'enside')
	),
	"desc" => wp_kses_post(__('Choose elements that will be displayed in sticky header after scroll.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable fullscreen search (add search button to header)', 'enside'),
	"id" => "enable_fullscreen_search",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Fullscreen Search can be opened by search button in header right side.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Header advanced menu', 'enside'),
	"id" => "header_menu_type",
	"std" => "none",
	"options" => array(
		"offcanvas" => esc_html__('Offcanvas floating sidebar menu', 'enside'),
		"fullscreen" => esc_html__('Fullscreen menu', 'enside'),
		"none" => esc_html__('Disable advanced menu', 'enside')
	),
	"desc" => wp_kses_post(__('Menu can be opened by menu toggle button in header right side. You can add widgets to offcanvas sidebar in "Offcanvas Right sidebar" in Appearance > Widgets. You can assign menu to "Header advanced menu" area in Appearance > Menus.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Header info text for top header', 'enside'),
	"id" => "header_info_text",
	"std" => '',
	"desc" => wp_kses_post(__('Available only with "Menu below header" main menu position. Does not available with Logo position = "Center". Displayed in header left or center (depending on logo position). ', 'enside')),
	"field_options" => array(
		'media_buttons' => false
	),
	"type" => "wp_editor",
);
$ipanel_enside_option[] = array(
		"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Left side header specific settings', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true 
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Left side header colors style', 'enside'),
	"id" => "header_side_color_style",
	"std" => "light",
	"options" => array(
		"light" => esc_html__('Light', 'enside'),
		"dark" => esc_html__('Dark', 'enside'),
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Elements align in left side header', 'enside'),
	"id" => "header_side_align",
	"std" => "none",
	"options" => array(
		"left" => esc_html__('Left', 'enside'),
		"center" => esc_html__('Center', 'enside'),
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Left side header menu items text transform', 'enside'),
	"id" => "header_side_menu_text_transform",
	"std" => "menu_uppercase",
	"options" => array(
		"menu_uppercase" => esc_html__('UPPERCASE', 'enside'),
		"menu_regular" => esc_html__('Regular', 'enside'),
	),
	"desc" => wp_kses_post(__('This option will change menu text tranform for main elements.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Left side header menu font weight', 'enside'),
	"id" => "header_side_menu_font_weight",
	"std" => "bold",
	"options" => array(
		"bold" => esc_html__('Bold', 'enside'),
		"normal" => esc_html__('Normal', 'enside')
	),
	"desc" => wp_kses_post(__('This option will change left side header menu font weight for root level menu items.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable search field in left side header', 'enside'),
	"id" => "header_side_search_enable",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Header info text for left side header', 'enside'),
	"id" => "header_side_info_text",
	"std" => '',
	"desc" => wp_kses_post(__('This info will be shown only in Left Side header style.', 'enside')),
	"field_options" => array(
		'media_buttons' => false
	),
	"type" => "wp_editor",
);
$ipanel_enside_option[] = array(
		"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Pages/Posts title settings', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true // Set true to show items by default.
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Pages/Posts title width', 'enside'),
	"id" => "page_title_width",
	"std" => "fullwidth",
	"options" => array(
		"fullwidth" => esc_html__('Fullwidth', 'enside'),
		"boxed" => esc_html__('Boxed', 'enside')
	),
	"desc" => wp_kses_post(__('This option change WordPress pages/posts title below header layout.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Pages/Posts title align', 'enside'),
	"id" => "page_title_align",
	"std" => "left",
	"options" => array(
		"left" => esc_html__('Left', 'enside'),
		"center" => esc_html__('Center', 'enside'),
		"right" => esc_html__('Right', 'enside')
	),
	"desc" => wp_kses_post(__('This option change WordPress pages/posts title below header align.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Pages/Posts title text transform', 'enside'),
	"id" => "page_title_texttransform",
	"std" => "uppercase",
	"options" => array(
		"uppercase" => esc_html__('UPPERCASE', 'enside'),
		"none" => esc_html__('Regular', 'enside')
	),
	"desc" => wp_kses_post(__('This option change WordPress pages/posts title below header text transform.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
		"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Main menu and Top menu settings', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true // Set true to show items by default.
	)
);
$ipanel_enside_option[] = array(
	"type" => "info",
	"name" => wp_kses_post(__('You can manage your theme menus <a href="nav-menus.php">here</a>.', 'enside')),
	"field_options" => array(
		"style" => 'alert'
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Disable top menu', 'enside'),
	"id" => "disable_top_menu",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('This option will disable top menu (first menu with social icons and additional links)', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show top menu above Main menu in header', 'enside'),
	"id" => "top_menu_position",
	"std" => "default",
	"options" => array(
		"header" => esc_html__('Yes', 'enside'),
		"default" => esc_html__('No', 'enside')
	),
	"desc" => wp_kses_post(__('This option work only if you selected Main menu position = "Main menu in header" and Logo position = "Left".', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Top menu align', 'enside'),
	"id" => "top_menu_align",
	"std" => "right",
	"options" => array(
		"right" => esc_html__('Right', 'enside'),
		"left" => esc_html__('Left', 'enside')
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Header top menu text', 'enside'),
	"id" => "header_top_text",
	"std" => '',
	"desc" => wp_kses_post(__('Text in top menu.', 'enside')),
	"field_options" => array(
		'media_buttons' => false
	),
	"type" => "wp_editor",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Main menu position', 'enside'),   
	"id" => "header_menu_layout",
	"options" => array(
		'menu_below_header' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/menu_in_header_1.png',
			"label" => esc_html__('Main menu below header', 'enside')
		),
		'menu_in_header' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/menu_in_header_2.png',
			"label" => esc_html__('Main menu in header', 'enside')
		),
	),
	"desc" => wp_kses_post(__('Main menu position in header will work if you selected Logo position = "Left".', 'enside')),
	"std" => "menu_in_header",
	"type" => "image",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable Mega Menu', 'enside'),
	"id" => "megamenu_enable",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Add additional mega menu options to menus elements if enabled.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Number of megamenu sidebars', 'enside'),
	"id" => "megamenu_sidebars_count",
	"std" => "1",
	"desc" => wp_kses_post(__('You can use megamenu sidebars to show widgets in your megamenus. Increase this option value to add more new sidebars.', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Main menu below header width', 'enside'),
	"id" => "header_menu_width",
	"std" => "menu_fullwidth",
	"options" => array(
		"menu_fullwidth" => esc_html__('Fullwidth', 'enside'),
		"menu_boxed" => esc_html__('Boxed', 'enside')
	),
	"desc" => wp_kses_post(__('This option change menu width for menu below header position.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Main menu dropdown menu style', 'enside'),
	"id" => "header_menu_style",
	"std" => "shadow",
	"options" => array(
		"shadow" => esc_html__('Shadow', 'enside'),
		"border" => esc_html__('Border', 'enside'),
		"border-top" => esc_html__('Border top', 'enside'),
		"border-bottom" => esc_html__('Border bottom', 'enside'),
		"border-left" => esc_html__('Border left', 'enside')		
	),
	"desc" => wp_kses_post(__('This option change drop down menus style in main menu.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Main menu color scheme', 'enside'),
	"id" => "header_menu_color_scheme",
	"std" => "menu_dark",
	"options" => array(
		"menu_light" => esc_html__('Light menu', 'enside'),
		"menu_light_clean" => esc_html__('Light menu without borders', 'enside'),
		"menu_dark" => esc_html__('Dark menu', 'enside')
	),
	"desc" => wp_kses_post(__('This option will change menu background if Main menu located below header', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Main menu horizontal align', 'enside'),
	"id" => "header_menu_align",
	"std" => "menu_left",
	"options" => array(
		"menu_left" => esc_html__('Left', 'enside'),
		"menu_center" => esc_html__('Center', 'enside'),
		"menu_right" => esc_html__('Right', 'enside')
	),
	"desc" => wp_kses_post(__('This option will change menu align.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Main menu font weight', 'enside'),
	"id" => "header_menu_font_weight",
	"std" => "normal",
	"options" => array(
		"bold" => esc_html__('Bold', 'enside'),
		"normal" => esc_html__('Normal', 'enside')
	),
	"desc" => wp_kses_post(__('This option will change Main menu font weight for root level menu items.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Main menu items text transform', 'enside'),
	"id" => "header_menu_text_transform",
	"std" => "menu_uppercase",
	"options" => array(
		"menu_uppercase" => esc_html__('UPPERCASE', 'enside'),
		"menu_regular" => esc_html__('Regular', 'enside'),
	),
	"desc" => wp_kses_post(__('This option will change menu text tranform for main elements.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
		"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"type" => "EndTab"
);
/**
 * FOOTER TAB
 **/
$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Footer', 'enside'),
	'id' => 'footer_settings'
);
$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "footer_settings"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show "Bottom sidebar" only on homepage', 'enside'),
	"id" => "bottom_sidebar_homepage_only",
	"std" => true,
	"desc" => wp_kses_post(__('This option will disable Bottom sidebar from other pages (not homepage).', 'enside')),
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Footer sidebar style', 'enside'),
	"id" => "footer_sidebar_style",
	"std" => "dark",
	"options" => array(
		"dark" => esc_html__('Dark', 'enside'),
		"light" => esc_html__('Light', 'enside')
	),
	"desc" => wp_kses_post(__('This option will change background and text/links colors for footer sidebar at the bottom. You can select background color for dark and light footer sidebar separately in Colors tab at the left.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Footer sidebar background image', 'enside'),
	"id" => "footer_sidebar_background_image",
	"field_options" => array(
		"button_text" =>  esc_html__('Select image', 'enside'),
	),
	"desc" => wp_kses_post(__('You can upload background image for footer sidebar. You need to prepare image (add dark overlay for example) before uploading.', 'enside')),
	"type" => "media",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Footer sidebar columns', 'enside'),
	"id" => "footer_sidebar_columns",
	"std" => "4",
	"options" => array(
		"5" => '5',
		"4" => '4',
		"3" => '3',
		"2" => '2',
		"1" => '1',
	),
	"desc" => wp_kses_post(__('This option will change columns count (widgets per row) in Footer sidebar. Default: 4', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Disable footer', 'enside'),
	"id" => "footer_disable",
	"std" => false,
	"desc" => wp_kses_post(__('This option completetly disable footer in theme. This does not disable footer sidebar (you need to remove all widgets from sidebar to disable it).', 'enside')),
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Footer layout', 'enside'),
	"id" => "footer_layout",
	"std" => "fullwidth",
	"options" => array(
		"fullwidth" => esc_html__('Fullwidth', 'enside'),
		"boxed" => esc_html__('Boxed', 'enside')
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Footer style', 'enside'),
	"id" => "footer_style",
	"std" => "dark",
	"options" => array(
		"dark" => esc_html__('Dark', 'enside'),
		"light" => esc_html__('Light', 'enside')
	),
	"desc" => wp_kses_post(__('This option will change background and text/links colors for footer with copyright and menu at the bottom. You can select background color for dark and light footer separately in Colors tab at the left.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Copyright and footer menu positions', 'enside'),
	"id" => "footer_columns",
	"std" => "2",
	"options" => array(
		"2" => esc_html__('2 columns in 1 row, align left and right', 'enside'),
		"1" => esc_html__('1 column in 2 rows, align centered', 'enside')
	),
	"desc" => wp_kses_post(__('Change footer structure for copyright and footer menu.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Custom footer paddings in pixels', 'enside'),
	"id" => "footer_paddings",
	"std" => "",
	"desc" => wp_kses_post(__('Change paddings for footer. For example: 50px 0 50px 0 (top, right, bottom, left). Leave empty to use default value (25px 0).', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Footer copyright text', 'enside'),
	"id" => "footer_copyright_text",
	"std" => "Powered by <a href='http://themeforest.net/user/dedalx/' target='_blank'>Enside - Premium WordPress Theme</a>",
	"field_options" => array(
		'media_buttons' => true
	),
	"desc" => wp_kses_post(__('You can use shortcodes here, for example [enside_social_icons] to add social icons buttons.', 'enside')),
	"type" => "wp_editor",
);

$ipanel_enside_option[] = array(
	"type" => "EndTab"
);
/**
 * SIDEBARS TAB
 **/
$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Sidebars', 'enside'),
	'id' => 'sidebar_settings'
);

$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "sidebar_settings"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Pages sidebar position', 'enside'),   
	"id" => "page_sidebar_position",
	"options" => array(
		'left' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_1.png',
			"label" => esc_html__('Left', 'enside')
		),
		'right' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_2.png',
			"label" => esc_html__('Right', 'enside')
		),
		'disable' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_3.png',
			"label" => esc_html__('Disable sidebar', 'enside')
		),
	),
	"std" => "left",
	"type" => "image",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Blog page sidebar position', 'enside'),   
	"id" => "blog_sidebar_position",
	"options" => array(
		'left' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_1.png',
			"label" => esc_html__('Left', 'enside')
		),
		'right' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_2.png',
			"label" => esc_html__('Right', 'enside')
		),
		'disable' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_3.png',
			"label" => esc_html__('Disable sidebar', 'enside')
		),
	),
	"std" => "left",
	"type" => "image",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Blog Archive page sidebar position', 'enside'),   
	"id" => "archive_sidebar_position",
	"options" => array(
		'left' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_1.png',
			"label" => esc_html__('Left', 'enside')
		),
		'right' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_2.png',
			"label" => esc_html__('Right', 'enside')
		),
		'disable' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_3.png',
			"label" => esc_html__('Disable sidebar', 'enside')
		),
	),
	"std" => "right",
	"type" => "image",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Blog Search page sidebar position', 'enside'),   
	"id" => "search_sidebar_position",
	"options" => array(
		'left' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_1.png',
			"label" => esc_html__('Left', 'enside')
		),
		'right' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_2.png',
			"label" => esc_html__('Right', 'enside')
		),
		'disable' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_3.png',
			"label" => esc_html__('Disable sidebar', 'enside')
		),
	),
	"std" => "right",
	"type" => "image",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Blog post sidebar position', 'enside'),   
	"id" => "post_sidebar_position",
	"options" => array(
		'left' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_1.png',
			"label" => esc_html__('Left', 'enside')
		),
		'right' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_2.png',
			"label" => esc_html__('Right', 'enside')
		),
		'disable' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_3.png',
			"label" => esc_html__('Disable sidebar', 'enside')
		),
	),
	"std" => "disable",
	"type" => "image",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio item page sidebar position', 'enside'),   
	"id" => "portfolio_sidebar_position",
	"options" => array(
		'left' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_1.png',
			"label" => esc_html__('Left', 'enside')
		),
		'right' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_2.png',
			"label" => esc_html__('Right', 'enside')
		),
		'disable' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_3.png',
			"label" => esc_html__('Disable sidebar', 'enside')
		),
	),
	"std" => "disable",
	"type" => "image",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('WooCommerce pages sidebar position', 'enside'),   
	"id" => "woocommerce_sidebar_position",
	"options" => array(
		'left' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_1.png',
			"label" => esc_html__('Left', 'enside')
		),
		'right' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_2.png',
			"label" => esc_html__('Right', 'enside')
		),
		'disable' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_3.png',
			"label" => esc_html__('Disable sidebar', 'enside')
		),
	),
	"std" => "disable",
	"type" => "image",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('WooCommerce product page sidebar position', 'enside'),   
	"id" => "woocommerce_product_sidebar_position",
	"options" => array(
		'left' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_1.png',
			"label" => esc_html__('Left', 'enside')
		),
		'right' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_2.png',
			"label" => esc_html__('Right', 'enside')
		),
		'disable' => array(
			"image" => ENSIDE_IPANEL_URI . 'option-images/sidebar_position_3.png',
			"label" => esc_html__('Disable sidebar', 'enside')
		),
	),
	"std" => "disable",
	"type" => "image",
);

$ipanel_enside_option[] = array(
	"type" => "EndTab"
);
/**
 * BLOG TAB
 **/
$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Blog', 'enside'),
	'id' => 'blog_settings'
);
$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "blog_settings"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Blog page title', 'enside'),
	"id" => "blog_page_title",
	"std" => esc_html__('News', 'enside'),
	"desc" => wp_kses_post(__('You can change default blog page title heading here.', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Blog page title background image', 'enside'),
	"id" => "blog_page_title_image",
	"field_options" => array(
		"button_text" =>  esc_html__('Select image', 'enside'),
	),
	"desc" => wp_kses_post(__('You can upload background image for your Blog page title.', 'enside')),
	"type" => "media",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable transparent header for blog page', 'enside'),
	"id" => "enable_blog_transparent_header",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('This option will work only if you uploaded background image for Blog page title above.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable transparent header for blog category pages', 'enside'),
	"id" => "enable_blog_cat_transparent_header",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('This option will work only if you uploaded background images for blog categories.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Blog layout', 'enside'),
	"id" => "blog_layout",
	"std" => "regular",
	"options" => array(
		"regular" => esc_html__('Regular', 'enside'),
		"grid" => esc_html__('Grid', 'enside')
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Blog posts list category links and read more button style', 'enside'),
	"id" => "blog_post_elements_style",
	"std" => "square",
	"options" => array(
		"square" => esc_html__('Square', 'enside'),
		"rounded" => esc_html__('Rounded', 'enside')
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show exrcept and read more button in posts', 'enside'),
	"id" => "blog_post_exrcept",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Apply to blog listing pages.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Post excerpt length (words)', 'enside'),
	"id" => "post_excerpt_legth",
	"std" => "30",
	"desc" => wp_kses_post(__('Used by WordPress for post shortening. Default: 18', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show author info and avatar after single blog post', 'enside'),
	"id" => "blog_enable_author_info",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show prev/next posts navigation links on single post page', 'enside'),
	"id" => "blog_post_navigation",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Hide post featured image on single post page', 'enside'),
	"id" => "blog_post_hide_featured_image",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Enable this if you don\'t want to see featured post image on single post page.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Blog post header title on single post page', 'enside'),
	"id" => "blog_post_title",
	"std" => "title",
	"options" => array(
		"title" => esc_html__('Post title', 'enside'),
		"category" => esc_html__('Post category (title in content)', 'enside')
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"type" => "EndTab"
);

/**
 * PORTFOLIO TAB
 **/
$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Portfolio', 'enside'),
	'id' => 'portfolio_settings'
);
$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "portfolio_settings"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio taxonomy settings', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true // Set true to show items by default.
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio page url', 'enside'),
	"id" => "portfolio_page_url",
	"std" => "",
	"desc" => wp_kses_post(__('Create portfolio page with your projects (using MGT Portfolio Grid or other elements) and add this page url here. This url will be used in Breadcrumbs to access your all portfolio projects listing from single portfolio items pages. Leave empty to use homepage as portfolio url.', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio taxonomy item slug', 'enside'),
	"id" => "portfolio_item_slug",
	"std" => "project",
	"desc" => wp_kses_post(__('Portfolio item pages have url like http://yoursite.com/project/your-item-name/ by default. If you want to change "project" slug in url you can do this here. After changing this field you need to resave permalinks in <a href="options-permalink.php">Settings > Permalinks</a>.', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio taxonomy category slug', 'enside'),
	"id" => "portfolio_category_slug",
	"std" => "projects",
	"desc" => wp_kses_post(__('Portfolio category pages have url like http://yoursite.com/projects/category-name/ by default. If you want to change "projects" slug in url you can do this here. After changing this field you need to resave permalinks in <a href="options-permalink.php">Settings > Permalinks</a>.', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio taxonomy name', 'enside'),
	"id" => "portfolio_taxonomy_name",
	"std" => "Portfolio",
	"desc" => wp_kses_post(__('Portfolio taxonomy name used in several places on site, for example in breadcrumbs navigation for portfolio pages.', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
		"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio project page settings', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true // Set true to show items by default.
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Display portfolio item images slider prev/next navigation buttons', 'enside'),
	"id" => "portfolio_show_slider_navigation",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Display portfolio item images slider pagination buttons', 'enside'),
	"id" => "portfolio_show_slider_pagination",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio item images slider autoplay', 'enside'),
	"id" => "portfolio_slider_autoplay",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show prev/next portfolio items navigation on single portfolio item page', 'enside'),
	"id" => "portfolio_show_item_navigation",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
		"type" => "EndSection"
);
/* Related works */
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio related projects display settings', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true // Set true to show items by default.
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show related projects on portfolio items pages', 'enside'),
	"id" => "portfolio_related_works",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('This will show projects from the same categories', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio related items per row', 'enside'),
	"id" => "portfolio_related_items_columns",
	"std" => "4",
	"options" => array(
		"1" => "1",
		"2" => "2",
		"3" => "3",
		"4" => "4",
		"5" => "5"
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio item page related works limit', 'enside'),
	"id" => "portfolio_related_limit",
	"std" => "8",
	"desc" => wp_kses_post(__('Recommended values: 4, 8, 12, 16, etc', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio related items hover effect', 'enside'),
	"id" => "portfolio_posts_item_hover_effect",
	"std" => "0",
	"options" => array(
		"0" => esc_html__('Text from left, Zoom, Theme Color Overlay', 'enside'),
		"1" => esc_html__('Text from left, Zoom, Transparent Overlay', 'enside'),
		"2" => esc_html__('Text from left, Transparent Overlay', 'enside'),
		"3" => esc_html__('Text from bottom, Zoom, Transparent Overlay', 'enside'),
		"4" => esc_html__('Text from bottom, Transparent Overlay', 'enside'),
		"5" => esc_html__('Image and text always visible, button on hover', 'enside'),
		"6" => esc_html__('Image and text always visible, zoom on hover', 'enside'),
		"7" => esc_html__('Image on hover, text always visible', 'enside'),
		"8" => esc_html__('Image and text always visible', 'enside'),
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio related items grid sort animation effect 1', 'enside'),
	"id" => "portfolio_posts_animation_1",
	"std" => "fade",
	"options" => array(
		"fade" => "Fade",
		"scale" => "Scale",
		"translateX" => "TranslateX",
		"translateY" => "TranslateY",
		"translateZ" => "TranslateZ",
		"rotateX" => "RotateX",
		"rotateY" => "RotateY",
		"rotateZ" => "RotateZ",
		"stagger" => "Stagger"
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio related items grid sort animation effect 2', 'enside'),
	"id" => "portfolio_posts_animation_2",
	"std" => "scale",
	"options" => array(
		"fade" => "Fade",
		"scale" => "Scale",
		"translateX" => "TranslateX",
		"translateY" => "TranslateY",
		"translateZ" => "TranslateZ",
		"rotateX" => "RotateX",
		"rotateY" => "RotateY",
		"rotateZ" => "RotateZ",
		"stagger" => "Stagger"
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show View More button in related projects boxes', 'enside'),
	"id" => "portfolio_related_items_show_viewmore_button",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio related items view more button round edges', 'enside'),
	"id" => "portfolio_posts_button_round_edges",
	"std" => "disable",
	"options" => array(
		"disable" => esc_html__('Disable', 'enside'),
		"small" => esc_html__('Small', 'enside'),
		"medium" => esc_html__('Medium', 'enside'),
		"large" => esc_html__('Large', 'enside'),
		"full" => esc_html__('Full', 'enside'),
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Related projects View More button text', 'enside'),
	"id" => "portfolio_related_items_viewmore_button_title",
	"std" => "View more",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show short description in related projects boxes', 'enside'),
	"id" => "portfolio_related_items_show_description",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Portfolio related items text align', 'enside'),
	"id" => "portfolio_related_items_text_align",
	"std" => "left",
	"options" => array(
		"left" => esc_html__('Left', 'enside'),
		"center" => esc_html__('Center', 'enside'),
	),
	"type" => "select",
);
$ipanel_enside_option[] = array(
		"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"type" => "EndTab"
);
/**
 * WOOCOMMERCE TAB
 **/
$ipanel_enside_tabs[] = array(
	"name" => esc_html__('WooCommerce', 'enside'),
	'id' => 'woocommerce_settings'
);
$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "woocommerce_settings"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Products per page limit', 'enside'),
	"id" => "wc_products_per_page",
	"std" => "12",
	"desc" => wp_kses_post(__('Products per page limit on WooCommerce pages. Default: 12', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Products per row display', 'enside'),
	"id" => "wc_products_per_row",
	"std" => "3",
	"options" => array(
		"5" => 5,
		"4" => 4,
		"3" => 3,
		"2" => 2,
	),
	"desc" => wp_kses_post(__('Number of products columns on WooCommerce listing pages.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable mini cart drop down in header', 'enside'),
	"id" => "enable_woocommerce_cart",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('WooCommerce plugin must be installed to use this option.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Minicart products limit', 'enside'),
	"id" => "woocommerce_mini_cart_limit",
	"std" => "3",
	"options" => array(
		"6" => 6,
		"5" => 5,
		"4" => 4,
		"3" => 3,
		"2" => 2,
	),
	"desc" => wp_kses_post(__('Number of unique products that you will see in mini cart before title "XX more products in cart" will appear. Default: 3', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Shop page title background image', 'enside'),
	"id" => "shop_page_title_image",
	"field_options" => array(
		"button_text" =>  esc_html__('Select image', 'enside'),
	),
	"desc" => wp_kses_post(__('You can upload background image for your Shop page title.', 'enside')),
	"type" => "media",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable transparent header for Shop page', 'enside'),
	"id" => "enable_woocommerce_transparent_header",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('This option will work only if you uploaded background image for shop page title above.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show category image as category page title background', 'enside'),
	"id" => "shop_category_image_title",
	"std" => true,
	"desc" => wp_kses_post(__('To use this feature you need to upload images for WooCommerce categories. We recommend to use high quality images for categories, for example 1600x1200px for better display.', 'enside')),
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable transparent header for category page', 'enside'),
	"id" => "enable_woocommerce_cat_transparent_header",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('This option will work only if you enabled category image for page title background above and uploaded background image for your categories.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"type" => "EndTab"
);
/**
 * SOCIAL ICONS TAB
 **/
$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Social Icons', 'enside'),
	'id' => 'social_settings'
);
$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "social_settings"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Social icons', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true // Set true to show items by default.
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Show social icons in header', 'enside'),
	"id" => "header_socialicons",
	"std" => true,
	"field_options" => array(
		"box_label" => ""
	),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"type" => "info",
	"name" => esc_html__('Leave URL fields blank to hide some social icons. You can use shortcode [enside_social_icons] to show social icons in widgets or content.', 'enside'),
	"field_options" => array(
		"style" => 'alert'
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Facebook Page url', 'enside'),
	"id" => "facebook",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Vkontakte page url', 'enside'),
	"id" => "vk",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Twitter Page url', 'enside'),
	"id" => "twitter",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Google+ Page url', 'enside'),
	"id" => "google-plus",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Behance', 'enside'),
	"id" => "behance",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('LinkedIn Page url', 'enside'),
	"id" => "linkedin",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Dribbble Page url', 'enside'),
	"id" => "dribbble",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Instagram Page url', 'enside'),
	"id" => "instagram",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Tumblr page url', 'enside'),
	"id" => "tumblr",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Pinterest page url', 'enside'),
	"id" => "pinterest",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Vimeo page url', 'enside'),
	"id" => "vimeo-square",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('YouTube page url', 'enside'),
	"id" => "youtube",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Skype url', 'enside'),
	"id" => "skype",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Houzz url', 'enside'),
	"id" => "houzz",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Flickr url', 'enside'),
	"id" => "flickr",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Odnoklassniki url', 'enside'),
	"id" => "odnoklassniki",
	"std" => "",
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"type" => "EndTab"
);

/**
 * FONTS TAB
 **/

$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Fonts', 'enside'),
	'id' => 'font_settings'
);

$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "font_settings"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Fonts settings', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true // Set true to show items by default.
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Headers font', 'enside'),
	"id" => "header_font",
	"desc" => wp_kses_post(__('Font used in headers. Default: Nunito', 'enside')),
	"options" => array(
		"font-sizes" => false,
		"color" => false,
		"font-families" => iPanel::getGoogleFonts(),
		"font-styles" => false
	),
	"std" => array(
		"font-family" => 'Nunito'
	),
	"type" => "typography"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Headers font parameters for Google Font', 'enside'),
	"id" => "header_font_options",
	"std" => "400,700",
	"desc" => wp_kses_post(__('You can specify additional Google Fonts paramaters here, for example fonts styles to load or subset. Default: 400,700<br>Example with custom subsets: 300,300italic,400,400italic&subset=latin,latin-ext,cyrillic.', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Body font', 'enside'),
	"id" => "body_font",
	"desc" => wp_kses_post(__('Font used in text elements. Default: Muli', 'enside')),
	"options" => array(
		"font-sizes" => array(
			" " => esc_html__('Font Size', 'enside'),
			'11' => '11px',
			'12' => '12px',
			'13' => '13px',
			'14' => '14px',
			'15' => '15px',
			'16' => '16px',
			'17' => '17px',
			'18' => '18px',
			'19' => '19px',
			'20' => '20px',
			'21' => '21px',
			'22' => '22px',
			'23' => '23px',
			'24' => '24px',
			'25' => '25px',
			'26' => '26px',
			'27' => '27px'
		),
		"color" => false,
		"font-families" => iPanel::getGoogleFonts(),
		"font-styles" => false
	),
	"std" => array(
		"font-size" => '14',
		"font-family" => 'Muli'
	),
	"type" => "typography"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Body font parameters for Google Font', 'enside'),
	"id" => "body_font_options",
	"std" => "300,300italic,400,400italic,600,600italic",
	"desc" => wp_kses_post(__('You can specify additional Google Fonts paramaters here, for example fonts styles to load or subset. Default: 300,300italic,400,400italic,600,600italic<br>Example with custom subsets: 300,300italic,400,400italic&subset=latin,latin-ext,cyrillic', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Buttons font', 'enside'),
	"id" => "buttons_font",
	"desc" => wp_kses_post(__('Font used in buttons. Default: Poppins', 'enside')),
	"options" => array(
		"font-sizes" => false,
		"color" => false,
		"font-families" => iPanel::getGoogleFonts(),
		"font-styles" => false
	),
	"std" => array(
		"font-size" => '14',
		"font-family" => 'Poppins'
	),
	"type" => "typography"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Button font parameters for Google Font', 'enside'),
	"id" => "buttons_font_options",
	"std" => "300,400,600",
	"desc" => wp_kses_post(__('You can specify additional Google Fonts paramaters here, for example fonts styles to load or subset. Default: 300,400,600<br>Example with custom subsets: 300,300italic,400,400italic&subset=latin,latin-ext,cyrillic', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Additional font', 'enside'),
	"id" => "additional_font",
	"desc" => wp_kses_post(__('Font used some special decorated theme elements. Default: Herr Von Muellerhoff', 'enside')),
	"options" => array(
		"font-sizes" => false,
		"color" => false,
		"font-families" => iPanel::getGoogleFonts(),
		"font-styles" => false
	),
	"std" => array(
		"font-size" => '48',
		"font-family" => 'Herr Von Muellerhoff'
	),
	"type" => "typography"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Enable Additional font', 'enside'),
	"id" => "additional_font_enable",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Uncheck if you don\'t want to use Additional font. This will speed up your site.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => wp_kses_post(__('<span style="color:red;font-weight:bold;">Disable ALL Google Fonts on site</span>', 'enside')),
	"id" => "font_google_disable",
	"std" => false,
	"field_options" => array(
		"box_label" => ""
	),
	"desc" => wp_kses_post(__('Use this if you want extra site speed or want to have regular fonts. Arial font will be used with this option.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Regular font (apply if you disabled Google Fonts below)', 'enside'),
	"id" => "font_regular",
	"std" => "Arial",
	"options" => array(
		"Arial" => "Arial",
		"Tahoma" => "Tahoma",
		"Times New Roman" => "Times New Roman",
		"Verdana" => "Verdana",
		"Helvetica" => "Helvetica",
		"Georgia" => "Georgia",
		"Courier New" => "Courier New"
	),
	"desc" => wp_kses_post(__('Use this option if you disabled ALL Google Fonts.', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Custom font size and font weight settings', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true // Set true to show items by default.
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Page title font size override', 'enside'),
	"id" => "page_title_font_size",
	"std" => "",
	"desc" => wp_kses_post(__('If you want to override default theme font size for pages title you can do it here. For example: 40px', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Headers font weight override', 'enside'),
	"id" => "header_font_weight",
	"std" => "",
	"desc" => wp_kses_post(__('If you want to override default theme font weight for &#x3C;h1&#x3E;,&#x3C;h2&#x3E;,&#x3C;h3&#x3E;,&#x3C;h4&#x3E;,&#x3C;h5&#x3E;,&#x3C;h6&#x3E; tags you can do it here. For example: 300', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Body font weight override', 'enside'),
	"id" => "body_font_weight",
	"std" => "",
	"desc" => wp_kses_post(__('If you want to override default theme font weight for &#x3C;BODY&#x3E; tag you can do it here. For example: 500', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Widget title font weight override', 'enside'),
	"id" => "widget_title_font_weight",
	"std" => "",
	"desc" => wp_kses_post(__('If you want to override default theme font weight for widgets titles you can do it here. For example: 300', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
	"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"type" => "EndTab"
);

/**
 * COLORS TAB
 **/

$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Colors & Skins', 'enside'),
	'id' => 'color_settings',
);

$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "color_settings",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Predefined color skins', 'enside'),
	"id" => "color_skin_name",
	"std" => "none",
	"options" => array(
		"none" => esc_html__('Use colors specified below', 'enside'),
		"default" => esc_html__('Enside (Default)', 'enside'),
		"green" => esc_html__('Green', 'enside'),
		"blue" => esc_html__('Cloudy blue', 'enside'),
		"purple" => esc_html__('Purple', 'enside'),
		"red" => esc_html__('Red', 'enside'),
		"blackandwhite" => esc_html__('Greyscale', 'enside'),
		"orange" => esc_html__('Yellow', 'enside'),
		"fencer" => esc_html__('Fencer', 'enside'),
		"perfectum" => esc_html__('Perfectum', 'enside'),
		"simplegreat" => esc_html__('SimpleGreat', 'enside')
	),
	"desc" => wp_kses_post(__('Select one of predefined skins', 'enside')),
	"type" => "select",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Body background color', 'enside'),
	"id" => "theme_body_color",
	"std" => "#ffffff",
	"desc" => wp_kses_post(__('Used in many theme places, default: #ffffff', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Body text color', 'enside'),
	"id" => "theme_text_color",
	"std" => "#2A2F35",
	"desc" => wp_kses_post(__('Used in many theme places, default: #2A2F35', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Theme Main color', 'enside'),
	"id" => "theme_main_color",
	"std" => "#3452ff",
	"desc" => wp_kses_post(__('Used in many theme places, links, buttons, tabs color, default: #3452ff', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Header background color', 'enside'),
	"id" => "theme_header_bg_color",
	"std" => "#ffffff",
	"desc" => wp_kses_post(__('Default: #ffffff', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Top menu background color', 'enside'),
	"id" => "theme_top_menu_bg_color",
	"std" => "#F5F5F5",
	"desc" => wp_kses_post(__('This background will be used for top menu. Default: #F5F5F5', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Top menu text/links color', 'enside'),
	"id" => "theme_top_menu_color",
	"std" => "#828282",
	"desc" => wp_kses_post(__('This background will be used for top menu. Default: #828282', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Main menu background color (for Light menu style)', 'enside'),
	"id" => "theme_main_menu_bg_color",
	"std" => "#FFFFFF",
	"desc" => wp_kses_post(__('This background will be used for menu below header position. Default: #FFFFFF', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Main menu background color (for Dark menu style)', 'enside'),
	"id" => "theme_main_menu_dark_bg_color",
	"std" => "#2A2F35",
	"desc" => wp_kses_post(__('This background will be used for Dark menu below header position. Default: #2A2F35', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Footer sidebar background color (for dark footer sidebar style)', 'enside'),
	"id" => "theme_footer_sidebar_bg_color",
	"std" => "#2A2F35",
	"desc" => wp_kses_post(__('This color apply if you selected Dark footer sidebar style. Default: #2A2F35', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Footer sidebar background color (for light footer sidebar style)', 'enside'),
	"id" => "theme_footer_sidebarlight_bg_color",
	"std" => "#E6E6E6",
	"desc" => wp_kses_post(__('This color apply if you selected Light footer sidebar style. Default: #E6E6E6', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Footer background color (for Dark footer style)', 'enside'),
	"id" => "theme_footer_bg_color",
	"std" => "#1C2126",
	"desc" => wp_kses_post(__('This color apply if you selected Dark footer style. Default: #1C2126', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Footer background color (for Light footer style)', 'enside'),
	"id" => "theme_footerlight_bg_color",
	"std" => "#F4F4F4",
	"desc" => wp_kses_post(__('This color apply if you selected Light footer sidebar style. Default: #F4F4F4', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Pages title color', 'enside'),
	"id" => "theme_title_color",
	"std" => "#2A2F35",
	"desc" => wp_kses_post(__('Default: #2A2F35', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"name" => esc_html__('Pages title background color', 'enside'),
	"id" => "theme_titlebg_color",
	"std" => "#F4F4F4",
	"desc" => wp_kses_post(__('Default: #F4F4F4', 'enside')),
	"field_options" => array(
		//'desc_in_tooltip' => true
	),
	"type" => "color",
);

$ipanel_enside_option[] = array(
	"type" => "EndTab"
);

/**
 * RESPONSIVE SETTINGS TAB
 **/
$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Responsive Settings', 'enside'),
	'id' => 'responsive_settings'
);
$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "responsive_settings"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Touch devices', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true 
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Disable fixed header on touch devices', 'enside'),
	"id" => "sticky_header_touch_disable",
	"std" => true,
	"desc" => wp_kses_post(__('You can disable sticky header on touch devices. Sticky header animation on some touch devices not so smooth like on desktop PC, if you worry about this you can use this option.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
		"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Tablet resolution (< 1024px width)', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true 
	)
);
$ipanel_enside_option[] = array(
	"type" => "info",
	"name" => esc_html__('Please note that if you disabled some element for Tablet it will be automatically disabled for mobile resolution too, no matter what settings you set for this element for mobile.', 'enside'),
	"field_options" => array(
		"style" => 'alert'
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Disable header info text', 'enside'),
	"id" => "responsive_tablet_headerinfotext_disable",
	"std" => true,
	"desc" => wp_kses_post(__('Disable header info text (address and phone in header on demo)', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Disable header top menu text', 'enside'),
	"id" => "responsive_tablet_headertopmenutext_disable",
	"std" => true,
	"desc" => wp_kses_post(__('Disable header top menu text', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
		"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Mobile resolution (< 767px width)', 'enside'),   
	"type" => "StartSection",
	"field_options" => array(
		"show" => true 
	)
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Disable header info text', 'enside'),
	"id" => "responsive_mobile_headerinfotext_disable",
	"std" => true,
	"desc" => wp_kses_post(__('Disable header info text (address and phone in header on demo)', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Disable header top menu text', 'enside'),
	"id" => "responsive_mobile_headertopmenutext_disable",
	"std" => true,
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Disable advanced header menu toggle button', 'enside'),
	"id" => "responsive_mobile_headeradvmenutoggle_disable",
	"std" => false,
	"desc" => wp_kses_post(__('You can disable header advanced menu toggle on mobile if this is not your main menu.', 'enside')),
	"type" => "checkbox",
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Logo width (px)', 'enside'),
	"id" => "responsive_mobile_logo_width",
	"std" => "",
	"desc" => wp_kses_post(__('Custom logo width for mobile, use if you have wide logo and it does not fit near menu icons on mobile. For example: 200', 'enside')),
	"type" => "text",
);
$ipanel_enside_option[] = array(
		"type" => "EndSection"
);
$ipanel_enside_option[] = array(
	"type" => "EndTab"
);

/**
 * CUSTOM CODE TAB
 **/

$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Custom CSS/JS', 'enside'),
	'id' => 'custom_code'
);

$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "custom_code",
);
$ipanel_enside_option[] = array(
	"type" => "htmlpage",
	"name" => wp_kses_post(__('<div class="ipanel-label"><label>Custom CSS styles</label></div><div class="ipanel-input">You can add Custom CSS styles in <a href="customize.php" target="_blank">WordPress Customizer</a> (in "Additional CSS" section at the left sidebar).<br/><br/><br/></div>', 'enside'))
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Custom JavaScript or JQuery code', 'enside'),
	"id" => "custom_js_code",
	"std" => '',
	"field_options" => array(
		"language" => "javascript",
		"line_numbers" => true,
		"autoCloseBrackets" => true,
		"autoCloseTags" => true
	),
	"desc" => wp_kses_post(__('This code will run in header, do not add &#x3C;script&#x3E;...&#x3C;/script&#x3E; tags here, this tags will be added automatically. You can use JQuery code here.', 'enside')),
	"type" => "textarea",
);

$ipanel_enside_option[] = array(
	"type" => "EndTab"
);

/**
 * DOCUMENTATION TAB
 **/

$ipanel_enside_tabs[] = array(
	"name" => esc_html__('Documentation', 'enside'),
	'id' => 'documentation'
);

$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "documentation"
);

function enside_get_plugin_version_number($plugin_name) {
        // If get_plugins() isn't available, require it
	if ( ! function_exists( 'get_plugins' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
        // Create the plugins folder and file variables
	$plugin_folder = get_plugins( '/' . $plugin_name );
	$plugin_file = $plugin_name.'.php';

	// If the plugin version number is set, return it 
	if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
		return $plugin_folder[$plugin_file]['Version'];

	} else {
	// Otherwise return null
		return esc_html__('Plugin not installed', 'enside');
	}
}

if(is_child_theme()) {
	$child_theme_html = ' (Child theme installed)';
} else {
	$child_theme_html = '';
}

$ipanel_enside_option[] = array(
	"type" => "htmlpage",
	"name" => '<div class="documentation-icon"><img src="'.esc_url(ENSIDE_IPANEL_URI). 'assets/img/documentation-icon.png" alt="Documentation"/></div><p>We recommend you to read <a href="http://magniumthemes.com/go/enside-docs/" target="_blank">Theme Documentation</a> before you will start using our theme to building your website. It covers all steps for site configuration, demo content import, theme features usage and more.</p>
<p>If you have face any problems with our theme feel free to use our <a href="http://support.magniumthemes.com/" target="_blank">Support System</a> to contact us and get help for free.</p>
<a class="button button-primary" href="http://magniumthemes.com/go/enside-docs/" target="_blank">Theme Documentation</a>
<a class="button button-primary" href="http://support.magniumthemes.com/" target="_blank">Support System</a><h3>Technical information (paste it to your support ticket):</h3><textarea style="width: 500px; height: 160px;font-size: 12px;">Theme Version: '.wp_get_theme(get_template())->get( 'Version' ).$child_theme_html.'
WordPress Version: '.get_bloginfo( 'version' ).'
Theme Addons version: '.enside_get_plugin_version_number('enside-theme-addons').'
WooCommerce Version: '.enside_get_plugin_version_number('woocommerce').'
Visual Composer Version: '.enside_get_plugin_version_number('js_composer').'
Slider Revolution Version: '.enside_get_plugin_version_number('revslider').'
</textarea>'
);

$ipanel_enside_option[] = array(
	"type" => "EndTab"
);

/**
 * EXPORT/IMPORT TAB
 **/

$ipanel_enside_tabs[] = array(
	'name' => esc_html__('Settings Backup', 'enside'),
	'id' => 'export_settings'
);

$ipanel_enside_option[] = array(
	"type" => "StartTab",
	"id" => "export_settings"
);
	
$ipanel_enside_option[] = array(
	"name" => esc_html__('Export theme control panel settings', 'enside'),
	"type" => "export",
	"desc" => wp_kses_post(__('Export theme admin panel settings to file.', 'enside'))
);
$ipanel_enside_option[] = array(
	"name" => esc_html__('Import theme control panel settings', 'enside'),
	"type" => "import"
);
$ipanel_enside_option[] = array(
	"type" => "EndTab"
);

/**
 * CONFIGURATION
 **/

$ipanel_configs = array(
	'ID'=> 'ENSIDE_PANEL',
	'menu'=> 
		array(
			'submenu' => false,
			'page_title' => esc_html__('Enside Control Panel', 'enside'),
			'menu_title' => esc_html__('Theme Control Panel ', 'enside'),
			'capability' => 'manage_options',
			'menu_slug' => 'manage_theme_options',
			'icon_url' => ENSIDE_IPANEL_URI . 'assets/img/panel-icon.png',
			'position' => 59
		),
	'rtl' => ( function_exists('is_rtl') && is_rtl() ),
	'tabs' => $ipanel_enside_tabs,
	'fields' => $ipanel_enside_option,
	'download_capability' => 'manage_options',
	'live_preview' => ''
);

$ipanel_theme_usage = new IPANEL( $ipanel_configs );
	