<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	
$enside_theme_options = enside_get_theme_options();

// Shop page title background image transparent header
if(!is_product_category() && !is_product() && isset($enside_theme_options['shop_page_title_image']) && $enside_theme_options['shop_page_title_image'] <> '') {

  if(isset($enside_theme_options['enable_woocommerce_transparent_header']) && $enside_theme_options['enable_woocommerce_transparent_header']) {
  	wp_add_inline_script( 'enside-script', '(function($){$(document).ready(function() { "use strict";$("body").addClass("transparent-header"); });})(jQuery);', 'before');
  }

}

// Category page title background image transparent header
if(isset($enside_theme_options['shop_category_image_title']) && $enside_theme_options['shop_category_image_title']) {
	if ( is_product_category() ) {
		    global $wp_query; // required by WooCommerce to get current category object: https://docs.woocommerce.com/document/woocommerce-display-category-image-on-category-archive/

		    $cat = $wp_query->get_queried_object();
		    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		    $cat_image = wp_get_attachment_url( $thumbnail_id );
		    if ( $cat_image ) {

		    	  if(isset($enside_theme_options['enable_woocommerce_cat_transparent_header']) && $enside_theme_options['enable_woocommerce_cat_transparent_header']) {
				  		wp_add_inline_script( 'enside-script', '(function($){$(document).ready(function() { "use strict";$("body").addClass("transparent-header"); });})(jQuery);', 'before');
				  }
			}
	}
}

?>
<div class="content-block">