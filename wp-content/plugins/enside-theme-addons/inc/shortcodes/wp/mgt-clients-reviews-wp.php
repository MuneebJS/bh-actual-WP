<?php

// Shortcode [mgt_clients_reviews_wp]
function mgt_shortcode_clients_reviews_wp($atts, $content = null) {
	extract(shortcode_atts(array(
		'reviews_style' => 'box',
        'shadow_effect' => false,
        'border_effect' => false,
        'text_color' => 'text-dark',
        'text_align' => 'text-left',
		'use_slider' => 0,
		'slider_autoplay' => 0,
		'items_per_row' => 1,
		'slider_navigation' => 0,
		'slider_pagination' => 1,
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => 10,
        'css_animation' => 'none',
	), $atts));
	ob_start();

	$args = array(
		'posts_per_page'   => $posts_per_page,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => $orderby,
		'order'            => $order,
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'mgt_clients_reviews',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => false // WPML fix
	);

	$posts = get_posts( $args );

	if(count($posts) == 1) {
		$single_post = ' mgt-single-review';
	} else {
		$single_post = '';
	}

	$rand_id = rand(1000000,90000000);

  	$style = '';

  	// Slider
	if($use_slider == 1) {

		$style = ' style="display: none;"';

		if($slider_autoplay == 1) {
			$slider_autoplay = 'true';
		} else {
			$slider_autoplay = 'false';
		}
		if($slider_navigation == 1) {
			$slider_navigation = 'true';
		} else {
			$slider_navigation = 'false';
		}
		if($slider_pagination == 1) {
			$slider_pagination = 'true';
		} else {
			$slider_pagination = 'false';
		}

		echo '<div class="mgt-client-reviews-wrapper">';
	}

	// Styles
	$add_class = $text_color;

	$add_class .= ' mgt-client-review-style-'.$reviews_style;

	if($shadow_effect) {
		$add_class .= ' mgt-client-review-shadow';
	}

	if($border_effect) {
		$add_class .= ' mgt-client-review-border';
	}

	$add_class .= ' mgt-client-review-'.$text_align;

	if($text_color == 'text-white') {
		$owlnav = ' owl-invert-nav';
	} else {
		$owlnav = ' owl-normal-nav';
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

	// Render HTML
	echo '<div id="mgt-client-reviews-'.intval($rand_id).'" class="mgt-client-reviews'.esc_attr($single_post).esc_attr($animation_css_class).' wpb_content_element'.esc_attr($owlnav).'"'.$style.'>';

	foreach($posts as $post) {

	  	echo '<div class="mgt-client-review '.esc_attr($add_class).'">';

	    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'enside-reviews-avatar');

	    if(has_post_thumbnail( $post->ID )) {
	    	$image_html ='<div class="mgt-client-review-image"><img src="'.esc_url($image[0]).'" alt="'.esc_attr($post->post_title).'"/></div>';
	    }
	    else {
	    	$image_html = '';
	    }

	    $reviewer_title = get_post_meta( $post->ID, '_enside_clients_reviews_title', true );

	    if($reviewer_title !== '') {
	    	$reviewer_title_html = '<div class="mgt-client-review-position">'.$reviewer_title.'</div>';
	    } else {
	    	$reviewer_title_html = '';
	    }

	    // All data inside $image_html variable already correctly escaped and safe.
	  	echo '<div class="mgt-client-review-details">'.$image_html.'<div class="mgt-client-review-content">'.wp_kses_post($post->post_content).'</div><div class="mgt-client-review-title"><h5>'.esc_html($post->post_title).'</h5>'.wp_kses_post($reviewer_title_html).'</div></div>';

	    echo '</div>';

	}


	echo '</div>';

	echo '<div class="clear"></div>';

	// Slider code
	if($use_slider == 1) {
		echo '</div>';
	}

	if($use_slider == 1) {
		echo '<script>(function($){
	    $(document).ready(function() {

		    $("#mgt-client-reviews-'.intval($rand_id).'").owlCarousel({
	            items: '.esc_js($items_per_row).',
	            itemsDesktop: [1024,1],
	            itemsDesktopSmall : [979, 1],
	            itemsTablet: [770,1],
	            itemsMobile : [480,1],
	            autoPlay: '.esc_js($slider_autoplay).',
	            navigation: '.esc_js($slider_navigation).',
	            navigationText : false,
	            pagination: '.esc_js($slider_pagination).',
	            afterInit : function(elem){
	                $(this).css("display", "block");
	            }
		    });
	    });})(jQuery);</script>';
	}

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode("mgt_clients_reviews_wp", "mgt_shortcode_clients_reviews_wp");
