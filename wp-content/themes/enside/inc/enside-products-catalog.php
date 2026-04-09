<?php
/**
 * Theme product catalog: data, URLs, and rewrite routes.
 *
 * Edit $enside_products_catalog to add products. Image paths are relative to img/products/.
 *
 * @package Enside
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ENSIDE_PRODUCTS_REWRITE_VERSION', '1' );

/**
 * Product definitions (slug must be unique, URL-safe).
 *
 * @var array<int, array{slug:string,name:string,description:string,images:string[]}>
 */
$enside_products_catalog = array(
	array(
		'slug'        => 'inclusive-braille-kids-books-animals',
		'name'        => __( 'Inclusive Braille Kids Books — Animals', 'enside' ),
		'description' => __( 'A set of tactile Braille books introducing animals, designed for inclusive learning and early literacy.', 'enside' ),
		'images'      => array(
			'kids-books/Animals Book1.jpg',
			'kids-books/Animals Book2.jpg',
			'kids-books/Animals Book3.jpg',
		),
	),
	array(
		'slug'        => 'braille-certificates',
		'name'        => __( 'Braille Certificates', 'enside' ),
		'description' => __( 'Accessible certificate designs produced in Braille for recognition and formal occasions.', 'enside' ),
		'images'      => array(
			'certificates/WhatsApp Image 2024-05-20 at 4.13.31 PM.jpeg',
			'certificates/WhatsApp Image 2024-05-20 at 4.13.32 PM.jpeg',
		),
	),
);

/**
 * @return array<int, array{slug:string,name:string,description:string,images:string[]}>
 */
function enside_get_products() {
	global $enside_products_catalog;
	return is_array( $enside_products_catalog ) ? $enside_products_catalog : array();
}

/**
 * @param string $slug Raw slug from URL.
 * @return array{slug:string,name:string,description:string,images:string[]}|null
 */
function enside_get_product_by_slug( $slug ) {
	$slug = sanitize_title( $slug );
	if ( '' === $slug ) {
		return null;
	}
	foreach ( enside_get_products() as $product ) {
		if ( isset( $product['slug'] ) && $product['slug'] === $slug ) {
			return $product;
		}
	}
	return null;
}

/**
 * Public URL for the products index.
 */
function enside_products_archive_url() {
	return home_url( user_trailingslashit( 'products' ) );
}

/**
 * Public URL for a single product.
 *
 * @param string $slug Product slug.
 */
function enside_product_permalink( $slug ) {
	$slug = sanitize_title( $slug );
	if ( '' === $slug ) {
		return enside_products_archive_url();
	}
	return home_url( user_trailingslashit( 'products/' . $slug ) );
}

/**
 * Build image URL from path under img/products/.
 *
 * @param string $relative_path Path with optional subfolder, e.g. kids-books/photo.jpg
 */
function enside_product_image_url( $relative_path ) {
	$relative_path = str_replace( '\\', '/', (string) $relative_path );
	$relative_path = ltrim( $relative_path, '/' );
	$segments      = explode( '/', $relative_path );
	$encoded       = array();
	foreach ( $segments as $segment ) {
		if ( '' === $segment ) {
			continue;
		}
		$encoded[] = rawurlencode( $segment );
	}
	return get_template_directory_uri() . '/img/products/' . implode( '/', $encoded );
}

/**
 * @param string $relative_path Path under img/products/.
 */
function enside_product_image_exists( $relative_path ) {
	$relative_path = str_replace( '\\', '/', (string) $relative_path );
	$relative_path = ltrim( $relative_path, '/' );
	$file          = get_template_directory() . '/img/products/' . $relative_path;
	return '' !== $relative_path && file_exists( $file );
}

/**
 * First existing image URL for cards / fallbacks.
 *
 * @param array{images?:string[]} $product Product row.
 */
function enside_product_primary_image_url( $product ) {
	if ( empty( $product['images'] ) || ! is_array( $product['images'] ) ) {
		return '';
	}
	foreach ( $product['images'] as $path ) {
		if ( enside_product_image_exists( $path ) ) {
			return enside_product_image_url( $path );
		}
	}
	return enside_product_image_url( $product['images'][0] );
}

/**
 * Whether the current request is a theme catalog screen (for styles, etc.).
 */
function enside_is_products_catalog_view() {
	return (bool) get_query_var( 'enside_products_archive' ) || (bool) get_query_var( 'enside_product' );
}

/**
 * Register rewrite rules for /products/ and /products/{slug}/.
 */
function enside_products_register_rewrites() {
	add_rewrite_rule( '^products/?$', 'index.php?enside_products_archive=1', 'top' );
	add_rewrite_rule( '^products/([^/]+)/?$', 'index.php?enside_product=$matches[1]', 'top' );
}
add_action( 'init', 'enside_products_register_rewrites', 5 );

/**
 * Flush rewrite rules when catalog routes change.
 */
function enside_products_maybe_flush_rewrites() {
	if ( get_option( 'enside_products_rw_ver' ) === ENSIDE_PRODUCTS_REWRITE_VERSION ) {
		return;
	}
	flush_rewrite_rules( false );
	update_option( 'enside_products_rw_ver', ENSIDE_PRODUCTS_REWRITE_VERSION );
}
add_action( 'init', 'enside_products_maybe_flush_rewrites', 99 );

/**
 * @param string[] $vars Query vars.
 * @return string[]
 */
function enside_products_query_vars( $vars ) {
	$vars[] = 'enside_products_archive';
	$vars[] = 'enside_product';
	return $vars;
}
add_filter( 'query_vars', 'enside_products_query_vars' );

/**
 * Invalid product slug → 404.
 */
function enside_products_validate_single() {
	$slug = get_query_var( 'enside_product' );
	if ( ! $slug ) {
		return;
	}
	if ( enside_get_product_by_slug( $slug ) ) {
		return;
	}
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
}
add_action( 'template_redirect', 'enside_products_validate_single', 1 );

/**
 * @param string $template Path to template.
 * @return string
 */
function enside_products_template_include( $template ) {
	if ( get_query_var( 'enside_products_archive' ) ) {
		return get_template_directory() . '/products-archive.php';
	}
	$slug = get_query_var( 'enside_product' );
	if ( $slug && ! is_404() ) {
		return get_template_directory() . '/product-single.php';
	}
	return $template;
}
add_filter( 'template_include', 'enside_products_template_include', 99 );

/**
 * @param string $title Document title.
 * @return string
 */
function enside_products_document_title( $title ) {
	if ( get_query_var( 'enside_products_archive' ) ) {
		return __( 'Products', 'enside' ) . ' &#8212; ' . get_bloginfo( 'name', 'display' );
	}
	$slug    = get_query_var( 'enside_product' );
	$product = $slug ? enside_get_product_by_slug( $slug ) : null;
	if ( $product ) {
		return wp_strip_all_tags( $product['name'] ) . ' &#8212; ' . get_bloginfo( 'name', 'display' );
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'enside_products_document_title', 20 );

/**
 * @param string[] $classes Body classes.
 * @return string[]
 */
function enside_products_body_class( $classes ) {
	if ( get_query_var( 'enside_products_archive' ) ) {
		$classes[] = 'enside-products-archive';
	}
	if ( get_query_var( 'enside_product' ) && ! is_404() ) {
		$classes[] = 'enside-product-single';
	}
	return $classes;
}
add_filter( 'body_class', 'enside_products_body_class' );
