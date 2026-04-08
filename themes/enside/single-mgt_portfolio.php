<?php
/**
 * The Template for displaying Portfolio single posts.
 *
 * @package enside
 */

$enside_theme_options = enside_get_theme_options();

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<?php

// PORTFOLIO ITEM DETAILS
$comments_loaded = false;

$portfolio_css_classes = '';

$portfolio_small = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'mgt-portfolio-small' );
$portfolio_large = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'enside-portfolio-large' );
$portfolio_source = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'source' );

$portfolio_brand = get_post_meta( get_the_ID(), '_portfolio_brand_value', true );
$portfolio_url = get_post_meta( get_the_ID(), '_portfolio_url_value', true );

$portfolio_fullwidthslider = get_post_meta( get_the_ID(), '_portfolio_fullwidthslider_value', true );
$portfolio_socialshare_disable = get_post_meta( get_the_ID(), '_portfolio_socialshare_disable_value', true );
$portfolio_original_image_sizes = get_post_meta( get_the_ID(), '_portfolio_original_image_sizes_value', true );
$portfolio_hide_details = get_post_meta( get_the_ID(), '_portfolio_hide_details_value', true );
$portfolio_hide_breadcrumbs = get_post_meta( get_the_ID(), '_portfolio_hide_breadcrumbs_value', true );

$portfolio_hide_1st_image_from_slider = get_post_meta( get_the_ID(), '_portfolio_hide_1st_image_from_slider_value', true );

if(!isset($portfolio_hide_details)) {
  $portfolio_hide_details = false;
}

if(!isset($portfolio_socialshare_disable)) {
  $portfolio_socialshare_disable = false;
}

$portfolio_images = array();
$portfolio_images_sources = array();

$portfolio_images_sources = enside_cmb2_get_images_src( get_the_ID(), '_enside_portfolio_images_file_list', 'source' );

$portfolio_layout = get_post_meta( get_the_ID(), '_portfolio_display_type_value', true );
$portfolio_disableslider = get_post_meta( get_the_ID(), '_portfolio_disableslider_value', true );

$portfolio_sidebarposition = get_post_meta( $post->ID, '_portfolio_sidebarposition_value', true );
$portfolio_titleposition = get_post_meta( $post->ID, '_portfolio_titleposition_value', true );

$page_transparent_header = get_post_meta( $post->ID, '_page_transparent_header_value', true );

if(isset($page_transparent_header)&&($page_transparent_header)) {
  wp_add_inline_script( 'enside-script', '(function($){$(document).ready(function() { "use strict";$("body").addClass("transparent-header"); });})(jQuery);', 'before');
}

$page_bgcolor = get_post_meta( $post->ID, '_page_bgcolor_value', true );

$page_bgcolor_css = '';

if(isset($page_bgcolor)&&($page_bgcolor<>'')) {
    $page_bgcolor_css = 'background-color: '.$page_bgcolor;
}
else
{
    $page_bgcolor_css = '';
}

if(!isset($portfolio_sidebarposition) || ($portfolio_sidebarposition == '')) {
  $portfolio_sidebarposition = 0;
}

if(!isset($portfolio_titleposition) || ($portfolio_titleposition == '')) {
  $portfolio_titleposition = 'default';
}

if($portfolio_sidebarposition == "0") {
  $portfolio_sidebarposition = $enside_theme_options['portfolio_sidebar_position'];
}

$portfolio_css_classes = 'portfolio-layout-'.$portfolio_layout.' portfolio-title-position-'.$portfolio_titleposition;

$containerclass = 'container';
$containerboxclass = '';

