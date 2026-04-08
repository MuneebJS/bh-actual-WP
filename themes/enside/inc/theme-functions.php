<?php

/**
 * Additional theme functions
 **/

$enside_theme_options = enside_get_theme_options();

require_once('class-tgm-plugin-activation.php');

/**
 * Plugins installations
 */
if (!function_exists('enside_register_required_plugins')) :
    function enside_register_required_plugins() {
        $plugins = array(

            array(
                'name'                  => esc_html__('Enside Visual Page Builder', 'enside'), // The plugin name
                'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
                'source'                => get_template_directory() . '/inc/plugins/js_composer.zip', // The plugin source
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
                'version'               => '7.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            ),
            array(
                'name'                  => esc_html__('Enside Theme Addons', 'enside'), // The plugin name
                'slug'                  => 'enside-theme-addons', // The plugin slug (typically the folder name)
                'source'                => get_template_directory() . '/inc/plugins/enside-theme-addons.zip', // The plugin source
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
                'version'               => '1.4.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            ),
            array(
                'name'                  => esc_html__('Enside Custom Metaboxes', 'enside'), // The plugin name
                'slug'                  => 'cmb2', // The plugin slug (typically the folder name)
                'required'              => true, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name'                  => esc_html__('Revolution Slider', 'enside'), // The plugin name
                'slug'                  => 'revslider', // The plugin slug (typically the folder name)
                'source'                => get_template_directory() . '/inc/plugins/revslider.zip', // The plugin source
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
                'version'               => '6.6.15', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            ),
            array(
                'name'                  => esc_html__('Enside Widgets Display', 'enside'), // The plugin name
                'slug'                  => 'ah-display-widgets', // The plugin slug (typically the folder name)
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name'                  => esc_html__('WordPress Breadcrumbs', 'enside'), // The plugin name
                'slug'                  => 'breadcrumb-navxt', // The plugin slug (typically the folder name)
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name'                  => esc_html__('WordPress LightBox', 'enside'), // The plugin name
                'slug'                  => 'responsive-lightbox', // The plugin slug (typically the folder name)
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name'                  => esc_html__('WooCommerce (Shop)', 'enside'), // The plugin name
                'slug'                  => 'woocommerce', // The plugin slug (typically the folder name)
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name'                  => esc_html__('Contact Form 7', 'enside'), // The plugin name
                'slug'                  => 'contact-form-7', // The plugin slug (typically the folder name)
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name'                  => esc_html__('Regenerate Thumbnails', 'enside'), // The plugin name
                'slug'                  => 'regenerate-thumbnails', // The plugin slug (typically the folder name)
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name'                  => esc_html__('Enside Translation Manager', 'enside'), // The plugin name
                'slug'                  => 'loco-translate', // The plugin slug (typically the folder name)
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
            )

        );

        $config = array(
            'domain'            => 'enside',           // Text domain - likely want to be the same as your theme.
            'default_path'      => '',                          // Default absolute path to pre-packaged plugins
            'menu'              => 'install-required-plugins',  // Menu slug
            'has_notices'       => true,                        // Show admin notices or not
            'dismissable'  => true,
            'is_automatic'      => false,                       // Automatically activate plugins after installation or not
            'message'           => ''                          // Message to output right before the plugins table
        );

        tgmpa($plugins, $config);
    }
endif;
add_action('tgmpa_register', 'enside_register_required_plugins');

/**
 * Google Fonts Loading
 */
if (!function_exists('enside_google_fonts_url')) :
    function enside_google_fonts_url() {

        $enside_theme_options = enside_get_theme_options();

        $font_url = '';
        $font_header = '';
        $font_body = '';
        $font_additional = '';

        // Demo settings
        if (defined('DEMO_MODE') && isset($_GET['header_font'])) {
            $enside_theme_options['header_font']['font-family'] = $_GET['header_font'];
        }
        if (defined('DEMO_MODE') && isset($_GET['body_font'])) {
            $enside_theme_options['body_font']['font-family'] = $_GET['body_font'];
        }
        if (defined('DEMO_MODE') && isset($_GET['additional_font'])) {
            $enside_theme_options['additional_font']['font-family'] = $_GET['additional_font'];
        }
        if (defined('DEMO_MODE') && isset($_GET['buttons_font'])) {
            $enside_theme_options['buttons_font']['font-family'] = $_GET['buttons_font'];
        }

        if (!isset($enside_theme_options['font_google_disable']) || $enside_theme_options['font_google_disable'] == false) {

            // Header font
            if (isset($enside_theme_options['header_font'])) {
                $font_header = $enside_theme_options['header_font']['font-family'];

                if (isset($enside_theme_options['header_font_options'])) {
                    $font_header = $font_header . ':' . $enside_theme_options['header_font_options'];
                }
            }
            // Body font
            if (isset($enside_theme_options['body_font'])) {
                $font_body = '|' . $enside_theme_options['body_font']['font-family'];

                if (isset($enside_theme_options['body_font_options'])) {
                    $font_body = $font_body . ':' . $enside_theme_options['body_font_options'];
                }
            }
            // Buttons font
            if (isset($enside_theme_options['buttons_font'])) {
                $font_buttons = '|' . $enside_theme_options['buttons_font']['font-family'];

                if (isset($enside_theme_options['buttons_font_options'])) {
                    $font_buttons = $font_buttons . ':' . $enside_theme_options['buttons_font_options'];
                }
            }
            // Additional font
            if (isset($enside_theme_options['additional_font_enable']) && $enside_theme_options['additional_font_enable']) {
                if (isset($enside_theme_options['additional_font'])) {
                    $font_additional = '|' . $enside_theme_options['additional_font']['font-family'] . '|';
                }
            }

            // Build Google Fonts request
            $font_url = add_query_arg('family', urlencode($font_header . $font_body . $font_buttons . $font_additional), "//fonts.googleapis.com/css");
        }

        return $font_url;
    }
endif;

/**
 * Social Icons display
 */
if (!function_exists('enside_social_icons_show')) :
    function enside_social_icons_show() {

        $enside_theme_options = enside_get_theme_options();

        $s_count = 0;

        $social_services_html = '';

        $social_services_arr = array("facebook", "vk", "twitter", "google-plus", "behance", "linkedin", "dribbble", "instagram", "tumblr", "pinterest", "vimeo-square", "youtube", "skype", "houzz", "flickr", "odnoklassniki");

        foreach ($social_services_arr as $ss_data) {
            if (isset($enside_theme_options[$ss_data]) && (trim($enside_theme_options[$ss_data])) <> '') {
                $s_count++;
                $social_service_url = $enside_theme_options[$ss_data];
                $social_service = $ss_data;
                $social_services_html .= '<li><a href="' . esc_url($social_service_url) . '" target="_blank" class="a-' . esc_attr($social_service) . '"><i class="fa fa-' . esc_attr($social_service) . '"></i></a></li>';
            }
        }

        if ($s_count > 0) {
            $social_services_html = '<div class="social-icons-wrapper"><ul>' . $social_services_html . '</ul></div>';

            echo wp_kses_post($social_services_html);
        }
    }
endif;

/**
 * Top Menu Display
 */
if (!function_exists('enside_menu_top_show')) :
    function enside_menu_top_show() {
        $enside_theme_options = enside_get_theme_options();

        // DEMO SETTINGS
        if (defined('DEMO_MODE') && isset($_GET['disable_top_menu'])) {
            $enside_theme_options['disable_top_menu'] = true;
        }

        if (isset($enside_theme_options['disable_top_menu']) && (!$enside_theme_options['disable_top_menu'])) : ?>

            <?php

            // DEMO SETTINGS
            if (defined('DEMO_MODE') && isset($_GET['top_menu_position'])) {
                $enside_theme_options['top_menu_position'] = esc_html($_GET['top_menu_position']);
            }

            $header_container_class = 'container';

            $add_class = '';

            if (isset($enside_theme_options['top_menu_position'])) {
                // DEMO SETTINGS
                if (defined('DEMO_MODE') && isset($_GET['header_menu_layout'])) {
                    $enside_theme_options['header_menu_layout'] = esc_html($_GET['header_menu_layout']);
                }

                // Use menu below header if you use center logo layout
                if (isset($enside_theme_options['header_logo_position']) && $enside_theme_options['header_logo_position'] == 'center') {
                    $enside_theme_options['header_menu_layout'] = 'menu_below_header';
                }

                if ((isset($enside_theme_options['header_menu_layout'])) && ($enside_theme_options['header_menu_layout'] == 'menu_in_header')) {
                    $add_class = ' top-menu-position-' . $enside_theme_options['top_menu_position'];
                } else {

                    $add_class = ' top-menu-position-default';
                }

                if (isset($enside_theme_options['header_fullwidth']) && $enside_theme_options['header_fullwidth']) {
                    $header_container_class = 'container-fluid';
                }
            }

            // Top menu align
            if (isset($enside_theme_options['top_menu_align'])) {
                $add_class .= ' top-menu-align-' . $enside_theme_options['top_menu_align'];
            }

            ?>
            <div class="header-menu-bg<?php echo esc_attr($add_class); ?>">
                <div class="header-menu">
                    <div class="<?php echo esc_attr($header_container_class); ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                // Header top text
                                if ((isset($enside_theme_options['header_top_text'])) && ($enside_theme_options['header_top_text'] <> '')) {
                                    echo '<div class="header-top-text">';
                                    echo do_shortcode(wp_kses_post($enside_theme_options['header_top_text']));
                                    echo '</div>';
                                }

                                // Social icons
                                if ((isset($enside_theme_options['header_socialicons'])) && ($enside_theme_options['header_socialicons'])) {
                                    enside_social_icons_show();
                                }

                                ?>
                                <?php if (has_nav_menu('top')) : ?>
                                    <div class="menu-top-menu-container-toggle"></div>
                                <?php endif; ?>
                                <?php
                                wp_nav_menu(array(
                                    'theme_location'  => 'top',
                                    'menu_class'      => 'top-menu',
                                    'container_class'         => 'top-menu-container',
                                    'fallback_cb'    => false,
                                ));
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;
    }
endif;

/**
 * Menu Below Header Display
 */
if (!function_exists('enside_menu_below_header_show')) :
    function enside_menu_below_header_show() {
        $enside_theme_options = enside_get_theme_options();

        // Use menu below header if you use center logo layout
        if (isset($enside_theme_options['header_logo_position']) && $enside_theme_options['header_logo_position'] == 'center') {
            $enside_theme_options['header_menu_layout'] = 'menu_below_header';
        }

        // Demo settings
        if (defined('DEMO_MODE') && isset($_GET['header_menu_layout'])) {
            $enside_theme_options['header_menu_layout'] = esc_html($_GET['header_menu_layout']);
        }
        if (defined('DEMO_MODE') && isset($_GET['header_menu_color_scheme'])) {
            $enside_theme_options['header_menu_color_scheme'] = esc_html($_GET['header_menu_color_scheme']);
        }
        if (defined('DEMO_MODE') && isset($_GET['header_menu_align'])) {
            $enside_theme_options['header_menu_align'] = esc_html($_GET['header_menu_align']);
        }
        if (defined('DEMO_MODE') && isset($_GET['header_menu_text_transform'])) {
            $enside_theme_options['header_menu_text_transform'] = esc_html($_GET['header_menu_text_transform']);
        }
        if (defined('DEMO_MODE') && isset($_GET['header_menu_width'])) {
            $enside_theme_options['header_menu_width'] = esc_html($_GET['header_menu_width']);
        }

        // MainMenu Below header position
        if ((isset($enside_theme_options['header_menu_layout'])) && ($enside_theme_options['header_menu_layout'] == 'menu_below_header')) :
        ?>
            <?php
            // Main menu below header color scheme
            if (!isset($enside_theme_options['header_menu_color_scheme'])) {
                $enside_theme_options['header_menu_color_scheme'] = 'dark';
            }
            if ($enside_theme_options['header_menu_color_scheme'] == 'menu_dark') {
                $menu_add_class = ' mainmenu-dark';
            }
            if ($enside_theme_options['header_menu_color_scheme'] == 'menu_light') {
                $menu_add_class = ' mainmenu-light';
            }
            if ($enside_theme_options['header_menu_color_scheme'] == 'menu_light_clean') {
                $menu_add_class = ' mainmenu-light mainmenu-light-clean';
            }

            // Main menu align
            if (!isset($enside_theme_options['header_menu_align'])) {
                $enside_theme_options['header_menu_align'] = 'menu_left';
            }

            if ((isset($enside_theme_options['header_menu_align'])) && ($enside_theme_options['header_menu_align'] == 'menu_left')) {
                $menu_add_class .= ' menu-left';
            }

            if ((isset($enside_theme_options['header_menu_align'])) && ($enside_theme_options['header_menu_align'] == 'menu_center')) {
                $menu_add_class .= ' menu-center';
            }

            if ((isset($enside_theme_options['header_menu_align'])) && ($enside_theme_options['header_menu_align'] == 'menu_right')) {
                $menu_add_class .= ' menu-right';
            }

            // Menu font weight
            if ((isset($enside_theme_options['header_menu_font_weight'])) && ($enside_theme_options['header_menu_font_weight'] == 'bold')) {
                $menu_add_class .= ' menu-font-weight-bold';
            }

            // Main menu text transform
            if ((isset($enside_theme_options['header_menu_text_transform'])) && ($enside_theme_options['header_menu_text_transform'] == 'menu_uppercase')) {
                $menu_add_class .= ' menu-uppercase';
            }

            // Main menu width
            if ((isset($enside_theme_options['header_menu_width'])) && ($enside_theme_options['header_menu_width'] == 'menu_boxed')) {
                $menu_add_class .= ' container';
            }

            ?>
            <div class="mainmenu-belowheader<?php echo esc_attr($menu_add_class); ?>">
                <?php
                // Main Menu

                $menu = wp_nav_menu(
                    array(
                        'theme_location'  => 'primary',
                        'echo' => FALSE,
                        'fallback_cb'    => false,
                    )
                );

                if (!empty($menu)) :
                ?>
                    <?php
                    $add_class = '';

                    if (isset($enside_theme_options['header_menu_style']) && $enside_theme_options['header_menu_style']) {
                        $add_class .= " menu-style-" . $enside_theme_options['header_menu_style'];
                    }

                    if (isset($enside_theme_options['megamenu_enable']) && $enside_theme_options['megamenu_enable']) {
                        $add_class .= " mgt-mega-menu";
                    }
                    ?>
                    <div id="navbar" class="navbar navbar-default clearfix<?php echo esc_attr($add_class); ?>">
                        <div class="navbar-inner">
                            <div class="container">

                                <?php
                                if (isset($enside_theme_options['megamenu_enable']) && $enside_theme_options['megamenu_enable']) {
                                    wp_nav_menu(array(
                                        'theme_location'  => 'primary',
                                        'container_class' => 'navbar-collapse collapse',
                                        'menu_class'      => 'nav',
                                        'fallback_cb'    => false,
                                        'walker'          => new enside_megamenu_walker
                                    ));
                                } else {
                                    wp_nav_menu(array(
                                        'theme_location'  => 'primary',
                                        'container_class' => 'navbar-collapse collapse',
                                        'menu_class'      => 'nav',
                                        'fallback_cb'    => false,
                                        'walker'          => new enside_mainmenu_walker
                                    ));
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        <?php
        endif;
        // MainMenu Below header position END
    }
endif;

/**
 * Header Logo Display
 */
if (!function_exists('enside_header_logo_show')) :
    function enside_header_logo_show() {

        $enside_theme_options = enside_get_theme_options();

        // Text logo
        if ((isset($enside_theme_options['logo_text_enable'])) && ($enside_theme_options['logo_text_enable']) && (isset($enside_theme_options['logo_text'])) && ($enside_theme_options['logo_text'] !== '')) {
        ?>
            <a class="logo-link logo-text" href="<?php echo esc_url(home_url()); ?>"><?php echo wp_kses_post($enside_theme_options['logo_text']); ?></a>
        <?php
            // Image logo
        } else {
        ?>
            <a class="logo-link" href="<?php echo esc_url(home_url()); ?>"><img src="<?php echo esc_url(get_header_image()); ?>" alt="<?php bloginfo('name'); ?>" class="regular-logo"><img src="<?php if (get_theme_mod('enside_header_transparent_logo')) {
                                                                                                                                                                                                        echo esc_url(get_theme_mod('enside_header_transparent_logo'));
                                                                                                                                                                                                    } else {
                                                                                                                                                                                                        echo esc_url(get_header_image());
                                                                                                                                                                                                    }  ?>" alt="<?php bloginfo('name'); ?>" class="light-logo"></a>
        <?php
        }


        if (isset($enside_theme_options['header_position']) && $enside_theme_options['header_position'] !== 'left') {
            // Mobile offcanvas menu toggle
            if (isset($enside_theme_options['header_menu_type']) && ($enside_theme_options['header_menu_type'] == 'offcanvas')) {

                echo '<div class="mobile-sidebar-trigger"><div class="st-sidebar-trigger-effects"><a class="float-sidebar-toggle-btn" data-effect="st-sidebar-effect-2"><i class="fa fa-bars"></i></a></div></div>';
            }

            // Mobile fullscreen menu toggle
            if (isset($enside_theme_options['header_menu_type']) && ($enside_theme_options['header_menu_type'] == 'fullscreen')) {
                echo '<div class="mobile-sidebar-trigger"><a class="header-advanced-menu-toggle-btn"><i class="fa fa-bars"></i></a></div>';
            }

            // Mobile menu toggle
            $main_menu = wp_nav_menu(
                array(
                    'theme_location'  => 'primary',
                    'echo' => FALSE,
                    'fallback_cb'    => false,
                )
            );

            if (!empty($main_menu)) {

                echo '<div class="mobile-main-menu-toggle" data-toggle="collapse" data-target=".collapse"><i class="fa fa-bars"></i></div>';
            }

            // Mobile search toggle toggle
            if (isset($enside_theme_options['enable_fullscreen_search']) && ($enside_theme_options['enable_fullscreen_search'])) {

                echo '<div class="mobile-trigger-search"><a class="search-toggle-btn"><i class="fa fa-search"></i></a></div>';
            }
        }
    }
endif;

/**
 * Header Info Display
 */
if (!function_exists('enside_header_info_show')) :
    function enside_header_info_show() {

        $enside_theme_options = enside_get_theme_options();

        if ((isset($enside_theme_options['header_info_text'])) && ($enside_theme_options['header_info_text'] <> '')) {
            echo '<div class="header-info-text">' . do_shortcode(wp_kses_post($enside_theme_options['header_info_text'])) . '</div>';
        }
    }
endif;

/**
 * Header Side Info Display
 */
if (!function_exists('enside_header_side_info_show')) :
    function enside_header_side_info_show() {

        $enside_theme_options = enside_get_theme_options();

        if ((isset($enside_theme_options['header_side_info_text'])) && ($enside_theme_options['header_side_info_text'] <> '')) {
            echo '<div class="header-side-info-text">' . do_shortcode(wp_kses_post($enside_theme_options['header_side_info_text'])) . '</div>';
        }
    }
endif;

/**
 * Header Left Side Position Display
 */
if (!function_exists('enside_header_side_show')) :
    function enside_header_side_show() {

        $enside_theme_options = enside_get_theme_options();

        $header_menu_add_class = '';

        if (!isset($enside_theme_options['header_side_align'])) {
            $enside_theme_options['header_side_align'] = 'left';
        }
        // Align
        $header_wrapper_addclass = ' header-left-align-' . $enside_theme_options['header_side_align'];

        if (!isset($enside_theme_options['header_side_color_style'])) {
            $enside_theme_options['header_side_color_style'] = 'light';
        }
        // Color style
        $header_wrapper_addclass .= ' header-color-style-' . $enside_theme_options['header_side_color_style'];

        ?>
        <div class="header-left-wrapper<?php echo esc_attr($header_wrapper_addclass); ?>">
            <div class="header-left-logo clearfix">
                <?php enside_header_logo_show(); ?>
                <div class="header-left-menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
            </div>
            <?php if ((isset($enside_theme_options['header_side_search_enable'])) && ($enside_theme_options['header_side_search_enable'])) : ?>
                <div class="header-left-search">
                    <?php get_template_part('searchform-popup'); ?>
                </div>
            <?php endif; ?>
            <?php
            // Header left menu text transform
            if ((isset($enside_theme_options['header_side_menu_text_transform'])) && ($enside_theme_options['header_side_menu_text_transform'] == 'menu_uppercase')) {
                $header_menu_add_class = ' menu-uppercase';
            }
            // Header left menu font weight
            if ((isset($enside_theme_options['header_side_menu_font_weight'])) && ($enside_theme_options['header_side_menu_font_weight'] == 'bold')) {
                $header_menu_add_class .= ' menu-font-weight-bold';
            }
            ?>
            <div class="header-left-menu-wrapper<?php echo esc_attr($header_menu_add_class); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location'  => 'primary',
                    'menu_class'      => 'header-left-menu',
                    'fallback_cb'    => false,
                    'walker'          => new enside_megamenu_walker
                ));
                ?>
            </div>
            <?php if (is_active_sidebar('header-left-sidebar')) : ?>
                <div class="header-left-sidebar sidebar">
                    <ul id="main-sidebar">
                        <?php dynamic_sidebar('header-left-sidebar'); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php
            // Social icons
            if ((isset($enside_theme_options['header_socialicons'])) && ($enside_theme_options['header_socialicons'])) {
                enside_social_icons_show();
            }
            ?>
            <?php
            // Header info text
            enside_header_side_info_show();
            ?>
        </div>
    <?php

    }
