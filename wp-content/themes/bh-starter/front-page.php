<?php
/**
 * Front page template — assembles all homepage sections.
 *
 * @package BH_Starter
 */

get_header();
?>

<?php get_template_part( 'template-parts/hero' ); ?>
<?php get_template_part( 'template-parts/products' ); ?>
<?php get_template_part( 'template-parts/about' ); ?>
<?php get_template_part( 'template-parts/team' ); ?>
<?php get_template_part( 'template-parts/cta' ); ?>

<?php get_footer(); ?>