if($portfolio_layout == 0) {

	if(is_active_sidebar( 'portfolio-sidebar' ) && ($portfolio_sidebarposition <> 'disable')) {
		$span_class = 'col-md-4';
		$span_class2 = 'col-md-5';
	}
	else {
		$span_class = 'col-md-7';
		$span_class2 = 'col-md-5';
	}

	$portfolio_main_image = $portfolio_small;

  $portfolio_images = enside_cmb2_get_images_src( get_the_ID(), '_enside_portfolio_images_file_list', 'mgt-portfolio-small' );
}
else {
	if(is_active_sidebar( 'portfolio-sidebar' ) && ($portfolio_sidebarposition <> 'disable') ) {
		$span_class = 'col-md-9';
	}
	else {
		$span_class = 'col-md-12';
		$span_class2 = 'col-md-12 portfolio-single-content';
	}

	$portfolio_main_image = $portfolio_large;

  $portfolio_images = enside_cmb2_get_images_src( get_the_ID(), '_enside_portfolio_images_file_list', 'enside-portfolio-large' );
}

// full image size for fullwidth slider
if($portfolio_fullwidthslider) {

  $portfolio_images = enside_cmb2_get_images_src( get_the_ID(), '_enside_portfolio_images_file_list', 'source' );
	$portfolio_main_image = $portfolio_source;

  $span_class = 'col-md-12';

  $portfolio_css_classes .= ' portfolio-fullwidthslider';
}

if(!isset($portfolio_original_image_sizes)) {
  $portfolio_original_image_sizes = false;
}

if($portfolio_original_image_sizes) {

    $portfolio_images = enside_cmb2_get_images_src( get_the_ID(), '_enside_portfolio_images_file_list', 'source' );
    $portfolio_main_image = $portfolio_source;
}

$terms = get_the_terms( $post->ID , 'mgt_portfolio_filter' );

$terms_count = count($terms);

$terms_counter = 0;

$terms_slug = '';

$categories_html = '';

$parent_link = get_post_type_archive_link('mgt_portfolio');

$related_filter = '';

foreach ( $terms ? $terms: array() as $term ) {

  if($terms_counter  < $terms_count - 1) {
    $categories_html .= esc_html($term->name).', ';
    $related_filter .= esc_html($term->slug).', ';
  }
  else
  {
    $categories_html .= esc_html($term->name);
    $related_filter .= esc_html($term->slug);
  }

  $terms_slug .= ' '.$term->slug;

  $terms_counter++;
}

$theme_data['related_filter'] = $related_filter;

enside_set_theme_data($theme_data);

// PORTFOLIO ITEM DETAILS END

// TITLE SETTINGS
$header_background_image = get_post_meta( get_the_ID(), '_enside_header_image', true );

if(isset($header_background_image) && ($header_background_image!== '')) {
  $header_background_image_style = 'background-image: url('.$header_background_image.');';
  $header_background_class = ' with-bg';
} else {
  $header_background_image_style = '';
  $header_background_class = '';
}

$header_background_color =  get_post_meta( get_the_ID(), '_enside_header_bgcolor', true );

if(isset($header_background_color) && ($header_background_color!== '')) {
  $header_background_image_style .= 'background-color: '.$header_background_color;
  $header_background_class .= ' with-bgcolor';
}

// Fullwidth page title
if(isset($enside_theme_options['page_title_width']) && $enside_theme_options['page_title_width'] == 'boxed') {
  $page_title_layout_class = 'container';
} else {
  $page_title_layout_class = 'container-fluid';
}

// Page title align
if(isset($enside_theme_options['page_title_align'])) {
  $page_title_align_class = 'text-'.$enside_theme_options['page_title_align'];
} else {
  $page_title_align_class = 'text-left';
}

// Page title text transform
if(isset($enside_theme_options['page_title_texttransform'])) {
  $page_title_texttransform_class = 'texttransform-'.$enside_theme_options['page_title_texttransform'];
} else {
  $page_title_texttransform_class = 'texttransform-uppercase';
}

?>

