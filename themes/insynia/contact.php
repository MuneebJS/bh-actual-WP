<?php
/**
 * Standalone contact page for virtual /contact/ route.
 *
 * @package BH_Starter
 */

get_header();
?>

<div class="page-banner">
	<div class="bh-container">
		<h1 class="page-banner-title"><?php esc_html_e( 'Contact', 'bh-starter' ); ?></h1>
	</div>
</div>

<div class="single-post-content">
	<div class="bh-container">
		<section class="bh-mobile-apps">
			<p class="bh-mobile-apps__lead">
				<?php esc_html_e( 'Get in touch with Boltay Huroof for inclusive Braille products, mobile app support, and accessibility software collaboration.', 'bh-starter' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Use the contact methods listed on our social channels or send us a message through your preferred platform, and our team will respond as soon as possible.', 'bh-starter' ); ?>
			</p>
			<p>
				<a class="bh-btn bh-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php esc_html_e( 'Back to Home', 'bh-starter' ); ?>
				</a>
			</p>
		</section>
	</div>
</div>

<?php get_footer(); ?>
