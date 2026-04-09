<?php

// Shortcode [mgt_calltoaction_block_wp]
function mgt_shortcode_calltoaction_block_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		'background_image_id' => '',
		'background_repeat' => 'no-repeat',
		'parallax' => 0,
		'parallax_speed' => 1.5,
		'video_bg' => false,
		'video_bg_url' => 'https://www.youtube.com/watch?v=lMJXxhRFO1k',
		'background_color' => '#EEEEEE',
		/* Text */
		'text_color' => 'black',
		'title' => 'Header',
		'text_size' => 'normal',
		'side_paddings' => 1,
		'css_animation' => 'none',
		/* Button */
		'button_url' => '',
		'button_link_lightbox' => false,
		'button_style' => 'solid',
		'hover_effect' => 'default',
		'button_round_edges' => 'disable',
		'button_size' => 'normal',
		'button_text_size' => 'normal',
		'button_text_transform' => 'none',
		/* Button icon */
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
	), $atts));

	ob_start();

	$style = '';
	$parallax_image = '';

	$background_image_data = wp_get_attachment_image_src( $background_image_id, 'full' );

	if($background_image_data[0] == '') {
		$style = 'background-color: '.$background_color.';';

	} else {
		$style = 'background: '.$background_color.' url('.$background_image_data[0].') '.$background_repeat.';';
		$parallax_image = $background_image_data[0];
	}

	$add_class = '';

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

	// End Custom CSS styles

	if($text_color == 'white') {
		$add_class .= ' white-text';
	} else {
		$add_class .= ' black-text';
	}

	// Button
	$button_data = vc_build_link($button_url);

	$button_html = '';

	if($button_data['url'] !== '') {

		$button_html .= do_shortcode('[mgt_button_wp button_link="'.$button_url.'" button_link_lightbox="'.$button_link_lightbox.'" button_style="'.$button_style.'" hover_effect="'.$hover_effect.'" button_round_edges="'.$button_round_edges.'" button_icon="'.$button_icon.'" button_icon_position="'.$button_icon_position.'" button_icon_separator="'.$button_icon_separator.'" icon_type="'.$icon_type.'" icon_fontawesome="'.$icon_fontawesome.'" icon_openiconic="'.$icon_openiconic.'" icon_typicons="'.$icon_typicons.'" icon_entypo="'.$icon_entypo.'" icon_linecons="'.$icon_linecons.'" icon_monosocial="'.$icon_monosocial.'" icon_material="'.$icon_material.'" icon_pe7stroke="'.$icon_pe7stroke.'" button_size="'.$button_size.'" text_size="'.$button_text_size.'" text_transform="'.$button_text_transform.'" button_align="right" button_display="newline"  button_override="'.$button_override.'" fontweight="'.$fontweight.'" button_color_bg="'.$button_color_bg.'" button_bg_grad="'.$button_bg_grad.'" button_color_bggrad="'.$button_color_bggrad.'" button_color_bghover="'.$button_color_bghover.'" button_bghover_grad="'.$button_bghover_grad.'" button_color_bghovergrad="'.$button_color_bghovergrad.'" button_color_text="'.$button_color_text.'" button_color_texthover="'.$button_color_texthover.'" button_border="'.$button_border.'" button_border_width="'.$button_border_width.'" button_color_border="'.$button_color_border.'" button_color_borderhover="'.$button_color_borderhover.'"]');

	}

	if($sc_content !== '') {
		$content = '<div class="mgt-cta-block-content">'.$sc_content.'</div>';

		$add_class .= ' with-text';
	} else {
		$content = '';

		$add_class .= ' without-text';
	}

	if($side_paddings == 0) {
		$add_class .= ' no-side-paddings';
	}

	// Parallax
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

	echo '<div '.implode(" ", $parallax_attributes).' class="'.implode(" ", $parallax_classes).' mgt-cta-block clearfix'.esc_attr($add_class).' wpb_content_element'.esc_attr($animation_css_class).'" data-style="'.esc_attr($style).'"><div class="mgt-cta-content-wrapper"><h5 class="mgt-cta-block-header">'.esc_html($title).'</h5>'.wp_kses_post($content).'</div>'.$button_html.'</div>';

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_calltoaction_block_wp", "mgt_shortcode_calltoaction_block_wp");