<div class="content-block"<?php if($page_bgcolor_css<>'') { echo ' data-style="'.esc_attr($page_bgcolor_css).'"'; }; ?>>
  <?php if($portfolio_titleposition == 'default'): ?>
    <div class="container-bg <?php echo esc_attr($page_title_layout_class); ?> <?php echo esc_attr($header_background_class); ?>" data-style="<?php echo esc_attr($header_background_image_style); ?>">
      <div class="container-bg-overlay">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="page-item-title">
                <h1 class="<?php echo esc_attr($page_title_align_class); ?> <?php echo esc_attr($page_title_texttransform_class); ?>"><?php the_title(); ?></h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if(!$portfolio_hide_breadcrumbs) { enside_show_breadcrumbs(); } ?>
    </div>

  <?php endif; ?>

  <?php if($portfolio_fullwidthslider):?>
  <div class="portfolio-item-image">
    <div class="porftolio-slider porfolio-slider-fullwidth<?php if((!$portfolio_disableslider)&&(count($portfolio_images) > 0)) { echo ' enable-slider'; } ?>">
      <ul class="slides">
        <?php if(!$portfolio_hide_1st_image_from_slider): ?>
        <li><a href="<?php echo esc_url($portfolio_source[0]); ?>" rel="lightbox"><img src="<?php echo esc_url($portfolio_main_image[0]); ?>" alt="<?php the_title(); ?>"/></a></li>
        <?php endif; ?>
        <?php
        $i = 0;
        foreach ( $portfolio_images as $portfolio_image ) {
          echo '<li><a href="'.esc_url($portfolio_images_sources[$i]).'" rel="lightbox"><img src="'.esc_url($portfolio_image).'" alt="'.the_title_attribute(array('echo' => false)).'"/></a></li>';
          $i++;
        }

        ?>
      </ul>
    </div>
  </div>
  <?php endif;?>

	<div class="project-container <?php echo esc_attr($containerclass);?> portfolio-item-details <?php echo esc_attr($portfolio_css_classes);?>">
		<div class="row">
		<?php if ( is_active_sidebar( 'portfolio-sidebar' ) && ( $portfolio_sidebarposition == 'left') &&(!$portfolio_fullwidthslider)) : ?>
		<div class="col-md-3 main-sidebar portfolio-sidebar sidebar">
		  <ul id="portfolio-sidebar">
		    <?php dynamic_sidebar( 'portfolio-sidebar' ); ?>
		  </ul>
		</div>
		<?php endif; ?>

		<div class="<?php echo esc_attr($span_class); ?>">
      <?php if(!$portfolio_fullwidthslider):?>

        <?php if((!$portfolio_hide_1st_image_from_slider)||(count($portfolio_images) > 0)):?>
        <div class="<?php echo esc_attr($containerboxclass); ?> portfolio-item-image-container">
        <div class="row">
        <div class="col-md-12">
  			<div class="portfolio-item-image">
  				<div class="porftolio-slider<?php if((!$portfolio_disableslider)&&(count($portfolio_images) > 0)) { echo ' enable-slider'; } ?>">
            <ul class="slides">
              <?php if(!$portfolio_hide_1st_image_from_slider && isset($portfolio_main_image[0])): ?>
              <li><a href="<?php echo esc_url($portfolio_source[0]); ?>" rel="lightbox"><img src="<?php echo esc_url($portfolio_main_image[0]); ?>" alt="<?php the_title(); ?>"/></a></li>
              <?php endif; ?>
              <?php
              $i = 0;
              foreach ( $portfolio_images as $portfolio_image ) {
                echo '<li><a href="'.esc_url($portfolio_images_sources[$i]).'" rel="lightbox"><img src="'.esc_url($portfolio_image).'" alt="'.the_title_attribute(array('echo' => false)).'"/></a></li>';
                $i++;
              }

              ?>
            </ul>
          </div>
        </div>
        </div>
        </div>
        </div>
        <?php endif;?>

      <?php endif;?>
    <?php if ( !is_active_sidebar( 'portfolio-sidebar' ) || ($portfolio_sidebarposition == 'disable') || ($portfolio_layout == 0)) : ?>
		</div>

		<div class="<?php echo esc_attr($span_class2); ?>">
		<?php endif; ?>

		  <div class="portfolio-item-data clearfix">
            <?php if($portfolio_titleposition == 'description'): ?>

                  <div class="page-item-title">
                    <h1><?php the_title(); ?></h1>
                  </div>

            <?php endif; ?>
            <div class="project-content">
            <?php the_content(); ?>
            <div class="clear"></div>
            </div>

            <?php if( ($portfolio_hide_details && !$portfolio_socialshare_disable) || (!$portfolio_hide_details && $portfolio_socialshare_disable) || (!$portfolio_hide_details && !$portfolio_socialshare_disable) ): ?>
            <div class="row">
                <div class="col-md-12">

                  <div class="portfolio-item-data-bottom">
                  <?php if(!$portfolio_hide_details): ?>

                    <div class="project-details">

                        <?php if(isset($portfolio_brand) && $portfolio_brand <> ''): ?>
                        <p><span><?php esc_html_e('Client:', 'enside');?></span> <?php echo esc_html($portfolio_brand); ?></p>
                        <?php endif; ?>
                        <?php if(isset($portfolio_url) && $portfolio_url <> ''): ?>
                        <p><span><?php esc_html_e('Project url:', 'enside');?></span> <a href="<?php echo esc_url($portfolio_url); ?>" target="_blank"><?php echo esc_html($portfolio_url); ?></a></p>
                        <?php endif; ?>
                        <p><span><?php esc_html_e('Category:', 'enside');?></span> <?php echo esc_html($categories_html); ?></p>

                    </div>

                  <?php endif; ?>

                  <?php if(!$portfolio_socialshare_disable): ?>
                    <?php do_action('enside_social_share'); // this action called from plugin ?>
                  <?php endif; ?>
                  </div>

                </div>
            </div>
            <?php endif; ?>

      </div>
      <div class="clear"></div>
      <?php if(($portfolio_sidebarposition !== 'disable')): ?>

            <?php
            if(!$comments_loaded) {
               if ( comments_open() || '0' != get_comments_number() )

                  comments_template();
            }
            ?>

      <?php endif; ?>
		</div>

		<?php if ( is_active_sidebar( 'portfolio-sidebar' ) &&( $portfolio_sidebarposition == 'right') &&(!$portfolio_fullwidthslider) ) : ?>
		<div class="col-md-3 main-sidebar portfolio-sidebar sidebar">
		  <ul id="portfolio-sidebar">
		    <?php dynamic_sidebar( 'portfolio-sidebar' ); ?>
		  </ul>
		</div>
		<?php endif; ?>


		</div>
    <?php if($portfolio_sidebarposition == 'disable' && ( comments_open() || '0' != get_comments_number() )): ?>
    <div class="container fullwidth-no-padding">
      <div class="row">
        <div class="col-md-12">
          <?php
          if(!$comments_loaded) {
             if ( comments_open() || '0' != get_comments_number() )

                comments_template();
          }
          ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
	</div>
