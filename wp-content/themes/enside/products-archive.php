<?php
/**
 * Products catalog archive (/products/).
 *
 * @package Enside
 */

get_header();

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

$products = enside_get_products();
?>
<div class="content-block enside-products-catalog-block">
	<div class="container-bg <?php echo esc_attr( $page_title_layout_class ); ?>">
		<div class="container-bg-overlay">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="page-item-title">
							<h1 class="<?php echo esc_attr( $page_title_align_class ); ?> <?php echo esc_attr( $page_title_texttransform_class ); ?>">
								<?php esc_html_e( 'Our Products', 'enside' ); ?>
							</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php enside_show_breadcrumbs(); ?>
	</div>

	<div class="page-container container enside-products-catalog-wrap">
		<div class="row">
			<div class="col-md-12 entry-content">
				<p class="enside-products-intro"><?php esc_html_e( 'Explore our inclusive Braille and accessibility offerings.', 'enside' ); ?></p>
				<div class="row enside-products-grid">
					<?php foreach ( $products as $product ) : ?>
						<?php
						$thumb = enside_product_primary_image_url( $product );
						$link  = enside_product_permalink( $product['slug'] );
						?>
					<div class="col-md-4 col-sm-6 col-xs-12 enside-products-grid-item">
						<article class="enside-product-tile">
							<a class="enside-product-tile-link" href="<?php echo esc_url( $link ); ?>">
								<?php if ( '' !== $thumb ) : ?>
								<div class="enside-product-tile-image-wrap">
									<img
										class="enside-product-tile-image"
										src="<?php echo esc_url( $thumb ); ?>"
										alt="<?php echo esc_attr( wp_strip_all_tags( $product['name'] ) ); ?>"
										loading="lazy"
										decoding="async"
									/>
								</div>
								<?php endif; ?>
								<h2 class="enside-product-tile-title"><?php echo esc_html( $product['name'] ); ?></h2>
								<p class="enside-product-tile-excerpt"><?php echo esc_html( wp_trim_words( $product['description'], 24, '…' ) ); ?></p>
								<span class="enside-product-tile-cta"><?php esc_html_e( 'View details', 'enside' ); ?></span>
							</a>
						</article>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();
