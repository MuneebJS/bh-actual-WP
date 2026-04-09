<?php
/**
 * Load custom VC shortcodes
 */

add_action( 'wp_loaded', 'enside_visual_composer_custom_init' );

function enside_visual_composer_custom_init() {

	if(function_exists('vc_set_as_theme')) vc_set_as_theme(true);

	// VC Templates
	$vc_templates_dir = plugin_dir_path( __FILE__ ).'shortcodes/visual-composer/templates';

	vc_set_shortcodes_templates_dir($vc_templates_dir);

	// Animation CSS media fix for VC
	wp_deregister_style( 'animate-css' );
	wp_register_style( 'animate-css', vc_asset_url( 'lib/bower/animate-css/animate.min.css' ), false, WPB_VC_VERSION, 'screen' );

	// Adding new icons fonts
	function vc_iconpicker_type_pe7stroke( $icons ) {
		$pe7stroke_icons = array(
			array( 'pe-7s-album' => 'album' ),
			array( 'pe-7s-arc' => 'arc' ),
			array( 'pe-7s-back-2' => 'back-2' ),
			array( 'pe-7s-bandaid' => 'bandaid' ),
			array( 'pe-7s-car' => 'car' ),
			array( 'pe-7s-diamond' => 'diamond' ),
			array( 'pe-7s-door-lock' => 'door-lock' ),
			array( 'pe-7s-eyedropper' => 'eyedropper' ),
			array( 'pe-7s-female' => 'female' ),
			array( 'pe-7s-gym' => 'gym' ),
			array( 'pe-7s-hammer' => 'hammer' ),
			array( 'pe-7s-headphones' => 'headphones' ),
			array( 'pe-7s-helm' => 'helm' ),
			array( 'pe-7s-hourglass' => 'hourglass' ),
			array( 'pe-7s-leaf' => 'leaf' ),
			array( 'pe-7s-magic-wand' => 'magic-wand' ),
			array( 'pe-7s-male' => 'male' ),
			array( 'pe-7s-map-2' => 'map-2' ),
			array( 'pe-7s-next-2' => 'next-2' ),
			array( 'pe-7s-paint-bucket' => 'paint-bucket' ),
			array( 'pe-7s-pendrive' => 'spendrive' ),
			array( 'pe-7s-photo' => 'photo' ),
			array( 'pe-7s-piggy' => 'piggy' ),
			array( 'pe-7s-plugin' => 'plugin' ),
			array( 'pe-7s-refresh-2' => 'refresh-2' ),
			array( 'pe-7s-rocket' => 'rocket' ),
			array( 'pe-7s-settings' => 'settings' ),
			array( 'pe-7s-shield' => 'shield' ),
			array( 'pe-7s-smile' => 'smile' ),
			array( 'pe-7s-usb' => 'usb' ),
			array( 'pe-7s-vector' => 'vector' ),
			array( 'pe-7s-wine' => 'wine' ),
			array( 'pe-7s-cloud-upload' => 'cloud-upload' ),
			array( 'pe-7s-cash' => 'cash' ),
			array( 'pe-7s-close' => 'close' ),
			array( 'pe-7s-bluetooth' => 'bluetooth' ),
			array( 'pe-7s-cloud-download' => 'cloud-download' ),
			array( 'pe-7s-way' => 'way' ),
			array( 'pe-7s-close-circle' => 'close-circle' ),
			array( 'pe-7s-id' => 'id' ),
			array( 'pe-7s-angle-up' => 'angle-up' ),
			array( 'pe-7s-wristwatch' => 'wristwatch' ),
			array( 'pe-7s-angle-up-circle' => 'angle-up-circle' ),
			array( 'pe-7s-world' => 'world' ),
			array( 'pe-7s-angle-right' => 'angle-right' ),
			array( 'pe-7s-volume' => 'volume' ),
			array( 'pe-7s-angle-right-circle' => 'angle-right-circle' ),
			array( 'pe-7s-users' => 'users' ),
			array( 'pe-7s-angle-left' => 'angle-left' ),
			array( 'pe-7s-user-female' => 'user-female' ),
			array( 'pe-7s-angle-left-circle' => 'angle-left-circle' ),
			array( 'pe-7s-up-arrow' => 'up-arrow' ),
			array( 'pe-7s-angle-down' => 'angle-down' ),
			array( 'pe-7s-switch' => 'switch' ),
			array( 'pe-7s-angle-down-circle' => 'angle-down-circle' ),
			array( 'pe-7s-scissors' => 'scissors' ),
			array( 'pe-7s-wallet' => 'wallet' ),
			array( 'pe-7s-safe' => 'safe' ),
			array( 'pe-7s-volume2' => 'volume2' ),
			array( 'pe-7s-volume1' => 'volume1' ),
			array( 'pe-7s-voicemail' => 'voicemail' ),
			array( 'pe-7s-video' => 'video' ),
			array( 'pe-7s-user' => 'user' ),
			array( 'pe-7s-upload' => 'upload' ),
			array( 'pe-7s-unlock' => 'unlock' ),
			array( 'pe-7s-umbrella' => 'umbrella' ),
			array( 'pe-7s-trash' => 'trash' ),
			array( 'pe-7s-tools' => 'tools' ),
			array( 'pe-7s-timer' => 'timer' ),
			array( 'pe-7s-ticket' => 'ticket' ),
			array( 'pe-7s-target' => 'target' ),
			array( 'pe-7s-sun' => 'sun' ),
			array( 'pe-7s-study' => 'study' ),
			array( 'pe-7s-stopwatch' => 'stopwatch' ),
			array( 'pe-7s-star' => 'star' ),
			array( 'pe-7s-speaker' => 'speaker' ),
			array( 'pe-7s-signal' => 'signal' ),
			array( 'pe-7s-shuffle' => 'shuffle' ),
			array( 'pe-7s-shopbag' => 'shopbag' ),
			array( 'pe-7s-share' => 'share' ),
			array( 'pe-7s-server' => 'server' ),
			array( 'pe-7s-search' => 'search' ),
			array( 'pe-7s-film' => 'film' ),
			array( 'pe-7s-science' => 'science' ),
			array( 'pe-7s-disk' => 'disk' ),
			array( 'pe-7s-ribbon' => 'ribbon' ),
			array( 'pe-7s-repeat' => 'repeat' ),
			array( 'pe-7s-refresh' => 'refresh' ),
			array( 'pe-7s-add-user' => 'add-user' ),
			array( 'pe-7s-refresh-cloud' => 'refresh-cloud' ),
			array( 'pe-7s-paperclip' => 'paperclip' ),
			array( 'pe-7s-radio' => 'radio' ),
			array( 'pe-7s-note2' => 'note2' ),
			array( 'pe-7s-print' => 'print' ),
			array( 'pe-7s-network' => 'network' ),
			array( 'pe-7s-prev' => 'prev' ),
			array( 'pe-7s-mute' => 'mute' ),
			array( 'pe-7s-power' => 'power' ),
			array( 'pe-7s-medal' => 'medal' ),
			array( 'pe-7s-portfolio' => 'portfolio' ),
			array( 'pe-7s-like2' => 'like2' ),
			array( 'pe-7s-plus' => 'plus' ),
			array( 'pe-7s-left-arrow' => 'left-arrow' ),
			array( 'pe-7s-play' => 'play' ),
			array( 'pe-7s-key' => 'key' ),
			array( 'pe-7s-plane' => 'plane' ),
			array( 'pe-7s-joy' => 'joy' ),
			array( 'pe-7s-photo-gallery' => 'photo-gallery' ),
			array( 'pe-7s-pin' => 'pin' ),
			array( 'pe-7s-phone' => 'phone' ),
			array( 'pe-7s-plug' => 'plug' ),
			array( 'pe-7s-pen' => 'pen' ),
			array( 'pe-7s-right-arrow' => 'right-arrow' ),
			array( 'pe-7s-paper-plane' => 'paper-plane' ),
			array( 'pe-7s-delete-user' => 'delete-user' ),
			array( 'pe-7s-paint' => 'paint' ),
			array( 'pe-7s-bottom-arrow' => 'bottom-arrow' ),
			array( 'pe-7s-notebook' => 'notebook' ),
			array( 'pe-7s-note' => 'note' ),
			array( 'pe-7s-next' => 'next' ),
			array( 'pe-7s-news-paper' => 'news-paper' ),
			array( 'pe-7s-musiclist' => 'musiclist' ),
			array( 'pe-7s-music' => 'music' ),
			array( 'pe-7s-mouse' => 'mouse' ),
			array( 'pe-7s-more' => 'more' ),
			array( 'pe-7s-moon' => 'moon' ),
			array( 'pe-7s-monitor' => 'monitor' ),
			array( 'pe-7s-micro' => 'micro' ),
			array( 'pe-7s-menu' => 'menu' ),
			array( 'pe-7s-map' => 'map' ),
			array( 'pe-7s-map-marker' => 'map-marker' ),
			array( 'pe-7s-mail' => 'mail' ),
			array( 'pe-7s-mail-open' => 'mail-open' ),
			array( 'pe-7s-mail-open-file' => 'mail-open-file' ),
			array( 'pe-7s-magnet' => 'magnet' ),
			array( 'pe-7s-loop' => 'loop' ),
			array( 'pe-7s-look' => 'look' ),
			array( 'pe-7s-lock' => 'lock' ),
			array( 'pe-7s-lintern' => 'lintern' ),
			array( 'pe-7s-link' => 'link' ),
			array( 'pe-7s-like' => 'like' ),
			array( 'pe-7s-light' => 'light' ),
			array( 'pe-7s-less' => 'less' ),
			array( 'pe-7s-keypad' => 'keypad' ),
			array( 'pe-7s-junk' => 'junk' ),
			array( 'pe-7s-info' => 'info' ),
			array( 'pe-7s-home' => 'home' ),
			array( 'pe-7s-help2' => 'help2' ),
			array( 'pe-7s-help1' => 'help1' ),
			array( 'pe-7s-graph3' => 'graph3' ),
			array( 'pe-7s-graph2' => 'graph2' ),
			array( 'pe-7s-graph1' => 'graph1' ),
			array( 'pe-7s-graph' => 'graph' ),
			array( 'pe-7s-global' => 'global' ),
			array( 'pe-7s-gleam' => 'gleam' ),
			array( 'pe-7s-glasses' => 'glasses' ),
			array( 'pe-7s-gift' => 'gift' ),
			array( 'pe-7s-folder' => 'folder' ),
			array( 'pe-7s-flag' => 'flag' ),
			array( 'pe-7s-filter' => 'filter' ),
			array( 'pe-7s-file' => 'file' ),
			array( 'pe-7s-expand1' => 'expand1' ),
			array( 'pe-7s-exapnd2' => 'exapnd2' ),
			array( 'pe-7s-edit' => 'edit' ),
			array( 'pe-7s-drop' => 'drop' ),
			array( 'pe-7s-drawer' => 'drawer' ),
			array( 'pe-7s-download' => 'download' ),
			array( 'pe-7s-display2' => 'display2' ),
			array( 'pe-7s-display1' => 'display1' ),
			array( 'pe-7s-diskette' => 'diskette' ),
			array( 'pe-7s-date' => 'date' ),
			array( 'pe-7s-cup' => 'cup' ),
			array( 'pe-7s-culture' => 'culture' ),
			array( 'pe-7s-crop' => 'crop' ),
			array( 'pe-7s-credit' => 'credit' ),
			array( 'pe-7s-copy-file' => 'copy-file' ),
			array( 'pe-7s-config' => 'config' ),
			array( 'pe-7s-compass' => 'compass' ),
			array( 'pe-7s-comment' => 'comment' ),
			array( 'pe-7s-coffee' => 'coffee' ),
			array( 'pe-7s-cloud' => 'cloud' ),
			array( 'pe-7s-clock' => 'clock' ),
			array( 'pe-7s-check' => 'check' ),
			array( 'pe-7s-chat' => 'chat' ),
			array( 'pe-7s-cart' => 'cart' ),
			array( 'pe-7s-camera' => 'camera' ),
			array( 'pe-7s-call' => 'call' ),
			array( 'pe-7s-calculator' => 'calculator' ),
			array( 'pe-7s-browser' => 'browser' ),
			array( 'pe-7s-box2' => 'box2' ),
			array( 'pe-7s-box1' => 'box1' ),
			array( 'pe-7s-bookmarks' => 'bookmarks' ),
			array( 'pe-7s-bicycle' => 'bicycle' ),
			array( 'pe-7s-bell' => 'bell' ),
			array( 'pe-7s-battery' => 'battery' ),
			array( 'pe-7s-ball' => 'ball' ),
			array( 'pe-7s-back' => 'back' ),
			array( 'pe-7s-attention' => 'attention' ),
			array( 'pe-7s-anchor' => 'anchor' ),
			array( 'pe-7s-albums' => 'albums' ),
			array( 'pe-7s-alarm' => 'alarm' ),
			array( 'pe-7s-airplay' => 'airplay' ),
		);

		return array_merge( $icons, $pe7stroke_icons );
	}

	add_filter( 'vc_iconpicker-type-pe7stroke', 'vc_iconpicker_type_pe7stroke' );

	wp_enqueue_style('vc-pe7stroke', get_template_directory_uri() . '/css/pe-icon-7-stroke.css');

	// Remove default VC elements
	vc_remove_element("vc_posts_grid");
	vc_remove_element("vc_carousel");
	vc_remove_element("vc_posts_slider");
	vc_remove_element("vc_cta_button");
	vc_remove_element("vc_cta_button2");
	vc_remove_element("vc_message");

	// Adding new Param Types for VC
	vc_add_shortcode_param( 'mgt_separator', 'mgt_separator_settings' );

	function mgt_separator_settings( $settings, $value ) {
	    return '<div class="mgt_separator_block">'
             .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
             esc_attr( $settings['param_name'] ) . ' ' .
             esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '" />' .
             '</div>'; // This is html markup that will be outputted in content elements edit form
	}

	// Add new WP shortcodes to VC
	include_once('shortcodes/visual-composer/mgt-promo-block.php');
	include_once('shortcodes/visual-composer/mgt-header-block.php');
	include_once('shortcodes/visual-composer/mgt-icon-box.php');
	include_once('shortcodes/visual-composer/mgt-post-list.php');
	include_once('shortcodes/visual-composer/mgt-button.php');
	include_once('shortcodes/visual-composer/mgt-calltoaction-block.php');
	include_once('shortcodes/visual-composer/mgt-signup-block.php');
	include_once('shortcodes/visual-composer/mgt-message-box.php');
	include_once('shortcodes/visual-composer/mgt-counter.php');
	include_once('shortcodes/visual-composer/mgt-clients-reviews.php');
	include_once('shortcodes/visual-composer/mgt-portfolio-grid.php');
	include_once('shortcodes/visual-composer/mgt-countdown.php');
	include_once('shortcodes/visual-composer/mgt-pricing-table.php');
	include_once('shortcodes/visual-composer/mgt-process.php');
	include_once('shortcodes/visual-composer/mgt-item-price.php');
	include_once('shortcodes/visual-composer/mgt-images-slider.php');
	include_once('shortcodes/visual-composer/mgt-flipbox.php');
	
	// Shortcodes that work only with VC plugin
	include_once('shortcodes/wp/mgt-promo-block-wp.php');
	include_once('shortcodes/wp/mgt-button-wp.php');
	include_once('shortcodes/wp/mgt-calltoaction-block-wp.php');
	include_once('shortcodes/wp/mgt-portfolio-grid-wp.php');
	include_once('shortcodes/wp/mgt-flipbox-wp.php');
	include_once('shortcodes/wp/mgt-pricing-table-wp.php');
	include_once('shortcodes/wp/mgt-signup-block-wp.php');
	
	// Custom VC Row
	include_once('shortcodes/visual-composer/vc-row-custom.php');

}
add_action( 'init', 'enside_addons_shortcodes_init', 9999 );

