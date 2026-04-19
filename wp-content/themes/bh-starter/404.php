<?php
/**
 * 404 page template.
 *
 * @package BH_Starter
 */

get_header();
?>

<div class="error-404-page">
	<div class="bh-container">
		<div class="error-404-code">404</div>
		<h1 class="error-404-title"><?php esc_html_e( 'Page Not Found', 'bh-starter' ); ?></h1>
		<p class="error-404-description">
			<?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'bh-starter' ); ?>
		</p>
		<?php get_search_form(); ?>
		<div style="margin-top:var(--space-6);">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="bh-btn bh-btn--primary">
				<?php esc_html_e( 'Back to Home', 'bh-starter' ); ?>
			</a>
		</div>
	</div>
</div>

<?php get_footer(); ?>
