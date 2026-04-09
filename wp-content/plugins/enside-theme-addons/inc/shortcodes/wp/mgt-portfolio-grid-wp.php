<?php

// Shortcode [mgt_portfolio_grid_wp]
function mgt_shortcode_portfolio_grid_wp($atts, $content = null) {

	global $wp_query, $post;

	extract(shortcode_atts(array(
		'layout' => 0,
		'columns' => 4,
		'slider_columns' => 4,
		'slider_autoplay' => 'false',
		'slider_navigation' => 'false',
		'slider_pagination' => 'false',
		'slider_speed' => 200,
        'spaces' => 0,
        'show_viewmore_button' => 1,
        'viewmore_button_text' => 'View more',
        'viewmore_button_round_edges' => 'disable',
		'show_description'	=> 1,
		'text_align' => 'left',
		// Filter
		'show_filter' => false,
		'filter_align' => 'left',
		'filter_color' => 'dark',
		'filter_border' => 'hide',
		'filter_border_style' => 'rounded',
		'reset_filter_button_text' => 'All',
		// Additional
		'show_viewall_button' => '',
		'open_image' => 0,
		'open_url' => 0,
		// Order and limit
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => '',
        'category_name' => '',
        // Effects
        'item_hover_effect' => 0,
        'filter_effect_1' => 'fade',
		'filter_effect_2' => 'scale',
        'css_animation' => 'none'
	), $atts));
	ob_start();

	$portfolio_list_id = 'portfolio-list-'.rand(1000000,90000000);

	$porfolio_image_size = 'enside-portfolio-thumb-square'; // 1024 by default

	if(($slider_columns < 3) || ($columns < 3)) {
		$porfolio_image_size = 'enside-portfolio-large'; // 1600x800
	}

	// Show items in one column if used Compact/Medium List layout
	if($layout == 5 || $layout == 6) {
		$slider_columns = 1;
		$porfolio_image_size = 'enside-portfolio-large'; // 1600x800
	}

	if((trim($posts_per_page) == '')||($posts_per_page == 0)) {
		$posts_per_page = 10000;
	}

	$all_terms = get_terms( 'mgt_portfolio_filter');

	$show_viewall_button_data = vc_build_link($show_viewall_button);

	if($layout == 1) {
		$spaces = 0;
	}

	if($item_hover_effect == 9) {
		$spaces = 1;
	}

	if($spaces == 1) {
		$add_class = ' portfolio-with-spaces ';
	} else {
		$add_class = '';
	}

	// Don't show filter if Gallery used
	if($layout == 4) {
		$show_filter = false;
	}

	$filter_add_class = 'filter-'.$filter_align.' filter-'.$filter_color;

	if($filter_border == 'show') {
		$filter_add_class .= ' filter-bordered filter-border-style-'.$filter_border_style;
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

	?>

	<div class="mgt-portfolio-grid wpb_content_element <?php echo esc_attr($animation_css_class);?>"> <?php // mgt-portfolio-grid start div ?>

	<?php if((count($all_terms) > 1) && ($show_filter) && $category_name == ''): ?>
	<div class="row portfolio-filter <?php echo esc_attr($filter_add_class);?>">
		<div class="col-md-12">
		<a class="filter" data-filter="all"><?php echo esc_html($reset_filter_button_text); ?></a><?php
		foreach ( $all_terms as $term ) {
		  echo '<a class="filter" data-filter=".'.esc_attr($term->slug).'">'.esc_html($term->name).'</a>';
		}
		?><?php if($show_viewall_button_data['title'] !== ''): ?><?php echo '<a class="filter view-all" href="'.esc_url($show_viewall_button_data['url']).'" target="'.esc_attr($show_viewall_button_data['target']).'">'.esc_html($show_viewall_button_data['title']).'</a>'; ?>
		<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>

	<div class="portfolio-list portfolio-columns-<?php echo esc_attr($columns); ?> portfolio-grid-layout-<?php echo esc_attr($layout);?> <?php echo esc_attr($add_class); ?>clearfix" id="<?php echo esc_attr($portfolio_list_id); ?>">

	<?php

	$temp = $wp_query;
	$wp_query = null;

	$data_item = 0;

	// Show items from specific category
	if($category_name == '') {
		// Custom order
		if($orderby == 'custom') {
			$wp_query = new WP_Query(array(
				'post_type' => 'mgt_portfolio',
				'posts_per_page' => $posts_per_page,
				'orderby'    => 'meta_value_num',
				'meta_key' => '_portfolio_sort_id_value',
				'order' => $order
			));
		} else {
			$wp_query = new WP_Query(array(
				'post_type' => 'mgt_portfolio',
				'posts_per_page' => $posts_per_page,
				'orderby'    => $orderby,
				'order' => $order
			));
		}
	} else {
		// Custom order
		if($orderby == 'custom') {
			$wp_query = new WP_Query(array(
				'post_type' => 'mgt_portfolio',
				'tax_query' => array(
					array(
						'taxonomy' => 'mgt_portfolio_filter',
						'field'    => 'slug',
						'terms'    => $category_name,
					),
				),
				'posts_per_page' => $posts_per_page,
				'orderby'    => 'meta_value_num',
				'meta_key' => '_portfolio_sort_id_value',
				'order' => $order
			));
		} else {
			$wp_query = new WP_Query(array(
				'post_type' => 'mgt_portfolio',
				'tax_query' => array(
					array(
						'taxonomy' => 'mgt_portfolio_filter',
						'field'    => 'slug',
						'terms'    => $category_name,
					),
				),
				'posts_per_page' => $posts_per_page,
				'orderby'    => $orderby,
				'order' => $order
			));
		}

	}

	if(!$wp_query->have_posts()) {
		esc_html_e('You does not have projects to display for current MGT Portfolio Grid element settings.', 'enside');
	}

	while ($wp_query->have_posts()) : $wp_query->the_post();

	  $data_item++;

	  $portfolio_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $porfolio_image_size );

	  $portfolio_brand = get_post_meta( $post->ID, '_portfolio_brand_value', true );
	  $portfolio_brand_url = get_post_meta( $post->ID, '_portfolio_brand_url_value', true );
	  $portfolio_url = get_post_meta( $post->ID, '_portfolio_url_value', true );
	  $portfolio_description = get_post_meta( $post->ID, '_portfolio_description_value', true );

	  $terms = get_the_terms( $post->ID , 'mgt_portfolio_filter' );

	  $terms_count = count($terms);

	  $terms_counter = 0;

	  $terms_slug = '';

	  $categories_html = '';

	  foreach ( $terms ? $terms: array() as $term ) {

	    if($terms_counter  < $terms_count - 1) {
	      $categories_html.= $term->name.' / ';
	    }
	    else
	    {
	      $categories_html .= $term->name;
	    }

	    $terms_slug .= ' '.$term->slug;

	    $terms_counter++;
	  }

	  $style = 'background-image: url('.$portfolio_thumb[0].');';

	  if($layout == 4) {
	  	$item_class_add = 'slide-item';
	  } else {
	  	$item_class_add = 'mix';
	  }

	  // Open item image lightbox instead of item page
	  if($open_image == 1) {
	  	$open_url = 0;

	  	$portfolio_full_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'source' );
	  	$item_url = $portfolio_full_image[0];
	  	$item_rel = 'lightbox';
	  	$item_target = '_self';

	  } else {

		$item_rel = '';

	  	// Open item url instead of item page
		if($open_url == 1) {
			$item_url = $portfolio_url;
			$item_target = '_blank';
		} else {
			$item_url = esc_url(get_permalink( $post->ID ));
			$item_target = '_self';
		}
	  }
	?><div class="portfolio-item-block text-<?php echo esc_attr($text_align); ?> portfolio-item-animation-<?php echo esc_attr($item_hover_effect);?> <?php echo esc_attr($item_class_add); ?><?php echo esc_attr($terms_slug); ?>" data-item="<?php echo esc_attr($data_item); ?>" data-name="<?php the_title(); ?>">
	<div class="portfolio-item-block-inside">
	  <a href="<?php echo esc_url($item_url);?>" target="<?php echo esc_attr($item_target); ?>" rel="<?php echo esc_attr($item_rel); ?>">
	    <div class="portfolio-item-image" data-style="<?php echo esc_attr($style); ?>"></div>
	    <div class="portfolio-item-bg"></div>

	    <div class="info">
	      <?php if($item_hover_effect <> 9): ?>
		      <span class="sub-title"><?php echo esc_html($categories_html); ?></span>
		      <h4 class="title"><?php the_title(); ?></h4>
		      <?php if($show_description == 1 && $portfolio_description !== ''): ?>
		      <div class="project-description"><?php echo wp_kses_post($portfolio_description); ?></div>
		  	  <?php endif; ?>
	  	  <?php endif; ?>
	      <?php if($show_viewmore_button == 1): ?>
	      <div class="view-more btn mgt-button mgt-button-round-edges-<?php echo $viewmore_button_round_edges; ?>"><?php echo wp_kses_post($viewmore_button_text); ?></div>
	  	  <?php endif; ?>
	    </div>

	  </a>
	</div>
	<?php
	// Text below image layout
	if($item_hover_effect == 9): ?>
	<div class="portfolio-info-below">
		<span class="sub-title"><?php echo esc_html($categories_html); ?></span>
		<a href="<?php echo esc_url($item_url);?>" target="<?php echo esc_attr($item_target); ?>" rel="<?php echo esc_attr($item_rel); ?>"><h4 class="title"><?php the_title(); ?></h4></a>
		<?php if($show_description == 1 && $portfolio_description !== ''): ?>
		<div class="project-description"><?php echo wp_kses_post($portfolio_description); ?></div>
		  <?php endif; ?>
	</div>
	<?php endif; ?>
	</div><?php
	if($data_item == 3){
	  $data_item = 0;
	}

	endwhile; // end of the loop.

	wp_reset_query();

	?>

	<?php $wp_query = null; $wp_query = $temp;?>

	</div>

	</div> <?php // mgt-portfolio-grid end div ?>