endif;

/*
* WooCommerce ajax add to cart
*/
// Ensure cart contents update when products are added to the cart via AJAX
if (!function_exists('enside_woocommerce_header_add_to_cart_fragment')) :
    function enside_woocommerce_header_add_to_cart_fragment($fragments) {
        $enside_theme_options = enside_get_theme_options();
        global $woocommerce;

        $add_class = '';

        // Main menu text transform
        if ((isset($enside_theme_options['header_menu_text_transform'])) && ($enside_theme_options['header_menu_text_transform'] == 'menu_uppercase')) {
            $add_class .= ' menu-uppercase';
        }

        // Main menu font weight
        if ((isset($enside_theme_options['header_menu_font_weight'])) && ($enside_theme_options['header_menu_font_weight'] == 'bold')) {
            $add_class .= ' menu-font-weight-bold';
        }

        ob_start();
    ?>
        <div class="shopping-cart" id="shopping-cart">

            <a class="cart-toggle-btn" href="<?php echo esc_url(wc_get_cart_url()); ?>"><i class="fa fa-shopping-cart"></i>
                <?php if ($woocommerce->cart->cart_contents_count > 0) : ?>
                    <div class="shopping-cart-count"><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></div>
                <?php endif; ?>
                <span class="<?php echo esc_attr($add_class); ?>"><?php esc_html_e('Shopping cart', 'enside'); ?></span>
            </a>

            <div class="shopping-cart-content">
                <?php
                $cart_products_i = 0;
                $cart_products_more = 0;
                $cart_products_count = count($woocommerce->cart->get_cart());

                if ($woocommerce->cart->cart_contents_count > 0) : ?>
                    <div class="shopping-cart-products">
                        <?php foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) : $_product = $cart_item['data'];
                            if (!apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key) || !$_product->exists() || $cart_item['quantity'] == 0) continue;

                            $cart_products_i++;

                            if (isset($enside_theme_options['woocommerce_mini_cart_limit'])) {
                                $cart_products_more_limit = $enside_theme_options['woocommerce_mini_cart_limit'];
                            } else {
                                $cart_products_more_limit = 3;
                            }

                            if ($cart_products_i == $cart_products_more_limit + 1) {
                                $cart_products_more = $cart_products_count - $cart_products_more_limit;
                                break;
                            }

                            $product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? wc_get_price_excluding_tax($_product) : wc_get_price_including_tax($_product);
                            $product_price = apply_filters('woocommerce_cart_item_price_html', wc_price($product_price), $cart_item, $cart_item_key);
                        ?>
                            <div class="shopping-cart-product clearfix">
                                <div class="shopping-cart-product-image">
                                    <a href="<?php echo get_permalink($cart_item['product_id']); ?>"><?php echo wp_kses_post($_product->get_image()); ?></a>
                                </div>
                                <div class="shopping-cart-product-remove">
                                    <?php
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">×</a>', esc_url(wc_get_cart_remove_url($cart_item_key)), esc_html__('Remove this item', 'enside')), $cart_item_key));
                                    ?>
                                </div>
                                <div class="shopping-cart-product-title">
                                    <a href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>"><?php echo wp_kses_post(apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product)); ?></a>
                                </div>
                                <div class="shopping-cart-product-price">
                                    <?php echo wp_kses_post(wc_get_formatted_cart_item_data($cart_item)); ?><span class="quantity"><?php wp_kses_post(printf('%s &times; %s', $cart_item['quantity'], $product_price)); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if ($cart_products_more > 0) : ?>
                            <div class="shopping-cart-product-more"><?php esc_html_e('And', 'enside'); ?> <?php echo wp_kses_post($cart_products_more); ?> <?php esc_html_e('more product(s) in cart.', 'enside'); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="shopping-cart-subtotal clearfix">
                        <div class="shopping-cart-subtotal-text"><?php esc_attr_e('Subtotal', 'enside'); ?></div>
                        <div class="shopping-cart-subtotal-value"><?php echo wp_kses_post(wc_cart_totals_subtotal_html()); ?></div>
                    </div>
                    <a class="btn mgt-button" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'enside'); ?>"><?php esc_html_e('View cart', 'enside'); ?></a> <a class="btn mgt-button mgt-style-bordered mgt-button-checkout" href="<?php echo esc_url(wc_get_checkout_url()); ?>" title="<?php esc_html_e('Proceed to checkout', 'enside'); ?>"><?php esc_html_e('Proceed to checkout', 'enside'); ?></a>
                <?php else : ?>
                    <div class="empty-cart-icon-mini">

                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>

                    </div>
                    <div class="empty"><?php esc_html_e('No products in the cart.', 'enside'); ?></div>
                <?php endif; ?>

            </div>
        </div>
        <?php
        $fragments['#shopping-cart'] = ob_get_clean();
        return $fragments;
    }
