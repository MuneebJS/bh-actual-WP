<?php
/**
 * BH Starter theme functions and definitions.
 *
 * @package BH_Starter
 */

if ( ! defined( 'BH_STARTER_VERSION' ) ) {
	define( 'BH_STARTER_VERSION', '1.0.0' );
}

require_once get_template_directory() . '/inc/bh-starter-products.php';

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

/* ---------- Product catalog routes (/products/, /product/{slug}/) ---------- */

function bh_starter_register_product_rewrites() {
	add_rewrite_rule( '^products/?$', 'index.php?bh_products_catalog=1', 'top' );
	add_rewrite_rule( '^product/([^/]+)/?$', 'index.php?bh_product=$matches[1]', 'top' );
}
add_action( 'init', 'bh_starter_register_product_rewrites' );

/**
 * Bump when adding rewrite rules so existing installs flush once (Settings → Permalinks not required).
 */
function bh_starter_maybe_flush_product_rewrites() {
	$version = '2';
	if ( get_option( 'bh_starter_rewrite_version' ) === $version ) {
		return;
	}
	bh_starter_register_product_rewrites();
	flush_rewrite_rules( false );
	update_option( 'bh_starter_rewrite_version', $version );
}
add_action( 'init', 'bh_starter_maybe_flush_product_rewrites', 99 );

function bh_starter_product_query_vars( $vars ) {
	$vars[] = 'bh_products_catalog';
	$vars[] = 'bh_product';
	return $vars;
}
add_filter( 'query_vars', 'bh_starter_product_query_vars' );

/**
 * Custom index.php rewrites match no posts; prevent a false 404 so we can serve our templates.
 *
 * @param bool     $preempt  Whether to short-circuit default 404 handling.
 * @param WP_Query $wp_query Main query.
 * @return bool
 */
function bh_starter_pre_handle_404( $preempt, $wp_query ) {
	if ( ! $wp_query->is_main_query() ) {
		return $preempt;
	}
	if ( get_query_var( 'bh_products_catalog' ) ) {
		return true;
	}
	$slug = get_query_var( 'bh_product' );
	if ( $slug && bh_starter_get_product_by_slug( $slug ) ) {
		return true;
	}
	return $preempt;
}
add_filter( 'pre_handle_404', 'bh_starter_pre_handle_404', 10, 2 );

function bh_starter_product_template_include( $template ) {
	if ( get_query_var( 'bh_products_catalog' ) ) {
		return get_template_directory() . '/products-catalog.php';
	}
	$slug = get_query_var( 'bh_product' );
	if ( ! $slug ) {
		return $template;
	}
	if ( ! bh_starter_get_product_by_slug( $slug ) ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		return get_404_template();
	}
	return get_template_directory() . '/product-detail.php';
}
add_filter( 'template_include', 'bh_starter_product_template_include', 99 );

function bh_starter_flush_product_rewrites() {
	bh_starter_register_product_rewrites();
	flush_rewrite_rules( false );
	update_option( 'bh_starter_rewrite_version', '2' );
}
add_action( 'after_switch_theme', 'bh_starter_flush_product_rewrites' );

function bh_starter_body_classes_products( $classes ) {
	if ( bh_starter_is_products_catalog_route() ) {
		$classes[] = 'products-catalog-page';
	}
	if ( bh_starter_is_product_detail() ) {
		$classes[] = 'product-detail-page';
	}
	return $classes;
}
add_filter( 'body_class', 'bh_starter_body_classes_products' );

function bh_starter_products_catalog_document_title( $parts ) {
	if ( bh_starter_is_products_catalog_route() ) {
		$parts['title'] = __( 'Products', 'bh-starter' );
	} elseif ( bh_starter_is_product_detail() ) {
		$slug    = get_query_var( 'bh_product' );
		$product = $slug ? bh_starter_get_product_by_slug( $slug ) : null;
		if ( $product ) {
			$parts['title'] = $product['name'];
		}
	}
	return $parts;
}
add_filter( 'document_title_parts', 'bh_starter_products_catalog_document_title', 20 );

/* ---------- Awards post type ---------- */

