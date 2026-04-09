<?php
/**
 * Template Name: Disable Header/Footer
 *
 * @package Enside
 */

get_header('empty');

?>

<?php while ( have_posts() ) : the_post(); ?>
<div class="only-content-page">
	<?php get_template_part( 'content', 'page' ); ?>
</div>
<?php endwhile; // end of the loop. ?>

<?php get_footer('empty'); ?>
