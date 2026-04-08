<?php
/**
 * Theme sidebars
 */

$enside_theme_options = enside_get_theme_options();

/**
 * Theme sidebars
 */
if (!function_exists('enside_sidebars_init')) :
function enside_sidebars_init() {

    $enside_theme_options = enside_get_theme_options();

    register_sidebar(
      array(
        'name' => esc_html__( 'Blog sidebar', 'enside' ),
        'id' => 'main-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the left or right site column for blog related pages.', 'enside' )
      )
    );
    register_sidebar(
      array(
        'name' => esc_html__( 'Page sidebar', 'enside' ),
        'id' => 'page-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the left or right site column for pages.', 'enside' )
      )
    );
    register_sidebar(
      array(
        'name' => esc_html__( 'Portfolio sidebar', 'enside' ),
        'id' => 'portfolio-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the left or right site column for portfolio items pages.', 'enside' )
      )
    );
    register_sidebar(
      array(
        'name' => esc_html__( 'WooCommerce sidebar', 'enside' ),
        'id' => 'woocommerce-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the left or right site column for woocommerce pages.', 'enside' )
      )
    );
    register_sidebar(
      array(
        'name' => esc_html__( 'Offcanvas Right sidebar', 'enside' ),
        'id' => 'offcanvas-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the right floating offcanvas menu sidebar that can be opened by toggle button in header. You can enable this sidebar in theme control panel.', 'enside' )
      )
    );

    register_sidebar(
      array(
        'name' => esc_html__( 'Bottom sidebar (4 column)', 'enside' ),
        'id' => 'bottom-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown below site content in 4 column.', 'enside' )
      )
    );

    register_sidebar(
      array(
        'name' => esc_html__( 'Footer sidebar (1-5 columns)', 'enside' ),
        'id' => 'footer-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in site footer in 4 column below Bottom sidebar.', 'enside' )
      )
    );

    register_sidebar(
      array(
        'name' => esc_html__( 'Header Left Sidebar', 'enside' ),
        'id' => 'header-left-sidebar',
        'description' => esc_html__( 'Widgets in this area will be shown in the left header below menu if you use Left side header.', 'enside' )
      )
    );

    // Mega Menu sidebars
    if(isset($enside_theme_options['megamenu_sidebars_count']) && ($enside_theme_options['megamenu_sidebars_count'] > 0)) {
        for ($i = 1; $i <= $enside_theme_options['megamenu_sidebars_count']; $i++) {
            register_sidebar(
              array(
                'name' => esc_html__( 'MegaMenu sidebar #', 'enside' ).$i,
                'id' => 'megamenu_sidebar_'.$i,
                'description' => esc_html__( 'You can use this sidebar to display widgets inside megamenu items in menus.', 'enside' )
              )
            );
        }
    }
}
endif;
add_action( 'widgets_init', 'enside_sidebars_init' );
?>
