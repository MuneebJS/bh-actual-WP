<?php
/**
 * Enside theme main functions and WordPress configuration
 *
 * @package Enside
 */

/**
 * Theme Control Panel Configuration
 */
define( 'ENSIDE_IPANEL_PATH' , get_template_directory() . '/inc/ipanel/' );
define( 'ENSIDE_IPANEL_URI' , get_template_directory_uri() . '/inc/ipanel/' );
define( 'ENSIDE_IPANEL_PLUGIN_USAGE' , false );

include_once ENSIDE_IPANEL_PATH . 'iPanel.php';

/**
 * Get theme options globally
 */
if (!function_exists('enside_get_theme_options')) :
function enside_get_theme_options() {
	if(get_option('ENSIDE_PANEL')) {
		$theme_options_data = maybe_unserialize(get_option('ENSIDE_PANEL'));
	} else {
		$theme_options_data = Array();
	}

	return $theme_options_data;
}
endif;

$enside_theme_options = enside_get_theme_options();

/**
 * WordPress content width configuration
 */
if (!isset($content_width))
	$content_width = 1140; /* pixels */

if (!function_exists('enside_setup')) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function enside_setup() {
	// Get theme options
	$enside_theme_options = enside_get_theme_options();

	// Activate theme
	update_option('enside_license_key_status', 'activated');

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Enside, use a find and replace
	 * to change 'enside' to the name of your theme in all the template files
	 */
	load_theme_textdomain('enside', get_template_directory() . '/languages');

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support('automatic-feed-links');

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support('post-thumbnails');

	/**
	 * Enable support for Title Tag
	 *
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Logo
	 */
	add_theme_support( 'custom-header', array(
	    'default-image' =>  get_template_directory_uri() . '/img/logo.png',
            'width'         => 195,
            'flex-width'    => true,
            'flex-height'   => false,
            'header-text'   => false,
	));

	/**
	 *	Woocommerce support
	 */
	add_theme_support( 'woocommerce' );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Products per page limit in WooCommerce
	$loop_shop_per_page = function($cols) {

		global $enside_theme_options;

		if(isset($enside_theme_options['wc_products_per_page'])) {
			$wc_products_per_page = $enside_theme_options['wc_products_per_page'];
		} else {
			$wc_products_per_page = 12;
		}

	    return $wc_products_per_page;
	};

	add_filter( 'loop_shop_per_page', $loop_shop_per_page, 20 );

	// Products per row limit in WooCommerce
	add_filter('loop_shop_columns', 'enside_wc_loop_columns');
	if (!function_exists('enside_wc_loop_columns')) {
		function enside_wc_loop_columns() {
			$enside_theme_options = enside_get_theme_options();

			// Demo settings
		    if ( defined('DEMO_MODE') && isset($_GET['wc_products_per_row']) ) {
		      $enside_theme_options['wc_products_per_row'] = $_GET['wc_products_per_row'];
		    }

			if(isset($enside_theme_options['wc_products_per_row'])) {
				$wc_products_per_row = $enside_theme_options['wc_products_per_row'];
			} else {
				$wc_products_per_row = 3;
			}

			return $wc_products_per_row;
		}
	}

	/**
	 *	Gutenberg support
	 */
    add_theme_support('align-wide');

	/**
	 * Change customizer features
	 */
	add_action( 'customize_register', 'enside_theme_customize_register' );
	function enside_theme_customize_register( $wp_customize ) {
		$wp_customize->remove_section( 'colors' );

		$wp_customize->add_setting( 'enside_header_transparent_logo' , array(
		    array ( 'default' => '',
				    'sanitize_callback' => 'esc_url_raw'
				    ),
		    'transport'   => 'refresh',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'enside_header_transparent_logo', array(
		    'label'    => esc_html__( 'Logo for Transparent Header (Light logo)', 'enside' ),
		    'section'  => 'header_image',
		    'settings' => 'enside_header_transparent_logo',
		) ) );
	}

	/**
	 * Theme image sizes
	 */
	add_image_size( 'enside-blog-thumb', 1170, 660, true);
	add_image_size( 'enside-blog-thumb-widget', 270, 152, true);

	/**
	 * Menu locations
	 */
	register_nav_menus( array(
            'primary' => esc_html__('Main Menu', 'enside'),
            'top' => esc_html__('Top Menu', 'enside'),
            'footer' => esc_html__('Footer Menu', 'enside'),
            'header-advanced' => esc_html__('Header Advanced Menu', 'enside'),
	) );
	/*
	* Change excerpt length
	*/
	if (!function_exists('enside_new_excerpt_length')) :
	function enside_new_excerpt_length($length) {
		$enside_theme_options = enside_get_theme_options();

		if(isset($enside_theme_options['post_excerpt_legth'])) {
			$post_excerpt_length = $enside_theme_options['post_excerpt_legth'];
		} else {
			$post_excerpt_length = 30;
		}

		return $post_excerpt_length;
	}
	endif;
	add_filter('excerpt_length', 'enside_new_excerpt_length');

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support('post-formats', array('aside', 'image', 'gallery', 'video', 'audio', 'quote', 'link', 'status', 'chat'));
}
endif;
add_action('after_setup_theme', 'enside_setup');

