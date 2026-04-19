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
					$bh_android_link = 'https://play.google.com/store/apps/details?id=com.mega_dealers.boltexponativewind&pcampaignid=web_share';
					?>
					<section class="bh-mobile-apps">
						<p class="bh-mobile-apps__lead"><?php esc_html_e( 'Download our Android app from Google Play.', 'bh-starter' ); ?></p>
						<p>
							<a class="bh-btn bh-btn--primary bh-mobile-apps__store-link" href="<?php echo esc_url( $bh_android_link ); ?>" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'Get it on Google Play', 'bh-starter' ); ?>
							</a>
						</p>
						<div class="bh-mobile-apps__gallery">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/mobile-apps/app-screen-1.png' ); ?>" alt="<?php esc_attr_e( 'Boltay Huroof Android app screen 1', 'bh-starter' ); ?>" loading="lazy">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/mobile-apps/app-screen-2.png' ); ?>" alt="<?php esc_attr_e( 'Boltay Huroof Android app screen 2', 'bh-starter' ); ?>" loading="lazy">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/mobile-apps/app-screen-3.png' ); ?>" alt="<?php esc_attr_e( 'Boltay Huroof Android app screen 3', 'bh-starter' ); ?>" loading="lazy">
						</div>
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
