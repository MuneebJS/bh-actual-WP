<?php
/**
 * Mobile app spotlight section for homepage.
 *
 * @package BH_Starter
 */

$app_product = bh_starter_get_product_by_slug( 'urdu-english-braille-mobile-apps' );

if ( empty( $app_product ) ) {
	return;
}

$app_details = isset( $app_product['app_details'] ) && is_array( $app_product['app_details'] ) ? $app_product['app_details'] : array();
$features    = isset( $app_details['features'] ) && is_array( $app_details['features'] ) ? $app_details['features'] : array();
$screenshots = isset( $app_details['screenshots'] ) && is_array( $app_details['screenshots'] ) ? $app_details['screenshots'] : array();
?>

<section class="bh-section" id="mobile-apps">
	<div class="bh-container">
		<div class="section-header">
			<span class="section-label"><?php esc_html_e( 'Mobile Apps', 'bh-starter' ); ?></span>
			<h2 class="section-title"><?php echo esc_html( $app_product['name'] ); ?></h2>
			<p class="section-subtitle"><?php echo esc_html( $app_product['short'] ); ?></p>
		</div>
		<div class="bh-home-apps">
			<?php if ( ! empty( $app_details['lead'] ) ) : ?>
				<p class="bh-home-apps__lead"><?php echo esc_html( $app_details['lead'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $app_details['store_url'] ) ) : ?>
				<p>
					<a class="bh-btn bh-btn--primary bh-home-apps__store-link" href="<?php echo esc_url( $app_details['store_url'] ); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo esc_html( ! empty( $app_details['store_label'] ) ? $app_details['store_label'] : __( 'Get it on Google Play', 'bh-starter' ) ); ?>
					</a>
				</p>
			<?php endif; ?>
			<?php if ( ! empty( $features ) ) : ?>
				<ul class="bh-home-apps__features">
					<?php foreach ( $features as $feature ) : ?>
						<li><?php echo esc_html( $feature ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<?php if ( ! empty( $screenshots ) ) : ?>
				<div class="bh-home-apps__gallery">
					<?php foreach ( $screenshots as $index => $screen ) : ?>
						<figure class="bh-home-apps__shot">
							<img src="<?php echo esc_url( bh_starter_mobile_apps_image_url( $screen ) ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %d: app screenshot number */ __( 'Boltay Huroof app screenshot %d', 'bh-starter' ), $index + 1 ) ); ?>" loading="lazy">
						</figure>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
