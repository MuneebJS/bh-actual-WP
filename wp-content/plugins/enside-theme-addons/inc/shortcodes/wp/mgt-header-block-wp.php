<?php

// Shortcode [mgt_header_block_wp]
function mgt_shortcode_header_block_wp($atts, $sc_content = null) {
	global $mgt_custom_css;

	extract(shortcode_atts(array(
		'title' => 'Header',
		'subtitle' => '',
		'fontsize' => 'regular',
		'line' => 1,
		'line_style' => 'rounded',
		'line_margin' => 'large',
		'line_color' => '',
		'line_grad' => false,
		'line_color_grad' => '',
		'align' => 'left',
		'style' => 1,
		'texttransform' => 'header',
		'color' => 'black',
		'color_custom' => '',
		'header_font_size' => 'h2',
		'fontweight' => 'normal',
		'css_animation' => 'none',
		'css' => ''
	), $atts));

	ob_start();

	// Default font-weight
	if($fontweight == 'normal') {
		$fontweight = 'default';
	}

	$mgt_custom_css = '';

	// Custom CSS
	$unique_id = rand(1000000,90000000);

	$unique_class_name = 'mgt-header-block-'.$unique_id;

	// Custom color
	if($color_custom !== '') {
		$mgt_custom_css .= "
		    .$unique_class_name.mgt-header-block .mgt-header-block-title {
		        color: $color_custom!important;
		    }
		";
	}

	// Line
	if($line == 1 && $line_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-header-block .mgt-header-line {
		        background-color: $line_color!important;
		    }
		";
    }

    if($line == 1 && $line_color_grad !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-header-block .mgt-header-line {
		        background-color: $line_color!important;
				background: -moz-linear-gradient(left,  $line_color 0%, $line_color_grad 100%)!important;
				background: -webkit-linear-gradient(left,  $line_color 0%, $line_color_grad 100%)!important;
				background: linear-gradient(to right,  $line_color 0%, $line_color_grad 100%)!important;
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$line_color', endColorstr='$line_color_grad',GradientType=1 )!important;

		    }
		";
    }

	// Subtitle
	if($subtitle !== '') {
		$subtitle = '<p class="mgt-header-block-subtitle">'.$subtitle.'</p>';
	}

	// Line
	$line_html = '';

	if($line == 1) {
		$line_html = '<div class="mgt-header-line mgt-header-line-margin-'.esc_attr($line_margin).' mgt-header-line-style-'.esc_attr($line_style).'"></div>';
	}

	// Styles
	$addclass = " mgt-header-block-style-".$style;

	$addclass .= " mgt-header-block-fontsize-".$fontsize;

	$addclass .= " mgt-header-texttransform-".$texttransform;

	$addclass .= ' '.$unique_class_name;


	if($style == 1) {
		$content = '<'.$header_font_size.' class="mgt-header-block-title text-font-weight-'.esc_attr($fontweight).'">'.wp_kses_post($title).'</'.$header_font_size.'>'.$subtitle;
	} else {
		$content = $subtitle.'<'.$header_font_size.' class="mgt-header-block-title text-font-weight-'.esc_attr($fontweight).'">'.wp_kses_post($title).'</'.$header_font_size.'>';
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

	echo '<div class="mgt-header-block clearfix text-'.esc_attr($align).' text-'.esc_attr($color).esc_attr($animation_css_class).' wpb_content_element '.esc_attr($addclass).' '.esc_attr( $css_class ).'">'.wp_kses_post($content).wp_kses_post($line_html).'</div>';

	// Add custom styles to button
    if($mgt_custom_css !== '') {
		$mgt_custom_css = str_replace(array("\r", "\n", "  ", "	"), '', $mgt_custom_css);
		echo "<style scoped='scoped'>$mgt_custom_css</style>"; // This variable contains user Custom CSS code and can't be escaped with WordPress functions.
	}

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_header_block_wp", "mgt_shortcode_header_block_wp");
