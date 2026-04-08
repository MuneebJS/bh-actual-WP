<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Enside
 */

get_header();

$enside_theme_options = enside_get_theme_options();

// Demo settings
if ( defined('DEMO_MODE') && isset($_GET['blog_sidebar_position']) ) {
  $enside_theme_options['blog_sidebar_position'] = $_GET['blog_sidebar_position'];
}

if ( defined('DEMO_MODE') && isset($_GET['blog_layout']) ) {
  $enside_theme_options['blog_layout'] = $_GET['blog_layout'];
}

$blog_sidebarposition = $enside_theme_options['blog_sidebar_position'];

if(is_active_sidebar( 'main-sidebar' ) && ($blog_sidebarposition <> 'disable') ) {
	$span_class = 'col-md-9';
}
else {
	$span_class = 'col-md-12';
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

// Blog layout
if(isset($enside_theme_options['blog_layout'])) {
  $blog_layout = $enside_theme_options['blog_layout'];
} else {
  $blog_layout = 'regular';
}

// Blog page title
if(isset($enside_theme_options['blog_page_title'])) {
	$blog_page_title = $enside_theme_options['blog_page_title'];
} else {
	$blog_page_title = esc_html__('News', 'enside');
}

// Blog page title background image
if(isset($enside_theme_options['blog_page_title_image']) && $enside_theme_options['blog_page_title_image'] <> '') {
  $header_background_image_style = 'background-image: url('.$enside_theme_options['blog_page_title_image'].');';
  $header_background_class = ' with-bg';

  // Transparent header
  if(isset($enside_theme_options['enable_blog_transparent_header']) && $enside_theme_options['enable_blog_transparent_header']) {
	wp_add_inline_script( 'enside-script', '(function($){$(document).ready(function() { "use strict";$("body").addClass("transparent-header"); });})(jQuery);', 'before');
  }
} else {
  $header_background_image_style = '';
  $header_background_class = '';
}

?>
<div class="content-block">
<div class="container-bg<?php echo esc_attr($header_background_class); ?> <?php echo esc_attr($page_title_layout_class); ?>" data-style="<?php echo esc_attr($header_background_image_style); ?>">
  <div class="container-bg-overlay">
	  <div class="container">
	    <div class="row">
	      <div class="col-md-12">
	        <div class="page-item-title">
	          <h1 class="<?php echo esc_attr($page_title_align_class); ?> <?php echo esc_attr($page_title_texttransform_class); ?>">
	          	<?php echo esc_html($blog_page_title); ?>
	          </h1>
	        </div>
	      </div>
	    </div>
	  </div>
  </div>
  <?php enside_show_breadcrumbs(); ?>
</div>

<?php get_template_part( 'team-members' ); ?>

<?php get_template_part( 'products-section' ); ?>

	<div class="container">
		<div class="row">
			<?php if ( is_active_sidebar( 'main-sidebar' ) && ( $blog_sidebarposition == 'left')) : ?>
			<div class="col-md-3 main-sidebar sidebar">
			<ul id="main-sidebar">
			  <?php dynamic_sidebar( 'main-sidebar' ); ?>
			</ul>
			</div>
			<?php endif; ?>
			<div class="<?php echo esc_attr($span_class); ?>">

			<?php if ( have_posts() ) : ?>

				<div class="blog-layout-<?php echo esc_attr($blog_layout); ?> mgt-post-list clearfix">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>
				</div>

				<?php enside_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'index' ); ?>

			<?php endif; ?>
			</div>
			<?php if ( is_active_sidebar( 'main-sidebar' ) && ( $blog_sidebarposition == 'right')) : ?>
			<div class="col-md-3 main-sidebar sidebar">
			<ul id="main-sidebar">
			  <?php dynamic_sidebar( 'main-sidebar' ); ?>
			</ul>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
