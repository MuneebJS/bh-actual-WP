<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Enside
 */

$enside_theme_options = enside_get_theme_options();
?>

<?php
// PAGE SETTINGS
$page_stick_footer = get_post_meta( $post->ID, '_page_stick_footer_value', true );

$page_sidebarposition = get_post_meta( $post->ID, '_page_sidebarposition_value', true );
$page_notdisplaytitle = get_post_meta( $post->ID, '_page_notdisplaytitle_value', true );
$page_transparent_header = get_post_meta( $post->ID, '_page_transparent_header_value', true );

if(isset($page_transparent_header)&&($page_transparent_header)) {

  wp_add_inline_script( 'enside-script', '(function($){$(document).ready(function() { "use strict";$("body").addClass("transparent-header"); });})(jQuery);', 'before');
  
}

if(!isset($page_sidebarposition)||($page_sidebarposition == '')) {
  $page_sidebarposition = 0;
}

// Demo settings
if ( defined('DEMO_MODE') && isset($_GET['page_sidebar_position']) ) {
  $enside_theme_options['page_sidebar_position'] = $_GET['page_sidebar_position'];
}

if($page_sidebarposition == "0") {
  if(isset($enside_theme_options['page_sidebar_position'])) {
    $page_sidebarposition = $enside_theme_options['page_sidebar_position'];
  } else {
    $page_sidebarposition = 'disable';
  }
}

$containerclass = 'container';

$page_class = get_post_meta( $post->ID, '_page_class_value', true );

$page_bgcolor = get_post_meta( $post->ID, '_page_bgcolor_value', true );

$page_bgcolor_css = '';

if(isset($page_bgcolor)&&($page_bgcolor<>'')) {
    $page_bgcolor_css = 'background-color: '.$page_bgcolor;
}
else
{
    $page_bgcolor_css = '';
}

if($page_stick_footer) {
  $page_class .= ' stick-to-footer';
}

if(is_active_sidebar( 'page-sidebar' ) && ($page_sidebarposition <> 'disable')) {
  $span_class = 'col-md-9';
}
else {
  $span_class = 'col-md-12';
}

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
// PAGE SETTINGS END

// Demo settings
if ( defined('DEMO_MODE') && isset($_GET['page_title_width']) ) {
  $enside_theme_options['page_title_width'] = $_GET['page_title_width'];
}

// Fullwidth page title
if(isset($enside_theme_options['page_title_width']) && $enside_theme_options['page_title_width'] == 'boxed') {
  $page_title_layout_class = 'container';
} else {
  $page_title_layout_class = 'container-fluid';
}

// Demo settings
if ( defined('DEMO_MODE') && isset($_GET['page_title_align']) ) {
  $enside_theme_options['page_title_align'] = $_GET['page_title_align'];
}

// Page title align
if(isset($enside_theme_options['page_title_align'])) {
  $page_title_align_class = 'text-'.$enside_theme_options['page_title_align'];
} else {
  $page_title_align_class = 'text-left';
}

// Demo settings
if ( defined('DEMO_MODE') && isset($_GET['page_title_texttransform']) ) {
  $enside_theme_options['page_title_texttransform'] = $_GET['page_title_texttransform'];
}

// Page title text transform
if(isset($enside_theme_options['page_title_texttransform'])) {
  $page_title_texttransform_class = 'texttransform-'.$enside_theme_options['page_title_texttransform'];
} else {
  $page_title_texttransform_class = 'texttransform-uppercase';
}

?>
<div class="content-block <?php echo esc_attr($page_class); ?>"<?php if($page_bgcolor_css<>'') { echo ' data-style="'.esc_attr($page_bgcolor_css).'"'; }; ?>>
  <?php if(!$page_notdisplaytitle): ?>
  <div class="container-bg<?php echo esc_attr($header_background_class); ?> <?php echo esc_attr($page_title_layout_class); ?>" data-style="<?php echo esc_attr($header_background_image_style); ?>">
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
    <?php enside_show_breadcrumbs(); ?>
    
  </div>
  <?php endif; ?>
  <div class="page-container <?php echo esc_attr($containerclass); ?>">
    <div class="row">
      <?php if ( is_active_sidebar( 'page-sidebar' ) && ( $page_sidebarposition == 'left')) : ?>
      <div class="col-md-3 main-sidebar sidebar">
        <ul id="main-sidebar">
          <?php dynamic_sidebar( 'page-sidebar' ); ?>
        </ul>
      </div>
      <?php endif; ?>
			<div class="<?php echo esc_attr($span_class);?> entry-content">
      
      <article>
				<?php the_content(); ?>
      </article>
    
        <?php 
        // If comments are open or we have at least one comment, load up the comment template
        if ( comments_open() || '0' != get_comments_number() )
            comments_template();
        ?>
        
			</div>
      <?php if ( is_active_sidebar( 'page-sidebar' ) && ( $page_sidebarposition == 'right')) : ?>
      <div class="col-md-3 main-sidebar sidebar">
        <ul id="main-sidebar">
          <?php dynamic_sidebar( 'page-sidebar' ); ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>