</div> <?php //content-block ?>

<?php if(!$portfolio_disableslider): ?>

<?php
if(isset($enside_theme_options['portfolio_show_slider_navigation']) && $enside_theme_options['portfolio_show_slider_navigation']) {
  $portfolio_show_slider_navigation = 'true';
} else {
  $portfolio_show_slider_navigation = 'false';
}

if(isset($enside_theme_options['portfolio_slider_autoplay']) && $enside_theme_options['portfolio_slider_autoplay']) {
  $portfolio_slider_autoplay = 'true';
} else {
  $portfolio_slider_autoplay = 'false';
}

if(isset($enside_theme_options['portfolio_show_slider_pagination']) && $enside_theme_options['portfolio_show_slider_pagination']) {
  $portfolio_show_slider_pagination = 'true';
} else {
  $portfolio_show_slider_pagination = 'false';
}

?>
<?php if(count($portfolio_images) > 0): ?>
<?php
  wp_add_inline_script( 'enside-script', '(function($){
$(document).ready(function() {
  "use strict";
  $(".porftolio-slider.enable-slider ul.slides").owlCarousel({
          items: 1,
          itemsDesktop: [1024,3],
          itemsTablet: [770,2],
          itemsMobile : [480,1],
          autoHeight: true,
          autoPlay: '.esc_js($portfolio_slider_autoplay).',
          navigation: '.esc_js($portfolio_show_slider_navigation).',
          navigationText : false,
          pagination: '.esc_js($portfolio_show_slider_pagination).',
          afterInit : function(elem){
              $(".porftolio-slider").css("display", "block");
          }
    });

});
})(jQuery);');
?>
<?php endif; ?>
<?php endif; ?>


