<?php
/**
 * Template for displaying all pages.
 *
 * @package BH_Starter
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="page-banner">
	<div class="bh-container">
		<h1 class="page-banner-title"><?php the_title(); ?></h1>
	</div>
</div>

<div class="single-post-content">
	<div class="bh-container">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bh-starter' ),
					'after'  => '</div>',
				) );
				?>
			</div>
		</article>

		<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>
	</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
