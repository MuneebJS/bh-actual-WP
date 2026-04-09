<?php

// Shortcode [mgt_message_box_wp]
function mgt_shortcode_message_box_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		'message_text' => 'Message box test',
		'message_type' => 'mgt-message-box-message',
		'css_animation' => 'none'
	), $atts));

	ob_start();

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

	echo '<div class="mgt-message-box wpb_content_element'.esc_attr($animation_css_class).' '.esc_attr($message_type).'">'.wp_kses_post($message_text).'</div>';

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_message_box_wp", "mgt_shortcode_message_box_wp");