function bh_starter_register_awards_post_type() {
	register_post_type(
		'bh_award',
		array(
			'labels' => array(
				'name'               => __( 'Awards', 'bh-starter' ),
				'singular_name'      => __( 'Award', 'bh-starter' ),
				'add_new_item'       => __( 'Add New Award', 'bh-starter' ),
				'edit_item'          => __( 'Edit Award', 'bh-starter' ),
				'new_item'           => __( 'New Award', 'bh-starter' ),
				'view_item'          => __( 'View Award', 'bh-starter' ),
				'search_items'       => __( 'Search Awards', 'bh-starter' ),
				'not_found'          => __( 'No awards found', 'bh-starter' ),
				'not_found_in_trash' => __( 'No awards found in Trash', 'bh-starter' ),
			),
			'public'             => true,
			'show_ui'            => true,
			'show_in_rest'       => true,
			'has_archive'        => false,
			'menu_icon'          => 'dashicons-awards',
			'publicly_queryable' => false,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'bh_starter_register_awards_post_type' );

function bh_starter_add_award_gallery_metabox() {
	add_meta_box(
		'bh-award-gallery',
		__( 'Award Images', 'bh-starter' ),
		'bh_starter_render_award_gallery_metabox',
		'bh_award',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'bh_starter_add_award_gallery_metabox' );

function bh_starter_render_award_gallery_metabox( $post ) {
	$gallery_ids = get_post_meta( $post->ID, '_bh_award_gallery_ids', true );
	wp_nonce_field( 'bh_award_gallery_nonce', 'bh_award_gallery_nonce' );
	?>
	<div class="bh-award-admin">
		<p><?php esc_html_e( 'Select one or more images for this award. These will appear on the Awards and Recognitions page.', 'bh-starter' ); ?></p>
		<input type="hidden" class="bh-award-admin__ids" name="bh_award_gallery_ids" value="<?php echo esc_attr( $gallery_ids ); ?>">
		<div class="bh-award-admin__actions">
			<button type="button" class="button bh-award-admin__choose"><?php esc_html_e( 'Choose Images', 'bh-starter' ); ?></button>
			<button type="button" class="button bh-award-admin__clear"><?php esc_html_e( 'Clear', 'bh-starter' ); ?></button>
		</div>
		<div class="bh-award-admin__preview"></div>
	</div>
	<?php
}

function bh_starter_save_award_gallery_metabox( $post_id ) {
	if ( ! isset( $_POST['bh_award_gallery_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bh_award_gallery_nonce'] ) ), 'bh_award_gallery_nonce' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );
	if ( 'bh_award' !== $post_type ) {
		return;
	}

	$gallery_ids = isset( $_POST['bh_award_gallery_ids'] ) ? sanitize_text_field( wp_unslash( $_POST['bh_award_gallery_ids'] ) ) : '';
	$gallery_ids = preg_replace( '/[^0-9,]/', '', (string) $gallery_ids );

	if ( '' === $gallery_ids ) {
		delete_post_meta( $post_id, '_bh_award_gallery_ids' );
		return;
	}

	update_post_meta( $post_id, '_bh_award_gallery_ids', $gallery_ids );
}
add_action( 'save_post', 'bh_starter_save_award_gallery_metabox' );

function bh_starter_awards_admin_assets( $hook ) {
	$screen = get_current_screen();

	if ( ! $screen || 'bh_award' !== $screen->post_type ) {
		return;
	}

	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	wp_enqueue_media();

	wp_enqueue_script(
		'bh-starter-admin-awards',
		get_template_directory_uri() . '/assets/js/admin-awards.js',
		array( 'jquery' ),
		BH_STARTER_VERSION,
		true
	);

	$admin_css = '.bh-award-admin__actions{display:flex;gap:8px;margin-bottom:12px}.bh-award-admin__preview{display:grid;grid-template-columns:repeat(auto-fill,minmax(90px,1fr));gap:8px}.bh-award-admin__preview-item img{width:100%;height:90px;object-fit:cover;border-radius:6px}';
	wp_register_style( 'bh-starter-admin-awards', false, array(), BH_STARTER_VERSION );
	wp_enqueue_style( 'bh-starter-admin-awards' );
	wp_add_inline_style( 'bh-starter-admin-awards', $admin_css );
}
add_action( 'admin_enqueue_scripts', 'bh_starter_awards_admin_assets' );
