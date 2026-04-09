<?php
// Shortcode [mgt_promo_block_wp]
function mgt_shortcode_promo_block_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		/* General */
		'background_color' => '#F5F5F5',
		'darken' => 'no-darken',
		'darken_overlay_color' => 'rgba(0,0,0,0.3)',
		'darken_overlay_grad' => '',
		'darken_overlay_color_grad' => 'rgba(0,0,0,0.7)',
		'animated' => 0,
		'animated_overlay_color' => 'rgba(0,0,0,0.5)',
		'background_image_id' => '',
		'background_repeat' => 'no-repeat',
		'coverimage' => 0,
		'parallax' => '',
		'parallax_speed' => 1.5,
		'video_bg' => false,
		'video_bg_url' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
		'block_border' => false,
		'block_border_width' => 1,
		'block_border_style' => 'solid',
		'block_color_border' => '',
		'block_color_borderhover' => '',
		'block_height' => '',
		'content_va' => 'middle',
		'block_round_edges' => 'disable',
		'text_color' => 'black',
		'text_color_hover' => 0,
		'block_url'	=> '',
		'block_url_target_blank' => false,
		'css_animation' => 'none',
		/* Top Image */
		'top_image_enable' => false,
		'top_image_id' => '',
		'top_image_background_color' => '',
		'top_image_background_size' => 'cover',
		'top_image_height' => '',
		'top_image_url' => '',
		/* Button */
		'button_url' => '',
		'button_link_lightbox' => false,
		'button_style' => 'solid',
		'button_round_edges' => 'disable',
		'button_size' => 'normal',
		'button_align' => 'center',
		'button_text_size' => 'normal',
		'button_text_transform' => 'none',
		'button_top_margin' => false,
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
		// Animation
		'button_show_onhover' => 0,
		'hover_effect' => 'default',
		/* Button custom styles */
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
		/* Block format */
		'format_h1_fontsize' => '',
		'format_h1_margin' => '',
		'format_h1_color' => '',
		'format_h2_fontsize' => '',
		'format_h2_margin' => '',
		'format_h2_color' => '',
		'format_h3_fontsize' => '',
		'format_h3_margin' => '',
		'format_h3_color' => '',
		'format_p_fontsize' => '',
		'format_p_margin' => '',
		'format_p_color' => '',
		'format_a_color' => '',
		/* CSS */
		'block_shadow_effect' => false,
		'block_hover_effect' => false,
		'block_content_onhover' => false,
		'css' => '',
	), $atts));

	ob_start();

	$style = '';
	$wrapper_add_class = '';
	$add_class = '';
	$mgt_custom_css = '';
	$add_class_content = '';
	$top_image_html = '';
	$parallax_image = '';

	// Trim fields
	$block_url = trim($block_url);
	$top_image_url = trim($top_image_url);

	// Top image
	if($top_image_enable) {
		$top_image_size = 'enside-blog-thumb';

		$top_image_data = wp_get_attachment_image_src( $top_image_id, $top_image_size );

		if(trim($top_image_data[0]) !== '') {

			$style = 'background-image: url('.$top_image_data[0].');';

			if($top_image_height !== '') {
				$style .= 'height: '.esc_attr($top_image_height).'px;';
			}

			if($top_image_background_color !=='') {
				$style .= 'background-color: '.esc_attr($top_image_background_color).';';
			}

			if($top_image_background_size !=='') {
				$style .= 'background-size: '.esc_attr($top_image_background_size).';';
			}

			if($top_image_url !=='') {
				$top_image_html = '<div class="mgt-promo-block-top-image" data-style="'.($style).'"><a class="mgt-promo-block-top-image-link" href="'.($top_image_url).'"></a></div>';
			} else {
				$top_image_html = '<div class="mgt-promo-block-top-image" data-style="'.($style).'"></div>';
			}
		}
	}

	// Background image
	$style = '';

	$background_image_size = 'full';

	$background_image_data = wp_get_attachment_image_src( $background_image_id, $background_image_size );

	if(empty($background_image_data[0])) {
		if($background_color !== '') {
			$style = 'background-color: '.$background_color.';';
		}

		if($block_height == '') {
			$block_height = 'auto';
		}
	} else {

		if($background_color !== '') {
			$style .= 'background-color: '.$background_color.';';
		}

		if(empty( $parallax )) {
			$style .= 'background-image: url('.($background_image_data[0]).');';

			$style .= 'background-repeat: '.($background_repeat).';';

			if($block_height == '') {
				$block_height = $background_image_data[2].'px';
			}
		} else {
			$parallax_image = $background_image_data[0];
		}

	}

	// CSS Classes
	if($animated == 1) {
		$add_class .= ' animated';
	}

	if($text_color == 'white') {
		$add_class .= ' white-text';
	} else {
		$add_class .= ' black-text';
	}

	if($text_color_hover == 1) {
		$add_class .= ' text-color-hover-white';
	}

	if($coverimage == 1) {
		$add_class .= ' cover-image';
	}

	$add_class .= ' '.$darken;

	$style .= 'height: '.($block_height).';';

	// Custom CSS for Promo Block
	$unique_block_id = rand(1000000,90000000);

	$unique_class_name = 'mgt-promo-block-'.($unique_block_id);

	// Block border
	if($block_border) {
		$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block {
		        border: ".$block_border_width."px $block_border_style $block_color_border!important;
		    }
		";

		if($block_color_borderhover!=='') {
			$mgt_custom_css .= "
			    .$unique_class_name.mgt-promo-block:hover {
			    	border-color: $block_color_borderhover!important;
			    }
			";
		}
	}

	if($darken == 'darken' && ($darken_overlay_color !== '')) {
		$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block.darken .mgt-promo-block-content {
		        background-color: $darken_overlay_color!important;
		    }

		";
	}

	if($darken_overlay_grad !== '' && ($darken_overlay_color_grad !== '')) {
		// IE fix
		if($darken_overlay_grad == 'left') {
			$darken_overlay_grad_ie = 'right';
		}

		if($darken_overlay_grad == 'top') {
			$darken_overlay_grad_ie = 'bottom';
		}

		$mgt_custom_css .= "
	    .$unique_class_name.mgt-promo-block.darken .mgt-promo-block-content {

			background: -moz-linear-gradient($darken_overlay_grad,  $darken_overlay_color 0%, $darken_overlay_color_grad 100%)!important;
			background: -webkit-linear-gradient($darken_overlay_grad,  $darken_overlay_color 0%, $darken_overlay_color_grad 100%)!important;
			background: linear-gradient(to $darken_overlay_grad_ie,  $darken_overlay_color 0%, $darken_overlay_color_grad 100%)!important;
			background-color: $darken_overlay_color!important;
	    }
		";
	}

    if($animated == 1 && ($animated_overlay_color !== '')) {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block.animated:hover .mgt-promo-block-content {
		        background-color: $animated_overlay_color!important;
		    }
		";
    }

    if($format_h1_fontsize !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content h1 {
		        font-size: $format_h1_fontsize;
		        line-height: normal!important;
		    }
		";
    }
    if($format_h1_margin !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content h1 {
		        margin: $format_h1_margin!important;
		    }
		";
    }
    if($format_h1_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content h1 {
		        color: $format_h1_color!important;
		    }
		";
    }

    if($format_h2_fontsize !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content h2 {
		        font-size: $format_h2_fontsize;
		        line-height: normal!important;
		    }
		";
    }
    if($format_h2_margin !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content h2 {
		        margin: $format_h2_margin!important;
		    }
		";
    }

    if($format_h2_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content h2 {
		        color: $format_h2_color!important;
		    }
		";
    }

    if($format_h3_fontsize !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content h3 {
		        font-size: $format_h3_fontsize;
		        line-height: normal!important;
		    }
		";
    }

    if($format_h3_margin !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content h3 {
		        margin: $format_h3_margin!important;
		    }
		";
    }

    if($format_h3_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content h3 {
		        color: $format_h3_color!important;
		    }
		";
    }

    if($format_p_fontsize !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content p {
		        font-size: $format_p_fontsize;
		        line-height: normal!important;
		    }
		";
    }

	if($format_p_margin !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content p {
		        margin: $format_p_margin!important;
		    }
		";
    }

    if($format_p_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content p {
		        color: $format_p_color!important;
		    }
		";
    }
    if($format_a_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-promo-block .mgt-promo-block-content a {
		        color: $format_a_color!important;
		    }
		";
    }

	if($mgt_custom_css !== '') {
		$mgt_custom_css = str_replace(array("\r", "\n", "  ", "	"), '', $mgt_custom_css);
		echo "<style scoped='scoped'>$mgt_custom_css</style>"; // This variable contains user Custom CSS code and can't be escaped with WordPress functions.

		//enside_add_shortcodes_custom_css($mgt_custom_css);
	}

	$add_class .= ' '.$unique_class_name;

	// Custom CSS from VC
	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );

	// Block show content on hover
	if($block_content_onhover) {
		$css_class .= ' mgt-promo-block-content-inside-show-on-hover';
	}

	// Button
	$button_data = vc_build_link($button_url);

	$button_html = '';
	$button_show_onhover_class = '';

	if($button_data['url'] !== '') {

		if($button_show_onhover == 1) {
			$button_show_onhover_class = ' mgt-hide-button';
		}

		$button_html .= do_shortcode('[mgt_button_wp button_link="'.$button_url.'" button_link_lightbox="'.$button_link_lightbox.'" button_style="'.$button_style.'" hover_effect="'.$hover_effect.'" button_round_edges="'.$button_round_edges.'" button_icon="'.$button_icon.'" button_icon_position="'.$button_icon_position.'" button_icon_separator="'.$button_icon_separator.'" icon_type="'.$icon_type.'" icon_fontawesome="'.$icon_fontawesome.'" icon_openiconic="'.$icon_openiconic.'" icon_typicons="'.$icon_typicons.'" icon_entypo="'.$icon_entypo.'" icon_linecons="'.$icon_linecons.'" icon_monosocial="'.$icon_monosocial.'" icon_material="'.$icon_material.'" icon_pe7stroke="'.$icon_pe7stroke.'" button_size="'.$button_size.'" text_size="'.$button_text_size.'" text_transform="'.$button_text_transform.'" button_align="'.$button_align.'" button_display="newline" button_top_margin="'.$button_top_margin.'" button_override="'.$button_override.'" fontweight="'.$fontweight.'" button_color_bg="'.$button_color_bg.'" button_bg_grad="'.$button_bg_grad.'" button_color_bggrad="'.$button_color_bggrad.'" button_color_bghover="'.$button_color_bghover.'" button_bghover_grad="'.$button_bghover_grad.'" button_color_bghovergrad="'.$button_color_bghovergrad.'" button_color_text="'.$button_color_text.'" button_color_texthover="'.$button_color_texthover.'" button_border="'.$button_border.'" button_border_width="'.$button_border_width.'" button_color_border="'.$button_color_border.'" button_color_borderhover="'.$button_color_borderhover.'"]');

	}

	$add_class_content .= $button_show_onhover_class;

	// Vertical align for content
	if($content_va !=='') {
		$add_class_content .= ' va-'.$content_va;
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

	// Block shadow effect
	if($block_shadow_effect) {
		$wrapper_add_class .= ' mgt-promo-block-shadow';
	}

	// Block hover effect
	if($block_hover_effect) {
		$wrapper_add_class .= ' mgt-promo-block-hover';
	}

	$wrapper_add_class .= ' mgt-promo-block-wrapper-round-edges-'.$block_round_edges;

	// Video bg & Parallax
	$parallax_attributes = array();
	$parallax_classes = array();

	$has_video_bg = ( ( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

	if ( $has_video_bg ) {

		$parallax_image = $video_bg_url;
		$parallax_classes[] = 'vc_video-bg-container';
		wp_enqueue_script( 'vc_youtube_iframe_api_js' );

		$parallax_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image ) . '"';
		$parallax_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
	}

	if ( ! empty( $parallax ) && $parallax_image !== '' && !$has_video_bg) {

	    wp_enqueue_script( 'vc_jquery_skrollr_js' );
	    $parallax_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"';
	    $parallax_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image ) . '"';
	    $parallax_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	    if ( false !== strpos( $parallax, 'fade' ) ) {
	        $parallax_classes[] = 'js-vc_parallax-o-fade';
	        $parallax_attributes[] = 'data-vc-parallax-o-fade="on"';
	    } elseif ( false !== strpos( $parallax, 'fixed' ) ) {
	        $parallax_classes[] = 'js-vc_parallax-o-fixed';
	    }
	}

	// Show promo block
	echo '<div class="mgt-promo-block-container wpb_content_element'.esc_attr($animation_css_class).'">'; // container start
	echo '<div class="mgt-promo-block-wrapper '.esc_attr($wrapper_add_class).'">'.$top_image_html; // wrapper start
	echo '<div '.implode(" ", $parallax_attributes).' class="'.implode(" ", $parallax_classes).' mgt-promo-block'.esc_attr($add_class).'" data-style="'.esc_attr($style).'">';

	// Block link
	if($block_url !== '') {
		if($block_url_target_blank) {
			echo '<a class="mgt-promo-block-link" target="_blank" href="'.esc_url($block_url).'">';
		} else {
			echo '<a class="mgt-promo-block-link" href="'.esc_url($block_url).'">';
		}
	}

	echo '<div class="mgt-promo-block-content'.esc_attr($add_class_content).'">';
	echo '<div class="mgt-promo-block-content-inside'.esc_attr( $css_class ).'">'.do_shortcode($sc_content).''.$button_html.'</div>';

	echo '</div>';

	// Block link end
	if($block_url !== '') {
		echo '</a>';
	}

	echo '</div>';
	echo '</div>'; // wrapper end
	echo '</div>'; // container end

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_promo_block_wp", "mgt_shortcode_promo_block_wp");
