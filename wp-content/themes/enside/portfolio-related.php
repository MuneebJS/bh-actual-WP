<?php
/*
  Show related items on portfolio single item page
*/

$enside_theme_options = enside_get_theme_options();

$related_filter = enside_get_theme_data_value('related_filter');

// Posts limit
$portfolio_posts_limit = $enside_theme_options['portfolio_related_limit'];

// Columns layout
if(isset($enside_theme_options['portfolio_related_items_columns'])) {
  $related_columns = $enside_theme_options['portfolio_related_items_columns'];
} else {
  $related_columns = 4;
}

// Text align
if(isset($enside_theme_options['portfolio_related_items_text_align'])) {
  $text_align = $enside_theme_options['portfolio_related_items_text_align'];
} else {
  $text_align = "left";
}

// Hover effect
if(isset($enside_theme_options['portfolio_posts_item_hover_effect'])) {
  $item_hover_effect = $enside_theme_options['portfolio_posts_item_hover_effect'];
} else {
  $item_hover_effect = 0;
}

// View more button
if(isset($enside_theme_options['portfolio_related_items_show_viewmore_button'])) {
  
  $show_viewmore_button = $enside_theme_options['portfolio_related_items_show_viewmore_button'];

  if(isset($enside_theme_options['portfolio_related_items_viewmore_button_title'])) {
    $viewmore_button_text = $enside_theme_options['portfolio_related_items_viewmore_button_title'];
  } else {
    $viewmore_button_text = esc_html__('View more', 'enside');
  }

  if(isset($enside_theme_options['portfolio_posts_button_round_edges'])) {
    $viewmore_button_round_edges = $enside_theme_options['portfolio_posts_button_round_edges'];
  } else {
    $viewmore_button_round_edges = 'disable';
  }

} else {
  $show_viewmore_button = false;
  $viewmore_button_text = '';
  $viewmore_button_round_edges = '';
}

// Description
if(isset($enside_theme_options['portfolio_related_items_show_description'])) {
  $show_description = $enside_theme_options['portfolio_related_items_show_description'];
} else {
  $show_description = false;
}

// Get items
$all_terms = get_terms( 'mgt_portfolio_filter' );

$temp = $wp_query;
$wp_query = null;

$data_item = 0;

$exclude_ids = array( get_the_ID() );

$wp_query = new WP_Query(array(
  'post_type' => 'mgt_portfolio',
  'mgt_portfolio_filter' => $related_filter,
  'posts_per_page' => $portfolio_posts_limit,
  'orderby'=> 'date',
  'post__not_in' => $exclude_ids
));

if($wp_query->have_posts()) {
?>
<div class="related-works">
  <div class="portfolio-list portfolio-list-related clearfix portfolio-columns-<?php echo esc_attr($related_columns); ?>" id="portfolio-list">
  <?php

  while ($wp_query->have_posts()) : $wp_query->the_post();
    
    $data_item++;
    
    $portfolio_small = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'enside-portfolio-thumb-square' );

    if($show_description) {
      $portfolio_description = get_post_meta( $post->ID, '_portfolio_description_value', true );
    } else {
      $portfolio_description = '';
    }

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

  ?>
  <div class="portfolio-item-block mix<?php echo esc_attr($terms_slug); ?> text-<?php echo esc_attr($text_align); ?> portfolio-item-animation-<?php echo esc_attr($item_hover_effect);?>" data-item="<?php echo esc_attr($data_item); ?>" data-name="<?php the_title(); ?>">
    <a href="<?php echo esc_url(get_permalink( $post->ID ));?>">
      <div class="portfolio-item-image" data-style="background-image: url('<?php echo esc_url($portfolio_small[0]); ?>')"></div>
      <div class="portfolio-item-bg"></div>
      <div class="info">
        <span class="sub-title"><?php echo esc_html($categories_html); ?></span>
        <h4 class="title"><?php the_title(); ?></h4>
        <?php if($show_description == 1 && $portfolio_description !== ''): ?>
        <div class="project-description"><?php echo wp_kses_post($portfolio_description); ?></div>
        <?php endif; ?>
        <?php if($show_viewmore_button == 1): ?>
        <div class="view-more btn mgt-button mgt-button-round-edges-<?php echo esc_attr($viewmore_button_round_edges); ?>"><?php echo wp_kses_post($viewmore_button_text); ?></div>
        <?php endif; ?>
      </div>
    </a>
  </div>

  <?php 
  if($data_item == 3){
    $data_item = 0;
  }

  endwhile; // end of the loop. 

  ?>
  </div>
  <?php
  wp_add_inline_script( 'enside-script', '(function($){
      $(document).ready(function() {
        "use strict";

        $("#portfolio-list").mixItUp({effects:["'.esc_js($enside_theme_options['portfolio_posts_animation_1']).'","'.esc_js($enside_theme_options['portfolio_posts_animation_2']).'"],easing:"snap"});

      });})(jQuery);');
  ?>
</div>
<?php
}
?>
    
<?php $wp_query = null; $wp_query = $temp;?>