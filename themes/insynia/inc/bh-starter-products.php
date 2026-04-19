<?php
/**
 * Static product catalog (names, descriptions, images under assets/img/products).
 *
 * @package BH_Starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base filesystem path for product images.
 *
 * @return string
 */
function bh_starter_products_images_dir() {
	return trailingslashit( get_template_directory() ) . 'assets/img/products/';
}

/**
 * Base URI for product images.
 *
 * @return string
 */
function bh_starter_products_images_uri() {
	return trailingslashit( get_template_directory_uri() ) . 'assets/img/products/';
}

/**
 * Base URI for mobile app images.
 *
 * @return string
 */
function bh_starter_mobile_apps_images_uri() {
	return trailingslashit( get_template_directory_uri() ) . 'assets/img/mobile-apps/';
}

/**
 * Build a public URL for a file under assets/img/mobile-apps.
 *
 * @param string $relative_path Path relative to mobile apps folder.
 * @return string
 */
function bh_starter_mobile_apps_image_url( $relative_path ) {
	$relative_path = ltrim( str_replace( '\\', '/', (string) $relative_path ), '/' );
	if ( '' === $relative_path ) {
		return '';
	}
	$parts    = explode( '/', $relative_path );
	$encoded  = array_map( 'rawurlencode', $parts );
	$rel_uri  = implode( '/', $encoded );
	return bh_starter_mobile_apps_images_uri() . $rel_uri;
}

/**
 * Build a public URL for a file under assets/img/products (handles spaces & subfolders).
 *
 * @param string $relative_path Path relative to products folder, e.g. kids-books/file.jpg.
 * @return string
 */
function bh_starter_products_image_url( $relative_path ) {
	$relative_path = ltrim( str_replace( '\\', '/', (string) $relative_path ), '/' );
	if ( '' === $relative_path ) {
		return '';
	}
	$parts    = explode( '/', $relative_path );
	$encoded  = array_map( 'rawurlencode', $parts );
	$rel_uri  = implode( '/', $encoded );
	return bh_starter_products_images_uri() . $rel_uri;
}

/**
 * Product definitions (slug => data). Order follows homepage “Core products”.
 *
 * @return array<string, array<string, mixed>>
 */
function bh_starter_products_catalog_definitions() {
	return array(
		'inclusive-braille-books'       => array(
			'name'        => __( 'Inclusive Braille Books', 'bh-starter' ),
			'short'       => __( 'Dual-script textbooks combining Braille and Urdu text for inclusive classrooms.', 'bh-starter' ),
			'description' => array(
				__( 'Our inclusive Braille books pair embossed Braille with printed Urdu so sighted teachers, peers, and family can read alongside visually impaired learners in the same classroom.', 'bh-starter' ),
				__( 'Titles are developed for school-age readers and early learners, with clear tactile layouts and durable production suited to daily use.', 'bh-starter' ),
			),
			'images'      => array(
				'kids-books/Animals Book1.jpg',
				'kids-books/Animals Book2.jpg',
				'kids-books/Animals Book3.jpg',
			),
			'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
		),
		'inclusive-braille-forms'       => array(
			'name'        => __( 'Inclusive Braille Forms', 'bh-starter' ),
			'short'       => __( 'Accessible form designs enabling independent document completion for all users.', 'bh-starter' ),
			'description' => array(
				__( 'We design forms—applications, surveys, and official paperwork—with Braille, large-print, and clear tactile cues so people can complete them independently or with minimal assistance.', 'bh-starter' ),
				__( 'Layouts follow accessibility best practices for banks, schools, and public services.', 'bh-starter' ),
			),
			'images'      => array(),
			'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>',
		),
		'inclusive-braille-noorani-qaida' => array(
			'name'        => __( 'Inclusive Braille Noorani Qaida', 'bh-starter' ),
			'short'       => __( 'Braille editions of the Noorani Qaida for inclusive religious education.', 'bh-starter' ),
			'description' => array(
				__( 'Structured Braille lessons mirror traditional Noorani Qaida progression so students can learn Quranic reading in inclusive madrasah and home settings.', 'bh-starter' ),
				__( 'Materials are crafted for consistent dot height and readable lesson flow.', 'bh-starter' ),
			),
			'images'      => array(),
			'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 10 3 12 0v-5"/></svg>',
		),
		'urdu-english-braille-mobile-apps' => array(
			'name'        => __( 'Urdu/English to Braille Mobile Apps', 'bh-starter' ),
			'short'       => __( 'Real-time text-to-Braille conversion apps for mobile devices.', 'bh-starter' ),
			'description' => array(
				__( 'Mobile apps convert Urdu and English input into Braille for quick reference, study, and communication on the go.', 'bh-starter' ),
				__( 'Built for accessibility with screen reader–friendly interfaces and predictable output.', 'bh-starter' ),
			),
			'images'      => array(),
			'app_details' => array(
				'lead'        => __( 'Download our Android app from Google Play and start Urdu/English to Braille conversion on your phone.', 'bh-starter' ),
				'store_label' => __( 'Get it on Google Play', 'bh-starter' ),
				'store_url'   => 'https://play.google.com/store/apps/details?id=com.mega_dealers.boltexponativewind&pcampaignid=web_share',
				'features'    => array(
					__( 'Instant Urdu and English text-to-Braille conversion for day-to-day reading and writing support.', 'bh-starter' ),
					__( 'Clean, accessible interface designed for screen readers and low-vision users.', 'bh-starter' ),
					__( 'Useful for students, teachers, and families practicing Braille on the go.', 'bh-starter' ),
				),
				'screenshots' => array(
					'app-screen-1.png',
				),
			),
			'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>',
		),
		'accessibility-software-for-banks' => array(
			'name'        => __( 'Accessibility Software for Banks', 'bh-starter' ),
			'short'       => __( 'Banking-grade accessibility solutions enabling financial independence.', 'bh-starter' ),
			'description' => array(
				__( 'We deliver software and workflow support so banks can serve blind and low-vision customers with dignity—from ATMs and counters to digital channels.', 'bh-starter' ),
				__( 'Engagements focus on compliance, staff training, and sustainable accessibility roadmaps.', 'bh-starter' ),
			),
			'images'      => array(),
			'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
		),
		'braille-certificates'          => array(
			'name'        => __( 'Braille Certificates & Recognition', 'bh-starter' ),
			'short'       => __( 'Tactile certificates and awards with embossed Braille and print.', 'bh-starter' ),
			'description' => array(
				__( 'Celebrate achievements with certificates that include embossed Braille alongside visual design—ideal for schools, programs, and ceremonies.', 'bh-starter' ),
				__( 'Each piece is produced for clarity, durability, and a dignified presentation.', 'bh-starter' ),
			),
			'images'      => array(
				'certificates/WhatsApp Image 2024-05-20 at 4.13.31 PM.jpeg',
				'certificates/WhatsApp Image 2024-05-20 at 4.13.32 PM.jpeg',
			),
			'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>',
		),
	);
}

