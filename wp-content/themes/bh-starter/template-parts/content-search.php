<?php
/**
 * Template part for search results.
 *
 * @package BH_Starter
 */
?>
<article class="blog-card" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="blog-card-image">
			<?php the_post_thumbnail( 'bh-blog-thumb' ); ?>
		</a>
	<?php endif; ?>

	<div class="blog-card-body">
		<div class="blog-card-meta">
			<span class="blog-card-category"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
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
