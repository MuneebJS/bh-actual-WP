<?php
/**
 * @package Enside
 */

$post_classes = get_post_class();

$current_post_class = $post_classes[4];

// This post formats will display content before title
$post_classes_content_top = array('format-audio', 'format-image', 'format-video', 'format-gallery', 'format-status', 'format-link');

?>

<div class="content-block blog-post clearfix">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
				
				<div class="post-content-wrapper">
					<?php 
					if(in_array($current_post_class , $post_classes_content_top)) {

						if($current_post_class !== 'format-image') {
							echo '<div class="entry-content">';
							the_excerpt();
							echo '</div>';
						}
						
						if($current_post_class == 'format-image'): ?>
						<div class="blog-post-thumb text-center">
							<a href="<?php the_permalink(); ?>" rel="bookmark">
							<?php the_post_thumbnail('enside-blog-thumb'); ?>
							</a>
						</div>
							
					<?php
					endif;

					} else {
						if ( has_post_thumbnail() ):
						?>
						<div class="blog-post-thumb text-center">
							<a href="<?php the_permalink(); ?>" rel="bookmark">
							<?php the_post_thumbnail('enside-blog-thumb'); ?>
							</a>
						</div>
						<?php
						endif;
					}
					?>
					<div class="post-content">

						<h2 class="entry-title post-header-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="post-info">
						<span><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_time(get_option( 'date_format' ));  ?></a></span><?php edit_post_link( esc_html__( 'Edit', 'enside' ), ' <span class="edit-link">', '</span>' ); ?>
						</div>
						
						
						
							<?php if(!in_array($current_post_class , $post_classes_content_top)): ?>
							<div class="entry-content">
								<?php 
								
								the_excerpt();
								

								wp_link_pages( array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'enside' ),
									'after'  => '</div>',
								) );
								?>
							</div><!-- .entry-content -->
							<?php endif;?>
						
							
						</div>
		
				</div>
			
		
	</article>
</div>