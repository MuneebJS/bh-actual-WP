<?php
/**
 * Template part for when no results are found.
 *
 * @package BH_Starter
 */
?>
<div style="text-align:center;padding:var(--space-16) 0;">
	<h2><?php esc_html_e( 'Nothing found', 'bh-starter' ); ?></h2>
	<p style="color:var(--color-text-light);margin:var(--space-4) auto var(--space-8);max-width:480px;">
		<?php if ( is_search() ) : ?>
			<?php esc_html_e( 'Sorry, no results matched your search. Please try different keywords.', 'bh-starter' ); ?>
		<?php else : ?>
			<?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'bh-starter' ); ?>
		<?php endif; ?>
	</p>
	<?php get_search_form(); ?>
</div>