/**
 * Ordered list of products with slug attached.
 *
 * @return array<int, array<string, mixed>>
 */
function bh_starter_get_products_list() {
	$defs = bh_starter_products_catalog_definitions();
	$list = array();
	foreach ( $defs as $slug => $data ) {
		$list[] = array_merge( array( 'slug' => $slug ), $data );
	}
	return $list;
}

/**
 * Single product by slug.
 *
 * @param string $slug Sanitized slug.
 * @return array<string, mixed>|null
 */
function bh_starter_get_product_by_slug( $slug ) {
	$slug = sanitize_title( $slug );
	if ( '' === $slug ) {
		return null;
	}
	$defs = bh_starter_products_catalog_definitions();
	return isset( $defs[ $slug ] ) ? array_merge( array( 'slug' => $slug ), $defs[ $slug ] ) : null;
}

/**
 * Permalink for a product detail view.
 *
 * @param string $slug Product slug.
 * @return string
 */
function bh_starter_product_permalink( $slug ) {
	return trailingslashit( home_url( '/product/' . sanitize_title( $slug ) ) );
}

/**
 * URL of the main products listing page (create a Page with slug “products” and assign the catalog template).
 *
 * @return string
 */
function bh_starter_products_archive_url() {
	return trailingslashit( home_url( '/products/' ) );
}

/**
 * First image URL for card thumbnails (file must exist).
 *
 * @param array<string, mixed> $product Product row from bh_starter_get_products_list().
 * @return string
 */
function bh_starter_product_card_image_url( $product ) {
	if ( empty( $product['images'] ) || ! is_array( $product['images'] ) ) {
		return '';
	}
	$dir = bh_starter_products_images_dir();
	foreach ( $product['images'] as $rel ) {
		$path = $dir . ltrim( str_replace( '\\', '/', $rel ), '/' );
		if ( is_readable( $path ) ) {
			return bh_starter_products_image_url( $rel );
		}
	}
	return '';
}

/**
 * Whether the current request is a virtual product detail route.
 *
 * @return bool
 */
function bh_starter_is_product_detail() {
	return (bool) get_query_var( 'bh_product' );
}

/**
 * Whether the current request is the virtual /products/ catalog route.
 *
 * @return bool
 */
function bh_starter_is_products_catalog_route() {
	return (bool) get_query_var( 'bh_products_catalog' );
}
