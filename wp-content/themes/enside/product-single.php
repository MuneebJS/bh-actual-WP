<?php
/**
 * Single product (/products/{slug}/).
 *
 * @package Enside
 */

get_header();

$slug    = get_query_var( 'enside_product' );
$product = $slug ? enside_get_product_by_slug( $slug ) : null;

if ( ! $product ) {
	get_footer();
	return;
}

$enside_theme_options = enside_get_theme_options();

$page_title_layout_class = ( isset( $enside_theme_options['page_title_width'] ) && 'boxed' === $enside_theme_options['page_title_width'] )
	? 'container'
	: 'container-fluid';

$page_title_align_class = isset( $enside_theme_options['page_title_align'] )
	? 'text-' . $enside_theme_options['page_title_align']
	: 'text-left';

$page_title_texttransform_class = isset( $enside_theme_options['page_title_texttransform'] )
	? 'texttransform-' . $enside_theme_options['page_title_texttransform']
	: 'texttransform-uppercase';

$archive_url = enside_products_archive_url();
?>
<div class="content-block enside-products-catalog-block enside-product-detail-block">
	<div class="container-bg <?php echo esc_attr( $page_title_layout_class ); ?>">
		<div class="container-bg-overlay">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="page-item-title">
							<h1 class="<?php echo esc_attr( $page_title_align_class ); ?> <?php echo esc_attr( $page_title_texttransform_class ); ?>">
								<?php echo esc_html( $product['name'] ); ?>
							</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php enside_show_breadcrumbs(); ?>
	</div>

	<div class="page-container container enside-product-detail-wrap">
		<div class="row">
			<div class="col-md-12 entry-content">
				<p class="enside-product-back">
					<a href="<?php echo esc_url( $archive_url ); ?>"><?php esc_html_e( '← All products', 'enside' ); ?></a>
				</p>
				<div class="enside-product-description">
					<?php echo wp_kses_post( wpautop( $product['description'] ) ); ?>
				</div>
				<?php if ( ! empty( $product['images'] ) && is_array( $product['images'] ) ) : ?>
				<div class="enside-product-gallery">
					<h2 class="enside-product-gallery-heading"><?php esc_html_e( 'Gallery', 'enside' ); ?></h2>
					<div class="row enside-product-gallery-grid">
						<?php foreach ( $product['images'] as $img_path ) : ?>
							<?php
							$src = enside_product_image_url( $img_path );
							if ( ! enside_product_image_exists( $img_path ) ) {
								continue;
							}
							?>
						<div class="col-sm-6 col-xs-12 enside-product-gallery-item">
							<a class="enside-product-gallery-link" href="<?php echo esc_url( $src ); ?>" target="_blank" rel="noopener noreferrer">
								<img
									class="enside-product-gallery-image"
									src="<?php echo esc_url( $src ); ?>"
									alt="<?php echo esc_attr( wp_strip_all_tags( $product['name'] ) ); ?>"
									loading="lazy"
									decoding="async"
								/>
							</a>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();
