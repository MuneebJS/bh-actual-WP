<?php

// Shortcode [mgt_pricing_table_wp]
function mgt_shortcode_pricing_table_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		/* Content */
		'header_text' => 'Service name',
		'subheader_text' => '<sup>$</sup>99<sub>per month</sub>',
		'subheader_icon' => false,
		'subheader_icon_type' => 'fontawesome',
		'subheader_icon_fontawesome' => 'fa fa-adjust',
		'subheader_icon_pe7stroke' => 'pe-7s-album',
		'subheader_icon_openiconic' => 'vc-oi vc-oi-dial',
		'subheader_icon_typicons' => 'typcn typcn-adjust-brightness',
		'subheader_icon_entypo' => 'entypo-icon entypo-icon-note',
		'subheader_icon_linecons' => 'vc_li vc_li-heart',
		'subheader_icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
		'subheader_icon_material' => 'vc-material vc-material-cake',
		/* Styles */
		'layout_style' => 'style-default',
		'hover_animation' => 'animation-none',
		'featured_table' => 0,
		'bordered' => 1,
		'enlarge' => 0,
		'shadow' => 0,
		'css_animation' => 'none',
		/* Button */
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
		'format_subheader_fontsize' => '',
		'format_subheader_padding' => '',
		'format_item_fontsize' => '',
		'format_item_padding' => '',
		/* Colors */
		'header_color' => '',
		'header_bg_color' => '',
		'header_bg_image' => '',
		'subheader_color' => '',
		'subheader_bg_color' => '',
		'list_text_color' => '',
		'list_bg_color_1' => '',
		'list_bg_color_2' => '',
		'a_color' => '',
		'border_color' => '',
		'icon_color' => '',
		/* CSS */
		'css' => '',
	), $atts));

	ob_start();

	$mgt_custom_css = '';
	$add_class = '';

	// Background image for header
	$background_image_data = wp_get_attachment_image_src( $header_bg_image, 'enside-blog-thumb' );

	$no_image_class = '';
	$style = '';

	if(trim($background_image_data[0]) !== '') {
		$style .= 'background-image: url('.$background_image_data[0].');';
	}

	// Styles and effects
	if($featured_table == 1) {
		$add_class .= ' featured';
	}
	if($bordered == 1) {
		$add_class .= ' bordered';
	}

	$add_class .= ' '.$hover_animation;

	$add_class .= ' '.$layout_style;

	if($enlarge == 1) {
		$add_class .= ' enlarge';
	}

	if($shadow == 1) {
		$add_class .= ' shadow';
	}

	// Button
	$button_data = vc_build_link($button_url);

	$button_html = '';

	$button_show_onhover_class = '';

	if($button_data['url'] !== '') {

		$button_html = '<div class="mgt-pricing-table-button">'.do_shortcode('[mgt_button_wp button_link="'.$button_url.'" button_link_lightbox="'.$button_link_lightbox.'" button_style="'.$button_style.'" hover_effect="'.$hover_effect.'" button_round_edges="'.$button_round_edges.'" button_icon="'.$button_icon.'" button_icon_position="'.$button_icon_position.'" button_icon_separator="'.$button_icon_separator.'" icon_type="'.$icon_type.'" icon_fontawesome="'.$icon_fontawesome.'" icon_openiconic="'.$icon_openiconic.'" icon_typicons="'.$icon_typicons.'" icon_entypo="'.$icon_entypo.'" icon_linecons="'.$icon_linecons.'" icon_monosocial="'.$icon_monosocial.'" icon_material="'.$icon_material.'" icon_pe7stroke="'.$icon_pe7stroke.'" button_size="'.$button_size.'" text_size="'.$button_text_size.'" text_transform="'.$button_text_transform.'" button_align="center" button_display="newline"  button_override="'.$button_override.'" fontweight="'.$fontweight.'" button_color_bg="'.$button_color_bg.'" button_bg_grad="'.$button_bg_grad.'" button_color_bggrad="'.$button_color_bggrad.'" button_color_bghover="'.$button_color_bghover.'" button_bghover_grad="'.$button_bghover_grad.'" button_color_bghovergrad="'.$button_color_bghovergrad.'" button_color_text="'.$button_color_text.'" button_color_texthover="'.$button_color_texthover.'" button_border="'.$button_border.'" button_border_width="'.$button_border_width.'" button_color_border="'.$button_color_border.'" button_color_borderhover="'.$button_color_borderhover.'"]'.'</div>');

	}

	// Custom CSS
	$unique_block_id = rand(1000000,90000000);

	$unique_class_name = 'mgt-pricing-table-'.$unique_block_id;

	// Header
    if($format_header_fontsize !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table h4.mgt-pricing-table-header {
		        font-size: $format_header_fontsize!important;
		        line-height: normal!important;
		    }
		";
    }
    if($format_header_padding !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table h4.mgt-pricing-table-header {
		        padding: $format_header_padding!important;
		    }
		";
    }

    if($header_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table h4.mgt-pricing-table-header {
		        color: $header_color!important;
		    }
		";
    }

    if($header_bg_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table h4.mgt-pricing-table-header {
		        background-color: $header_bg_color!important;
		    }
		";
    }

    // Subheader:
    if($format_subheader_fontsize !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table .mgt-pricing-table-subheader {
		        font-size: $format_subheader_fontsize!important;
		        line-height: normal!important;
		    }
		";
    }
    if($format_subheader_padding !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table .mgt-pricing-table-subheader {
		        padding: $format_subheader_padding!important;
		    }
		";
    }

    if($subheader_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table .mgt-pricing-table-subheader {
		        color: $subheader_color!important;
		    }
		";
    }

    if($subheader_bg_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table .mgt-pricing-table-subheader,
		    .$unique_class_name.mgt-pricing-table .mgt-pricing-table-button {
		        background-color: $subheader_bg_color!important;
		    }
		";
    }
    // List:
    if($format_item_fontsize !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table ul li {
		        font-size: $format_item_fontsize!important;
		        line-height: normal!important;
		    }
		";
    }
    if($format_item_padding !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table ul li {
		        padding: $format_item_padding!important;
		    }
		";
    }

    if($list_text_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table ul li {
		        color: $list_text_color!important;
		    }
		";
    }

    if($list_bg_color_1 !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table ul li {
		        background-color: $list_bg_color_1!important;
		    }
		";
    }

    if($list_bg_color_2 !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table ul li:nth-child(even) {
		        background-color: $list_bg_color_2!important;
		    }
		";
    }
    // Link:
    if($a_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table a {
		        color: $a_color!important;
		    }
		";
    }

    // Link:
    if($icon_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table .mgt-pricing-table-icon i {
		        color: $icon_color!important;
		    }
		";
    }

    // Border color:
    if($border_color !== '') {
    	$mgt_custom_css .= "
		    .$unique_class_name.mgt-pricing-table.bordered,
			.$unique_class_name.mgt-pricing-table.bordered h4.mgt-pricing-table-header,
			.$unique_class_name.mgt-pricing-table.bordered .mgt-pricing-table-subheader,
			.$unique_class_name.mgt-pricing-table.bordered ul li,
			.$unique_class_name.mgt-pricing-table.bordered .mgt-pricing-table-button {
		        border-color: $border_color!important;
		    }
		";
    }

	if($mgt_custom_css !== '') {
		$mgt_custom_css = str_replace(array("\r", "\n", "  ", "	"), '', $mgt_custom_css);
		echo "<style scoped='scoped'>$mgt_custom_css</style>"; // This variable contains user Custom CSS code and can't be escaped with WordPress functions.
	}

	$add_class .= ' '.$unique_class_name;

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );

	// Table HTML
	$header_text_html = '<h4 class="mgt-pricing-table-header" data-style="'.esc_attr($style).'">'.wp_kses_post($header_text).'</h4>';

	// Subheader icon
	if($subheader_icon == true) {

		// Load VC icons libraries
		vc_iconpicker_editor_jscss();

		switch($subheader_icon_type) {
			case 'fontawesome':
		        $subheader_icon_html = '<i class="'.$subheader_icon_fontawesome.'"></i>';
		    break;
		    case 'openiconic':
		        $subheader_icon_html = '<i class="'.$subheader_icon_openiconic.'"></i>';
		    break;
		    case 'typicons':
		        $subheader_icon_html = '<i class="'.$subheader_icon_typicons.'"></i>';
		    break;
		    case 'entypo':
		        $subheader_icon_html = '<i class="'.$subheader_icon_entypo.'"></i>';
		    break;
		    case 'linecons':
		        $subheader_icon_html = '<i class="'.$subheader_icon_linecons.'"></i>';
		    break;
		    case 'monosocial':
		        $subheader_icon_html = '<i class="'.$subheader_icon_monosocial.'"></i>';
		    break;
		    case 'material':
		        $subheader_icon_html = '<i class="'.$subheader_icon_material.'"></i>';
		    break;
		   case 'pe7stroke':
		        $subheader_icon_html = '<i class="'.$subheader_icon_pe7stroke.'"></i>';
		    break;
		}

		$subheader_icon_html = '<div class="mgt-pricing-table-icon">'.$subheader_icon_html.'</div>';

	} else {
		$subheader_icon_html = '';
	}

	if($subheader_text !== '') {
		$subheader_text_html =  '<div class="mgt-pricing-table-subheader">'.$subheader_icon_html.wp_kses_post($subheader_text).'</div>';
	} else {
		$subheader_text_html = '';
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

	// Show table
	echo '<div class="mgt-pricing-table-wrapper wpb_content_element '.esc_attr($animation_css_class).'">';
	echo '<div class="mgt-pricing-table'.esc_attr($add_class).' '.esc_attr( $css_class ).'">'.$header_text_html.$subheader_text_html.'<div class="mgt-pricing-table-list">'.wp_kses_post($sc_content).$button_html.'</div></div>';
	echo '</div>';

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_pricing_table_wp", "mgt_shortcode_pricing_table_wp");