endif;

if (class_exists('Woocommerce')) {
    add_filter('woocommerce_add_to_cart_fragments', 'enside_woocommerce_header_add_to_cart_fragment');
}

/**
 * Header Left Part Display
 */
if (!function_exists('enside_header_left_show')) :
    function enside_header_left_show() {

        $enside_theme_options = enside_get_theme_options();

        if (isset($enside_theme_options['header_logo_position']) && $enside_theme_options['header_logo_position'] == 'center') {
            enside_header_info_show();
        } else {
            enside_header_logo_show();
        }
    }
endif;

/**
 * Header Center Part Display
 */
if (!function_exists('enside_header_center_show')) :
    function enside_header_center_show() {
        $enside_theme_options = enside_get_theme_options();

        // Demo settings
        if (defined('DEMO_MODE') && isset($_GET['header_menu_layout'])) {
            $enside_theme_options['header_menu_layout'] = $_GET['header_menu_layout'];
        }
        if (defined('DEMO_MODE') && isset($_GET['header_menu_text_transform'])) {
            $enside_theme_options['header_menu_text_transform'] = esc_html($_GET['header_menu_text_transform']);
        }

        if (isset($enside_theme_options['header_logo_position']) && $enside_theme_options['header_logo_position'] == 'center') {
            enside_header_logo_show();
        } else {

            // MainMenu in Header position
            if ((isset($enside_theme_options['header_menu_layout'])) && ($enside_theme_options['header_menu_layout'] == 'menu_in_header')) :
        ?>
                <?php
                // Main Menu in header
                $menu = wp_nav_menu(
                    array(
                        'theme_location'  => 'primary',
                        'echo' => FALSE,
                        'fallback_cb'    => false,
                    )
                );

                if (!empty($menu)) :
                ?>
                    <?php
                    if (isset($enside_theme_options['megamenu_enable']) && $enside_theme_options['megamenu_enable']) {
                        $add_class = " mgt-mega-menu";
                    } else {
                        $add_class = "";
                    }

                    // Main menu align
                    if (!isset($enside_theme_options['header_menu_align'])) {
                        $enside_theme_options['header_menu_align'] = 'menu_left';
                    }

                    if ((isset($enside_theme_options['header_menu_align'])) && ($enside_theme_options['header_menu_align'] == 'menu_left')) {
                        $add_class .= ' menu-left';
                    }

                    if ((isset($enside_theme_options['header_menu_align'])) && ($enside_theme_options['header_menu_align'] == 'menu_center')) {
                        $add_class .= ' menu-center';
                    }

                    if ((isset($enside_theme_options['header_menu_align'])) && ($enside_theme_options['header_menu_align'] == 'menu_right')) {
                        $add_class .= ' menu-right';
                    }

                    // Main menu font weight
                    if ((isset($enside_theme_options['header_menu_font_weight'])) && ($enside_theme_options['header_menu_font_weight'] == 'bold')) {
                        $add_class .= ' menu-font-weight-bold';
                    }

                    // Main menu text transform
                    if ((isset($enside_theme_options['header_menu_text_transform'])) && ($enside_theme_options['header_menu_text_transform'] == 'menu_uppercase')) {
                        $add_class .= ' menu-uppercase';
                    }

                    // Dropdown menus style
                    if (!isset($enside_theme_options['header_menu_style'])) {
                        $enside_theme_options['header_menu_style'] = 'shadow';
                    }

                    if (isset($enside_theme_options['header_menu_style']) && $enside_theme_options['header_menu_style']) {
                        $add_class .= " menu-style-" . $enside_theme_options['header_menu_style'];
                    }

                    ?>
                    <div id="navbar" class="navbar navbar-default clearfix<?php echo esc_attr($add_class); ?>">
                        <div class="navbar-inner">


                            <?php
                            if (isset($enside_theme_options['megamenu_enable']) && $enside_theme_options['megamenu_enable']) {
                                wp_nav_menu(array(
                                    'theme_location'  => 'primary',
                                    'container_class' => 'navbar-collapse collapse',
                                    'menu_class'      => 'nav',
                                    'fallback_cb'    => false,
                                    'walker'          => new enside_megamenu_walker
                                ));
                            } else {
                                wp_nav_menu(array(
                                    'theme_location'  => 'primary',
                                    'container_class' => 'navbar-collapse collapse',
                                    'menu_class'      => 'nav',
                                    'fallback_cb'    => false,
                                    'walker'          => new enside_mainmenu_walker
                                ));
                            }
                            ?>

                        </div>
                    </div>
                <?php endif; //!empty($menu)
                ?>
            <?php else : ?>
                <?php
                // Header info
                enside_header_info_show();
                ?>
        <?php
            endif;
            // MainMenu in Header position END

        }
    }
