<?php

// Shortcode [mgt_post_list_wp]
function mgt_shortcode_post_list_wp($atts, $content = null) {
	extract(shortcode_atts(array(
		// Layout
		'block_size' => 'small', /* small, normal, medium, large */
		'elements_style' => 'square',
		'use_slider' => 0,
		'slider_autoplay' => 0,
		'slider_navigation' => 0,
		'slider_pagination' => 1,
		// Filters
		'category' => '', /* Categories ID */
		'category_name' => '', /* Category name */
        'exclude' => '',
        'include' => '',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => 9,
        // Animations
        'animated' => 1,
		'hover_effect' => 'default',
        'css_animation' => 'none',
        // Layout
		'showcategory' => 1,
		'showexrcept' => 1,
		'showreadmore' => 1
	), $atts));
	ob_start();

	$args = array(
		'posts_per_page'   => $posts_per_page,
		'offset'           => 0,
		'category'         => $category,
		'category_name'    => $category_name,
		'orderby'          => $orderby,
		'order'            => $order,
		'include'          => $include,
		'exclude'          => $exclude,
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => false // WPML fix
	);

	$posts = get_posts( $args );

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

	if(count($posts) == 1) {
		$single_post = ' mgt-single-post';
	} else {
		$single_post = '';
	}

	$rand_id = rand(1000000,90000000);

  	if($block_size == 'small') {
  		$slider_items = 4;
  	}
  	if($block_size == 'normal') {
  		$slider_items = 3;
  	}
  	if($block_size == 'medium') {
  		$slider_items = 2;
  	}
  	if($block_size == 'large') {
  		$slider_items = 1;
  	}

  	$image_size = 'enside-blog-thumb';

  	$style = '';

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

		echo '<div class="mgt-post-list-wrapper">';
	}

	if($animated == 1) {
		$add_class = ' animated';
	} else {
		$add_class = '';
	}

	$add_class .= ' mgt-post-list-style-'.$elements_style;

	echo '<div id="mgt-post-list-'.intval($rand_id).'" class="mgt-post-list'.esc_attr($single_post).' wpb_content_element'.esc_attr($animation_css_class).' '.esc_attr($add_class).'"'.$style.'>';

	$add_class = '';

	foreach($posts as $post) {

		setup_postdata( $post );

	    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $image_size);

	    if(has_post_thumbnail( $post->ID )) {
	    	$post_has_image = true;
	    	$image_bg ='background-image: url('.$image[0].');';
	    }
	    else {
	    	$post_has_image = false;
	    	$image_bg = '';
	    }

		if($post_has_image) {
			$add_post_class = ' post-has-image';
		} else {
			$add_post_class = ' post-no-image';
		}

	  	echo '<div class="mgt-post '.esc_attr($block_size).'-blocks '.esc_attr($add_post_class).'">';

	    $post_classes = get_post_class('', $post->ID);
		$post_format_class = $post_classes[4];

		if($showexrcept == 1) {
			$the_excerpt = get_the_excerpt();

			$exrcept_html = '<div class="mgt-post-text">'.$the_excerpt.'</div>';
		} else {
			$exrcept_html = '';
		}

		if($showreadmore == 1) {
			$readmore_html = '<a href="'.get_permalink($post->ID).'" class="btn mgt-button mgt-style-borderedgrey hvr-'.$hover_effect.' mgt-size-small mgt-align-left mgt-display-inline mgt-text-size-normal mgt-text-transform-none">'.esc_html__('Read more', 'enside').'</a>';
		} else {
			$readmore_html = '';
		}

		if($showcategory == 1) {
			$category_html = '<div class="mgt-post-categories">'.strip_tags( get_the_category_list( ', ', 0, $post->ID )).'</div>';
		} else {
			$category_html = '';
		}

		echo '<a href="'.get_permalink($post->ID).'"><div class="mgt-post-image" data-style="'.esc_attr($image_bg).'"><div class="mgt-post-image-wrapper">
		<div class="mgt-post-details"><div class="mgt-post-icon '.esc_attr($post_format_class).'"></div><div class="mgt-post-date">
'.get_the_time( get_option( 'date_format' ), $post->ID ).' </div></div><div class="mgt-post-details-bottom">'.wp_kses_post($category_html).'<div class="mgt-post-title"><h5>'.esc_html($post->post_title).'</h5></div></div>
</div></div></a>';

		echo wp_kses_post($exrcept_html).wp_kses_post($readmore_html);


		echo '';

	    echo '</div>';
	}

	echo '</div>';


	if($use_slider == 1) {
		echo '</div>';
	}

	echo '<div class="clearfix"></div>';

	if($use_slider == 1) {
		echo '<script>(function($){
	    $(document).ready(function() {

		    $("#mgt-post-list-'.intval($rand_id).'").owlCarousel({
	            items: '.esc_js($slider_items).',
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

	wp_reset_query();

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode("mgt_post_list_wp", "mgt_shortcode_post_list_wp");
