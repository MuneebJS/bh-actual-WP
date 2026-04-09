<?php
/**
 * Core products section.
 *
 * @package BH_Starter
 */

$bh_products = array(
	array(
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
		'title' => __( 'Inclusive Braille Books', 'bh-starter' ),
		'desc'  => __( 'Dual-script textbooks combining Braille and Urdu text for inclusive classrooms.', 'bh-starter' ),
	),
	array(
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
		'title' => __( 'Inclusive Braille Forms', 'bh-starter' ),
		'desc'  => __( 'Accessible form designs enabling independent document completion for all users.', 'bh-starter' ),
	),
	array(
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 10 3 12 0v-5"/></svg>',
		'title' => __( 'Inclusive Braille Noorani Qaida', 'bh-starter' ),
		'desc'  => __( 'Braille editions of the Noorani Qaida for inclusive religious education.', 'bh-starter' ),
	),
	array(
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>',
		'title' => __( 'Urdu/English to Braille Mobile Apps', 'bh-starter' ),
		'desc'  => __( 'Real-time text-to-Braille conversion apps for mobile devices.', 'bh-starter' ),
	),
	array(
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
		'title' => __( 'Accessibility Software for Banks', 'bh-starter' ),
		'desc'  => __( 'Banking-grade accessibility solutions enabling financial independence.', 'bh-starter' ),
	),
);
?>

<section class="products-section bh-section" id="products">
	<div class="bh-container">

		<div class="section-header">
			<span class="section-label"><?php esc_html_e( 'What We Build', 'bh-starter' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Our Core Products', 'bh-starter' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Technology-driven solutions making education and everyday life accessible for visually impaired communities.', 'bh-starter' ); ?></p>
		</div>

		<div class="products-grid">
			<?php foreach ( $bh_products as $i => $product ) : ?>
				<div class="product-card">
					<div class="product-card-icon" aria-hidden="true">
						<?php echo $product['icon']; ?>
					</div>
					<h3 class="product-card-title"><?php echo esc_html( $product['title'] ); ?></h3>
					<p class="product-card-desc"><?php echo esc_html( $product['desc'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>

	</div>
</section>
