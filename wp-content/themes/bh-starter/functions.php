<?php
/**
 * BH Starter theme functions and definitions.
 *
 * @package BH_Starter
 */

if ( ! defined( 'BH_STARTER_VERSION' ) ) {
	define( 'BH_STARTER_VERSION', '1.0.0' );
}

/* ---------- Theme Setup ---------- */

function bh_starter_setup() {
	load_theme_textdomain( 'bh-starter', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'woocommerce' );

	add_theme_support( 'custom-logo', array(
		'height'      => 48,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	add_theme_support( 'custom-header', array(
		'default-image' => '',
		'width'         => 1920,
		'height'        => 600,
		'flex-width'    => true,
		'flex-height'   => true,
		'header-text'   => false,
	) );

	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'video', 'audio', 'quote', 'link' ) );

	add_image_size( 'bh-blog-thumb', 800, 500, true );
	add_image_size( 'bh-blog-wide', 1200, 675, true );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'bh-starter' ),
		'footer'  => esc_html__( 'Footer Menu', 'bh-starter' ),
	) );

	if ( ! isset( $content_width ) ) {
		$GLOBALS['content_width'] = 1200;
	}
}
add_action( 'after_setup_theme', 'bh_starter_setup' );

/* ---------- Scripts & Styles ---------- */

function bh_starter_scripts() {
	wp_enqueue_style(
		'bh-starter-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap',
		array(),
		BH_STARTER_VERSION
	);

	wp_enqueue_style( 'bh-starter-style', get_stylesheet_uri(), array(), BH_STARTER_VERSION );

	wp_enqueue_script(
		'bh-starter-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		BH_STARTER_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bh_starter_scripts' );

/* ---------- Sidebars ---------- */

function bh_starter_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'bh-starter' ),
		'id'            => 'sidebar-blog',
		'description'   => esc_html__( 'Widgets shown on blog pages.', 'bh-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'bh-starter' ),
		'id'            => 'sidebar-page',
		'description'   => esc_html__( 'Widgets shown on pages.', 'bh-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'bh-starter' ),
		'id'            => 'sidebar-footer',
		'description'   => esc_html__( 'Widgets shown in the footer.', 'bh-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title footer-heading">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'bh_starter_widgets_init' );

/* ---------- Excerpt ---------- */

function bh_starter_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'bh_starter_excerpt_length' );

function bh_starter_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'bh_starter_excerpt_more' );

/* ---------- Team Member Avatar Helper ---------- */

if ( ! function_exists( 'bh_starter_team_avatar_url' ) ) :
	function bh_starter_team_avatar_url( $slug ) {
		$slug = sanitize_file_name( $slug );
		if ( '' === $slug ) {
			return '';
		}
		$dir = get_template_directory() . '/assets/img/team/';
		$uri = get_template_directory_uri() . '/assets/img/team/';
		foreach ( array( 'png', 'webp', 'jpg', 'jpeg' ) as $ext ) {
			if ( file_exists( $dir . $slug . '.' . $ext ) ) {
				return $uri . $slug . '.' . $ext;
			}
		}
		return $uri . $slug . '.svg';
	}
endif;

/* ---------- Content Navigation ---------- */

if ( ! function_exists( 'bh_starter_content_nav' ) ) :
	function bh_starter_content_nav() {
		global $wp_query;

		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}
		?>
		<nav class="navigation-paging" role="navigation">
			<div class="nav-previous"><?php next_posts_link( esc_html__( 'Older posts', 'bh-starter' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( esc_html__( 'Newer posts', 'bh-starter' ) ); ?></div>
		</nav>
		<?php
	}
endif;

/* ---------- Comment Callback ---------- */

if ( ! function_exists( 'bh_starter_comment' ) ) :
	function bh_starter_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-body">
				<?php if ( 0 !== (int) $args['avatar_size'] ) echo get_avatar( $comment, 48 ); ?>
				<div class="comment-content">
					<div class="comment-author"><?php comment_author_link(); ?></div>
					<div class="comment-meta">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php printf( '%1$s at %2$s', get_comment_date(), get_comment_time() ); ?>
						</time>
					</div>
					<?php comment_text(); ?>
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>
		<?php
	}
endif;

/* ---------- Disable Gutenberg Widget Editor ---------- */

function bh_starter_disable_widget_block_editor() {
	remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'bh_starter_disable_widget_block_editor' );

/* ---------- Body Classes ---------- */

function bh_starter_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'singular';
	}
	if ( is_front_page() ) {
		$classes[] = 'front-page';
	}
	return $classes;
}
add_filter( 'body_class', 'bh_starter_body_classes' );
