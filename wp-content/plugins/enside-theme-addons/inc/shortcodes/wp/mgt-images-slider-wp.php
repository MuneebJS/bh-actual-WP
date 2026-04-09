<?php
// Shortcode [mgt_images_slider_wp]
function mgt_shortcode_images_slider_wp($atts, $sc_content = null) {
	extract(shortcode_atts(array(
		'slider_images' => '',
		'slider_image_size' => 'full',
		'infinite' => 'true',
		'vertical' => 'false',
		'autoplay' => 'true',
	  	'autoplay_speed' => 2000,
	  	'fade' => 'false',
		'speed' => 300,
		'slides' => 1,
		'slidesscroll' => 1,
		'arrows' => 'true',
		'dots' => 'true',
		'centeractiveslide' => 'false',
		'center_padding' => '60px',
		'variable_width' => 'false',
		'adaptive_height' => 'false',
		'slider_padding' => 'false',
		'slider_lightbox' => 'false',
		'css_animation' => 'none'
	), $atts));

	wp_register_script('slick-slider', get_template_directory_uri() . '/js/slick.min.js');
	wp_enqueue_script('slick-slider');

	wp_enqueue_style('slick-slider', get_template_directory_uri() . '/css/slick.css');
	wp_enqueue_style('slick-slider-theme', get_template_directory_uri() . '/css/slick-theme.css');

	ob_start();

	$add_class = '';

	$slidesToShow = $slides;
	$slidesToScroll = $slidesscroll;
	$centerMode = $centeractiveslide;
	$autoplaySpeed = $autoplay_speed;
	$centerPadding = $center_padding;

	$variableWidth = $variable_width;
	$adaptiveHeight = $adaptive_height;

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

	$slider_images_id = explode(",", $slider_images);

	$unique_block_id = rand(1000000,90000000);

	$unique_class_name = 'mgt-images-slider-'.($unique_block_id);

	// Image size
	if ( preg_match_all( '/(\d+)x(\d+)/', $slider_image_size, $sizes ) ) {
		$exact_size = array(
			'width' => isset( $sizes[1][0] ) ? $sizes[1][0] : '0',
			'height' => isset( $sizes[2][0] ) ? $sizes[2][0] : '0',
		);

		$exact_size_int_w = (int) $exact_size['width'];
		$exact_size_int_h = (int) $exact_size['height'];

		$slider_image_size = array($exact_size_int_w, $exact_size_int_h);

	}

	if($slider_padding == 'true') {
		$add_class .= " mgt-images-slider-padding";
	}

	if($centerMode == 'true') {
		$add_class .= " mgt-images-slider-centered";
	}

	// Render HTML
	echo '<div class="mgt-images-slider'.esc_attr($add_class).' '.esc_attr($unique_class_name).' wpb_content_element'.esc_attr($animation_css_class).'">
		<div class="mgt-images-slider-items">';

	// Adding slider items
	foreach ($slider_images_id as &$current_image_id) {
	    $image = wp_get_attachment_image_src( $current_image_id, $slider_image_size );

	    $image_source = wp_get_attachment_image_src( $current_image_id, 'full' );

		if(trim($image[0]) !== '') {
			if($slider_lightbox == 'false') {
				echo '<div class="mgt-images-slider-item"><img src="'.$image[0].'" alt="'.get_post_meta($current_image_id, '_wp_attachment_image_alt', true).'"/></div>';
			} else {
				echo '<div class="mgt-images-slider-item"><a href="'.esc_url($image_source[0]).'" rel="lightbox"><img src="'.esc_url($image[0]).'" alt="'.get_post_meta($current_image_id, '_wp_attachment_image_alt', true).'"/></a></div>';
			}

		}
	}

	echo '</div>
	</div>';

	if($fade == 'false') {
		$cssEase = 'ease';
	} else {
		$cssEase = 'linear';
	}

	echo '<script>(function($){
            $(document).ready(function() {
			   $(".mgt-images-slider.'.esc_js($unique_class_name).' .mgt-images-slider-items").on("init", function(slick){
					$(".mgt-images-slider.'.esc_js($unique_class_name).' .mgt-images-slider-items").show();
				});

               $(".mgt-images-slider.'.esc_js($unique_class_name).' .mgt-images-slider-items").slick({
               	  pauseOnHover: false,
				  infinite: '.esc_js($infinite).',
				  autoplay: '.esc_js($autoplay).',
  				  autoplaySpeed: '.esc_js($autoplaySpeed).',
				  slidesToShow: '.esc_js($slidesToShow).',
				  slidesToScroll: '.esc_js($slidesToScroll).',
				  arrows: '.esc_js($arrows).',
				  dots: '.esc_js($dots).',
				  speed: '.esc_js($speed).',
				  centerMode: '.esc_js($centerMode).',
				  centerPadding: "'.esc_js($centerPadding).'",
  				  variableWidth: '.esc_js($variableWidth).',
  				  adaptiveHeight: '.esc_js($adaptiveHeight).',
  				  fade: '.esc_js($fade).',
  				  cssEase: "'.esc_js($cssEase).'",
  				  vertical: '.esc_js($vertical).',
  				  responsive: [
				    {
				      breakpoint: 1024,
				      settings: {
				        slidesToShow: 1,
				        slidesToScroll: 1,
				        infinite: true,
				        dots: true
				      }
				    },
				    {
				      breakpoint: 600,
				      settings: {
				        slidesToShow: 1,
				        slidesToScroll: 1
				      }
				    },
				    {
				      breakpoint: 480,
				      settings: {
				        slidesToShow: 1,
				        slidesToScroll: 1
				      }
				    }
				  ]
				});



            });})(jQuery);</script>';

	$sc_content = ob_get_contents();
	ob_end_clean();
	return $sc_content;
}

add_shortcode("mgt_images_slider_wp", "mgt_shortcode_images_slider_wp");
