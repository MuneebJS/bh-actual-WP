<?php
/**
 * Template Name: Awards and Recognitions
 * Description: Showcases Boltay Huroof awards with image galleries.
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

<section class="bh-section bh-awards-showcase">
	<div class="bh-container">
		<?php if ( '' !== trim( wp_strip_all_tags( get_the_content() ) ) ) : ?>
			<div class="bh-awards-showcase__intro">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>

		<?php
		$bh_awards = new WP_Query(
			array(
				'post_type'      => 'bh_award',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				),
			)
		);
		?>

		<?php if ( $bh_awards->have_posts() ) : ?>
			<div class="bh-awards-grid">
				<?php
				while ( $bh_awards->have_posts() ) :
					$bh_awards->the_post();
					$bh_gallery_ids = get_post_meta( get_the_ID(), '_bh_award_gallery_ids', true );
					$bh_gallery_ids = is_string( $bh_gallery_ids ) && '' !== $bh_gallery_ids ? array_filter( array_map( 'absint', explode( ',', $bh_gallery_ids ) ) ) : array();

					if ( empty( $bh_gallery_ids ) ) {
						$bh_featured_id = get_post_thumbnail_id();
						if ( $bh_featured_id ) {
							$bh_gallery_ids[] = absint( $bh_featured_id );
						}
					}
					?>
					<article id="award-<?php the_ID(); ?>" <?php post_class( 'bh-award-card' ); ?>>
						<?php if ( ! empty( $bh_gallery_ids ) ) : ?>
							<div class="bh-award-gallery" aria-label="<?php echo esc_attr( sprintf( __( 'Gallery for %s', 'bh-starter' ), get_the_title() ) ); ?>">
								<?php foreach ( $bh_gallery_ids as $bh_image_id ) : ?>
									<figure class="bh-award-gallery__item">
										<?php echo wp_get_attachment_image( $bh_image_id, 'large', false, array( 'loading' => 'lazy' ) ); ?>
									</figure>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<div class="bh-award-card__content">
							<h2 class="bh-award-card__title"><?php the_title(); ?></h2>
							<div class="bh-award-card__description">
								<?php the_content(); ?>
							</div>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<p class="bh-awards-showcase__empty"><?php esc_html_e( 'No awards added yet. Add awards from the admin panel to display them here.', 'bh-starter' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>
