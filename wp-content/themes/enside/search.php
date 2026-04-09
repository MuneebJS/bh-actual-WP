<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Enside
 */

get_header(); 

$enside_theme_options = enside_get_theme_options();

// Demo options
if ( defined('DEMO_MODE') && isset($_GET['blog_layout']) ) {
  $enside_theme_options['blog_layout'] = $_GET['blog_layout'];
}

$search_sidebarposition = esc_html($enside_theme_options['search_sidebar_position']);

if(is_active_sidebar( 'main-sidebar' ) && ($search_sidebarposition <> 'disable') ) {
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
?>
<div class="content-block">
<div class="container-bg <?php echo esc_attr($page_title_layout_class); ?>">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="page-item-title">
          <h1 class="<?php echo esc_attr($page_title_align_class); ?> <?php echo esc_attr($page_title_texttransform_class); ?>"><?php printf( wp_kses_post(__('Search Results for: %s', 'enside')), '<span>' . get_search_query() . '</span>' ); ?></h1>
        </div>
      </div>
    </div>
  </div>
  <?php enside_show_breadcrumbs(); ?>
</div>
<div class="container">
	<div class="row">

<?php if ( is_active_sidebar( 'main-sidebar' ) && ( $search_sidebarposition == 'left')) : ?>
		<div class="col-md-3 main-sidebar sidebar">
		<ul id="main-sidebar">
		  <?php dynamic_sidebar( 'main-sidebar' ); ?>
		</ul>
		</div>
		<?php endif; ?>
		<div class="<?php echo esc_attr($span_class); ?>">
		<?php /* Start the Loop */ ?>
			<?php if ( have_posts() ) : ?>
				<div class="blog-layout-<?php echo esc_attr($blog_layout); ?> mgt-post-list clearfix">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'search' ); ?>

				<?php endwhile; ?>
				</div>

				<?php enside_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'search' ); ?>

			<?php endif; ?>
		</div>
		<?php if ( is_active_sidebar( 'main-sidebar' ) && ( $search_sidebarposition == 'right')) : ?>
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