endif;

/**
 * Header Right Part Display
 */
if (!function_exists('enside_header_right_show')) :
    function enside_header_right_show() {
        $enside_theme_options = enside_get_theme_options();

        // Demo settings
        if (defined('DEMO_MODE') && isset($_GET['header_menu_type'])) {
            $enside_theme_options['header_menu_type'] = $_GET['header_menu_type'];
        }

        ?>

        <ul class="header-nav">
            <?php
            if (isset($enside_theme_options['enable_fullscreen_search']) && ($enside_theme_options['enable_fullscreen_search'])) :
            ?>
                <li class="search-toggle">
                    <div id="trigger-search"><a class="search-toggle-btn"><i class="fa fa-search"></i></a></div>
                </li>
            <?php endif; ?>
            <?php
            $menu_button_html = '<div class="icon-lined-menu"><span class="icon-lined-menu-line"></span><span class="icon-lined-menu-line"></span><span class="icon-lined-menu-line"></span></div>';
            ?>
            <?php
            if (isset($enside_theme_options['header_menu_type']) && ($enside_theme_options['header_menu_type'] == 'offcanvas')) :
            ?>
                <li class="header-advanced-menu-toggle">
                    <div class="st-sidebar-trigger-effects"><a class="float-sidebar-toggle-btn" data-effect="st-sidebar-effect-2"><?php echo wp_kses_post($menu_button_html); ?></a></div>
                </li>
            <?php endif; ?>

            <?php
            if (isset($enside_theme_options['header_menu_type']) && ($enside_theme_options['header_menu_type'] == 'fullscreen')) :
            ?>
                <li class="header-advanced-menu-toggle">
                    <div class="header-advanced-menu-toggle-inside"><a class="header-advanced-menu-toggle-btn"><?php echo wp_kses_post($menu_button_html); ?></a></div>
                </li>
            <?php endif; ?>

            <?php
            if (isset($enside_theme_options['enable_woocommerce_cart']) && ($enside_theme_options['enable_woocommerce_cart'])) :
            ?>
                <?php if (class_exists('Woocommerce')) : ?>
                    <li class="woocommerce-mini-cart">
                        <?php
                        // Show cart dropdown
                        $fragments = array();
                        $cart_display = enside_woocommerce_header_add_to_cart_fragment($fragments);
                        // Esc this
                        //
                        echo wp_kses_post($cart_display['#shopping-cart']);
                        ?>
                    </li>
                <?php endif; ?>

            <?php endif; ?>
        </ul>

    <?php
    }
