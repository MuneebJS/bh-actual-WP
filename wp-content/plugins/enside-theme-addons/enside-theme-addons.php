<?php
/*
Plugin Name: Enside Theme Addons
Plugin URI: https://magniumthemes.com/
Description: Custom Post Types, Shortcodes, Demo data for Enside WordPress theme
Author: dedalx
Version: 1.4.6
Author URI: https://magniumthemes.com/
Text Domain: enside-ta
License: General Public License
*/

//load translated strings
add_action( 'init', 'enside_ta_load_textdomain' );

//load init
add_action( 'init', 'enside_ta_init' );

//process custom taxonomies
add_action( 'init', 'enside_ta_create_custom_taxonomies', 0 );

//process custom post types
add_action( 'init', 'enside_ta_create_custom_post_types', 0 );

//process custom meta boxes
add_action( 'init', 'enside_ta_create_metaboxes', 0 );

//flush rewrite rules on deactivation
register_deactivation_hook( __FILE__, 'enside_ta_deactivation' );

function enside_ta_deactivation() {
	// Clear the permalinks to remove our post type's rules
	flush_rewrite_rules();
}

function enside_ta_load_textdomain() {
	load_plugin_textdomain( 'enside-ta', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

function enside_ta_init() {
	global $pagenow;

	add_image_size( 'enside-portfolio-thumb-square', 1024, 1024, true);
    add_image_size( 'enside-portfolio-large', 1600, 800, true);
    add_image_size( 'enside-portfolio-nav', 100, 100, true);
    add_image_size( 'enside-reviews-avatar', 75, 75, true);

    // Allow shortcodes in Text widgets
	add_filter('widget_text', 'do_shortcode');

    // Demo data import
    if (( $pagenow !== 'admin-ajax.php' ) && (is_admin())) {
		require plugin_dir_path( __FILE__ ).'inc/oneclick-demo-import/init.php';
	}
}

function enside_ta_create_custom_post_types() {

	function enside_posts_types() {

		if (function_exists('enside_get_theme_options')) {
			$enside_theme_options = enside_get_theme_options();
		} else {
			$enside_theme_options = Array();
		}

		if(isset($enside_theme_options['portfolio_item_slug']) && trim($enside_theme_options['portfolio_item_slug']) !== '') {
			$portfolio_item_slug = trim($enside_theme_options['portfolio_item_slug']);
		} else {
			$portfolio_item_slug = 'project';
		}

		if(isset($enside_theme_options['portfolio_taxonomy_name']) && trim($enside_theme_options['portfolio_taxonomy_name']) !== '') {
			$portfolio_taxonomy_name = trim($enside_theme_options['portfolio_taxonomy_name']);
		} else {
			$portfolio_taxonomy_name = 'Portfolio';
		}

		register_post_type( 'mgt_clients_reviews',
		array(
		    'labels' => array(
		    'name' => __( 'Clients reviews', 'enside-ta' ),
		    'singular_name' => __( 'Clients reviews', 'enside-ta' ),
		    'has_archive' => true,
		    'add_new' => __( 'Add review', 'enside-ta' ),
		    'not_found' => __( 'Not found', 'enside-ta' ),
		    'not_found_in_trash' => __( 'No clients reviews found in trash', 'enside-ta' ),
		    'add_new_item' => __( 'Add review', 'enside-ta' ),
		    'all_items' => __( 'All client reviews', 'enside-ta' ),
		    ),
		    'public' => true,
		    'has_archive' => true,
		    'supports' => array(
		        'title',
		        'thumbnail',
		        'editor',
		        'comments'
		    ),
		    'menu_icon' => 'dashicons-format-aside'
		));

		register_post_type( 'mgt_portfolio',
		array(
		    'labels' => array(
		    'name' => __( $portfolio_taxonomy_name, 'enside-ta' ),
		    'singular_name' => __( $portfolio_taxonomy_name, 'enside-ta' ),
		    'has_archive' => true,
		    'add_new' => __( 'Add New item', 'enside-ta' ),
		    'not_found' => __( 'Not found', 'enside-ta' ),
		    'not_found_in_trash' => __( 'No Portfolio items found in trash', 'enside-ta' ),
		    'add_new_item' => __( 'Add New item', 'enside-ta' ),
		    'all_items' => __( 'All Portfolio items', 'enside-ta' ),
		    ),
		    'public' => true,
		    'has_archive' => true,
		    'rewrite' => array(
		    	'slug' => $portfolio_item_slug
		    ),
		    'supports' => array(
		        'title',
		        'thumbnail',
		        'excerpt',
		        'editor',
		        'comments'
		    ),
		    'menu_icon' => 'dashicons-welcome-view-site'
		));
	}

	add_action( 'init', 'enside_posts_types' );
}

function enside_ta_create_custom_taxonomies() {
	function enside_register_portfolio_taxonomy() {

		if (function_exists('enside_get_theme_options')) {
			$enside_theme_options = enside_get_theme_options();
		} else {
			$enside_theme_options = Array();
		}

		if(isset($enside_theme_options['portfolio_category_slug']) && trim($enside_theme_options['portfolio_category_slug']) !== '') {
			$portfolio_category_slug = trim($enside_theme_options['portfolio_category_slug']);
		} else {
			$portfolio_category_slug = 'projects';
		}

	    register_taxonomy("mgt_portfolio_filter", array("mgt_portfolio"), array("hierarchical" => true, "label" => "Project category", "singular_label" => "Project Category", 'rewrite'  => array( 'slug' => $portfolio_category_slug ), "show_admin_column" => true));
	}
	add_action( 'init', 'enside_register_portfolio_taxonomy');
}

function enside_ta_create_metaboxes() {

	/**
	* Custom metabox for Our Team custom post type
	**/

	function reviews_image_box() {

	    remove_meta_box('postimagediv', 'mgt_clients_reviews', 'side');

	    add_meta_box('postimagediv', __('Client photo/logo', 'enside-ta'), 'post_thumbnail_meta_box', 'mgt_clients_reviews', 'normal', 'high');

	}

	add_action('do_meta_boxes', 'reviews_image_box');

	/**
	* Custom metabox for Portfolio custom post type
	**/

	function portfolio_image_box() {

	    remove_meta_box('postimagediv', 'mgt_portfolio', 'side');

	    add_meta_box('postimagediv', __('Portfolio grid item image', 'enside-ta'), 'post_thumbnail_meta_box', 'mgt_portfolio', 'normal', 'high');

	}
	add_action('do_meta_boxes', 'portfolio_image_box');

	function portfolio_settings_box() {

	    $screens = array( 'mgt_portfolio' );

	    foreach ( $screens as $screen ) {

	        add_meta_box(
	            'portfolio_settings_box',
	            __( 'Portfolio item page details and settings', 'enside-ta' ),
	            'portfolio_settings_inner_box',
	            $screen,
	            'normal'
	        );
	    }
	}
	add_action( 'add_meta_boxes', 'portfolio_settings_box' );

	function portfolio_settings_inner_box( $post ) {

		wp_enqueue_script('wp-color-picker');
  		wp_enqueue_style( 'wp-color-picker' );

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'portfolio_settings_inner_box', 'portfolio_settings_inner_box_nonce' );

		/*
		* Use get_post_meta() to retrieve an existing value
		* from the database and use the value for the form.
		*/

		$value_portfolio_display_type = get_post_meta( $post->ID, '_portfolio_display_type_value', true );

		echo '<p><label for="portfolio_display_type" style="width: 120px; display: inline-block;">';
		_e( "Layout: ", 'enside-ta' );
		echo '</label> ';
		echo '<label><input type="radio" name="portfolio_display_type" value="0"';
		if($value_portfolio_display_type == 0) { echo 'checked'; }
		echo ' >';
		_e( "Normal image size, description at the right", 'enside-ta' ).'</label>';
		echo ' &nbsp; &nbsp;<label><input type="radio" name="portfolio_display_type" value="1"';
		if($value_portfolio_display_type == 1) { echo 'checked'; }
		echo '>';
		_e( "Full width image size, description at the bottom", 'enside-ta' ).'</label>';

		$value_portfolio_description = get_post_meta( $post->ID, '_portfolio_description_value', true );

		echo '<p><label for="portfolio_description" style="width: 120px; display: inline-block;">';
		_e( "Short description: ", 'enside-ta' );
		echo '</label> ';
		echo '<input type="text" id="portfolio_description" name="portfolio_description" value="' . esc_attr( $value_portfolio_description ) . '" size="30" /> <span>(Used in MGT Portfolio Grid)</span></p>';

		$value_portfolio_url = get_post_meta( $post->ID, '_portfolio_url_value', true );

		echo '<p><label for="portfolio_url" style="width: 120px; display: inline-block;">';
		_e( "Project url: ", 'enside-ta' );
		echo '</label> ';
		echo '<input type="text" id="portfolio_url" name="portfolio_url" value="' . esc_attr( $value_portfolio_url ) . '" size="30" /> <span>(Also can be used in MGT Portfolio Grid to open url instead of single project page)</span></p>';

		$value_portfolio_brand = get_post_meta( $post->ID, '_portfolio_brand_value', true );

		echo '<p><label for="portfolio_brand" style="width: 120px; display: inline-block;">';
		_e( "Client: ", 'enside-ta' );
		echo '</label> ';
		echo '<input type="text" id="portfolio_brand" name="portfolio_brand" value="' . esc_attr( $value_portfolio_brand ) . '" size="30" /></p>';

		$value_portfolio_hide_details = get_post_meta( $post->ID, '_portfolio_hide_details_value', true );

		$checked = '';
		if( $value_portfolio_hide_details == true ) {
			$checked = 'checked = "checked"';
		}
		echo '<p><input type="checkbox" id="portfolio_hide_details" name="portfolio_hide_details" '.$checked.' /> <label for="portfolio_hide_details">'.__( "Hide portfolio details (Project url, Client, Category)", 'enside-ta' ).'</label></p>';

		$value_portfolio_hide_1st_image_from_slider = get_post_meta( $post->ID, '_portfolio_hide_1st_image_from_slider_value', true );

		$checked = '';
		if( $value_portfolio_hide_1st_image_from_slider == true ) {
			$checked = 'checked = "checked"';
		}
		echo '<p><input type="checkbox" id="portfolio_hide_1st_image_from_slider" name="portfolio_hide_1st_image_from_slider" '.$checked.' /> <label for="portfolio_hide_1st_image_from_slider">'.__( "Don't show 'Portfolio grid item image' on item page", 'enside-ta' ).'</label></p>';


		$value_portfolio_disableslider = get_post_meta( $post->ID, '_portfolio_disableslider_value', true );

		$checked = '';
		if( $value_portfolio_disableslider == true ) {
			$checked = 'checked = "checked"';
		}
		echo '<p><input type="checkbox" id="portfolio_disableslider" name="portfolio_disableslider" '.$checked.' /> <label for="portfolio_disableslider">'.__( "Disable slider for this item images (show images in column)", 'enside-ta' ).'</label></p>';

		$value_portfolio_fullwidthslider = get_post_meta( $post->ID, '_portfolio_fullwidthslider_value', true );

		$checked = '';
		if( $value_portfolio_fullwidthslider == true ) {
			$checked = 'checked = "checked"';
		}
		echo '<p><input type="checkbox" id="portfolio_fullwidthslider" name="portfolio_fullwidthslider" '.$checked.' /> <label for="portfolio_fullwidthslider">'.__( "Show item images or slider fullwidth (liquid)", 'enside-ta' ).'</label></p>';

		$value_portfolio_original_image_sizes = get_post_meta( $post->ID, '_portfolio_original_image_sizes_value', true );

		$checked = '';
		if( $value_portfolio_original_image_sizes == true ) {
			$checked = 'checked = "checked"';
		}
		echo '<p><input type="checkbox" id="portfolio_original_image_sizes" name="portfolio_original_image_sizes" '.$checked.' /> <label for="portfolio_original_image_sizes">'.__( "Use original images sizes for all item images (don't crop images)", 'enside-ta' ).'</label></p>';

		$value_portfolio_socialshare_disable = get_post_meta( $post->ID, '_portfolio_socialshare_disable_value', true );

		$checked = '';
		if( $value_portfolio_socialshare_disable == true ) {
			$checked = 'checked = "checked"';
		}

		echo '<p><input type="checkbox" id="portfolio_socialshare_disable" name="portfolio_socialshare_disable" '.$checked.' /> <label for="portfolio_socialshare_disable">'.__( "Disable social share counters and buttons on this item page", 'enside-ta' ).'</label></p>';

		$checked = '';

		$value_page_transparent_header = get_post_meta( $post->ID, '_page_transparent_header_value', true );

		if( $value_page_transparent_header == true ) {
			$checked = 'checked = "checked"';
		}

		echo '<p><input type="checkbox" id="page_transparent_header" name="page_transparent_header" '.$checked.' /> <label for="page_transparent_header">'.__( "Show transparent header with light logo and white menus under page content. Use this if you have fullwidth image or slider at the page start (header will be displayed above your image).", 'enside-ta' ).'</label></p>';

		$value_portfolio_hide_breadcrumbs = get_post_meta( $post->ID, '_portfolio_hide_breadcrumbs_value', true );

		$checked = '';
		if( $value_portfolio_hide_breadcrumbs == true ) {
			$checked = 'checked = "checked"';
		}
		echo '<p><input type="checkbox" id="portfolio_hide_breadcrumbs" name="portfolio_hide_breadcrumbs" '.$checked.' /> <label for="portfolio_hide_breadcrumbs">'.__( "Hide breadcrumbs navigation", 'enside-ta' ).'</label></p>';

		$value_portfolio_titleposition = get_post_meta( $post->ID, '_portfolio_titleposition_value', true );

		$selected_1 = '';
		$selected_2 = '';
		$selected_3 = '';

		if($value_portfolio_titleposition == "default") {
			$selected_1 = ' selected';
		}
		if($value_portfolio_titleposition == "description") {
			$selected_2 = ' selected';
		}
		if($value_portfolio_titleposition == "disable") {
			$selected_3 = ' selected';
		}

		echo '<p><label for="portfolio_titleposition" style="display: inline-block; width: 150px;">'.__( "Title position: ", 'enside-ta' ).'</label>';
		echo '<select name="portfolio_titleposition" id="portfolio_titleposition">
		    <option value="default"'.$selected_1.'>'.__( "Page title", 'enside-ta' ).'</option>
		    <option value="description"'.$selected_2.'>'.__( "Before description and details", 'enside-ta' ).'</option>
		    <option value="disable"'.$selected_3.'>'.__( "Disable title", 'enside-ta' ).'</option>
		</select></p>';

		$value_page_bgcolor = get_post_meta( $post->ID, '_page_bgcolor_value', true );

		echo '<label for="page_bgcolor" style="display: inline-block; height: 40px;">'.__( "Page background color: ", 'enside-ta' ).'</label> &nbsp;';
	  	echo '<input type="text" id="page_bgcolor" name="page_bgcolor" value="' . esc_attr( $value_page_bgcolor ) . '" style="width: auto; height:25px;" />';

	  	echo "<script type=\"text/javascript\">    jQuery(document).ready(function($) {    $('#page_bgcolor').wpColorPicker(); }); </script>";


		$value_portfolio_sidebarposition = get_post_meta( $post->ID, '_portfolio_sidebarposition_value', true );

		$selected_1 = '';
		$selected_2 = '';
		$selected_3 = '';
		$selected_4 = '';

		if($value_portfolio_sidebarposition == 0) {
			$selected_1 = ' selected';
		}
		if($value_portfolio_sidebarposition == "left") {
			$selected_2 = ' selected';
		}
		if($value_portfolio_sidebarposition == "right") {
			$selected_3 = ' selected';
		}
		if($value_portfolio_sidebarposition == "disable") {
			$selected_4 = ' selected';
		}

		echo '<p><label for="portfolio_sidebarposition" style="display: inline-block; width: 150px;">'.__( "Sidebar position: ", 'enside-ta' ).'</label>';
		echo '<select name="portfolio_sidebarposition" id="portfolio_sidebarposition">
		    <option value="0"'.$selected_1.'>'.__( "Use theme control panel settings", 'enside-ta' ).'</option>
		    <option value="left"'.$selected_2.'>'.__( "Left", 'enside-ta' ).'</option>
		    <option value="right"'.$selected_3.'>'.__( "Right", 'enside-ta' ).'</option>
		    <option value="disable"'.$selected_4.'>'.__( "Disable sidebar", 'enside-ta' ).'</option>
		</select></p>';

		$value_portfolio_sort_id = get_post_meta( $post->ID, '_portfolio_sort_id_value', true );

		echo '<p><label for="portfolio_sort_id" style="width: 120px; display: inline-block;">';
		_e( "Sort order ID: ", 'enside-ta' );
		echo '</label> ';
		echo '<input type="text" id="portfolio_sort_id" name="portfolio_sort_id" value="' . esc_attr( $value_portfolio_sort_id ) . '" size="10" /> <span>Used for custom sorting order in MGT Portfolio Grid element. For example: 15</span></p>';

	}

	function portfolio_settings_save_postdata( $post_id ) {

		/*
		* We need to verify this came from the our screen and with proper authorization,
		* because save_post can be triggered at other times.
		*/

		// Check if our nonce is set.
		if ( ! isset( $_POST['portfolio_settings_inner_box_nonce'] ) )
		return $post_id;

		$nonce = $_POST['portfolio_settings_inner_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'portfolio_settings_inner_box' ) )
		  return $post_id;

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		  return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) )
		    return $post_id;

		} else {

		if ( ! current_user_can( 'edit_post', $post_id ) )
		    return $post_id;
		}

		// Sanitize user input.
		if(!isset($_POST['portfolio_hide_details'])) $_POST['portfolio_hide_details'] = false;

		$mydata = sanitize_text_field( $_POST['portfolio_hide_details'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_hide_details_value', $mydata );

		// Sanitize user input.
		if(!isset($_POST['portfolio_hide_breadcrumbs'])) $_POST['portfolio_hide_breadcrumbs'] = false;

		$mydata = sanitize_text_field( $_POST['portfolio_hide_breadcrumbs'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_hide_breadcrumbs_value', $mydata );

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_url'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_url_value', $mydata );

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_description'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_description_value', $mydata );

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_brand'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_brand_value', $mydata );

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_display_type'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_display_type_value', $mydata );

		if(!isset($_POST['portfolio_disableslider'])) $_POST['portfolio_disableslider'] = false;

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_disableslider'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_disableslider_value', $mydata );

		if(!isset($_POST['portfolio_fullwidthslider'])) $_POST['portfolio_fullwidthslider'] = false;

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_fullwidthslider'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_fullwidthslider_value', $mydata );

		if(!isset($_POST['portfolio_hide_1st_image_from_slider'])) $_POST['portfolio_hide_1st_image_from_slider'] = false;

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_hide_1st_image_from_slider'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_hide_1st_image_from_slider_value', $mydata );

		if(!isset($_POST['portfolio_socialshare_disable'])) $_POST['portfolio_socialshare_disable'] = false;

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_socialshare_disable'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_socialshare_disable_value', $mydata );

		if(!isset($_POST['portfolio_original_image_sizes'])) $_POST['portfolio_original_image_sizes'] = false;

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_original_image_sizes'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_original_image_sizes_value', $mydata );

	  	// Sanitize user input.
 		$mydata = sanitize_text_field( $_POST['page_bgcolor'] );

	  	// Update the meta field in the database.
	  	update_post_meta( $post_id, '_page_bgcolor_value', $mydata );

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_sidebarposition'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_sidebarposition_value', $mydata );

		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['portfolio_titleposition'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_portfolio_titleposition_value', $mydata );

		// Sanitize user input.
		if(!isset($_POST['page_transparent_header'])) $_POST['page_transparent_header'] = false;

		$mydata = sanitize_text_field( $_POST['page_transparent_header'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, '_page_transparent_header_value', $mydata );

	  	// Sanitize user input.
 		$mydata = sanitize_text_field( $_POST['portfolio_sort_id'] );

	  	// Update the meta field in the database.
	  	update_post_meta( $post_id, '_portfolio_sort_id_value', $mydata );

	}
	add_action( 'save_post', 'portfolio_settings_save_postdata' );

	// CMB2 Metaboxes
	// Portfolio Gallery Uploader
	function enside_register_porftolio_images_metabox() {

	  // Start with an underscore to hide fields from custom fields list
	  $prefix = '_enside_';
	  /**
	   * Metabox to be displayed on a single page ID
	   */
	  $cmb_post_format_settings = new_cmb2_box( array(
	    'id'           => $prefix . 'post_format_settings_metabox',
	    'title'        => __( 'Portfolio images/photos', 'cmb2' ),
	    'object_types' => array( 'mgt_portfolio' ), // Post type
	    'context'      => 'normal',
	    'priority'     => 'high',
	    'show_names'   => false, // Show field names on the left
	  ) );

	  $cmb_post_format_settings->add_field( array(
	    'name'         => __( 'Portfolio images<br>', 'cmb2' ),
	    'desc'         => __( 'Use this field to add your images for portfolio item. Use SHIFT/CTRL keyboard buttons to select multiple images.', 'cmb2' ),
	    'id'           => $prefix . 'portfolio_images_file_list',
	    'type'         => 'file_list',
	    'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	  ) );

	}
	add_action( 'cmb2_init', 'enside_register_porftolio_images_metabox' );

	// Clients Reviews metabox
	function enside_register_clients_reviews_metabox() {

	  // Start with an underscore to hide fields from custom fields list
	  $prefix = '_enside_';
	  /**
	   * Metabox to be displayed on a single page ID
	   */
	  $cmb_cr_post_format_settings = new_cmb2_box( array(
	    'id'           => $prefix . 'cr_post_format_settings_metabox',
	    'title'        => __( 'Client Review settings', 'cmb2' ),
	    'object_types' => array( 'mgt_clients_reviews' ), // Post type
	    'context'      => 'normal',
	    'priority'     => 'high',
	    'show_names'   => true, // Show field names on the left
	  ) );

	  $cmb_cr_post_format_settings->add_field( array(
        'name'       => __( 'Reviewer title', 'cmb2' ),
        'desc'       => __( 'Reviewer title or description', 'cmb2' ),
        'id'         => $prefix . 'clients_reviews_title',
        'type'       => 'text',
      ) );

	}
	add_action( 'cmb2_init', 'enside_register_clients_reviews_metabox' );

	/**
	* Removes the 'view' link in the admin bar
	*
	*/
	function enside_remove_view_button_admin_bar() {

		global $wp_admin_bar;
		$hide_view_in_post_types = Array('mgt_clients_reviews');
		foreach ( $hide_view_in_post_types as $post_type ) {
			if( get_post_type() === $post_type){
				$wp_admin_bar->remove_menu('view');
			}
		}
	}
	add_action( 'wp_before_admin_bar_render', 'enside_remove_view_button_admin_bar' );

	function enside_remove_view_row_action( $actions ) {
	 	$hide_view_in_post_types = Array('mgt_clients_reviews');
		foreach ( $hide_view_in_post_types as $post_type ) {
			if( get_post_type() === $post_type ){
				unset( $actions['view'] );
			}
		}
		return $actions;

	}
	add_filter( 'post_row_actions', 'enside_remove_view_row_action', 10, 1 );
}

/**
*	Social share links function
*/
function enside_social_share_links() {
	$post_image_data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'enside-blog-thumb');

	if(has_post_thumbnail( get_the_ID() )) {
	    $post_image = $post_image_data[0];
	} else {
		$post_image = '';
	}
	?>
	<div class="post-social-wrapper">
		<div class="post-social">
			<a title="<?php esc_html_e("Share with Facebook", 'enside-ta'); ?>" href="<?php the_permalink(); ?>" data-type="facebook" data-title="<?php the_title(); ?>" class="facebook-share"> <i class="fa fa-facebook"></i></a><a title="<?php esc_html_e("Tweet this", 'enside-ta'); ?>" href="<?php the_permalink(); ?>" data-type="twitter" data-title="<?php the_title(); ?>" class="twitter-share"> <i class="fa fa-twitter"></i></a><a title="<?php esc_html_e("Share with Google Plus", 'enside-ta'); ?>" href="<?php the_permalink(); ?>" data-type="google" data-title="<?php the_title(); ?>" class="googleplus-share"> <i class="fa fa-google-plus"></i></a><a title="<?php esc_html_e("Share with LinkedIn", 'mgtblog-ta'); ?>" href="<?php the_permalink(); ?>" data-type="linkedin" data-title="<?php the_title(); ?>" data-image="<?php echo esc_attr($post_image); ?>" class="linkedin-share"> <i class="fa fa-linkedin"></i></a><a title="<?php esc_html_e("Pin this", 'enside-ta'); ?>" href="<?php the_permalink(); ?>" data-type="pinterest" data-title="<?php the_title(); ?>" data-image="<?php echo esc_attr($post_image); ?>" class="pinterest-share"> <i class="fa fa-pinterest"></i></a><a title="<?php esc_html_e("Share with StumbleUpon", 'enside-ta'); ?>" href="<?php the_permalink(); ?>" data-type="stumbleupon" data-title="<?php the_title(); ?>" data-image="<?php echo esc_attr($post_image); ?>" class="stumbleupon-share"> <i class="fa fa-stumbleupon"></i></a><a title="<?php esc_html_e("Share with VKontakte", 'enside-ta'); ?>" href="<?php the_permalink(); ?>" data-type="vk" data-title="<?php the_title(); ?>" data-image="<?php echo esc_attr($post_image); ?>" class="vk-share"> <i class="fa fa-vk"></i></a>
		</div>
		<div class="clear"></div>
	</div>
	<?php
}

add_action('enside_social_share', 'enside_social_share_links');

/*
* Theme update notifications
*/
if(defined('DEMO_MODE')) {
	delete_option('enside_update_cache_date');
}

if (!function_exists('enside_update_checker')) :
function enside_update_checker() {
  ?>
  <script type="text/javascript" >
  (function($){
  $(document).ready(function($) {

  	$.getJSON('//api.magniumthemes.com/theme-versions.json', function(data){

	  	var items = data.themes;

		$.each(items, function(i, theme){

			if(theme.title == '<?php echo wp_get_theme(get_template());?>') {

				// Get version info
				var data = {
			      action: 'enside_update_checker_cache',
			      version: theme.version,
			      version_message: theme.version_message,
			      message: theme.message,
			      message_id: theme.message_id
			    };

				$.post( ajaxurl, data, function(response) {

				});
			}
		});

	});

  });
  })(jQuery);
  </script>
  <?php

  // Update update cache after time
  update_option('enside_update_cache_date', strtotime("+3 days"));

}

if(strtotime("now") > get_option( 'enside_update_cache_date', 0 )) {
	add_action('admin_print_footer_scripts', 'enside_update_checker', 99);
}

endif;

/**
 * Ajax update version cacher
 */
if (!function_exists('enside_update_checker_cache_callback')) :
function enside_update_checker_cache_callback() {
	$version = esc_html($_POST['version']);
	$version_message = ($_POST['version_message']);
	$message = ($_POST['message']);
	$message_id = esc_html($_POST['message_id']);

	update_option('enside_update_cache_version', $version);
	update_option('enside_update_cache_version_message', $version_message);
	update_option('enside_update_cache_message', $message);
	update_option('enside_update_cache_message_id', $message_id);

	wp_die();
}
add_action('wp_ajax_enside_update_checker_cache', 'enside_update_checker_cache_callback');
endif;

/**
 * Display update notifications
 */
if (!function_exists('enside_update_notify_display')) :
function enside_update_notify_display() {

	// Hide update notice
	if(isset($_GET['update-notify-dismiss'])) {
		$notify_id = 'dismiss-update-notify-v'.$_GET['update-notify-dismiss'];
		update_option($notify_id, 1);
	}

	$latest_version = get_option('enside_update_cache_version', '');
	$current_version = wp_get_theme(get_template())->get( 'Version' );
	$version_message = get_option('enside_update_cache_version_message', '');

	$notify_id = 'dismiss-update-notify-v'.$latest_version;
	$notify_dismiss = get_option($notify_id, 0);

	if(version_compare($latest_version, $current_version, ">") && $latest_version !== '' && $notify_dismiss == 0) {

		$message_html = '<div class="notice notice-error"><p>You are using outdated <strong>Enside '.esc_html($current_version).'</strong> theme version. Please update to <strong>'.esc_html($latest_version).'</strong> version. <a href="http://magniumthemes.com/go/theme-update-guide/" target="_blank">How to update theme</a>. '.$version_message.' <strong><span style="display: block; margin: 0.5em 0.5em 0 0; clear: both;"><a href="'.esc_url( add_query_arg( 'update-notify-dismiss', esc_html($latest_version))).'">'.esc_html__('Dismiss this notice', 'enside-ta').'</a></span></strong></p></div>';

		echo $message_html;

	}

	// Hide message notice
	if(isset($_GET['message-notify-dismiss'])) {
		$notify_id = 'dismiss-message-notify-v'.$_GET['message-notify-dismiss'];
		update_option($notify_id, 1);
	}

	$message = get_option('enside_update_cache_message', '');
	$message_id = get_option('enside_update_cache_message_id', 0);

	$notify_id = 'dismiss-message-notify-v'.$message_id;
	$notify_dismiss = get_option($notify_id, 0);

	if($notify_dismiss == 0 && $message !== '') {

		$message_html = '<div class="notice notice-success"><p>'.$message.'<strong><span style="display: block; margin: 0.5em 0.5em 0 0; clear: both;"><a href="'.esc_url( add_query_arg( 'message-notify-dismiss', esc_html($message_id))).'">'.esc_html__('Dismiss this notice', 'enside-ta').'</a></span></strong></p></div>';

		echo $message_html;

	}

}

if(!defined('ENVATO_HOSTED_SITE')) {
	add_action( 'admin_notices', 'enside_update_notify_display' );
}

endif;

/**
 * Clean up output of stylesheet <link> tags for W3C Validator
 */
function enside_clean_style_tag( $input ) {
    preg_match_all( "!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches );
    if ( empty( $matches[2] ) ) {
        return $input;
    }
    // Only display media if it is meaningful
    $media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';

    return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
if(!is_admin()) { // Gutenberg fix
	add_filter( 'style_loader_tag',  'enside_clean_style_tag'  );
}

/**
 * Clean up output of <script> tags for W3C Validator
 */
function enside_clean_script_tag( $input ) {
    $input = str_replace( "type='text/javascript' ", '', $input );

    return str_replace( "'", '"', $input );
}
if(!is_admin()) { // Gutenberg fix
	//add_filter( 'script_loader_tag', 'enside_clean_script_tag'  );
}

/**
 * Load theme custom shortcodes.
*/
// Check that VC installed
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

function enside_admin_notice_vc_required() {
    ?>
    <div class="notice notice-error">
        <p><?php _e( '<strong>Visual Composer (Enside Visual Page Builder) plugin must be installed and activated for correct theme work. Please <a href="'.esc_url('themes.php?page=install-required-plugins').'">install and activate all required plugins</a>.</strong>', 'enside-ta' ); ?></p>
    </div>
    <?php
}


/**
 * Ajax registration PHP
 */
if (!function_exists('enside_registration_process_callback')) :
function enside_registration_process_callback() {

	// User don't allowed subscription
	if(empty($_POST['email'])) {
		$email = '-';
		$subscribe = 0;
	} else {
	// User allowed subscription
		$email = esc_html($_POST['email']);
		$subscribe = 1;
	}

	$code = esc_html($_POST['code']);

	update_option('envato_purchase_code_enside', $code);

	echo wp_kses_post($email.';'.$code.';-;'.wp_get_theme().';'.get_site_url().';'.$subscribe);

	wp_die();
}
add_action('wp_ajax_enside_registration_process', 'enside_registration_process_callback');
endif;

/**
 * Ajax registration JS
 */
if (!function_exists('enside_registration_javascript')) :
function enside_registration_javascript() {
  ?>
  <script type="text/javascript" >
  (function($){
  $(document).ready(function($) {
  	"use strict";

	$('.theme-activation-wrapper .activate-theme-btn').on('click', function(e){

		var email = $('.theme-activation-wrapper .activate-theme-email').val();
		var code = $('.theme-activation-wrapper .activate-theme-code').val();

		if(code == '') {
			$('.theme-activation-wrapper .theme-activation-message').html('<span class="error"><?php esc_html_e('Please fill out purchase code field.', 'enside-ta'); ?></span>');
		} else {
			$('.theme-activation-wrapper .activate-theme-btn').attr('disabled', 'disabled').removeClass('button-primary').addClass('button-secondary');

			$('.theme-activation-wrapper .theme-activation-message').html('<?php esc_html_e('Registering theme...', 'enside-ta'); ?>');

			var data = {
		      action: 'enside_registration_process',
		      email: email,
		      code: code
		    };

			$.post( ajaxurl, data, function(response) {

		      var wpdata = response;

			  $.ajax({
			    url: "//api.magniumthemes.com/activation.php?act=register&purchasecheck&data="+wpdata,
			    type: "GET",
			    timeout: 10000,
			    success: function(data) {
			    	if(data == 'verified') {

						$('.theme-activation-wrapper .theme-activation-message').html('<span class="success"><?php esc_html_e('Theme registered succesfully!', 'enside-ta'); ?></span><br/><br>');

						window.location = "themes.php?page=ipanel_ENSIDE_PANEL&act=registration_complete";


					} else if(data == 'verifiedused') {
						$('.theme-activation-wrapper .theme-activation-message').html('<span class="success"><?php esc_html_e('Theme registered succesfully!', 'enside-ta'); ?></span><br/><br>');

							alert('<?php esc_html_e('Theme registered succesfully, but we see that theme purchase code was already activated before. Please note that by ThemeForest regular license rules you can use one theme license only on one WordPress installation with one language (you allowed to use theme another time only on test/development environments). If you are using theme on multiple sites or multilanguage website make sure you purchased separate regular license for every site and language, otherwise theme on your sites can be automatically blocked in next check.', 'enside-ta'); ?>');

							window.location = "themes.php?page=ipanel_ENSIDE_PANEL&act=registration_complete";

					} else {
						$('.theme-activation-wrapper .theme-activation-message').html('<span class="error"><?php esc_html_e('Purchase code is not valid. Your purchase code should look like this: 36434418-e837-48c5-8737-f20d52b36a1f', 'enside-ta'); ?></span>');

						$('.theme-activation-wrapper .activate-theme-btn').removeAttr('disabled', 'disabled').removeClass('button-secondary').addClass('button-primary');

					}
			    },
			    error: function(xmlhttprequest, textstatus, message) {
			        $('.theme-activation-wrapper .theme-activation-message').html("<?php echo wp_kses_post(__("<span class='error'>Oops! It looks like the your hosting blocks external connections to our server.<br/>Please click the button below to skip activation for 1 day and start using all theme features right now. <br/>Please <a href='http://support.magniumthemes.com/' target='_blank'>contact our support team</a> to get theme activated manually.</span><br><a href='themes.php?page=ipanel_ENSIDE_PANEL&act=registration_skip' class='button button-primary button-hero activate-theme-btn'>Start using theme</a>", 'enside-ta')); ?>");
			    }
			  });

		    });

	  	}

    });

  });
  })(jQuery);
  </script>
  <?php
}
add_action('admin_print_footer_scripts', 'enside_registration_javascript', 99);
endif;

// Theme metaboxes
require plugin_dir_path( __FILE__ ).'inc/theme-metaboxes.php';

// Theme widgets
require plugin_dir_path( __FILE__ ).'inc/theme-widgets.php';

if(is_plugin_active('js_composer/js_composer.php')) {
	require plugin_dir_path( __FILE__ ).'inc/theme-shortcodes.php';
} else {
	add_action( 'admin_notices', 'enside_admin_notice_vc_required' );
}
