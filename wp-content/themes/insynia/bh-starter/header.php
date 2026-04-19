<?php
/**
 * Theme header.
 *
 * @package BH_Starter
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
	<div class="bh-container">

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-brand" rel="home">
			<?php if ( has_custom_logo() ) : ?>
				<?php
				$logo_id  = get_theme_mod( 'custom_logo' );
				$logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
				?>
				<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
			<?php else : ?>
				<?php bloginfo( 'name' ); ?>
			<?php endif; ?>
		</a>

		<nav class="main-nav" id="main-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'bh-starter' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'depth'          => 2,
				'fallback_cb'    => false,
			) );
			?>
		</nav>

		<div class="header-actions">
			<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="bh-btn bh-btn--primary bh-btn--sm">
				<?php esc_html_e( 'Get in Touch', 'bh-starter' ); ?>
			</a>
			<button class="nav-toggle" id="nav-toggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'bh-starter' ); ?>" aria-expanded="false">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>

	</div>
</header>
