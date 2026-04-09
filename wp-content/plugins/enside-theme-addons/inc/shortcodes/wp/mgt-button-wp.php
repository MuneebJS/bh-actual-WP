<?php
// Shortcode [mgt_button_wp]
function mgt_shortcode_button_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		'button_link' => '',
		'button_link_lightbox' => false,
		'button_style' => 'solid',
		'button_round_edges' => 'disable',
		'button_size' => 'normal',
		'button_align' => 'center',
		'button_display' => 'inline',
		'text_size' => 'normal',
		'text_transform' => 'none',
		'button_top_margin' => false,
		'button_right_margin' => false,
		// Icon
		'button_icon' => false,
		'button_icon_position' => 'left',
		'button_icon_separator' => false,
		'icon_type' => 'fontawesome',
		'icon_fontawesome' => 'fa fa-adjust',
		'icon_pe7stroke' => 'pe-7s-album',
		'icon_openiconic' => 'vc-oi vc-oi-dial',
		'icon_typicons' => 'typcn typcn-adjust-brightness',
		'icon_entypo' => 'entypo-icon entypo-icon-note',
		'icon_linecons' => 'vc_li vc_li-heart',
		'icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
		'icon_material' => 'vc-material vc-material-cake',
		// Animations
		'hover_effect' => 'default',
		'css_animation' => 'none',
		// Custom styles
		'button_override' => false,
		'fontweight' => 'normal',
		'button_color_bg' => '',
		'button_bg_grad' => false,
		'button_color_bggrad' => '',
		'button_color_bghover' => '',
		'button_bghover_grad' => false,
		'button_color_bghovergrad' => '',
		'button_color_text' => '',
		'button_color_texthover' => '',
		'button_border' => false,
		'button_border_width' => 2,
		'button_color_border' => '',
		'button_color_borderhover' => '',
		'unique_button_id' =>'',

	), $atts));

	ob_start();

	// Default font-weight
	if($fontweight == 'normal') {
		$fontweight = 'default';
	}

	if(!$button_top_margin) {
		$button_top_margin = 'false';
	}

	if(!$button_right_margin) {
		$button_right_margin = 'false';
	}

	$button_data = vc_build_link($button_link);

	$button_html = '';
	$mgt_custom_css = '';

	if($button_data['url'] !== '') {

		// CSS classes
		if($css_animation !== 'none') {
			// Code from /wp-content/plugins/js_composer/include/classes/shortcodes/shortcodes.php:640, public function getCSSAnimation( $css_animation )
			$animation_css_class = ' wpb_animate_when_almost_visible wpb_'.$css_animation.' '.$css_animation;

			// Load animation JS
			wp_enqueue_script( 'vc_waypoints' );
			wp_enqueue_style( 'vc_animate-css' );

		} else {
			$animation_css_class = '';
		}

		$add_class = 'btn hvr-'.$hover_effect.' mgt-button-icon-'.$button_icon.' mgt-button mgt-style-'.$button_style.' mgt-size-'.$button_size.' mgt-align-'.$button_align.' mgt-display-'.$button_display.' mgt-text-size-'.$text_size.' mgt-button-icon-separator-'.$button_icon_separator.' mgt-button-icon-position-'.$button_icon_position.' text-font-weight-'.esc_attr($fontweight).' mgt-text-transform-'.$text_transform;

		// Custom styles
		if($button_override == true) {

			$unique_id = rand(1000000,90000000);

			$unique_class_name = 'mgt-button-'.$unique_id;

			if($button_bg_grad == false && $button_color_bg !== '') {
		    	$mgt_custom_css .= "
				    .$unique_class_name.mgt-button {
				        background-color: $button_color_bg!important;

				    }
				";
		    }

		    if($button_bg_grad == true && $button_color_bggrad !== '') {
		    	$mgt_custom_css .= "
				    .$unique_class_name.mgt-button {

						background: -moz-linear-gradient(left,  $button_color_bg 0%, $button_color_bggrad 100%)!important;
						background: -webkit-linear-gradient(left,  $button_color_bg 0%, $button_color_bggrad 100%)!important;
						background: linear-gradient(to right,  $button_color_bg 0%, $button_color_bggrad 100%)!important;
						background-color: $button_color_bg!important;
				    }
				";
		    }

		    if($button_color_bghovergrad == false && $button_color_bghover !== '') {
		    	$mgt_custom_css .= "
				    .$unique_class_name.mgt-button:hover {
				    	background: none!important;
				        background-color: $button_color_bghover!important;
				    }
				";
		    }

		    if($button_bghover_grad == true && $button_color_bghovergrad !== '') {
		    	$mgt_custom_css .= "
				    .$unique_class_name.mgt-button:hover {

						background: -moz-linear-gradient(left,  $button_color_bghover 0%, $button_color_bghovergrad 100%)!important;
						background: -webkit-linear-gradient(left,  $button_color_bghover 0%, $button_color_bghovergrad 100%)!important;
						background: linear-gradient(to right,  $button_color_bghover 0%, $button_color_bghovergrad 100%)!important;
						background-color: $button_color_bghover!important;

				    }
				";
		    }

		    if($button_color_text !== '') {
		    	$mgt_custom_css .= "
				    .$unique_class_name.mgt-button {
				        color: $button_color_text!important;
				    }
				";
		    }

		    if($button_color_texthover !== '') {
		    	$mgt_custom_css .= "
				    .$unique_class_name.mgt-button:hover {
				        color: $button_color_texthover!important;
				    }
				";
		    }

		    // Animations support for custom style
		    if($hover_effect !== 'default') {

		    	if($button_color_bg !== '') {
		    		$mgt_custom_css .= "
					    .$unique_class_name.mgt-button:before {
						    background: $button_color_bg!important;
						}
						.$unique_class_name.mgt-button.hvr-sweep-to-right:hover,
						.$unique_class_name.mgt-button.hvr-sweep-to-left:hover,
						.$unique_class_name.mgt-button.hvr-sweep-to-bottom:hover,
						.$unique_class_name.mgt-button.hvr-sweep-to-top:hover,
						.$unique_class_name.mgt-button.hvr-bounce-to-right:hover,
						.$unique_class_name.mgt-button.hvr-bounce-to-left:hover,
						.$unique_class_name.mgt-button.hvr-bounce-to-bottom:hover,
						.$unique_class_name.mgt-button.hvr-bounce-to-top:hover {
						    background: $button_color_bg!important;
						}
					";
		    	}

				if($button_color_bghover !== '') {
					$mgt_custom_css .= "
						.$unique_class_name.mgt-button.mgt-style-solid:before {
						    background: $button_color_bghover!important;
						}
						.$unique_class_name.mgt-button.mgt-style-solid-invert.hvr-sweep-to-right:hover,
						.$unique_class_name.mgt-button.mgt-style-solid-invert.hvr-sweep-to-left:hover,
						.$unique_class_name.mgt-button.mgt-style-solid-invert.hvr-sweep-to-bottom:hover,
						.$unique_class_name.mgt-button.mgt-style-solid-invert.hvr-sweep-to-top:hover,
						.$unique_class_name.mgt-button.mgt-style-solid-invert.hvr-bounce-to-right:hover,
						.$unique_class_name.mgt-button.mgt-style-solid-invert.hvr-bounce-to-left:hover,
						.$unique_class_name.mgt-button.mgt-style-solid-invert.hvr-bounce-to-bottom:hover,
						.$unique_class_name.mgt-button.mgt-style-solid-invert.hvr-bounce-to-top:hover {
						    background: $button_color_bghover!important;
						}
						.$unique_class_name.mgt-button.mgt-style-borderedblack:before {
						    background: $button_color_bghover!important;
						}
					";
				}

		    }

		    // Button border
		    if($button_border == true) {

		    	$button_border_widthpx = $button_border_width.'px';

				$mgt_custom_css .= "
				    .$unique_class_name.mgt-button {
				        border: $button_border_widthpx solid $button_color_border!important;
				        height: auto;
				    }
				    .$unique_class_name.mgt-button:hover {
				        border: $button_border_widthpx solid $button_color_borderhover!important;
				    }
				";
		    }

			$add_class .= ' '.$unique_class_name;

		}

		// Button icon
		if($button_icon == true) {

			// Load VC icons libraries
			vc_iconpicker_editor_jscss();

			switch($icon_type) {
				case 'fontawesome':
			        $button_icon_html = '<i class="'.$icon_fontawesome.'"></i>';
			    break;
			    case 'openiconic':
			        $button_icon_html = '<i class="'.$icon_openiconic.'"></i>';
			    break;
			    case 'typicons':
			        $button_icon_html = '<i class="'.$icon_typicons.'"></i>';
			    break;
			    case 'entypo':
			        $button_icon_html = '<i class="'.$icon_entypo.'"></i>';
			    break;
			    case 'linecons':
			        $button_icon_html = '<i class="'.$icon_linecons.'"></i>';
			    break;
			    case 'monosocial':
			        $button_icon_html = '<i class="'.$icon_monosocial.'"></i>';
			    break;
			    case 'material':
			        $button_icon_html = '<i class="'.$icon_material.'"></i>';
			    break;
			   case 'pe7stroke':
			        $button_icon_html = '<i class="'.$icon_pe7stroke.'"></i>';
			    break;
			}

		} else {
			$button_icon_html = '';
		}

		if($button_data['target'] !== '') {
			$target_html = ' target="'.$button_data['target'].'"';
		} else {
			$target_html = '';
		}

		if($button_data['title'] == '') {
			$add_class .= ' mgt-button-no-text';
		}

		if($button_link_lightbox) {
			$button_rel = ' rel="lightbox"';
		} else {
			$button_rel = '';
		}

		$button_html .= '<div class="mgt-button-wrapper mgt-button-wrapper-align-'.$button_align.' mgt-button-wrapper-display-'.$button_display.' mgt-button-top-margin-'.$button_top_margin.' mgt-button-right-margin-'.$button_right_margin.' mgt-button-round-edges-'.$button_round_edges.' '.esc_attr($animation_css_class).'">';

		if($button_icon_position == 'right') {

			$button_html .= '<a class="'.esc_attr($add_class).'"'.wp_kses_post($button_rel).' href="'.esc_url($button_data['url']).'"'.($target_html).'>'.esc_html($button_data['title']).wp_kses_post($button_icon_html).'</a>';
		} else {
			$button_html .= '<a class="'.esc_attr($add_class).'"'.wp_kses_post($button_rel).' href="'.esc_url($button_data['url']).'"'.($target_html).'>'.wp_kses_post($button_icon_html).esc_html($button_data['title']).'</a>';
		}

		$button_html .= '</div>';

	}

	// All data inside $button_html variable already correctly escaped and safe.
	echo $button_html;

	// Add custom styles to button
    if($mgt_custom_css !== '') {
		$mgt_custom_css = str_replace(array("\r", "\n", "  ", "	"), '', $mgt_custom_css);

		echo "<style scoped='scoped'>$mgt_custom_css</style>"; // This variable contains user Custom CSS code and can't be escaped with WordPress functions.
	}

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_button_wp", "mgt_shortcode_button_wp");