<?php
	// Gallery
	if($layout == 4) {

		echo '<script>(function($){
            $(document).ready(function() {

                function initPortfolioCarousel() {

					$("#'.esc_js($portfolio_list_id).'").owlCarousel({
	                    items: '.esc_js($slider_columns).',
	                    slideSpeed: '.esc_js($slider_speed).',
	                    itemsDesktop:   [1199,'.esc_js($slider_columns).'],
	                    itemsDesktopSmall: [979,1],
	                    itemsTablet: [768,1],
	                    itemsMobile : [479,1],
	                    autoPlay: '.esc_js($slider_autoplay).',
	                    navigation: '.esc_js($slider_navigation).',
	                    navigationText : false,
	                    pagination: '.esc_js($slider_pagination).',
	                    afterInit : function(elem){
	                        $(this).css("display", "block");
	                    }
	                });

				}

				setTimeout(initPortfolioCarousel, 1000);

            });})(jQuery);</script>';
	} else {
		echo '<script>(function($){
	    $(document).ready(function() {

		    $("#'.esc_js($portfolio_list_id).'").mixItUp({effects:["'.esc_js($filter_effect_1).'","'.esc_js($filter_effect_2).'"],easing:"snap"});

	    });})(jQuery);</script>';
	}


	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode("mgt_portfolio_grid_wp", "mgt_shortcode_portfolio_grid_wp");
