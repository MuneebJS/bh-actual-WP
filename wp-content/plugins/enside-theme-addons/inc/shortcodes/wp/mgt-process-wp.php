<?php
// Shortcode [mgt_process_wp]
function mgt_shortcode_process_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		'process_title' => '',
		'title_color' => '',
		'text_color' => 'black',
		'align' => 'center',
		'fontweight' => 'bold',
		'dots_position' => 'none',
		'process_icon_size' => 'regular',
		'process_type' => 'icon',
		'char' => '1',
		'process_icon_type' => 'fontawesome',
		'process_icon_fontawesome' => 'fa fa-adjust',
		'process_icon_pe7stroke' => 'pe-7s-album',
		'process_icon_openiconic' => 'vc-oi vc-oi-dial',
		'process_icon_typicons' => 'typcn typcn-adjust-brightness',
		'process_icon_entypo' => 'entypo-icon entypo-icon-note',
		'process_icon_linecons' => 'vc_li vc_li-heart',
		'process_icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
		'process_icon_material' => 'vc-material vc-material-cake',
		'icon_color' => '',
		'icon_color_bg' => '',
		'border_style' => 'circle',
		'process_border_color' => '',
		'process_border_color_grad_enable' => false,
		'process_border_color_grad' => '',
		'block_shadow_effect' => false,
		'css_animation' => 'none'
	), $atts));

	ob_start();

	$mgt_custom_css = '';

	// Default font-weight
	if($fontweight == 'bold') {
		$fontweight = 'default';
	}

	// Process icon
	// Load VC icons libraries
	if($process_type == 'icon') {
		vc_iconpicker_editor_jscss();

		switch($process_icon_type) {
			case 'fontawesome':
		        $process_icon_html = '<i class="'.$process_icon_fontawesome.'"></i>';
		    break;
		    case 'openiconic':
		        $process_icon_html = '<i class="'.$process_icon_openiconic.'"></i>';
		    break;
		    case 'typicons':
		        $process_icon_html = '<i class="'.$process_icon_typicons.'"></i>';
		    break;
		    case 'entypo':
		        $process_icon_html = '<i class="'.$process_icon_entypo.'"></i>';
		    break;
		    case 'linecons':
		        $process_icon_html = '<i class="'.$process_icon_linecons.'"></i>';
		    break;
		    case 'monosocial':
		        $process_icon_html = '<i class="'.$process_icon_monosocial.'"></i>';
		    break;
		    case 'material':
		        $process_icon_html = '<i class="'.$process_icon_material.'"></i>';
		    break;
		   case 'pe7stroke':
		        $process_icon_html = '<i class="'.$process_icon_pe7stroke.'"></i>';
		    break;
		}
	} else {
		$process_icon_html = '<span class="mgt-process-icon-char">'.$char.'</span>';
	}

	$icon_html = '<div class="mgt-process-icon-wrapper"><div class="mgt-process-icon">'.$process_icon_html.'</div></div>';

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

	// Block shadow effect
	if($block_shadow_effect) {
		$block_shadow_class = ' mgt-process-shadow';
	} else {
		$block_shadow_class = '';
	}

	// Custom CSS
	$unique_id = rand(1000000,90000000);

	$unique_class_name = 'mgt-process-'.$unique_id;

	if($process_border_color_grad_enable == false && $process_border_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-process-wrapper .mgt-process-icon-wrapper {
		        background-color: $process_border_color!important;
		    }
		";
    }

    if($process_border_color_grad_enable == true && $process_border_color_grad !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-process-wrapper .mgt-process-icon-wrapper {
		        background-color: $process_border_color!important;
				background: -moz-linear-gradient(top,  $process_border_color 0%, $process_border_color_grad 100%)!important;
				background: -webkit-linear-gradient(top,  $process_border_color 0%, $process_border_color_grad 100%)!important;
				background: linear-gradient(to bottom,  $process_border_color 0%, $process_border_color_grad 100%)!important;
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='$process_border_color', endColorstr='$process_border_color_grad',GradientType=1 )!important;

		    }
		";
    }

    if($icon_color_bg !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-process-wrapper .mgt-process-icon-wrapper:after {
		        background-color: $icon_color_bg!important;
		    }
		";
    }

    if($title_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-process-wrapper h5.mgt-process-title {
		        color: $title_color!important;
		    }
		";
    }

    if($icon_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-process-wrapper .mgt-process-icon-wrapper .mgt-process-icon {
		        color: $icon_color!important;
		    }
		";
    }

    // Render element
	echo '<div class="mgt-process-wrapper '.esc_attr($unique_class_name).' mgt-process-icon-size-'.esc_attr($process_icon_size).' mgt-process-border-'.$border_style.' mgt-process-dots-'.$dots_position.' wpb_content_element text-'.esc_attr($text_color).' text-'.esc_attr($align).esc_attr($animation_css_class).$block_shadow_class.'">';

	echo wp_kses_post($icon_html);

	if(trim($process_title) !== '') {
		echo '<h5 class="mgt-process-title text-font-weight-'.esc_attr($fontweight).' ">'.wp_kses_post($process_title).'</h5>';
	}

	if(trim($sc_content) !== '') {
		echo '<div class="mgt-process-text">'.wp_kses_post($sc_content).'</div>';
	}

	echo '</div>';

	// Custom CSS display
    if($mgt_custom_css !== '') {
		$mgt_custom_css = str_replace(array("\r", "\n", "  ", "	"), '', $mgt_custom_css);
		echo "<style scoped='scoped'>$mgt_custom_css</style>"; // This variable contains user Custom CSS code and can't be escaped with WordPress functions.
	}

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_process_wp", "mgt_shortcode_process_wp");
