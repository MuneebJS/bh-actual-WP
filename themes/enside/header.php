<?php
/**
 * WP Theme Header
 *
 * Displays all of the <head> section
 *
 * @package Enside
 */
$enside_theme_options = enside_get_theme_options();

// Demo settings
if ( defined('DEMO_MODE') && isset($_GET['header_logo_position']) ) {
  $enside_theme_options['header_logo_position'] = esc_html($_GET['header_logo_position']);
}
if ( defined('DEMO_MODE') && isset($_GET['header_fullwidth']) ) {
  if($_GET['header_fullwidth'] == 0) {
    $enside_theme_options['header_fullwidth'] = false;
  }
  if($_GET['header_fullwidth'] == 1) {
    $enside_theme_options['header_fullwidth'] = true;
  }

}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-spy="scroll" data-target=".navbar" data-offset="80">

<?php
// Progress bar
if(isset($enside_theme_options['enable_progressbar']) && $enside_theme_options['enable_progressbar']): ?>
<div class="header-progressbar">
    <div class="header-progressbar-under-bar"></div>
</div>
<?php endif; ?>

<?php
// Use menu below header if you use center logo layout
if(isset($enside_theme_options['header_logo_position']) && $enside_theme_options['header_logo_position'] == 'center') {
  $enside_theme_options['header_menu_layout'] = 'menu_below_header';
}

// Don't show special header menu layout depending on settings
if(isset($enside_theme_options['header_menu_layout']) && $enside_theme_options['header_menu_layout'] == "menu_below_header" ) {
  $enside_theme_options['top_menu_position'] = "default";
}

if(isset($enside_theme_options['top_menu_position']) && $enside_theme_options['top_menu_position'] == "header" ) {
  $enside_theme_options['header_logo_position'] = "left";
}

// Center logo
if(isset($enside_theme_options['header_logo_position']) && $enside_theme_options['header_logo_position'] == 'center') {
  $header_container_add_class = ' header-logo-center';
} else {
  $header_container_add_class = '';
}
if(isset($enside_theme_options['header_fullwidth']) && $enside_theme_options['header_fullwidth']) {
  $header_container_class = 'container-fluid';
} else {
  $header_container_class = 'container';
}

// Sticky header
if(isset($enside_theme_options['enable_sticky_header']) && $enside_theme_options['enable_sticky_header']) {
  $header_add_class = 'sticky-header main-header';
} else {
  $header_add_class = 'main-header';
}

// Sticky header elements
if(!isset($enside_theme_options['sticky_header_elements'])) {
  $enside_theme_options['sticky_header_elements'] = 'headeronly';
}

$header_add_class .= ' sticky-header-elements-'.esc_attr($enside_theme_options['sticky_header_elements']);

$header_add_class .= ' mainmenu-position-'.esc_attr($enside_theme_options['header_menu_layout']);

?>
<?php
// Left header
if(isset($enside_theme_options['header_position']) && $enside_theme_options['header_position'] == 'left'):
?>
<header class="left-side-header">
<?php enside_header_side_show(); ?>
</header>
<?php else: ?>
<?php enside_menu_top_show(); ?>
<header class="<?php echo esc_attr($header_add_class); ?>">
<div class="<?php echo esc_attr($header_container_class); ?><?php echo esc_attr($header_container_add_class); ?>">
  <div class="row">
    <div class="col-md-12">

      <div class="header-left">
          <?php enside_header_left_show(); ?>
      </div>

      <div class="header-center">
        <?php enside_header_center_show(); ?>
      </div>

      <div class="header-right">
        <?php enside_header_right_show(); ?>
      </div>

    </div>
  </div>

</div>
<?php enside_menu_below_header_show(); ?>
</header>
<?php endif; ?>
