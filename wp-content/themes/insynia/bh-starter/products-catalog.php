<?php
/**
 * Products catalog listing (Page template + virtual /products/ route).
 *
 * @package BH_Starter
 */

get_header();

$products = bh_starter_get_products_list();
?>

<div class="page-banner">
	<div class="bh-container">
		<p class="page-banner-breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'bh-starter' ); ?></a>
			<span aria-hidden="true"> / </span>
			<span><?php esc_html_e( 'Products', 'bh-starter' ); ?></span>
		</p>
		<h1 class="page-banner-title"><?php esc_html_e( 'Our Products', 'bh-starter' ); ?></h1>
		<p class="page-banner-lead"><?php esc_html_e( 'Technology-driven solutions making education and everyday life accessible for visually impaired communities.', 'bh-starter' ); ?></p>
	</div>
</div>

<section class="products-catalog bh-section">
	<div class="bh-container">
		<div class="products-catalog-grid">
			<?php foreach ( $products as $product ) :
				$thumb = bh_starter_product_card_image_url( $product );
				$link  = bh_starter_product_permalink( $product['slug'] );
				?>
				<article class="products-catalog-card">
					<a class="products-catalog-card-media" href="<?php echo esc_url( $link ); ?>">
						<?php if ( '' !== $thumb ) : ?>
							<img
								src="<?php echo esc_url( $thumb ); ?>"
								alt=""
								loading="lazy"
								decoding="async"
								width="640"
								height="400"
							>
						<?php else : ?>
							<div class="products-catalog-card-placeholder" aria-hidden="true">
								<span class="products-catalog-card-icon"><?php echo $product['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							</div>
						<?php endif; ?>
					</a>
					<div class="products-catalog-card-body">
						<h2 class="products-catalog-card-title">
							<a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $product['name'] ); ?></a>
						</h2>
						<p class="products-catalog-card-excerpt"><?php echo esc_html( $product['short'] ); ?></p>
						<a class="bh-btn bh-btn--outline bh-btn--sm products-catalog-card-cta" href="<?php echo esc_url( $link ); ?>">
							<?php esc_html_e( 'View details', 'bh-starter' ); ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_footer();
