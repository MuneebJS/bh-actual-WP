<?php
/**
 * Template for displaying single posts.
 *
 * @package BH_Starter
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="page-banner">
	<div class="bh-container">
		<h1 class="page-banner-title"><?php the_title(); ?></h1>
		<div class="post-meta">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<span class="post-meta-divider"></span>
			<span><?php echo esc_html( strip_tags( get_the_category_list( ', ' ) ) ); ?></span>
			<span class="post-meta-divider"></span>
			<span><?php echo esc_html( get_comments_number() ); ?> <?php esc_html_e( 'comments', 'bh-starter' ); ?></span>
		</div>
	</div>
</div>

<div class="single-post-content">
	<div class="bh-container">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php if ( has_post_thumbnail() ) : ?>
				<div style="max-width:720px;margin:0 auto var(--space-8);">
					<?php the_post_thumbnail( 'bh-blog-wide', array( 'style' => 'border-radius:var(--radius-xl);width:100%;' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bh-starter' ),
					'after'  => '</div>',
				) );
				?>
			</div>

			<?php
			$tags_list = get_the_tag_list( '', '' );
			if ( $tags_list ) :
			?>
				<div class="post-tags">
					<?php echo wp_kses_post( $tags_list ); ?>
				</div>
			<?php endif; ?>

		</article>

		<nav class="post-navigation">
			<?php
			$prev = get_previous_post();
			$next = get_next_post();
			?>
			<div>
				<?php if ( $prev ) : ?>
					<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
						<div class="nav-label"><?php esc_html_e( 'Previous', 'bh-starter' ); ?></div>
						<?php echo esc_html( get_the_title( $prev ) ); ?>
					</a>
				<?php endif; ?>
			</div>
			<div style="text-align:right;">
				<?php if ( $next ) : ?>
					<a href="<?php echo esc_url( get_permalink( $next ) ); ?>">
						<div class="nav-label"><?php esc_html_e( 'Next', 'bh-starter' ); ?></div>
						<?php echo esc_html( get_the_title( $next ) ); ?>
					</a>
				<?php endif; ?>
			</div>
		</nav>

		<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>
	</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