<?php if(isset($enside_theme_options['portfolio_show_item_navigation']) && $enside_theme_options['portfolio_show_item_navigation']): ?>
    <?php
        $prevPost = get_previous_post();

        if($prevPost) {
          $prevthumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $prevPost->ID ), 'enside-portfolio-thumb-large' );
          $prevthumbnailUrl = $prevthumbnail[0];
          $prevPostUrl = get_permalink( $prevPost->ID );
        } else {
          $prevthumbnail = false;
        }

        $nextPost = get_next_post();

        if($nextPost) {
          $nextthumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $nextPost->ID ), 'enside-portfolio-thumb-large' );
          $nextthumbnailUrl = $nextthumbnail[0];
          $nextPostUrl = get_permalink( $nextPost->ID );
        } else {
          $nextthumbnail = false;
        }

        if($prevthumbnail && $nextthumbnail) {
          $portfolio_navigation_class = ' portfolio-navigation-both';
        } else {
          $portfolio_navigation_class = ' portfolio-navigation-single';
        }
    ?>
    <?php if($prevthumbnail || $nextthumbnail): ?>
    <div class="portfolio-navigation-wrapper clearfix<?php echo esc_attr($portfolio_navigation_class); ?>">
    <?php if($prevthumbnail): ?>
    <div class="portfolio-navigation portfolio-navigation-prev" data-name="<?php esc_attr_e('Previous project', 'enside'); ?>">
      <a href="<?php echo esc_url($prevPostUrl); ?>" class="portfolio-navigation-image" data-style="background-image: url(<?php echo esc_url($prevthumbnailUrl);?>);">
        <div class="portfolio-navigation-details">
          <div class="portfolio-navigation-title"><?php echo esc_html__('Previous Project', 'enside'); ?></div>
          <div class="portfolio-navigation-post-title"><h3><?php echo esc_html($prevPost->post_title); ?></h3></div>
        </div>
      </a>
    </div>
    <?php endif;?>
    <?php if($nextthumbnail): ?>
    <div class="portfolio-navigation portfolio-navigation-next" data-name="<?php esc_attr_e('Next project', 'enside'); ?>">
      <a href="<?php echo esc_url($nextPostUrl); ?>" class="portfolio-navigation-image" data-style="background-image: url(<?php echo esc_url($nextthumbnailUrl);?>);">
        <div class="portfolio-navigation-details">
          <div class="portfolio-navigation-title"><?php echo esc_html__('Next Project', 'enside'); ?></div>
          <div class="portfolio-navigation-post-title"><h3><?php echo esc_html($nextPost->post_title); ?></h3></div>
        </div>
      </a>
    </div>
    <?php endif;?>
    </div>
    <?php endif;?>
<?php endif; ?>


<?php if(isset($enside_theme_options['portfolio_related_works']) && ($enside_theme_options['portfolio_related_works'])): ?>


<?php get_template_part( 'portfolio-related' ); ?>

<?php endif; ?>

<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>