endif;

/**
 * Footer copyright display
 */
if (!function_exists('enside_show_footer_copyright')) :
    function enside_show_footer_copyright($footer_col_class) {
        $enside_theme_options = enside_get_theme_options();
    ?>
        <div class="<?php echo esc_attr($footer_col_class); ?> footer-copyright">
            <?php
            if (isset($enside_theme_options['footer_copyright_text'])) {
                echo do_shortcode(wp_kses_post($enside_theme_options['footer_copyright_text']));
            }
            ?>
        </div>
    <?php
    }
endif;

/**
 * Footer menu display
 */
if (!function_exists('enside_show_footer_menu')) :
    function enside_show_footer_menu($footer_col_class) {
        $enside_theme_options = enside_get_theme_options();
    ?>
        <div class="<?php echo esc_attr($footer_col_class); ?> footer-menu">
            <?php
            wp_nav_menu(array(
                'theme_location'  => 'footer',
                'menu_class'      => 'footer-menu',
                'fallback_cb'    => false
            ));
            ?>
        </div>
        <?php
    }
endif;

/**
 * Blog post excerpt read more link customization
 */
if (!function_exists('enside_excerpt_more')) :
    function enside_excerpt_more($more) {
        return '...';
    }
endif;
add_filter('excerpt_more', 'enside_excerpt_more');

