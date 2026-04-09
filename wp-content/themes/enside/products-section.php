<?php
/**
 * Core products section (hard-coded, no configuration).
 *
 * @package Enside
 */

$enside_core_products = array(
	array(
		'icon' => 'book',
		'title' => 'Inclusive Braille Books',
	),
	array(
		'icon' => 'wpforms',
		'title' => 'Inclusive Braille forms',
	),
	array(
		'icon' => 'graduation-cap',
		'title' => 'Inclusive Braille Noorani Qaida',
	),
	array(
		'icon' => 'mobile',
		'title' => 'Urdu/English to Braille Mobile Apps',
	),
	array(
		'icon' => 'university',
		'title' => 'Accessibility software for banks',
	),
);
?>
<section class="products-section content-block" aria-labelledby="enside-core-products-heading">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2 id="enside-core-products-heading" class="products-section-title"><?php esc_html_e( 'Our Core Products', 'enside' ); ?></h2>
			</div>
		</div>
		<div class="row products-section-grid">
			<?php foreach ( $enside_core_products as $product ) : ?>
				<div class="col-md-4 col-sm-6 col-xs-12 products-section-col">
					<div class="product-card">
						<div class="product-card-icon" aria-hidden="true">
							<i class="fa fa-<?php echo esc_attr( $product['icon'] ); ?>"></i>
						</div>
						<h3 class="product-card-title"><?php echo esc_html( $product['title'] ); ?></h3>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
