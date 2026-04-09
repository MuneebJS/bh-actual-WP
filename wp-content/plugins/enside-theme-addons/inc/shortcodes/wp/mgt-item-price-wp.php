<?php
// Shortcode [mgt_item_price_wp]
function mgt_shortcode_item_price_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		'item_title' => '',
		'item_price' => '',
		'item_image_id' => '',
		'item_badge_title' => '',
		'item_badge_color' => 'theme',
		'css_animation' => 'none'
	), $atts));

	ob_start();

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

	// Item badge
	if(trim($item_badge_title) !== '') {
		$item_badge_html = '<sup>'.esc_attr($item_badge_title).'</sup>';
	} else {
		$item_badge_html = '';
	}

	// Item image
	$item_image_size = 'enside-portfolio-thumb-square';

	$item_image_data = wp_get_attachment_image_src( $item_image_id, $item_image_size );

	if(trim($item_image_data[0]) !== '') {
		$item_image_html = '<div class="mgt-item-price-image"><img src="'.esc_url($item_image_data[0]).'" alt="'.esc_attr($item_title).'"></div>';
		$add_class = ' mgt-item-price-with-image';
	} else {
		$item_image_html = '';
	}

	echo '<div class="mgt-item-price mgt-item-price-badge-color-'.esc_attr($item_badge_color).' clearfix wpb_content_element'.esc_attr($animation_css_class).$add_class.'">

		'.wp_kses_post($item_image_html).'
		<div class="mgt-item-price-details">
		<div class="mgt-item-price-line"></div>
			<div class="mgt-item-price-title-holder"><h4>'.esc_attr($item_title).wp_kses_post($item_badge_html).'</h4></div>
			<div class="mgt-item-price-value">'.esc_attr($item_price).'</div>
			<p class="mgt-item-price-description">'.wp_kses_post($sc_content).'</p>
		</div>
	</div>';

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_item_price_wp", "mgt_shortcode_item_price_wp");
