<?php

	add_action( 'wp_enqueue_scripts', 'enside_enqueue_dynamic_styles', '999' );

    if (!function_exists('enside_enqueue_dynamic_styles')) :
	function enside_enqueue_dynamic_styles( ) {

        require_once(ABSPATH . 'wp-admin/includes/file.php'); // required to use WP_Filesystem()

        WP_Filesystem();

        $enside_theme_options = enside_get_theme_options();
        global $wp_filesystem;

        if ( function_exists( 'is_multisite' ) && is_multisite() ){
            $cache_file_name = 'style-cache-'.wp_get_theme()->get('TextDomain').'-b' . get_current_blog_id();
        } else {
            $cache_file_name = 'style-cache-'.wp_get_theme()->get('TextDomain');
        }

        $wp_upload_dir = wp_upload_dir();

        $css_cache_file = $wp_upload_dir['basedir'].'/'.$cache_file_name.'.css';

        $css_cache_file_url = $wp_upload_dir['baseurl'].'/'.$cache_file_name.'.css';

        $ipanel_saved_date = get_option( 'ipanel_saved_date', 1 );
        $cache_saved_date = get_option( 'cache_css_saved_date', 0 );

        if( file_exists( $css_cache_file ) ) {
            $cache_status = 'exist';

            if($ipanel_saved_date > $cache_saved_date) {
                $cache_status = 'no-exist';
            }

        } else {
            $cache_status = 'no-exist';
        }

        if ( defined('DEMO_MODE') ) {
            $cache_status = 'no-exist';
        }

        if ( $cache_status == 'exist' ) {

            wp_register_style( $cache_file_name, $css_cache_file_url, $cache_saved_date);
            wp_enqueue_style( $cache_file_name );

        } else {

            $out = '';

            $generated = microtime(true);

            $out = enside_get_css();

            $out = str_replace( array( "\t", "
", "\n", "  ", "   ", ), array( "", "", " ", " ", " ", ), $out );

            $out .= '/* CSS Generator Execution Time: ' . floatval( ( microtime(true) - $generated ) ) . ' seconds */';

            // FS_CHMOD_FILE required by WordPress guideliness - https://codex.wordpress.org/Filesystem_API#Using_the_WP_Filesystem_Base_Class
            if ( defined( 'FS_CHMOD_FILE' ) ) {
                $chmod_file = FS_CHMOD_FILE;
            } else {
                $chmod_file = ( 0644 & ~ umask() );
            }

            if ( $wp_filesystem->put_contents( $css_cache_file, $out, $chmod_file) ) {

                wp_register_style( $cache_file_name, $css_cache_file_url, $cache_saved_date);
                wp_enqueue_style( $cache_file_name );

                // Update save options date
                $option_name = 'cache_css_saved_date';

                $new_value = microtime(true) ;

                if ( get_option( $option_name ) !== false ) {

                    // The option already exists, so we just update it.
                    update_option( $option_name, $new_value );

                } else {

                    // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
                    $deprecated = null;
                    $autoload = 'no';
                    add_option( $option_name, $new_value, $deprecated, $autoload );
                }
            }

        }
	}
    endif;

    if (!function_exists('enside_get_css')) :
	function enside_get_css () {
		$enside_theme_options = enside_get_theme_options();
		// ===
		ob_start();
    ?>
    <?php
    if ( defined('DEMO_MODE') && isset($_GET['header_height']) ) {
      $enside_theme_options['header_height'] = $_GET['header_height'];
    }

    if(isset($enside_theme_options['header_height']) && $enside_theme_options['header_height'] > 0) {
        $header_height = $enside_theme_options['header_height'];
    } else {
        $header_height = 110;
    }
    ?>
    header .col-md-12 {
        height: <?php echo intval($header_height); ?>px;
    }
    <?php
    // Retina logo
    ?>
    header .logo-link img {
        width: <?php if(isset($enside_theme_options['logo_width'])) { echo intval($enside_theme_options['logo_width']); } else { echo '219'; } ?>px;
    }
    header.fixed:not(.top-menu-position-header) .logo-link > img {
        max-width: <?php if(isset($enside_theme_options['logo_width'])) { echo intval($enside_theme_options['logo_width']); } else { echo '219'; } ?>px;
    }
    <?php
    // Custom footer paddings
    if(isset($enside_theme_options['footer_paddings']) && $enside_theme_options['footer_paddings'] !== ''):
    ?>
    footer {
        padding: <?php echo esc_html($enside_theme_options['footer_paddings']); ?>;
    }
    <?php
    endif;
    ?>
    @media (max-width: 1024px) {
    <?php
    // Responsive tablet settings
    if(isset($enside_theme_options['responsive_tablet_headerinfotext_disable']) && $enside_theme_options['responsive_tablet_headerinfotext_disable']):
    ?>
    .header-info-text {
        display: none;
    }
    <?php endif; ?>
    <?php
    if(isset($enside_theme_options['responsive_tablet_headertopmenutext_disable']) && $enside_theme_options['responsive_tablet_headertopmenutext_disable']):
    ?>
    .header-menu-bg .header-menu .header-top-text {
        display: none;
    }
    .header-menu .menu-top-menu-container-toggle {
        float: none;
    }
    <?php endif; ?>
    }
    @media (max-width: 767px) {
    <?php
    // Responsive mobile settings
    if(isset($enside_theme_options['responsive_mobile_headerinfotext_disable']) && $enside_theme_options['responsive_mobile_headerinfotext_disable']):
    ?>
    .header-info-text {
        display: none;
    }
    <?php endif; ?>
    <?php
    if(isset($enside_theme_options['responsive_mobile_headertopmenutext_disable']) && $enside_theme_options['responsive_mobile_headertopmenutext_disable']):
    ?>
    .header-menu-bg .header-menu .header-top-text {
        display: none;
    }
    .header-menu .menu-top-menu-container-toggle {
        float: none;
    }
    <?php endif; ?>
    <?php
    if(isset($enside_theme_options['responsive_mobile_headeradvmenutoggle_disable']) && $enside_theme_options['responsive_mobile_headeradvmenutoggle_disable']):
    ?>
    header .mobile-sidebar-trigger {
        display: none;
    }
    <?php endif; ?>
    <?php
    if(isset($enside_theme_options['responsive_mobile_logo_width']) && $enside_theme_options['responsive_mobile_logo_width'] !== ''):
    ?>
    header .logo-link img {
        width: <?php echo esc_attr($enside_theme_options['responsive_mobile_logo_width']);?>px;
    }
    <?php endif; ?>
    }

    /**
    * Custom CSS
    **/
    <?php if(isset($enside_theme_options['custom_css_code'])) {

        echo wp_strip_all_tags($enside_theme_options['custom_css_code']); // This variable contains user Custom CSS code and can't be escaped with WordPress functions
    }
    ?>

    /**
    * Theme Google Font
    **/
    <?php
        // Demo settings
        if ( defined('DEMO_MODE') && isset($_GET['header_font']) ) {
          $enside_theme_options['header_font']['font-family'] = $_GET['header_font'];
        }
        if ( defined('DEMO_MODE') && isset($_GET['body_font']) ) {
          $enside_theme_options['body_font']['font-family'] = $_GET['body_font'];
        }
        if ( defined('DEMO_MODE') && isset($_GET['additional_font']) ) {
          $enside_theme_options['additional_font']['font-family'] = $_GET['additional_font'];
        }
        if ( defined('DEMO_MODE') && isset($_GET['buttons_font']) ) {
          $enside_theme_options['buttons_font']['font-family'] = $_GET['buttons_font'];
        }

        if(isset($enside_theme_options['font_google_disable']) && $enside_theme_options['font_google_disable']) {

            $enside_theme_options['body_font']['font-family'] = $enside_theme_options['font_regular'];
            $enside_theme_options['header_font']['font-family'] = $enside_theme_options['font_regular'];
            $enside_theme_options['additional_font']['font-family'] = $enside_theme_options['font_regular'];
            $enside_theme_options['buttons_font']['font-family'] = $enside_theme_options['font_regular'];
        }

        // Logo text font
        if(isset($enside_theme_options['logo_text_enable']) && $enside_theme_options['logo_text_enable'] && isset($enside_theme_options['logo_text_font'])) {

            switch ($enside_theme_options['logo_text_font']) {
                case 'body':
                    $logo_text_font = $enside_theme_options['body_font']['font-family'];
                    break;

                case 'header':
                    $logo_text_font = $enside_theme_options['header_font']['font-family'];
                    break;

                case 'additional':
                    $logo_text_font = $enside_theme_options['additional_font']['font-family'];
                    break;
            }

            ?>
            header .logo-link.logo-text {
                font-family: '<?php echo esc_attr($logo_text_font); ?>';
            }
            <?php
        }

        // Font weight overrides body_font_weight
        if(isset($enside_theme_options['body_font_weight']) && $enside_theme_options['body_font_weight'] !== '') {
            ?>
            body {
                font-weight: <?php echo esc_attr($enside_theme_options['body_font_weight']); ?>;
            }
            <?php
        }

        // Font weight overrides header_font_weight
        if(isset($enside_theme_options['header_font_weight']) && $enside_theme_options['header_font_weight'] !== '') {
            ?>
            h1, h2, h3, h4, h5, h6,
            .page-item-title h1,
            .mgt-header-block .mgt-header-block-title {
                font-weight: <?php echo esc_attr($enside_theme_options['header_font_weight']); ?>;
            }
            <?php
        }

        // Font weight overrides widget_title_font_weight
        if(isset($enside_theme_options['widget_title_font_weight']) && $enside_theme_options['widget_title_font_weight'] !== '') {
            ?>
            .sidebar .widgettitle,
            .footer-sidebar h2.widgettitle {
                font-weight: <?php echo esc_attr($enside_theme_options['widget_title_font_weight']); ?>;
            }
            <?php
        }

        // Font size overrides widget_title_font_weight
        if(isset($enside_theme_options['page_title_font_size']) && $enside_theme_options['page_title_font_size'] !== '') {
            ?>
            .page-item-title h1 {
                font-size: <?php echo esc_attr($enside_theme_options['page_title_font_size']); ?>;
            }
            <?php
        }

    ?>
    h1, h2, h3, h4, h5, h6 {
        font-family: '<?php echo esc_attr($enside_theme_options['header_font']['font-family']); ?>';
    }
    .wp-block-button a,
    a.btn,
    .btn,
    .btn:focus,
    input[type="submit"],
    .woocommerce #content input.button,
    .woocommerce #respond input#submit,
    .woocommerce a.button,
    .woocommerce button.button,
    .woocommerce input.button,
    .woocommerce-page #content input.button,
    .woocommerce-page #respond input#submit,
    .woocommerce-page a.button,
    .woocommerce-page button.button,
    .woocommerce-page input.button,
    .woocommerce a.added_to_cart,
    .woocommerce-page a.added_to_cart {
        font-family: '<?php echo esc_attr($enside_theme_options['buttons_font']['font-family']); ?>';
    }
    .header-info-text .header-info-half .header-info-content-title,
    .mgt-header-block p,
    .mgt-counter-wrapper .mgt-counter-value,
    .mgt-counter-wrapper h5.mgt-counter-title,
    .mgt-cta-block h5,
    .mgt-cta-block .mgt-cta-block-content,
    .mgt-countdown-wrapper .mgt-countdown-item,
    .sidebar.main-sidebar .widget.widget_nav_menu li,
    .widget-download-link-wrapper,
    .blog-post .tags,
    .post-social-wrapper span,
    .author-bio .author-title,
    .comment-meta .reply a,
    .comment-metadata .author,
    .comment-metadata .date,
    .woocommerce ul.products li.product,
    .woocommerce-page ul.products li.product,
    .woocommerce ul.products li.product .onsale,
    .woocommerce span.onsale,
    .sidebar .widget.widget_enside_recent_entries li .widget-post-details-wrapper {
        font-family: '<?php echo esc_attr($enside_theme_options['header_font']['font-family']); ?>';
    }
    body {
        font-family: '<?php echo esc_attr($enside_theme_options['body_font']['font-family']); ?>';
        font-size: <?php echo esc_attr($enside_theme_options['body_font']['font-size']); ?>px;
    }
    <?php if(isset($enside_theme_options['additional_font_enable']) && $enside_theme_options['additional_font_enable']): ?>
    .mgt-promo-block .mgt-promo-block-content strong,
    .enside-slide strong {
        font-family: '<?php echo esc_attr($enside_theme_options['additional_font']['font-family']); ?>';
    }
    <?php endif; ?>
    /**
    * Colors and color skins
    */
    <?php
    // Demo settings
    if ( defined('DEMO_MODE') && isset($_GET['color_skin_name']) ) {
      $enside_theme_options['color_skin_name'] = $_GET['color_skin_name'];
    }

    if(!isset($enside_theme_options['color_skin_name'])) {
        $color_skin_name = 'none';
    }
    else {
        $color_skin_name = $enside_theme_options['color_skin_name'];
    }
    // Use panel settings
    if($color_skin_name == 'none') {

        $theme_body_color = $enside_theme_options['theme_body_color'];
        $theme_text_color = $enside_theme_options['theme_text_color'];
        $theme_main_color = $enside_theme_options['theme_main_color'];
        $theme_header_bg_color = $enside_theme_options['theme_header_bg_color'];
        $theme_top_menu_bg_color = $enside_theme_options['theme_top_menu_bg_color'];
        $theme_top_menu_color = $enside_theme_options['theme_top_menu_color'];
        $theme_main_menu_bg_color = $enside_theme_options['theme_main_menu_bg_color'];
        $theme_main_menu_dark_bg_color = $enside_theme_options['theme_main_menu_dark_bg_color'];
        $theme_footer_sidebar_bg_color = $enside_theme_options['theme_footer_sidebar_bg_color'];
        $theme_footer_sidebarlight_bg_color = $enside_theme_options['theme_footer_sidebarlight_bg_color'];
        $theme_footer_bg_color = $enside_theme_options['theme_footer_bg_color'];
        $theme_footerlight_bg_color = $enside_theme_options['theme_footerlight_bg_color'];
        $theme_title_color = $enside_theme_options['theme_title_color'];
        $theme_titlebg_color = $enside_theme_options['theme_titlebg_color'];

    }
    // Default skin
    if($color_skin_name == 'default') {
        $theme_body_color = '#FFFFFF';
        $theme_text_color = '#2A2F35';
        $theme_main_color = '#3452ff';
        $theme_header_bg_color = '#FFFFFF';
        $theme_top_menu_bg_color = '#F5F5F5';
        $theme_top_menu_color = '#828282';
        $theme_main_menu_bg_color = '#FFFFFF';
        $theme_main_menu_dark_bg_color = '#2A2F35';
        $theme_footer_sidebar_bg_color = '#2A2F35';
        $theme_footer_sidebarlight_bg_color = '#E6E6E6';
        $theme_footer_bg_color = '#1C2126';
        $theme_footerlight_bg_color = '#F4F4F4';
        $theme_title_color = '#2A2F35';
        $theme_titlebg_color = '#F4F4F4';
    }
    // Green skin
    if($color_skin_name == 'green') {
        $theme_body_color = '#FFFFFF';
        $theme_text_color = '#2A2F35';
        $theme_main_color = '#79C852';
        $theme_header_bg_color = '#FFFFFF';
        $theme_top_menu_bg_color = '#F5F5F5';
        $theme_top_menu_color = '#828282';
        $theme_main_menu_bg_color = '#FFFFFF';
        $theme_main_menu_dark_bg_color = '#2A2F35';
        $theme_footer_sidebar_bg_color = '#2A2F35';
        $theme_footer_sidebarlight_bg_color = '#E6E6E6';
        $theme_footer_bg_color = '#1C2126';
        $theme_footerlight_bg_color = '#F4F4F4';
        $theme_title_color = '#2A2F35';
        $theme_titlebg_color = '#F4F4F4';
    }
    // Blue skin
    if($color_skin_name == 'blue') {
        $theme_body_color = '#FFFFFF';
        $theme_text_color = '#2A2F35';
        $theme_main_color = '#5a7e9f';
        $theme_header_bg_color = '#FFFFFF';
        $theme_top_menu_bg_color = '#F5F5F5';
        $theme_top_menu_color = '#828282';
        $theme_main_menu_bg_color = '#FFFFFF';
        $theme_main_menu_dark_bg_color = '#2A2F35';
        $theme_footer_sidebar_bg_color = '#2A2F35';
        $theme_footer_sidebarlight_bg_color = '#E6E6E6';
        $theme_footer_bg_color = '#1C2126';
        $theme_footerlight_bg_color = '#F4F4F4';
        $theme_title_color = '#2A2F35';
        $theme_titlebg_color = '#F4F4F4';
    }
    // Purple skin
    if($color_skin_name == 'purple') {
        $theme_body_color = '#FFFFFF';
        $theme_text_color = '#2A2F35';
        $theme_main_color = '#5d89f9';
        $theme_header_bg_color = '#FFFFFF';
        $theme_top_menu_bg_color = '#F5F5F5';
        $theme_top_menu_color = '#828282';
        $theme_main_menu_bg_color = '#FFFFFF';
        $theme_main_menu_dark_bg_color = '#2A2F35';
        $theme_footer_sidebar_bg_color = '#2A2F35';
        $theme_footer_sidebarlight_bg_color = '#E6E6E6';
        $theme_footer_bg_color = '#1C2126';
        $theme_footerlight_bg_color = '#F4F4F4';
        $theme_title_color = '#2A2F35';
        $theme_titlebg_color = '#F4F4F4';
    }
    // Red skin
    if($color_skin_name == 'red') {
        $theme_body_color = '#FFFFFF';
        $theme_text_color = '#2A2F35';
        $theme_main_color = '#F3403F';
        $theme_header_bg_color = '#FFFFFF';
        $theme_top_menu_bg_color = '#F5F5F5';
        $theme_top_menu_color = '#828282';
        $theme_main_menu_bg_color = '#FFFFFF';
        $theme_main_menu_dark_bg_color = '#2A2F35';
        $theme_footer_sidebar_bg_color = '#2A2F35';
        $theme_footer_sidebarlight_bg_color = '#E6E6E6';
        $theme_footer_bg_color = '#1C2126';
        $theme_footerlight_bg_color = '#F4F4F4';
        $theme_title_color = '#2A2F35';
        $theme_titlebg_color = '#F4F4F4';
    }
    // Black&White skin
    if($color_skin_name == 'blackandwhite') {
        $theme_body_color = '#FFFFFF';
        $theme_text_color = '#2A2F35';
        $theme_main_color = '#999a9d';
        $theme_header_bg_color = '#FFFFFF';
        $theme_top_menu_bg_color = '#F5F5F5';
        $theme_top_menu_color = '#828282';
        $theme_main_menu_bg_color = '#FFFFFF';
        $theme_main_menu_dark_bg_color = '#2A2F35';
        $theme_footer_sidebar_bg_color = '#2A2F35';
        $theme_footer_sidebarlight_bg_color = '#E6E6E6';
        $theme_footer_bg_color = '#1C2126';
        $theme_footerlight_bg_color = '#F4F4F4';
        $theme_title_color = '#2A2F35';
        $theme_titlebg_color = '#F4F4F4';
    }

    // Orange skin
    if($color_skin_name == 'orange') {
        $theme_body_color = '#FFFFFF';
        $theme_text_color = '#2A2F35';
        $theme_main_color = '#e3e002';
        $theme_header_bg_color = '#FFFFFF';
        $theme_top_menu_bg_color = '#F5F5F5';
        $theme_top_menu_color = '#828282';
        $theme_main_menu_bg_color = '#FFFFFF';
        $theme_main_menu_dark_bg_color = '#2A2F35';
        $theme_footer_sidebar_bg_color = '#2A2F35';
        $theme_footer_sidebarlight_bg_color = '#E6E6E6';
        $theme_footer_bg_color = '#1C2126';
        $theme_footerlight_bg_color = '#F4F4F4';
        $theme_title_color = '#2A2F35';
        $theme_titlebg_color = '#F4F4F4';
    }
    // Fencer skin
    if($color_skin_name == 'fencer') {
        $theme_body_color = '#FFFFFF';
        $theme_text_color = '#2A2F35';
        $theme_main_color = '#26cdb3';
        $theme_header_bg_color = '#FFFFFF';
        $theme_top_menu_bg_color = '#F5F5F5';
        $theme_top_menu_color = '#828282';
        $theme_main_menu_bg_color = '#FFFFFF';
        $theme_main_menu_dark_bg_color = '#2A2F35';
        $theme_footer_sidebar_bg_color = '#2A2F35';
        $theme_footer_sidebarlight_bg_color = '#E6E6E6';
        $theme_footer_bg_color = '#1C2126';
        $theme_footerlight_bg_color = '#F4F4F4';
        $theme_title_color = '#2A2F35';
        $theme_titlebg_color = '#F4F4F4';
    }
    // Perfectum skin
    if($color_skin_name == 'perfectum') {
        $theme_body_color = '#FFFFFF';
        $theme_text_color = '#2A2F35';
        $theme_main_color = '#F2532F';
        $theme_header_bg_color = '#FFFFFF';
        $theme_top_menu_bg_color = '#F5F5F5';
        $theme_top_menu_color = '#828282';
        $theme_main_menu_bg_color = '#FFFFFF';
        $theme_main_menu_dark_bg_color = '#2A2F35';
        $theme_footer_sidebar_bg_color = '#2A2F35';
        $theme_footer_sidebarlight_bg_color = '#E6E6E6';
        $theme_footer_bg_color = '#1C2126';
        $theme_footerlight_bg_color = '#F4F4F4';
        $theme_title_color = '#2A2F35';
        $theme_titlebg_color = '#F4F4F4';
    }
    // Simplegreat skin
    if($color_skin_name == 'simplegreat') {
        $theme_body_color = '#FFFFFF';
        $theme_text_color = '#2A2F35';
        $theme_main_color = '#C3A36B';
        $theme_header_bg_color = '#FFFFFF';
        $theme_top_menu_bg_color = '#F5F5F5';
        $theme_top_menu_color = '#828282';
        $theme_main_menu_bg_color = '#FFFFFF';
        $theme_main_menu_dark_bg_color = '#2A2F35';
        $theme_footer_sidebar_bg_color = '#2A2F35';
        $theme_footer_sidebarlight_bg_color = '#E6E6E6';
        $theme_footer_bg_color = '#1C2126';
        $theme_footerlight_bg_color = '#F4F4F4';
        $theme_title_color = '#2A2F35';
        $theme_titlebg_color = '#F4F4F4';
    }

    ?>
    body {
        background-color: <?php echo esc_html($theme_body_color); ?>;
        color: <?php echo esc_html($theme_text_color); ?>;
    }
    .st-pusher,
    .st-sidebar-pusher {
        background-color: <?php echo esc_html($theme_body_color); ?>;
    }
    a.btn,
    .btn,
    .btn:focus,
    input[type="submit"],
    .wp-block-button a,
    .woocommerce #content input.button,
    .woocommerce #respond input#submit,
    .woocommerce a.button,
    .woocommerce button.button,
    .woocommerce input.button,
    .woocommerce-page #content input.button,
    .woocommerce-page #respond input#submit,
    .woocommerce-page a.button,
    .woocommerce-page button.button,
    .woocommerce-page input.button,
    .woocommerce a.added_to_cart,
    .woocommerce-page a.added_to_cart,
    .btn-primary:hover,
    .btn-primary:active,
    header.main-header.top-menu-position-header .header-left,
    .mainmenu-belowheader .navbar .nav > li.mgt-highlight > a,
    .blog-post .tags a:hover,
    .sidebar .widget_calendar th,
    .sidebar .widget_calendar tfoot td,
    .sidebar.main-sidebar .widget.widget_nav_menu .current-menu-item > a,
    body .flex-control-paging li a.flex-active,
    body .flex-control-paging li a:hover,
    .mgt-header-block .mgt-header-line,
    .mgt-post-list .mgt-post-wrapper-icon:hover,
    .mgt-button.mgt-style-solid-invert:hover,
    .mgt-button.mgt-style-bordered:hover,
    .mgt-button.mgt-style-borderedwhite:hover,
    .mgt-button.mgt-style-borderedgrey:hover,
    .mgt-button.mgt-style-grey:hover,
    .mgt-button.mgt-style-green:hover,
    .mgt-button.mgt-style-red:hover,
    .portfolio-filter a:hover,
    .portfolio-filter a.active,
    .portfolio-item-block.portfolio-item-animation-0 .portfolio-item-bg,
    .portfolio-item-block .btn:hover,
    .mgt-pricing-table.featured h4.mgt-pricing-table-header,
    body .vc_tta-accordion.vc_tta-color-black.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-heading,
    .mgt-button.hvr-sweep-to-right:hover,
    .mgt-button.hvr-sweep-to-left:hover,
    .mgt-button.hvr-sweep-to-bottom:hover,
    .mgt-button.hvr-sweep-to-top:hover,
    .mgt-button.hvr-bounce-to-right:hover,
    .mgt-button.hvr-bounce-to-left:hover,
    .mgt-button.hvr-bounce-to-bottom:hover,
    .mgt-button.hvr-bounce-to-top:hover,
    .mgt-button:before,
    .woocommerce ul.products li.product .onsale,
    .woocommerce span.onsale,
    .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
    .portfolio-filter a.view-all:hover,
    .portfolio-filter a:hover, .portfolio-filter a.active,
    .nav > li sup,
    .mgt-icon-box.mgt-icon-background .mgt-icon-box-icon,
    .footer-sidebar-wrapper.footer-sidebar-style-light .sidebar.footer-sidebar .widget.widget_tag_cloud a:hover,
    .sidebar.footer-sidebar .widget.widget_tag_cloud a:hover,
    .mgt-process-wrapper .mgt-process-icon-wrapper,
    .sidebar.main-sidebar .widget.widget_nav_menu .current-menu-item > a:hover,
    .mgt-item-price.mgt-item-price-badge-color-theme sup,
    body .vc_tta-tabs.vc_tta.vc_tta-color-grey.vc_tta-style-outline .vc_tta-tab.vc_active > a,
    body .vc_tta-tabs.vc_tta.vc_tta-color-grey.vc_tta-style-outline .vc_tta-tab > a:hover,
    header div:not(.mainmenu-belowheader) > .navbar .nav > li.mgt-highlight-bordered > a:hover,
    header div:not(.mainmenu-belowheader) > .navbar .nav > li.mgt-highlight > a,
    body .owl-theme .owl-controls .owl-page.active span,
    body .owl-theme .owl-controls.clickable .owl-page:hover span,
    .mgt-images-slider .slick-dots li.slick-active button,
    .mgt-images-slider .slick-dots li:hover button,
    header.transparent-header .icon-lined-menu:hover .icon-lined-menu-line,
    header.main-header.top-menu-position-header .icon-lined-menu:hover .icon-lined-menu-line {
        background-color: <?php echo esc_html($theme_main_color); ?>;
    }
    a,
    .breadcrumbs-container-wrapper a:hover,
    .page-404 h1,
    header.main-header.top-menu-position-header .nav > li > a:hover,
    header.main-header.top-menu-position-header .nav > li.current-menu-item:not(.pull-right) > a,
    header.main-header.top-menu-position-header .header-right ul.header-nav > li > div > a:hover,
    header.main-header.top-menu-position-header .header-menu .social-icons-top a:hover,
    header .header-right ul.header-nav > li > div > a:hover,
    .navbar .nav > li.current-menu-item:not(.pull-right) > a,
    header.transparent-header .navbar .nav > li > a:hover,
    header.transparent-header .navbar .nav > li.current-menu-item:not(.pull-right) > a,
    .navbar .nav > li > a:hover,
    .navbar .nav > li.active > a,
    .navbar .nav > li.current-menu-item:not(.pull-right) > a,
    header.transparent-header .mainmenu-belowheader.mainmenu-light .navbar .nav > li:not(.pull-right) > a:hover,
    header.transparent-header .mainmenu-belowheader.mainmenu-light .navbar .nav > li.current-menu-item:not(.pull-right) > a,
    .mainmenu-belowheader.mainmenu-light .navbar .nav > li > a:hover,
    .mainmenu-belowheader.mainmenu-light .navbar .nav > li.active > a,
    .mainmenu-belowheader.mainmenu-dark .navbar .nav > li.current-menu-item:not(.pull-right) > a,
    .header-menu-bg.transparent-header .header-menu .social-icons-top a:hover,
    .header-menu-bg.transparent-header .header-menu .top-menu li a:hover,
    .header-menu .social-icons-top a:hover,
    .header-menu .top-menu li a:hover,
    .header-menu .top-menu .sub-menu li a:hover,
    .blog-post .post-header-title a:hover,
    .post-social-title i,
    .navigation-paging a:hover,
    footer a:hover,
    .sidebar.footer-sidebar .widget a:not(.select2-choice):hover,
    .footer-sidebar-wrapper .sidebar.footer-sidebar .widget.widget_calendar tbody td a:hover,
    .widget-download-link-wrapper .widget-download-icon,
    .widget-download-link-wrapper .widget-download-title a:hover,
    .sidebar .widget.widget_enside_recent_entries li .widget-post-details-wrapper .post-title a:hover,
    .footer-sidebar-wrapper.footer-sidebar-style-light .sidebar.footer-sidebar .widget.widget_enside_recent_entries li .widget-post-details-wrapper .post-title a:hover,
    .woocommerce ul.products li.product h2:hover,
    .woocommerce ul.products li.product h3:hover,
    .comment-meta .reply a:hover,
    .mgt-promo-block .mgt-promo-block-content i.fa,
    .mgt-button.mgt-style-bordered,
    .mgt-button.mgt-style-text,
    .mgt-button.mgt-style-textwhite,
    .mgt-button.mgt-style-bordered:active,
    .mgt-button.mgt-style-text:active,
    .mgt-button.mgt-style-textwhite:active,
    .mgt-button.mgt-style-bordered:focus,
    .mgt-button.mgt-style-text:focus,
    .mgt-button.mgt-style-textwhite:focus,
    .mgt-counter-wrapper .mgt-counter-icon,
    .portfolio-filter a.view-all,
    body .st-sidebar-menu .sidebar a:hover,
    .nav .sub-menu > li.menu-item.current-menu-item > a,
    body .select2-drop,
    .woocommerce.widget.widget_product_categories a:hover,
    .woocommerce ul.products li.product .added_to_cart:hover,
    .nav .sub-menu li.menu-item > a:hover,
    .text-color-theme,
    .text-color-theme *,
    .mgt-icon-box.mgt-icon-background-style-rounded-outline .mgt-icon-box-icon,
    .mgt-icon-box.mgt-icon-background-style-boxed-outline .mgt-icon-box-icon,
    .mgt-icon-box.mgt-icon-background-style-rounded-less-outline .mgt-icon-box-icon,
    .widget_enside_social_icons .social-icons-wrapper a:hover,
    footer.footer-style-light .widget_enside_social_icons .social-icons-wrapper a:hover,
    footer.footer-style-light a:hover,
    .sidebar .widget_calendar tbody td a,
    .footer-sidebar-wrapper.footer-sidebar-style-light .sidebar.footer-sidebar .widget a:not(.select2-choice):hover,
    .header-info-text .header-info-half .header-info-content-icon,
    body.wpb-js-composer .vc_tta-color-grey.vc_tta-style-outline .vc_tta-panel.vc_active .vc_tta-panel-title > a,
    .header-menu .social-icons-wrapper a:hover,
    header.main-header.top-menu-position-header .header-menu .social-icons-wrapper a:hover,
    .header-menu-bg.transparent-header .header-menu .social-icons-wrapper a:hover,
    .portfolio-item-block.portfolio-item-animation-9 h4.title:hover,
    header div:not(.mainmenu-belowheader) > .navbar .nav > li.mgt-highlight-bordered > a,
    header div:not(.mainmenu-belowheader) > .navbar .nav > li.mgt-highlight > a:hover,
    header.left-side-header .social-icons-wrapper a:hover,
    .header-left-menu-wrapper ul.header-left-menu li a:hover,
    .header-left-menu-wrapper ul.header-left-menu li.current_page_item a,
    header.mainmenu-position-menu_inside_header .shopping-cart a:hover span {
        color: <?php echo esc_html($theme_main_color); ?>;
    }
    blockquote,
    .sidebar .widget_calendar tbody td a,
    .widget-download-link-wrapper,
    .mgt-button.mgt-style-bordered,
    .mgt-button.mgt-style-bordered:active,
    .mgt-button.mgt-style-bordered:focus,
    .mgt-button.mgt-style-green:hover,
    .mgt-button.mgt-style-red:hover,
    .portfolio-item-block .btn:hover,
    .mgt-icon-box.mgt-icon-background-style-rounded-outline .mgt-icon-box-icon,
    .mgt-icon-box.mgt-icon-background-style-boxed-outline .mgt-icon-box-icon,
    .mgt-icon-box.mgt-icon-background-style-rounded-less-outline .mgt-icon-box-icon,
    .sidebar.main-sidebar .widget.widget_nav_menu .current-menu-item > a,
    .sidebar.main-sidebar .widget.widget_nav_menu .current-menu-item > a:hover,
    .portfolio-filter.filter-bordered a.view-all:hover,
    .portfolio-filter.filter-bordered a.view-all.active,
    .portfolio-filter.filter-bordered a:hover,
    .portfolio-filter.filter-bordered a.active,
    body .vc_tta-tabs.vc_tta-color-grey.vc_tta.vc_tta-style-outline .vc_tta-tab.vc_active > a,
    body .vc_tta-tabs.vc_tta-color-grey.vc_tta.vc_tta-style-outline .vc_tta-tab > a:hover,
    .mgt-button.mgt-style-borderedwhite:hover,
    textarea:focus,
    input:focus,
    header div:not(.mainmenu-belowheader) > .navbar .nav > li.mgt-highlight-bordered > a,
    header div:not(.mainmenu-belowheader) > .navbar .nav > li.mgt-highlight > a:hover {
        border-color: <?php echo esc_html($theme_main_color); ?>;
    }
    .navbar.menu-style-border-top .nav > li .sub-menu {
        border-top-color: <?php echo esc_html($theme_main_color); ?>;
    }
    .navbar.menu-style-border-bottom .nav > li .sub-menu,
    .mgt-client-reviews .mgt-client-review.mgt-client-review-style-box.mgt-client-review-border:hover {
        border-bottom-color: <?php echo esc_html($theme_main_color); ?>;
    }
    .navbar.menu-style-border-left .nav > li .sub-menu {
        border-left-color: <?php echo esc_html($theme_main_color); ?>;
    }
    header.main-header {
        background-color: <?php echo esc_html($theme_header_bg_color); ?>;
    }
    .header-menu-bg {
        background-color: <?php echo esc_html($theme_top_menu_bg_color); ?>;
    }
    .header-menu,
    .header-menu .social-icons-top a,
    .header-menu .top-menu li a,
    .header-menu .menu-top-menu-container-toggle {
        color: <?php echo esc_html($theme_top_menu_color); ?>;
    }
    .mainmenu-belowheader.mainmenu-light {
        background-color: <?php echo esc_html($theme_main_menu_bg_color); ?>;
    }
    .mainmenu-belowheader.mainmenu-dark {
        background-color: <?php echo esc_html($theme_main_menu_dark_bg_color); ?>;
    }
    .footer-sidebar-wrapper {
        background-color: <?php echo esc_html($theme_footer_sidebar_bg_color); ?>;
    }
    .footer-sidebar-wrapper.footer-sidebar-style-light {
        background-color: <?php echo esc_html($theme_footer_sidebarlight_bg_color); ?>;
    }
    footer {
        background-color: <?php echo esc_html($theme_footer_bg_color); ?>;
    }
    footer.footer-style-light {
        background-color: <?php echo esc_html($theme_footerlight_bg_color); ?>;
    }
    .page-item-title h1 {
        color: <?php echo esc_html($theme_title_color); ?>;
    }
    .container-bg {
        background-color: <?php echo esc_html($theme_titlebg_color); ?>;
    }
    #nprogress .bar {
      background: <?php echo esc_html($theme_main_color); ?>;
    }
    #nprogress .peg {
      box-shadow: 0 0 10px <?php echo esc_html($theme_main_color); ?>, 0 0 5px <?php echo esc_html($theme_main_color); ?>;
    }
    <?php

    	$out = ob_get_clean();

		$out .= ' /*' . date("Y-m-d H:i") . '*/';
		/* RETURN */
		return $out;
	}
    endif;
?>
