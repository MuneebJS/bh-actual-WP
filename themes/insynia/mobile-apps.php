<?php
/**
 * Standalone mobile apps page for virtual /mobile-apps/ route.
 *
 * @package BH_Starter
 */

get_header();

$bh_mobile_apps = bh_starter_get_mobile_apps_data();
$bh_app_details = isset( $bh_mobile_apps['app_details'] ) && is_array( $bh_mobile_apps['app_details'] ) ? $bh_mobile_apps['app_details'] : array();
$bh_android_link = isset( $bh_app_details['store_url'] ) ? $bh_app_details['store_url'] : '';
$bh_store_label  = isset( $bh_app_details['store_label'] ) ? $bh_app_details['store_label'] : __( 'Get it on Google Play', 'bh-starter' );
$bh_features     = isset( $bh_app_details['features'] ) && is_array( $bh_app_details['features'] ) ? $bh_app_details['features'] : array();
$bh_screenshots  = isset( $bh_app_details['screenshots'] ) && is_array( $bh_app_details['screenshots'] ) ? $bh_app_details['screenshots'] : array();
?>

<div class="page-banner">
	<div class="bh-container">
		<h1 class="page-banner-title"><?php esc_html_e( 'Mobile Apps', 'bh-starter' ); ?></h1>
	</div>
</div>

<div class="single-post-content">
	<div class="bh-container">
		<section class="bh-mobile-apps">
			<?php if ( ! empty( $bh_mobile_apps['short'] ) ) : ?>
				<p class="bh-mobile-apps__lead"><?php echo esc_html( $bh_mobile_apps['short'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $bh_app_details['lead'] ) ) : ?>
				<p><?php echo esc_html( $bh_app_details['lead'] ); ?></p>
			<?php endif; ?>
			<?php if ( ! empty( $bh_android_link ) ) : ?>
				<p>
					<a class="bh-btn bh-btn--primary bh-mobile-apps__store-link" href="<?php echo esc_url( $bh_android_link ); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo esc_html( $bh_store_label ); ?>
					</a>
				</p>
			<?php endif; ?>
			<?php if ( ! empty( $bh_features ) ) : ?>
				<ul class="bh-mobile-apps__features">
					<?php foreach ( $bh_features as $bh_feature ) : ?>
						<li><?php echo esc_html( $bh_feature ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<?php if ( ! empty( $bh_screenshots ) ) : ?>
				<div class="bh-mobile-apps__gallery">
					<?php foreach ( $bh_screenshots as $bh_index => $bh_screen ) : ?>
						<img src="<?php echo esc_url( bh_starter_mobile_apps_image_url( $bh_screen ) ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %d: app screenshot number */ __( 'Boltay Huroof app screenshot %d', 'bh-starter' ), $bh_index + 1 ) ); ?>" loading="lazy">
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</section>
	</div>
</div>

<?php get_footer(); ?>
