<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Enside
 */

get_header();

$enside_theme_options = enside_get_theme_options();

// Demo options
if ( defined('DEMO_MODE') && isset($_GET['blog_layout']) ) {
  $enside_theme_options['blog_layout'] = $_GET['blog_layout'];
}

$archive_sidebarposition = $enside_theme_options['archive_sidebar_position'];

if(is_active_sidebar( 'main-sidebar' ) && ($archive_sidebarposition <> 'disable') ) {
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

// Get current category image
$category = get_category( get_query_var( 'cat' ) );

$header_background_image_style = '';
$header_background_class = '';

if(isset($category->cat_ID)) {
	$cat_id = $category->cat_ID;
	// Get the image ID for the category
	$image_id = get_term_meta ( $cat_id, 'category-image-id', true );

	$category_image_data = wp_get_attachment_image_src( $image_id, 'full' );
	$category_image = $category_image_data[0];

	$header_background_image = $category_image;

	if(isset($header_background_image) && ($header_background_image!== '')) {
	  $header_background_image_style = 'background-image: url('.$header_background_image.');';
	  $header_background_class = ' with-bg';

	  if(isset($enside_theme_options['enable_blog_cat_transparent_header']) && $enside_theme_options['enable_blog_cat_transparent_header']) {
		wp_add_inline_script( 'enside-script', '(function($){$(document).ready(function() { "use strict";$("body").addClass("transparent-header"); });})(jQuery);', 'before');
	  }
	}
}

?>
<div class="content-block">
  <div class="container-bg<?php echo esc_attr($header_background_class); ?> <?php echo esc_attr($page_title_layout_class); ?>" data-style="<?php echo esc_attr($header_background_image_style); ?>">
    <div class="container-bg-overlay">
	    <div class="container">
	      <div class="row">
	        <div class="col-md-12">
	          <div class="page-item-title">
	            <h1 class="<?php echo esc_attr($page_title_align_class); ?> <?php echo esc_attr($page_title_texttransform_class); ?>"><?php
				if ( is_category() ) :
					printf( wp_kses_post(__( '%s', 'enside' )), '<span>' . single_cat_title( '', false ) . '</span>' );

				elseif ( is_tag() ) :
					printf( wp_kses_post(__('Tag: %s', 'enside' )), '<span>' . single_tag_title( '', false ) . '</span>' );

				elseif ( is_author() ) :
					/* Queue the first post, that way we know
					 * what author we're dealing with (if that is the case).
					*/
					the_post();
					printf( wp_kses_post(__( 'Author: %s', 'enside' )), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
					/* Since we called the_post() above, we need to
					 * rewind the loop back to the beginning that way
					 * we can run the loop properly, in full.
					 */
					rewind_posts();

				elseif ( is_day() ) :
					printf( wp_kses_post(__('Daily: %s', 'enside' )), '<span>' . get_the_date() . '</span>' );

				elseif ( is_month() ) :
					printf( wp_kses_post(__('Monthly: %s', 'enside' )), '<span>' . get_the_date( 'F Y' ) . '</span>' );

				elseif ( is_year() ) :
					printf( wp_kses_post(__('Yearly: %s', 'enside' )), '<span>' . get_the_date( 'Y' ) . '</span>' );

				elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
					esc_html_e( 'Asides', 'enside' );

				elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
					esc_html_e( 'Images', 'enside');

				elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
					esc_html_e( 'Videos', 'enside' );

				elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
					esc_html_e( 'Quotes', 'enside' );

				elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
					esc_html_e( 'Links', 'enside' );

				else :
					esc_html_e( 'Archives', 'enside' );

				endif;
			?></h1>
	          </div>
	        </div>
	      </div>
	    </div>
    </div>
    <?php enside_show_breadcrumbs(); ?>
  </div>
<div class="container">
	<div class="row">
<?php if ( is_active_sidebar( 'main-sidebar' ) && ( $archive_sidebarposition == 'left')) : ?>
		<div class="col-md-3 main-sidebar sidebar">
		<ul id="main-sidebar">
		  <?php dynamic_sidebar( 'main-sidebar' ); ?>
		</ul>
		</div>
		<?php endif; ?>
		<div class="<?php echo esc_attr($span_class); ?>">

<?php
	if ( is_category() ) :
		// show an optional category description
		$category_description = category_description();
		if ( ! empty( $category_description ) ) :
			echo '<div class="container">
<div class="row">
<div class="col-md-12">'.apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . wp_kses_post($category_description) . '</div>' ).'		</div>
</div>
</div>';
		endif;

	elseif ( is_tag() ) :
		// show an optional tag description
		$tag_description = tag_description();
		if ( ! empty( $tag_description ) ) :
			echo '<div class="container">
<div class="row">
<div class="col-md-12">'.apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . wp_kses_post($tag_description) . '</div>' ).'		</div>
</div>
</div>';
		endif;

	endif;
?>			
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

				<?php get_template_part( 'no-results', 'archive' ); ?>

			<?php endif; ?>
		</div>
		<?php if ( is_active_sidebar( 'main-sidebar' ) && ( $archive_sidebarposition == 'right')) : ?>
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