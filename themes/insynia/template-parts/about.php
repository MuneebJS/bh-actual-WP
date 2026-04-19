<?php
/**
 * About section for the front page.
 *
 * @package BH_Starter
 */
?>
<section class="about-section bh-section bh-section--lg" id="about">
	<div class="bh-container">
		<div class="about-inner">

			<div class="about-content">
				<span class="about-label"><?php esc_html_e( 'About Us', 'bh-starter' ); ?></span>
				<h2 class="about-title"><?php bloginfo( 'name' ); ?></h2>
				<p class="about-description">
					<?php esc_html_e( 'Boltay Huroof (Speaking Words) is a social enterprise dedicated to bridging the accessibility gap for visually impaired individuals in Pakistan through innovative Braille solutions and assistive technology.', 'bh-starter' ); ?>
				</p>
				<a href="#team" class="bh-btn bh-btn--lg" style="background:rgba(255,255,255,.15);color:#fff;border-color:rgba(255,255,255,.3);">
					<?php esc_html_e( 'Meet the Team', 'bh-starter' ); ?>
				</a>
			</div>

			<div class="about-visual">
				<div class="about-card">
					<h3 class="about-card-title"><?php bloginfo( 'name' ); ?></h3>
					<p class="about-card-text">
						<?php esc_html_e( 'We design and produce inclusive Braille books, forms, mobile apps, and accessibility software — making education, banking, and daily life possible for everyone regardless of visual ability.', 'bh-starter' ); ?>
					</p>
				</div>
			</div>

		</div>
	</div>
</section>