/**
 * Breadcrumbs display
 */
if (!function_exists('enside_show_breadcrumbs')) :
    function enside_show_breadcrumbs() {
        if (function_exists('bcn_display')) :
        ?>
            <div class="breadcrumbs-container-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                                <?php bcn_display(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php endif;
    }
endif;


/**
 * Custom body classes
 */
add_filter('body_class', 'enside_body_classes');
if (!function_exists('enside_body_classes')) :
    function enside_body_classes($classes) {

        $enside_theme_options = enside_get_theme_options();

        // Progress bar
        if (isset($enside_theme_options['enable_progressbar']) && $enside_theme_options['enable_progressbar']) {
            $classes[] = 'enable-progressbar';
        }

        // Left header
        if (isset($enside_theme_options['header_position']) && $enside_theme_options['header_position'] == 'left') {
            $classes[] = 'enable-left-header';
        }

        // Sticky header on touch devices
        if (isset($enside_theme_options['sticky_header_touch_disable']) && $enside_theme_options['sticky_header_touch_disable']) {
            $classes[] = 'sticky-header-disable-touch';
        }

        return $classes;
    }
endif;

/**
 * WooCommerce sale badge text
 */
add_filter('woocommerce_sale_flash', 'enside_custom_sale_text');

if (!function_exists('enside_custom_sale_text')) :
    function enside_custom_sale_text($html) {
        $sale_badge_html = '<span class="onsale">' . esc_html__('Sale', 'enside') . '</i></span>';

        return $sale_badge_html;
    }
