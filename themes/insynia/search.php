<?php
/**
 * Search results template.
 *
 * @package BH_Starter
 */

get_header();
?>

<div class="page-banner">
	<div class="bh-container">
		<h1 class="page-banner-title">
			<?php printf( esc_html__( 'Search Results for: %s', 'bh-starter' ), '<span style="color:var(--color-primary)">' . get_search_query() . '</span>' ); ?>
		</h1>
	</div>
</div>

<div class="blog-archive bh-container">
	<?php if ( have_posts() ) : ?>
		<div class="blog-archive-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'search' ); ?>
			<?php endwhile; ?>
		</div>
		<?php bh_starter_content_nav(); ?>
	<?php else : ?>
		<div style="text-align:center;padding:var(--space-16) 0;">
			<h2><?php esc_html_e( 'Nothing found', 'bh-starter' ); ?></h2>
			<p style="color:var(--color-text-light);margin:var(--space-4) auto var(--space-8);max-width:480px;">
				<?php esc_html_e( 'Sorry, no results were found. Please try a different search term.', 'bh-starter' ); ?>
			</p>
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
