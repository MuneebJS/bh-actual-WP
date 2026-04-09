<?php

// Shortcode [mgt_flipbox_wp]
function mgt_shortcode_flipbox_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		/* Front side */
		'header_text_front' => '',
		'description_text_front' => '',
		'header_color_front' => '',
		'description_color_front' => '',
		'background_color_front' => '',
		'background_image_front' => '',
		'block_border_front' => false,
		'block_border_front_width' => '',
		'block_border_front_style' => 'solid',
		'block_border_front_color' => '',
		'front_icon' => false,
		'front_icon_color' => '',
		'front_icon_type' => 'fontawesome',
		'front_icon_fontawesome' => 'fa fa-adjust',
		'front_icon_pe7stroke' => 'pe-7s-album',
		'front_icon_openiconic' => 'vc-oi vc-oi-dial',
		'front_icon_typicons' => 'typcn typcn-adjust-brightness',
		'front_icon_entypo' => 'entypo-icon entypo-icon-note',
		'front_icon_linecons' => 'vc_li vc_li-heart',
		'front_icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
		'front_icon_material' => 'vc-material vc-material-cake',
		/* Back side */
		'header_text_back' => '',
		'description_text_back' => '',
		'header_color_back' => '',
		'description_color_back' => '',
		'background_color_back' => '',
		'background_image_back' => '',
		'block_border_back' => false,
		'block_border_back_width' => '',
		'block_border_back_style' => 'solid',
		'block_border_back_color' => '',
		/* Styles and effects */
		'flipbox_animation' => 'horizontal',
		'block_height' => '',
		'flipbox_round_edges' => 'disable',
		'css_animation' => 'none',
		/* Button - back side */
		'button_url' => '',
		'button_link_lightbox' => false,
		'button_style' => 'solid',
		'button_round_edges' => 'disable',
		'button_size' => 'normal',
		'button_align' => 'center',
		'button_text_size' => 'normal',
		'button_text_transform' => 'none',
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
		/* Format */
		'format_header_fontsize' => '',
		'format_header_padding' => '',
		'format_description_fontsize' => '',
		'format_description_padding' => '',
		'format_icon_fontsize' => '',
		'format_content_padding' => '',
		/* CSS */
		'css' => '',
	), $atts));

	ob_start();

	$mgt_custom_css = '';
	$add_class = '';

	$style_front = '';
	$style_back = '';

	$add_class .= ' mgt-flipbox-animation-'.$flipbox_animation;
	$add_class .= ' mgt-flipbox-round-edges-'.$flipbox_round_edges;

	// Background image for front side
	$background_image_front_data = wp_get_attachment_image_src( $background_image_front, 'enside-blog-thumb' );

	if(trim($background_image_front_data[0]) !== '') {
		$style_front .= 'background-image: url('.$background_image_front_data[0].');';
	}

	// Background image for back side
	$background_image_back_data = wp_get_attachment_image_src( $background_image_back, 'enside-blog-thumb' );

	if(trim($background_image_back_data[0]) !== '') {
		$style_back .= 'background-image: url('.$background_image_back_data[0].');';
	}

	// Preparing content
	if($header_text_front !== '') {
		$header_text_front = '<h4 class="mgt-flipbox-header">'.$header_text_front.'</h4>';
	}

	if($header_text_back !== '') {
		$header_text_back = '<h4 class="mgt-flipbox-header">'.$header_text_back.'</h4>';
	}

	if($description_text_front !== '') {
		$description_text_front = '<div class="mgt-flipbox-description">'.$description_text_front.'</div>';
	}

	if($description_text_back !== '') {
		$description_text_back = '<div class="mgt-flipbox-description">'.$description_text_back.'</div>';
	}

	// Button
	$button_data = vc_build_link($button_url);

	$button_html = '';

	if($button_data['url'] !== '') {

		$button_html = '<div class="mgt-flipbox-button">'.do_shortcode('[mgt_button_wp button_link="'.$button_url.'" button_link_lightbox="'.$button_link_lightbox.'" button_style="'.$button_style.'" hover_effect="'.$hover_effect.'" button_round_edges="'.$button_round_edges.'" button_icon="'.$button_icon.'" button_icon_position="'.$button_icon_position.'" button_icon_separator="'.$button_icon_separator.'" icon_type="'.$icon_type.'" icon_fontawesome="'.$icon_fontawesome.'" icon_openiconic="'.$icon_openiconic.'" icon_typicons="'.$icon_typicons.'" icon_entypo="'.$icon_entypo.'" icon_linecons="'.$icon_linecons.'" icon_monosocial="'.$icon_monosocial.'" icon_material="'.$icon_material.'" icon_pe7stroke="'.$icon_pe7stroke.'" button_size="'.$button_size.'" text_size="'.$button_text_size.'" text_transform="'.$button_text_transform.'" button_align="center" button_display="newline"  button_override="'.$button_override.'" fontweight="'.$fontweight.'" button_color_bg="'.$button_color_bg.'" button_bg_grad="'.$button_bg_grad.'" button_color_bggrad="'.$button_color_bggrad.'" button_color_bghover="'.$button_color_bghover.'" button_bghover_grad="'.$button_bghover_grad.'" button_color_bghovergrad="'.$button_color_bghovergrad.'" button_color_text="'.$button_color_text.'" button_color_texthover="'.$button_color_texthover.'" button_border="'.$button_border.'" button_border_width="'.$button_border_width.'" button_color_border="'.$button_color_border.'" button_color_borderhover="'.$button_color_borderhover.'"]'.'</div>');

	}

	// Custom CSS
	$unique_block_id = rand(1000000,90000000);

	$unique_class_name = 'mgt-flipbox-'.$unique_block_id;

	// FORMAT
	// Content
	if($format_content_padding !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-front-inner,
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-back-inner {
		        padding: $format_content_padding!important;
		    }
		";
    }

	// Header
    if($format_header_fontsize !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox h4.mgt-flipbox-header {
		        font-size: $format_header_fontsize!important;
		        line-height: normal!important;
		    }
		";
    }
    if($format_header_padding !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox h4.mgt-flipbox-header {
		        padding: $format_header_padding!important;
		    }
		";
    }

    // Description
    if($format_description_fontsize !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-description {
		        font-size: $format_description_fontsize!important;
		    }
		";
    }

    if($format_description_padding !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-description {
		        padding: $format_description_padding!important;
		    }
		";
    }

    // Front
    if($header_color_front !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-front h4.mgt-flipbox-header {
		        color: $header_color_front!important;
		    }
		";
    }

    if($description_color_front !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-front .mgt-flipbox-description {
		        color: $description_color_front!important;
		    }
		";
    }

    if($background_color_front !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-front-inner {
		        background-color: $background_color_front!important;
		    }
		";
    }

    if($block_border_front) {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-front {
		        border: ".$block_border_front_width."px $block_border_front_style $block_border_front_color!important;
		    }
		";
    }

    // Back
    if($header_color_back !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-back h4.mgt-flipbox-header {
		        color: $header_color_back!important;
		    }
		";
    }

    if($background_color_back !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-back-inner {
		        background-color: $background_color_back!important;
		    }
		";
    }

    if($description_color_back !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-back .mgt-flipbox-description {
		        color: $description_color_back!important;
		    }
		";
    }

    if($block_border_back) {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-back {
		        border: ".$block_border_back_width."px $block_border_back_style $block_border_back_color!important;
		    }
		";
    }

    // Icon
    if($front_icon_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-front .mgt-flipbox-icon i {
		        color: $front_icon_color!important;
		    }
		";
    }

    if($format_icon_fontsize !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox .mgt-flipbox-front .mgt-flipbox-icon i {
		        font-size: $format_icon_fontsize!important;
		    }
		";
    }

    // Block height
    if($block_height !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-flipbox {
		        height: $block_height!important;
		    }
		";
    }

	if($mgt_custom_css !== '') {
		$mgt_custom_css = str_replace(array("\r", "\n", "  ", "	"), '', $mgt_custom_css);
		echo "<style scoped='scoped'>$mgt_custom_css</style>"; // This variable contains user Custom CSS code and can't be escaped with WordPress functions.
	}

	$add_class .= ' '.$unique_class_name;

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );

	// Subheader icon
	if($front_icon == true) {

		// Load VC icons libraries
		vc_iconpicker_editor_jscss();

		switch($front_icon_type) {
			case 'fontawesome':
		        $front_icon_html = '<i class="'.$front_icon_fontawesome.'"></i>';
		    break;
		    case 'openiconic':
		        $front_icon_html = '<i class="'.$front_icon_openiconic.'"></i>';
		    break;
		    case 'typicons':
		        $front_icon_html = '<i class="'.$front_icon_typicons.'"></i>';
		    break;
		    case 'entypo':
		        $front_icon_html = '<i class="'.$front_icon_entypo.'"></i>';
		    break;
		    case 'linecons':
		        $front_icon_html = '<i class="'.$front_icon_linecons.'"></i>';
		    break;
		    case 'monosocial':
		        $front_icon_html = '<i class="'.$front_icon_monosocial.'"></i>';
		    break;
		    case 'material':
		        $front_icon_html = '<i class="'.$front_icon_material.'"></i>';
		    break;
		   case 'pe7stroke':
		        $front_icon_html = '<i class="'.$front_icon_pe7stroke.'"></i>';
		    break;
		}

		$front_icon_html = '<div class="mgt-flipbox-icon">'.$front_icon_html.'</div>';

	} else {
		$front_icon_html = '';
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

	// Show flipbox
	echo '<div class="mgt-flipbox'.esc_attr($add_class).' wpb_content_element'.esc_attr( $css_class ).esc_attr($animation_css_class).'">
	          <div class="mgt-flipbox-front" data-style="'.esc_attr($style_front).'">
	            <div class="mgt-flipbox-front-inner">
		            <div class="mgt-flipbox-content-wrapper">
		              '.wp_kses_post($front_icon_html).'
		              '.wp_kses_post($header_text_front).'
		              '.wp_kses_post($description_text_front).'
		            </div>
	            </div>
	          </div>
	          <div class="mgt-flipbox-back" data-style="'.esc_attr($style_back).'">
	            <div class="mgt-flipbox-back-inner">
	            	<div class="mgt-flipbox-content-wrapper">
	              '.wp_kses_post($header_text_back).'
	              '.wp_kses_post($description_text_back).'
	              '.$button_html.'
	                </div>
	            </div>
	          </div>
          </div>';

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_flipbox_wp", "mgt_shortcode_flipbox_wp");