function enside_addons_shortcodes_init() {

	include_once('shortcodes/wp/mgt-header-block-wp.php');
	include_once('shortcodes/wp/mgt-icon-box-wp.php');
	include_once('shortcodes/wp/mgt-post-list-wp.php');
	include_once('shortcodes/wp/mgt-message-box-wp.php');
	include_once('shortcodes/wp/mgt-counter-wp.php');
	include_once('shortcodes/wp/mgt-clients-reviews-wp.php');
	include_once('shortcodes/wp/mgt-countdown-wp.php');
	include_once('shortcodes/wp/mgt-process-wp.php');
	include_once('shortcodes/wp/mgt-item-price-wp.php');
	include_once('shortcodes/wp/mgt-images-slider-wp.php');

}

// Theme default shortcodes
// [enside_social_icons] - Show theme social icons with links
function enside_social_icons_shortcode( $atts ) {
	ob_start();
	
	echo '<div class="widget_enside_social_icons shortcode_enside_social_icons">';
	enside_social_icons_show();
	echo '</div>';

	$w_content = ob_get_contents();
	ob_end_clean();
	return $w_content;
}
add_shortcode( 'enside_social_icons', 'enside_social_icons_shortcode' );

// WordPress AutoP fix for theme shortcodes
add_filter("the_content", "enside_the_content_filter");

function enside_the_content_filter($content) {

	// array of custom shortcodes requiring the fix 
	$block = join("|",array("mgt_promo_block_wp"));
	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

	return $rep;
}

$separator_id = 0;

// Separator element name for VC
function generate_separator_name() {

	global $separator_id;

	$separator_id++;

	return 'mgt_sep_'.$separator_id;
}

?>