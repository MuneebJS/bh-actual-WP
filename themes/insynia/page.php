<?php
/**
 * Template for displaying all pages.
 *
 * @package BH_Starter
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="page-banner">
	<div class="bh-container">
		<h1 class="page-banner-title"><?php the_title(); ?></h1>
	</div>
</div>

<div class="single-post-content">
	<div class="bh-container">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php
				$bh_is_mobile_apps_page = is_page( array( 'mobile-apps', 'mobile-app' ) );

				if ( ! $bh_is_mobile_apps_page ) {
					$bh_page_title = get_the_title();
					if ( is_string( $bh_page_title ) && false !== stripos( $bh_page_title, 'mobile app' ) ) {
						$bh_is_mobile_apps_page = true;
					}
				}

				if ( $bh_is_mobile_apps_page ) :
					$bh_mobile_product = bh_starter_get_product_by_slug( 'urdu-english-braille-mobile-apps' );
					$bh_app_details    = isset( $bh_mobile_product['app_details'] ) && is_array( $bh_mobile_product['app_details'] ) ? $bh_mobile_product['app_details'] : array();
					$bh_android_link   = isset( $bh_app_details['store_url'] ) ? $bh_app_details['store_url'] : '';
					$bh_store_label    = isset( $bh_app_details['store_label'] ) ? $bh_app_details['store_label'] : __( 'Get it on Google Play', 'bh-starter' );
					$bh_screenshots    = isset( $bh_app_details['screenshots'] ) && is_array( $bh_app_details['screenshots'] ) ? $bh_app_details['screenshots'] : array();
					?>
					<section class="bh-mobile-apps">
						<p class="bh-mobile-apps__lead"><?php echo esc_html( ! empty( $bh_app_details['lead'] ) ? $bh_app_details['lead'] : __( 'Download our Android app from Google Play.', 'bh-starter' ) ); ?></p>
						<?php if ( ! empty( $bh_android_link ) ) : ?>
							<p>
								<a class="bh-btn bh-btn--primary bh-mobile-apps__store-link" href="<?php echo esc_url( $bh_android_link ); ?>" target="_blank" rel="noopener noreferrer">
									<?php echo esc_html( $bh_store_label ); ?>
								</a>
							</p>
						<?php endif; ?>
						<?php if ( ! empty( $bh_screenshots ) ) : ?>
							<div class="bh-mobile-apps__gallery">
								<?php foreach ( $bh_screenshots as $bh_index => $bh_screen ) : ?>
									<img src="<?php echo esc_url( bh_starter_mobile_apps_image_url( $bh_screen ) ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %d: app screenshot number */ __( 'Boltay Huroof app screenshot %d', 'bh-starter' ), $bh_index + 1 ) ); ?>" loading="lazy">
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</section>
				<?php endif; ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bh-starter' ),
					'after'  => '</div>',
				) );
				?>
			</div>
		</article>

		<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>
	</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
