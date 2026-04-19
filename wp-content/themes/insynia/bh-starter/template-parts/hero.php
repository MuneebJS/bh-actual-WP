<?php
/**
 * Hero section for the front page.
 *
 * @package BH_Starter
 */
?>
<section class="hero-section">
	<div class="bh-container">
		<div class="hero-inner">

			<div class="hero-content">
				<div class="hero-badge">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
					<?php esc_html_e( 'Accessibility-First Solutions', 'bh-starter' ); ?>
				</div>

				<h1 class="hero-title">
					<?php esc_html_e( 'Inclusive Technology for', 'bh-starter' ); ?>
					<span class="text-accent"><?php esc_html_e( 'Everyone', 'bh-starter' ); ?></span>
				</h1>

				<p class="hero-description">
					<?php esc_html_e( 'Boltay Huroof creates inclusive Braille solutions and accessible technology to empower visually impaired communities across Pakistan.', 'bh-starter' ); ?>
				</p>

				<div class="hero-actions">
					<a href="#products" class="bh-btn bh-btn--primary bh-btn--lg">
						<?php esc_html_e( 'Explore Products', 'bh-starter' ); ?>
					</a>
					<a href="#about" class="bh-btn bh-btn--outline bh-btn--lg">
						<?php esc_html_e( 'Learn More', 'bh-starter' ); ?>
					</a>
				</div>
			</div>

			<div class="hero-visual">
				<div class="hero-visual-card">
					<div class="hero-card-icon" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
					</div>
					<div class="hero-card-label"><?php esc_html_e( 'Inclusive Braille Solutions', 'bh-starter' ); ?></div>
					<div class="hero-card-sublabel"><?php esc_html_e( 'Books, Forms, Mobile Apps & More', 'bh-starter' ); ?></div>
				</div>
			</div>

		</div>
	</div>
</section>