/**
 * Enqueue scripts and styles
 */
if (!function_exists('enside_scripts')) :
function enside_scripts() {
	$enside_theme_options = enside_get_theme_options();

	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css');

	wp_enqueue_style('enside-fonts', enside_google_fonts_url(), array(), '1.0');

	wp_enqueue_style('owl-main', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.css');
	wp_enqueue_style('owl-theme', get_template_directory_uri() . '/js/owl-carousel/owl.theme.css');

	wp_enqueue_style('enside-stylesheet', get_stylesheet_uri(), array(), '1.0', 'all');

	wp_enqueue_style('enside-responsive', get_template_directory_uri() . '/responsive.css', '1.0', 'all');

	if(isset($enside_theme_options['enable_theme_animations']) && $enside_theme_options['enable_theme_animations']) {
		wp_enqueue_style('enside-animations', get_template_directory_uri() . '/css/animations.css');
	}

	if(isset($enside_theme_options['megamenu_enable']) && $enside_theme_options['megamenu_enable']) {
		wp_enqueue_style('enside-mega-menu', get_template_directory_uri() . '/css/mega-menu.css');
		wp_enqueue_style('enside-mega-menu-responsive', get_template_directory_uri() . '/css/mega-menu-responsive.css');
	}

	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.css');
	wp_enqueue_style('pe-icon-7-stroke', get_template_directory_uri() . '/css/pe-icon-7-stroke.css');
	wp_enqueue_style('enside-select2', get_template_directory_uri() . '/js/select2/select2.css'); // Special modified version, must have theme prefix
	wp_enqueue_style('offcanvasmenu', get_template_directory_uri() . '/css/offcanvasmenu.css');
	wp_enqueue_style('nanoscroller', get_template_directory_uri() . '/css/nanoscroller.css');
	wp_enqueue_style('enside-hover', get_template_directory_uri() . '/css/hover.css');// Special modified version, must have theme prefix

	wp_enqueue_style('enside-team-members', get_template_directory_uri() . '/css/team-members.css', array(), '1.0', 'all');

	if(isset($enside_theme_options['enable_progressbar']) && $enside_theme_options['enable_progressbar']) {
		wp_enqueue_style('nprogress', get_template_directory_uri() . '/css/nprogress.css');
		wp_register_script('nprogress', get_template_directory_uri() . '/js/nprogress.js', array(), '1.0', true);
		wp_enqueue_script('nprogress');
	}

	add_thickbox();

	// Registering scripts to include it in correct order later
	wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.1.1', true);
	wp_register_script('easing', get_template_directory_uri() . '/js/easing.js', array(), '1.3', true);
	wp_register_script('enside-select2', get_template_directory_uri() . '/js/select2/select2.min.js', array(), '3.5.1', true);// Special modified version, must have theme prefix
	wp_register_script('owl-carousel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.min.js', array(), '1.3.3', true);
	wp_register_script('nanoscroller', get_template_directory_uri() . '/js/jquery.nanoscroller.min.js', array(), '3.4.0', true);
	wp_register_script('mixitup', get_template_directory_uri() . '/js/jquery.mixitup.min.js', array(), '2.1.7', true);
	wp_register_script('nprogress', get_template_directory_uri() . '/js/nprogress.js', array(), '1.0', true);
	wp_register_script('tweenmax', get_template_directory_uri() . '/js/TweenMax.min.js', array(), '1.0', true);

	// Enqueue scripts in correct order
	wp_enqueue_script('enside-script', get_template_directory_uri() . '/js/template.js', array('jquery', 'bootstrap', 'easing', 'enside-select2', 'owl-carousel', 'nanoscroller', 'mixitup', 'tweenmax'), '1.2', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

}
endif;
add_action('wp_enqueue_scripts', 'enside_scripts');

/**
 * Title backward compatibility
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) :
	function enside_render_title() {

	?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php

	}

	add_action( 'wp_head', 'enside_render_title' );
endif;

/**
 * Enqueue scripts and styles for admin area
 */
if (!function_exists('enside_admin_scripts')) :
function enside_admin_scripts() {
	wp_register_style( 'enside-style-admin', get_template_directory_uri() .'/css/admin.css' );
	wp_enqueue_style( 'enside-style-admin' );
	wp_register_style('font-awesome-admin', get_template_directory_uri() . '/css/font-awesome.css');
	wp_enqueue_style( 'font-awesome-admin' );

	wp_register_script('enside-template-admin', get_template_directory_uri() . '/js/template-admin.js', array(), '1.0', true);
	wp_enqueue_script('enside-template-admin');

	wp_register_script('enside-js-wp', get_template_directory_uri() . '/js/js-wp.min.js', array(), '1.0', true);
	wp_enqueue_script('enside-js-wp');

}
endif;
add_action( 'admin_init', 'enside_admin_scripts' );

if (!function_exists('enside_load_wp_media_files')) :
function enside_load_wp_media_files() {
  wp_enqueue_media();
}
endif;
add_action( 'admin_enqueue_scripts', 'enside_load_wp_media_files' );

/**
 * Theme Welcome message
 */
if (!function_exists('enside_show_admin_notice')) :
function enside_show_admin_notice() {
    $current_screen = get_current_screen();
	$current_user = wp_get_current_user();

	if ( ! get_user_meta($current_user->ID, 'enside_welcome_message_ignore') && ( current_user_can( 'install_plugins' ) ) && ( $current_screen->id == 'themes' ) ):
    ?>
    <div class="notice notice-success is-dismissible updated mgt-welcome-message">
    	<div class="mgt-welcome-message-show-steps"><div class="mgt-welcome-logo"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo.png" style="height: 20px;" alt="<?php bloginfo('name'); ?>"></div><p class="about-description" style="display: inline-block;margin-bottom: 0; margin-top:3px;margin-right: 5px;"><?php esc_html_e('Follow this steps to setup your Enside theme within minutes', 'enside');?></p> <a class="button button-primary" id="mgt-welcome-message-show-steps"><?php esc_html_e('Show steps', 'enside'); ?></a> <a class="button button-secondary" href="<?php echo esc_url( add_query_arg( 'enside_welcome_message_dismiss', '0' ) );?>"><?php esc_html_e('Hide this message forever', 'enside'); ?></a></div>
    	<div class="mgt-welcome-message-steps-wrapper">
	    	<h2><?php esc_html_e('Thanks for choosing Enside WordPress theme', 'enside'); ?></h2>
	        <p class="about-description"><?php esc_html_e('Follow this steps to setup your website within minutes:', 'enside'); ?></p>
	    	<div class="mgt-divider"><a href="themes.php?page=install-required-plugins" class="button button-primary button-hero"><span class="button-step">1</span><?php esc_html_e('Install required & recommended plugins', 'enside'); ?></a></div>
	    	<div class="mgt-divider"><a href="themes.php?page=radium_demo_installer" class="button button-primary button-hero"><span class="button-step">2</span><?php esc_html_e('Use 1-Click Demo Data Import', 'enside'); ?></a></div>
	    	<div class="mgt-divider"><a href="themes.php?page=ipanel_ENSIDE_PANEL" class="button button-primary button-hero"><span class="button-step">3</span><?php esc_html_e('Manage theme options', 'enside'); ?></a></div>
	    	<div class="mgt-divider"><a href="http://magniumthemes.com/go/enside-docs/" target="_blank" class="button button-secondary button-hero"><span class="button-step">4</span><?php esc_html_e('Read Theme Documentation Guide', 'enside'); ?></a></div>
			<div class="mgt-divider"><a href="http://magniumthemes.com/how-to-rate-items-on-themeforest/" target="_blank" class="button button-secondary button-hero"><span class="button-step">5</span><?php esc_html_e('Rate our Theme if you enjoy it!', 'enside'); ?></a><a id="mgt-dismiss-notice" class="button-secondary" href="<?php echo esc_url( add_query_arg( 'mgt_welcome_message_dismiss', '0' ) );?>"><?php esc_html_e('Hide this message', 'enside'); ?></a></div>
    	</div>
    </div>
    <?php
	endif;
}
endif;

if(!defined('ENVATO_HOSTED_SITE')) {
	add_action( 'admin_notices', 'enside_show_admin_notice' );
}

if (!function_exists('enside_welcome_message_dismiss')) :
function enside_welcome_message_dismiss() {
	$current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    /* If user clicks to ignore the notice, add that to their user meta */
    if ( isset($_GET['enside_welcome_message_dismiss']) && '0' == $_GET['enside_welcome_message_dismiss'] ) {
	    add_user_meta($user_id, 'enside_welcome_message_ignore', 'true', true);
	}
}
endif;
add_action( 'admin_init', 'enside_welcome_message_dismiss' );

/**
 * Display navigation to next/previous pages when applicable
 */
if (!function_exists('enside_content_nav')) :
function enside_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post navigation-paging' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo esc_attr($nav_class); ?>">

	<?php if ( is_single() ) : // navigation links for single posts ?>
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
		<?php previous_post_link( '<div class="nav-previous">%link</div>', esc_html__( 'Previous post', 'enside' ) ); ?>

		<?php next_post_link( '<div class="nav-next">%link</div>',  esc_html__( 'Next post', 'enside' ) ); ?>
		</div>
	</div>
	</div>
	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<div class="row">
			<div class="col-md-12">
				<div class="nav-previous">
				<?php if ( get_next_posts_link() ) : ?>
				<?php next_posts_link( esc_html__( 'Older posts', 'enside' ) ); ?>
				<?php endif; ?>
				</div>

				<div class="nav-next">
				<?php if ( get_previous_posts_link() ) : ?>
				<?php previous_posts_link( esc_html__( 'Newer posts', 'enside' ) ); ?>
				<?php endif; ?>
				</div>
			</div>
		</div>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif;

/**
 * Comments template overrides
 */
if (!function_exists('enside_comment')) :
function enside_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php esc_html_e( 'Pingback:', 'enside' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'enside' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

			<div class="comment-meta clearfix">
				<div class="reply">
					<?php edit_comment_link( esc_html__( 'Edit', 'enside' ), '', '' ); ?>
					<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
				<div class="comment-author vcard">

					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, 60 ); ?>

				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<div class="author">
					<?php printf( wp_kses_post('%s'), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div>
					<div class="date"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>"><?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'enside' ), get_comment_date(), get_comment_time() ); ?></time></a></div>

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'enside' ); ?></p>
					<?php endif; ?>
					<div class="comment-content">
						<?php comment_text(); ?>
					</div>
				</div><!-- .comment-metadata -->

			</div><!-- .comment-meta -->

		</article><!-- .comment-body -->

	<?php
	endif;
}
endif;

/**
 * Set/Get current data details for global usage in templates (post position in loop, etc)
 */
if (!function_exists('enside_set_theme_data')) :
function enside_set_theme_data($data) {
	global $enside_theme_data;

	$enside_theme_data = $data;
}
endif;

if (!function_exists('enside_get_theme_data')) :
function enside_get_theme_data() {
	global $enside_theme_data;

	return $enside_theme_data;
}
endif;

if (!function_exists('enside_get_theme_data_value')) :
function enside_get_theme_data_value($name) {
	global $enside_theme_data;

	if(isset($enside_theme_data[$name])) {
		$value = $enside_theme_data[$name];
	} else {
		$value = '';
	}

	return $value;
}
endif;

/**
 * Stop WordPress from removing tags in posts
 */
if (!function_exists('enside_tinymce_fix')) :
function enside_tinymce_fix( $init ) {
    $init['extended_valid_elements'] = 'div[*],br,i[*]';

    return $init;
}
endif;
add_filter('tiny_mce_before_init', 'enside_tinymce_fix');

/**
 * Change read more link
 */
add_filter( 'the_content_more_link', 'enside_read_more_link' );
if (!function_exists('enside_read_more_link')) :
function enside_read_more_link() {
	return '<a class="btn more-link mgt-button mgt-style-borderedgrey mgt-size-small mgt-align-left mgt-display-inline mgt-text-size-normal mgt-text-transform-none" href="' . esc_url(get_permalink()) . '">'.esc_html__('Read more', 'enside').'</a>';
}
endif;

/**
 * Custom mega menu
 */
if(isset($enside_theme_options['megamenu_enable']) && $enside_theme_options['megamenu_enable']) {
	require get_template_directory() . '/inc/mega-menu/custom-menu.php';
}

/**
 * Page excerpt support
 */
if (!function_exists('enside_pe_init')) :
function enside_pe_init() {
	if(function_exists("add_post_type_support")){
		add_post_type_support( 'page', 'excerpt' );
	}
}
add_action('init', 'enside_pe_init');
endif;

/**
 * Registers an editor stylesheet
 */
if (!function_exists('enside_add_editor_styles')) :
function enside_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'enside_add_editor_styles' );
endif;

/*
* Process already escaped complex data
*/
if (!function_exists('enside_wp_kses_data')) :
function enside_wp_kses_data($data) {
  // This function used in safe places only, where all dynamic data already escaped before,
  // and does not need double escaping

  return $data;
}
endif;

/**
 * Remove gutenberg widgets editor
 */
function enside_theme_support() {
		remove_theme_support('widgets-block-editor');
}
add_action('after_setup_theme', 'enside_theme_support');


/**
 * Load theme additional functions.
 */
require get_template_directory() . '/inc/theme-functions.php';

/**
 * Load theme widgets.
 */
require get_template_directory() . '/inc/theme-sidebars.php';

/**
 * Load theme dynamic CSS.
 */
require get_template_directory() . '/inc/theme-css.php';

/**
 * Load theme dynamic JS.
 */
require get_template_directory() . '/inc/theme-js.php';

/**
 * Load theme additional modules.
 */
require get_template_directory() . '/inc/modules/wp-category-image.php';
