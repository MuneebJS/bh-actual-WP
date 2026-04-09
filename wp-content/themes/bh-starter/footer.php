<?php
/**
 * Theme footer.
 *
 * @package BH_Starter
 */
?>

<footer class="site-footer">
	<div class="bh-container">

		<div class="footer-grid">
			<div>
				<div class="footer-brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php
						$logo_id  = get_theme_mod( 'custom_logo' );
						$logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
						?>
						<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
					<?php else : ?>
						<?php bloginfo( 'name' ); ?>
					<?php endif; ?>
				</div>
				<p class="footer-description">
					<?php echo esc_html( get_bloginfo( 'description' ) ); ?>
				</p>
				<div class="footer-social">
					<a href="https://www.linkedin.com/company/boltay-huroof/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
					</a>
				</div>
			</div>

			<div>
				<h4 class="footer-heading"><?php esc_html_e( 'Products', 'bh-starter' ); ?></h4>
				<div class="footer-links">
					<a href="#"><?php esc_html_e( 'Braille Books', 'bh-starter' ); ?></a>
					<a href="#"><?php esc_html_e( 'Braille Forms', 'bh-starter' ); ?></a>
					<a href="#"><?php esc_html_e( 'Noorani Qaida', 'bh-starter' ); ?></a>
					<a href="#"><?php esc_html_e( 'Mobile Apps', 'bh-starter' ); ?></a>
					<a href="#"><?php esc_html_e( 'Bank Accessibility', 'bh-starter' ); ?></a>
				</div>
			</div>

			<div>
				<h4 class="footer-heading"><?php esc_html_e( 'Company', 'bh-starter' ); ?></h4>
				<div class="footer-links">
					<a href="#"><?php esc_html_e( 'About Us', 'bh-starter' ); ?></a>
					<a href="#"><?php esc_html_e( 'Our Team', 'bh-starter' ); ?></a>
					<a href="#"><?php esc_html_e( 'Blog', 'bh-starter' ); ?></a>
					<a href="#"><?php esc_html_e( 'Contact', 'bh-starter' ); ?></a>
				</div>
			</div>

			<div>
				<h4 class="footer-heading"><?php esc_html_e( 'Resources', 'bh-starter' ); ?></h4>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-links',
					'depth'          => 1,
					'fallback_cb'    => false,
				) );
				?>
			</div>
		</div>

		<div class="footer-bottom">
			<p class="footer-copyright">
				&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'bh-starter' ); ?>
			</p>
			<p class="footer-address">
				<?php esc_html_e( 'Plot No.51, C, East Commercial St, Phase 2 DHA, Karachi 75500', 'bh-starter' ); ?>
			</p>
		</div>

	</div>
</footer>

<button class="scroll-to-top" id="scroll-to-top" aria-label="<?php esc_attr_e( 'Scroll to top', 'bh-starter' ); ?>">
	<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
