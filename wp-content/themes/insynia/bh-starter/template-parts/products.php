<?php
/**
 * Core products section.
 *
 * @package BH_Starter
 */

$bh_products = bh_starter_get_products_list();
?>

<section class="products-section bh-section" id="products">
	<div class="bh-container">

		<div class="section-header">
			<span class="section-label"><?php esc_html_e( 'What We Build', 'bh-starter' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Our Core Products', 'bh-starter' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Technology-driven solutions making education and everyday life accessible for visually impaired communities.', 'bh-starter' ); ?></p>
		</div>

		<div class="products-grid">
			<?php foreach ( $bh_products as $product ) :
				$link = bh_starter_product_permalink( $product['slug'] );
				?>
				<a class="product-card product-card--link" href="<?php echo esc_url( $link ); ?>">
					<div class="product-card-icon" aria-hidden="true">
						<?php echo $product['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<h3 class="product-card-title"><?php echo esc_html( $product['name'] ); ?></h3>
					<p class="product-card-desc"><?php echo esc_html( $product['short'] ); ?></p>
					<span class="product-card-more">
						<?php esc_html_e( 'Learn more', 'bh-starter' ); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
					</span>
				</a>
			<?php endforeach; ?>
		</div>

		<p class="products-section-cta">
			<a class="bh-btn bh-btn--outline" href="<?php echo esc_url( bh_starter_products_archive_url() ); ?>">
				<?php esc_html_e( 'View all products', 'bh-starter' ); ?>
			</a>
		</p>

	</div>
</section>
