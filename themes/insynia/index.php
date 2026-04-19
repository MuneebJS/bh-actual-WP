<?php
/**
 * The main template file.
 *
 * @package BH_Starter
 */

get_header();
?>

<div class="page-banner">
	<div class="bh-container">
		<h1 class="page-banner-title"><?php esc_html_e( 'Blog', 'bh-starter' ); ?></h1>
	</div>
</div>

<div class="blog-archive bh-container">
	<?php if ( have_posts() ) : ?>
		<div class="blog-archive-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content' ); ?>
			<?php endwhile; ?>
		</div>
		<?php bh_starter_content_nav(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
