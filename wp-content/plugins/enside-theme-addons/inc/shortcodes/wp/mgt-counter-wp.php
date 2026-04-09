<?php
// Shortcode [mgt_counter_wp]
function mgt_shortcode_counter_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		'counter_value_from' => '0',
		'counter_value_to' => '100',
		'counter_title' => '',
		'speed' => '2000',
		'decimals' => '0',
		'align' => 'left',
		'fontweight' => 'normal',
		'size' => 'small',
		'color' => 'black',
		'counter_icon' => false,
		'counter_icon_type' => 'fontawesome',
		'counter_icon_fontawesome' => 'fa fa-adjust',
		'counter_icon_pe7stroke' => 'pe-7s-album',
		'counter_icon_openiconic' => 'vc-oi vc-oi-dial',
		'counter_icon_typicons' => 'typcn typcn-adjust-brightness',
		'counter_icon_entypo' => 'entypo-icon entypo-icon-note',
		'counter_icon_linecons' => 'vc_li vc_li-heart',
		'counter_icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
		'counter_icon_material' => 'vc-material vc-material-cake',
		'icon_position' => 'top',
		'icon_color' => '',
		'css_animation' => 'none'
	), $atts));

	wp_register_script('appear', get_template_directory_uri() . '/js/jquery.appear.js');
	wp_enqueue_script('appear');

	wp_register_script('countto', get_template_directory_uri() . '/js/jquery.countTo.js');
	wp_enqueue_script('countto');

	ob_start();

	// Default font-weight
	if($fontweight == 'normal') {
		$fontweight = 'default';
	}

	if($icon_color !== '') {
		$add_icon_style = ' style="color: '.esc_attr($icon_color).'"';
	}

	// Counter icon
	if($counter_icon == true) {

		// Load VC icons libraries
		vc_iconpicker_editor_jscss();

		switch($counter_icon_type) {
			case 'fontawesome':
		        $counter_icon_html = '<i class="'.$counter_icon_fontawesome.'"></i>';
		    break;
		    case 'openiconic':
		        $counter_icon_html = '<i class="'.$counter_icon_openiconic.'"></i>';
		    break;
		    case 'typicons':
		        $counter_icon_html = '<i class="'.$counter_icon_typicons.'"></i>';
		    break;
		    case 'entypo':
		        $counter_icon_html = '<i class="'.$counter_icon_entypo.'"></i>';
		    break;
		    case 'linecons':
		        $counter_icon_html = '<i class="'.$counter_icon_linecons.'"></i>';
		    break;
		    case 'monosocial':
		        $counter_icon_html = '<i class="'.$counter_icon_monosocial.'"></i>';
		    break;
		    case 'material':
		        $counter_icon_html = '<i class="'.$counter_icon_material.'"></i>';
		    break;
		   case 'pe7stroke':
		        $counter_icon_html = '<i class="'.$counter_icon_pe7stroke.'"></i>';
		    break;
		}

		$icon_html = '<div class="mgt-counter-icon" '.$add_icon_style.'>'.$counter_icon_html.'</div>';

	} else {
		$icon_html = '';
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

	echo '<div class="mgt-counter-wrapper mgt-counter-icon-position-'.esc_attr($icon_position).' wpb_content_element text-'.esc_attr($color).' text-font-weight-'.esc_attr($fontweight).' text-'.esc_attr($size).' text-'.esc_attr($align).esc_attr($animation_css_class).'">';
	echo wp_kses_post($icon_html);
	echo '<span class="mgt-counter-value" data-from="'.esc_attr($counter_value_from).'" data-to="'.esc_attr($counter_value_to).'" data-speed="'.esc_attr($speed).'" data-decimals="'.esc_attr($decimals).'">'.esc_html($counter_value_to).'</span>';
	if(trim($counter_title) !== '') {
		echo '<h5 class="mgt-counter-title">'.esc_html($counter_title).'</h5>';
	}
	echo '</div>';

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_counter_wp", "mgt_shortcode_counter_wp");
