<?php

// Shortcode [mgt_icon_box_wp]
function mgt_shortcode_icon_box_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		/* Content */
		'disable_content' => false,
		'title_position' => 'top',
		'subtitle' => '',
		'title' => 'Title',
		'title_url' => '',
		'title_url_target' => '_self',
		'title_fontweight' => 'bold',
		'title_fontsize' => '',
		'title_color' => '',
		'color' => 'black',
		'css_animation' => 'none',
		/* Icon */
		'iconbox_icon_type' => 'font',
		'icon_image_id' => '',
		'icon_type' => 'fontawesome',
		'icon_fontawesome' => 'fa fa-adjust',
		'icon_pe7stroke' => 'pe-7s-album',
		'icon_openiconic' => 'vc-oi vc-oi-dial',
		'icon_typicons' => 'typcn typcn-adjust-brightness',
		'icon_entypo' => 'entypo-icon entypo-icon-note',
		'icon_linecons' => 'vc_li vc_li-heart',
		'icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
		'icon_material' => 'vc-material vc-material-cake',
		'icon_align' => 'left',
		'icon_color' => '',
		'icon_size' => 'normal',
		'icon_image_noresize' => false,
		'icon_animation_enable' => false,
		'icon_animation' => 'hvr-icon-push',
		'icon_background' => false,
		'icon_background_style' => 'none',
		'icon_background_color' => '',
		'css' => ''
	), $atts));

	ob_start();

	$mgt_custom_css = '';

	// Icon
	$icon_image_data = wp_get_attachment_image_src( $icon_image_id, 'mgt-image-square-small' );

	if(($icon_image_data !== false)&&($iconbox_icon_type == 'image')) {
		// Image icon
		$icon_image_html = '<img src="'.$icon_image_data[0].'" alt="'.$title.'"/>';
		$icon_type_class = "mgt-icon-image";
	} else {
		// Font icon

		// Load VC icons libraries
		vc_iconpicker_editor_jscss();

		switch($icon_type) {
			case 'fontawesome':
		        $icon_image_html = '<i class="mgt-font-icon '.$icon_fontawesome.'"></i>';
		    break;
		    case 'openiconic':
		        $icon_image_html = '<i class="mgt-font-icon '.$icon_openiconic.'"></i>';
		    break;
		    case 'typicons':
		        $icon_image_html = '<i class="mgt-font-icon '.$icon_typicons.'"></i>';
		    break;
		    case 'entypo':
		        $icon_image_html = '<i class="mgt-font-icon '.$icon_entypo.'"></i>';
		    break;
		    case 'linecons':
		        $icon_image_html = '<i class="mgt-font-icon '.$icon_linecons.'"></i>';
		    break;
		    case 'monosocial':
		        $icon_image_html = '<i class="mgt-font-icon '.$icon_monosocial.'"></i>';
		    break;
		    case 'material':
		        $icon_image_html = '<i class="mgt-font-icon '.$icon_material.'"></i>';
		    break;
		   case 'pe7stroke':
		        $icon_image_html = '<i class="mgt-font-icon '.$icon_pe7stroke.'"></i>';
		    break;
		}

		$icon_image_html = $icon_image_html;
		$icon_type_class = "mgt-icon-font";
	}

	$add_class = ' mgt-icon-box-'.$title_position;

	// Original image icon size
	if($icon_background == true) {
		$icon_image_noresize == false;
	}

	if($icon_image_noresize == true) {
		$add_class .= ' mgt-icon-box-icon-size-original';
	} else {
		$add_class .= ' mgt-icon-box-icon-size-'.$icon_size;
	}

	// Custom CSS for icon box
	$unique_block_id = rand(1000000,90000000);

	$unique_class_name = 'mgt-icon-box-'.($unique_block_id);

	if($icon_background == true) {
		$icon_background_class = ' '.$icon_type_class.' mgt-icon-background mgt-icon-background-style-'.$icon_background_style;
	}  else {
		$icon_background_class = ' '.$icon_type_class;
	}

	// Custom background color or icon color
	if($icon_background && $icon_background_color !== '' || $icon_color !== '') {

		// Icon background color
		if($icon_background_color !== '') {
			$mgt_custom_css .= "
			    .$unique_class_name.mgt-icon-box.mgt-icon-background .mgt-icon-box-icon {
			        border-color: $icon_background_color!important;
			    }
			    .$unique_class_name.mgt-icon-box.mgt-icon-background.mgt-icon-background-style-rounded .mgt-icon-box-icon,
			    .$unique_class_name.mgt-icon-box.mgt-icon-background.mgt-icon-background-style-boxed .mgt-icon-box-icon,
			    .$unique_class_name.mgt-icon-box.mgt-icon-background.mgt-icon-background-style-rounded-less .mgt-icon-box-icon {
			        background-color: $icon_background_color!important;
			    }

			";
		}

		// Icon color
		if($icon_color !== '') {
			$mgt_custom_css .= "
			    .$unique_class_name.mgt-icon-box .mgt-icon-box-icon {
			        color: $icon_color!important;
			    }
			";
		}

		$add_class .= ' '.$unique_class_name;

	}

	// Title font size
	if($title_fontsize !== '') {
		$mgt_custom_css .= "
		    .$unique_class_name.mgt-icon-box h5 {
		        font-size: $title_fontsize!important;
		    }
		";

		$add_class .= ' '.$unique_class_name;
	}

	// Title color
	if($title_color !== '') {
		$mgt_custom_css .= "
		    .$unique_class_name.mgt-icon-box h5,
		    .$unique_class_name.mgt-icon-box h5 a {
		        color: $title_color!important;
		    }
		";

		$add_class .= ' '.$unique_class_name;
	}

	// Subtitle
	$subtitle_html = '';

	if($subtitle !== '') {
		$subtitle_html = '<h6>'.$subtitle.'</h6>';
	}

	// Title url
	$title_url = trim($title_url);

	if($title_url !== '') {
		$title = '<a href="'.$title_url.'" target="'.$title_url_target.'">'.$title.'</a>';
	}

	// Icon animation
	if($icon_animation_enable == true) {
		$icon_class = ' '.$icon_animation;
	} else {
		$icon_class = '';
	}

	// CSS Animation
	if($css_animation !== 'none') {

		// Code from /wp-content/plugins/js_composer/include/classes/shortcodes/shortcodes.php:640, public function getCSSAnimation( $css_animation )
		$animation_css_class = ' wpb_animate_when_almost_visible wpb_'.$css_animation.' '.$css_animation;

		// Load animation JS
		wp_enqueue_script( 'vc_waypoints' );
		wp_enqueue_style( 'vc_animate-css' );

	} else {
		$animation_css_class = '';
	}

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );

	if($disable_content == false) {

		// Remove incorrect WordPress autop tag from content
		$patterns = array(
		    '#^\s*</p>#',
		    '#<p>\s*$#'
		);
		$sc_content = preg_replace($patterns, '', $sc_content);

		// Icon with content
		if($title_position == 'top') {
		echo '<div class="mgt-icon-box wpb_content_element'.esc_attr($animation_css_class).esc_attr($add_class).esc_attr($icon_background_class).' text-'.esc_attr($color).' '.esc_attr( $css_class ).'">'.wp_kses_post($subtitle_html).'<h5 class="text-font-weight-'.esc_attr($title_fontweight).'">'.wp_kses_post($title).'</h5><div class="mgt-icon-box-icon '.esc_attr($icon_class).'">'.wp_kses_post($icon_image_html).'</div><div class="mgt-icon-box-content">'.wp_kses_post($sc_content).'</div><div class="clearfix"></div></div>';
		} else {
			echo '<div class="mgt-icon-box wpb_content_element'.esc_attr($animation_css_class).esc_attr($add_class).esc_attr($icon_background_class).' text-'.esc_attr($color).' '.esc_attr( $css_class ).'"><div class="mgt-icon-box-icon'.esc_attr($icon_class).'">'.wp_kses_post($icon_image_html).'</div><div class="mgt-icon-box-content">'.wp_kses_post($subtitle_html).'<h5 class="text-font-weight-'.esc_attr($title_fontweight).'">'.wp_kses_post($title).'</h5><div class="mgt-icon-box-text">'.wp_kses_post($sc_content).'</div></div><div class="clearfix"></div></div>';
		}
	} else {
		// Icon without content
		echo '<div class="mgt-icon-box mgt-icon-box-disable-content mgt-icon-align-'.$icon_align.' wpb_content_element'.esc_attr($animation_css_class).esc_attr($add_class).esc_attr($icon_background_class).' '.esc_attr( $css_class ).'"><div class="mgt-icon-box-icon'.esc_attr($icon_class).'">'.wp_kses_post($icon_image_html).'</div></div>';

	}
	// Custom CSS
	if($mgt_custom_css !== '') {
		$mgt_custom_css = str_replace(array("\r", "\n", "  ", "	"), '', $mgt_custom_css);
		echo "<style scoped='scoped'>$mgt_custom_css</style>"; // This variable contains user Custom CSS code and can't be escaped with WordPress functions.
	}


	$sc_content = ob_get_contents();
	ob_end_clean();

	return $sc_content;
}

add_shortcode("mgt_icon_box_wp", "mgt_shortcode_icon_box_wp");
