<?php
/**
 * Featured blog posts section for the front page.
 *
 * @package BH_Starter
 */

$bh_blog_query = new WP_Query( array(
	'posts_per_page'      => 3,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
) );

if ( ! $bh_blog_query->have_posts() ) {
	return;
}
?>

<section class="blog-section bh-section" id="blog">
	<div class="bh-container">

		<div class="section-header">
			<span class="section-label"><?php esc_html_e( 'Latest News', 'bh-starter' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Explore Our Blog', 'bh-starter' ); ?></h2>
			<p class="section-subtitle"><?php esc_html_e( 'Stay up to date with our latest stories, updates, and insights.', 'bh-starter' ); ?></p>
		</div>

		<div class="blog-grid">
			<?php
			$counter = 0;
			while ( $bh_blog_query->have_posts() ) :
				$bh_blog_query->the_post();
				$counter++;
			?>
				<article class="blog-card">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="blog-card-image">
							<?php the_post_thumbnail( 'bh-blog-thumb' ); ?>
						</a>
					<?php endif; ?>
					<div class="blog-card-body">
						<div class="blog-card-meta">
							<span class="blog-card-category"><?php echo esc_html( strip_tags( get_the_category_list( ', ' ) ) ); ?></span>
							<span>&middot;</span>
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						</div>
						<h3 class="blog-card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<p class="blog-card-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<a href="<?php the_permalink(); ?>" class="blog-card-link">
							<?php esc_html_e( 'Read more', 'bh-starter' ); ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
						</a>
					</div>
				</article>
			<?php endwhile; ?>
		</div>

	</div>
</section>

<?php wp_reset_postdata(); ?>
