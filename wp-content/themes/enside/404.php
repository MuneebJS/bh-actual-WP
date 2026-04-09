<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Enside
 */

get_header(); ?>
<div class="content-block">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-404">
					<div class="page-404-box">
					<h3><?php esc_html_e( 'Page not found', 'enside' ); ?></h3>
					<h1><?php esc_html_e("404", 'enside'); ?></h1>
					</div>
					<p><?php esc_html_e( 'You may have typed the address incorrectly or you may have used an outdated link. Try search our site.', 'enside' ); ?></p>
					<div class="search-form">
						<?php get_search_form(true); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>