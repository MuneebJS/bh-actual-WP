<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$enside_theme_options = enside_get_theme_options();

// Remove default breadscrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

// Sidebar position
// Demo settings
if ( defined('DEMO_MODE') && isset($_GET['woocommerce_sidebar_position']) ) {
  $enside_theme_options['woocommerce_sidebar_position'] = $_GET['woocommerce_sidebar_position'];
}

if(isset($enside_theme_options['woocommerce_sidebar_position'])) {
	$page_sidebarposition = $enside_theme_options['woocommerce_sidebar_position'];
} else {
	$page_sidebarposition = 'disable';
}

if(is_active_sidebar( 'woocommerce-sidebar' ) && ($page_sidebarposition <> 'disable')) {
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

// Products per row

// Demo settings
if ( defined('DEMO_MODE') && isset($_GET['wc_products_per_row']) ) {
  $enside_theme_options['wc_products_per_row'] = $_GET['wc_products_per_row'];
}

if(isset($enside_theme_options['wc_products_per_row'])) {
	$wc_products_per_row = $enside_theme_options['wc_products_per_row'];
} else {
	$wc_products_per_row = 3;
}

// Shop page title background image
if(!is_product_category() && isset($enside_theme_options['shop_page_title_image']) && $enside_theme_options['shop_page_title_image'] <> '') {
  $header_background_image_style = 'background-image: url('.$enside_theme_options['shop_page_title_image'].');';
  $header_background_class = ' with-bg';

} else {
  $header_background_image_style = '';
  $header_background_class = '';
}

// Title background image for category
if(isset($enside_theme_options['shop_category_image_title']) && $enside_theme_options['shop_category_image_title']) {
	if ( is_product_category() ) {
		    global $wp_query; // required by WooCommerce to get current category object: https://docs.woocommerce.com/document/woocommerce-display-category-image-on-category-archive/

		    $cat = $wp_query->get_queried_object();
		    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		    $cat_image = wp_get_attachment_url( $thumbnail_id );
		    if ( $cat_image ) {
		    	$header_background_image_style = 'background-image: url('.$cat_image.');';
		    	$header_background_class = ' with-bg';
			}
	}
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<div class="container-bg<?php echo esc_attr($header_background_class); ?> <?php echo esc_attr($page_title_layout_class); ?>" data-style="<?php echo esc_attr($header_background_image_style); ?>">
				<div class="container-bg-overlay">
				  <div class="container">
				    <div class="row">
				      <div class="col-md-12">
				        <div class="page-item-title">
				          <h1 class="<?php echo esc_attr($page_title_align_class); ?> <?php echo esc_attr($page_title_texttransform_class); ?>">
					
							<?php woocommerce_page_title(); ?>
							
				          </h1>
				        </div>
				      </div>
				    </div>
				  </div>
			    </div>
			  <?php enside_show_breadcrumbs(); ?>
			</div>

		<?php endif; ?>
	 <div class="page-container container">
    	<div class="row">
			<?php if ( is_active_sidebar( 'woocommerce-sidebar' ) && ( $page_sidebarposition == 'left')) : ?>
			<div class="col-md-3 main-sidebar sidebar">
				<ul id="woocommerce-sidebar">
				  <?php dynamic_sidebar( 'woocommerce-sidebar' ); ?>
				</ul>
			</div>
			<?php endif; ?>
    		<div class="<?php echo esc_attr($span_class); ?>">
		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			<div class="columns-<?php echo esc_attr($wc_products_per_row); ?>">
			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
			</div>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
			<?php if ( is_active_sidebar( 'woocommerce-sidebar' ) && ( $page_sidebarposition == 'right')) : ?>
			<div class="col-md-3 main-sidebar sidebar">
				<ul id="woocommerce-sidebar">
				  <?php dynamic_sidebar( 'woocommerce-sidebar' ); ?>
				</ul>
			</div>
			<?php endif; ?>

			</div>

			
		</div>
	</div>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>
