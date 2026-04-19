<?php
/**
 * Virtual template: single product (routed via ?bh_product=slug → /product/slug/).
 *
 * @package BH_Starter
 */

$slug    = get_query_var( 'bh_product' );
$product = bh_starter_get_product_by_slug( $slug );

get_header();

$images       = isset( $product['images'] ) && is_array( $product['images'] ) ? $product['images'] : array();
$image_urls   = array();
$dir          = bh_starter_products_images_dir();
foreach ( $images as $rel ) {
	$path = $dir . ltrim( str_replace( '\\', '/', $rel ), '/' );
	if ( is_readable( $path ) ) {
		$image_urls[] = array(
			'url' => bh_starter_products_image_url( $rel ),
			'alt' => $product['name'],
		);
	}
}
$primary_url = ! empty( $image_urls ) ? $image_urls[0]['url'] : '';
$description = isset( $product['description'] ) && is_array( $product['description'] ) ? $product['description'] : array();
$app_details = isset( $product['app_details'] ) && is_array( $product['app_details'] ) ? $product['app_details'] : array();
$features    = isset( $app_details['features'] ) && is_array( $app_details['features'] ) ? $app_details['features'] : array();
$screenshots = isset( $app_details['screenshots'] ) && is_array( $app_details['screenshots'] ) ? $app_details['screenshots'] : array();
$show_gallery = ! empty( $image_urls ) || empty( $app_details );
$grid_class   = 'product-detail-grid';

if ( ! $show_gallery ) {
	$grid_class .= ' product-detail-grid--no-gallery';
}
?>

<div class="page-banner page-banner--product">
	<div class="bh-container">
		<p class="page-banner-breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'bh-starter' ); ?></a>
			<span aria-hidden="true"> / </span>
			<a href="<?php echo esc_url( bh_starter_products_archive_url() ); ?>"><?php esc_html_e( 'Products', 'bh-starter' ); ?></a>
			<span aria-hidden="true"> / </span>
			<span><?php echo esc_html( $product['name'] ); ?></span>
		</p>
		<h1 class="page-banner-title"><?php echo esc_html( $product['name'] ); ?></h1>
		<p class="page-banner-lead"><?php echo esc_html( $product['short'] ); ?></p>
	</div>
</div>

	<div class="product-detail-wrap">
		<div class="bh-container">
			<div class="<?php echo esc_attr( $grid_class ); ?>">
				<?php if ( $show_gallery ) : ?>
					<div class="product-detail-gallery" data-product-gallery>
						<?php if ( ! empty( $image_urls ) ) : ?>
							<div class="product-detail-main">
								<img
									id="product-detail-main-img"
									src="<?php echo esc_url( $primary_url ); ?>"
									alt="<?php echo esc_attr( $product['name'] ); ?>"
									width="960"
									height="600"
									decoding="async"
									fetchpriority="high"
								>
							</div>
							<?php if ( count( $image_urls ) > 1 ) : ?>
								<ul class="product-detail-thumbs" role="list">
									<?php foreach ( $image_urls as $i => $img ) : ?>
										<li>
											<button
												type="button"
												class="product-detail-thumb<?php echo 0 === $i ? ' is-active' : ''; ?>"
												data-full-src="<?php echo esc_url( $img['url'] ); ?>"
												aria-label="<?php echo esc_attr( sprintf( /* translators: %d: image number */ __( 'Show image %d', 'bh-starter' ), $i + 1 ) ); ?>"
												aria-pressed="<?php echo 0 === $i ? 'true' : 'false'; ?>"
											>
												<img src="<?php echo esc_url( $img['url'] ); ?>" alt="" loading="lazy" decoding="async" width="160" height="120">
											</button>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						<?php else : ?>
							<div class="product-detail-empty">
								<div class="product-detail-empty-icon" aria-hidden="true"><?php echo $product['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<div class="product-detail-copy">
				<?php foreach ( $description as $para ) : ?>
					<p><?php echo esc_html( $para ); ?></p>
				<?php endforeach; ?>
				<?php if ( ! empty( $app_details ) ) : ?>
					<section class="bh-product-apps">
						<?php if ( ! empty( $app_details['lead'] ) ) : ?>
							<p class="bh-product-apps__lead"><?php echo esc_html( $app_details['lead'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $app_details['store_url'] ) ) : ?>
							<p>
								<a class="bh-btn bh-btn--primary bh-product-apps__store-link" href="<?php echo esc_url( $app_details['store_url'] ); ?>" target="_blank" rel="noopener noreferrer">
									<?php echo esc_html( ! empty( $app_details['store_label'] ) ? $app_details['store_label'] : __( 'Get it on Google Play', 'bh-starter' ) ); ?>
								</a>
							</p>
						<?php endif; ?>
						<?php if ( ! empty( $features ) ) : ?>
							<ul class="bh-product-apps__features">
								<?php foreach ( $features as $feature ) : ?>
									<li><?php echo esc_html( $feature ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php if ( ! empty( $screenshots ) ) : ?>
							<div class="bh-product-apps__gallery">
								<?php foreach ( $screenshots as $index => $screen ) : ?>
									<figure class="bh-product-apps__shot">
										<img src="<?php echo esc_url( bh_starter_mobile_apps_image_url( $screen ) ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %d: app screenshot number */ __( 'Boltay Huroof app screenshot %d', 'bh-starter' ), $index + 1 ) ); ?>" loading="lazy">
									</figure>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</section>
				<?php endif; ?>
				<div class="product-detail-actions">
					<a class="bh-btn bh-btn--primary" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">
						<?php esc_html_e( 'Get in Touch', 'bh-starter' ); ?>
					</a>
					<a class="bh-btn bh-btn--outline" href="<?php echo esc_url( bh_starter_products_archive_url() ); ?>">
						<?php esc_html_e( 'All products', 'bh-starter' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