endif;

/**
 * CMB2 images file list display
 *
 * @param  string  $file_list_meta_key The field meta key. ('wiki_test_file_list')
 * @param  string  $img_size           Size of image to show
 */
if (!function_exists('enside_cmb2_get_images_src')) :
    function enside_cmb2_get_images_src($post_id, $file_list_meta_key, $img_size = 'medium') {

        // Get the list of files
        $files = get_post_meta($post_id, $file_list_meta_key, 1);

        $attachments_image_urls_array = array();

        foreach ((array) $files as $attachment_id => $attachment_url) {

            $current_attach = wp_get_attachment_image_src($attachment_id, $img_size);

            $attachments_image_urls_array[] = $current_attach[0];
        }

        if ($attachments_image_urls_array[0] == '') {
            $attachments_image_urls_array = array();
        }

        return $attachments_image_urls_array;
    }
endif;

/**
 * Set RevSlider as theme bundled
 */
if (function_exists('set_revslider_as_theme')) {

    add_action('init', 'enside_setRevSlider_asTheme');

    function enside_setRevSlider_asTheme() {
        set_revslider_as_theme();
    }
}

/**
 * Customisation Menu Links
 */
class enside_mainmenu_walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        global $wp_query;
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $class_names = $value = '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));

        $add_class = '';

        $post = get_post($item->object_id);

        $class_names = ' class="' . $add_class . ' ' . esc_attr($class_names) . '"';
        $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';
        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';

        $attributes .= !empty($item->url)        ? ' href="'   . esc_url($item->url) . '"' : '';

        if (is_object($args)) {
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID);
            $item_output .= $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }
}
