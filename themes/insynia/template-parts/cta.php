<?php
/**
 * Call-to-action section.
 *
 * @package BH_Starter
 */
?>
<section class="cta-section bh-section bh-section--lg">
	<div class="bh-container">
		<div>
			<h2 class="cta-title"><?php esc_html_e( 'Ready to Make a Difference?', 'bh-starter' ); ?></h2>
			<p class="cta-description"><?php esc_html_e( 'Join us in building a more inclusive world. Get in touch to collaborate or learn more about our products.', 'bh-starter' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="bh-btn bh-btn--primary bh-btn--lg">
				<?php esc_html_e( 'Get in Touch', 'bh-starter' ); ?>
			</a>
		</div>
	</div>
</section>
