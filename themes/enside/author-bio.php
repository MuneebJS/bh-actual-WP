<?php
/*
*	Posts Author info template
*/
?>
<div class="author-bio">
	<div class="author-image">
		<?php echo get_avatar( get_the_author_meta('email'), '100' ); ?>
	</div>
	<div class="author-info">
		<p class="author-title"><?php esc_html_e("Written by", 'enside'); ?> <strong><?php the_author_link(); ?></strong></p>
		<p class="author-description"><?php the_author_meta('description'); ?></p>
	</div>
	<div class="clear"></div>
</div>