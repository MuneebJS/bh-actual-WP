<?php

// Shortcode [mgt_signup_block_wp]
function mgt_shortcode_signup_block_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		'background_color' => '',
		'text' => 'Newsletter Sign Up',
		'text_color' => '',
		'button_text' => 'Sign Up',
		'form_url' => '',
		'css_animation' => 'none'
	), $atts));

	ob_start();

	if($background_color !== '') {
		$style = 'background-color: '.$background_color.';';
	} else {
		$style = '';
	}

	$add_class = '';

	if($text_color == 'white') {
		$add_class .= ' white-text';
	} else {
		$add_class .= ' black-text';
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

	echo '<div class="mgt-signup-block clearfix'.esc_attr($add_class).' wpb_content_element'.esc_attr($animation_css_class).'" data-style="'.esc_attr($style).'"><div class="mgt-signup-block-header"><h5>'.esc_html($text).'</h5></div><div class="mgt-signup-block-form"><form target="_blank" method="post" action="'.esc_url($form_url).'"><input type="email" value="" name="EMAIL" class="required email" placeholder="'.esc_html__("Input your email", "enside").'" id="mce-EMAIL"><input type="submit" value="'.esc_attr($button_text).'" name="subscribe" id="mc-embedded-subscribe" class="button mgt-button"></form></div></div>';

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_signup_block_wp", "mgt_shortcode_signup_block_wp");
