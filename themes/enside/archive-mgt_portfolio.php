<?php
/**
 * The template used for displaying mgt_portfolio post type archive page
 *
 * @package Enside
 */

$enside_theme_options = enside_get_theme_options();

if(isset($enside_theme_options['portfolio_page_url']) && $enside_theme_options['portfolio_page_url']!=='') {
  $portfolio_page_url = $enside_theme_options['portfolio_page_url'];
} else {
  $portfolio_page_url = home_url();
}

wp_redirect( esc_url($portfolio_page_url) ); exit;

?>