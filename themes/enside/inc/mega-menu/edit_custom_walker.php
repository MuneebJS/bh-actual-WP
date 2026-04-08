<?php
/**
 *  /!\ This is a copy of Walker_Nav_Menu_Edit class in core
 *
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */

class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {

	/**
	 * @see Walker_Nav_Menu::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	}

	/**
	 * @see Walker_Nav_Menu::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param object $args
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	    global $_wp_nav_menu_max_depth, $wp_registered_sidebars;

	    $enside_theme_options = enside_get_theme_options();

	    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

	    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

	    ob_start();
	    $item_id = esc_attr( $item->ID );
	    $removed_args = array(
	        'action',
	        'customlink-tab',
	        'edit-menu-item',
	        'menu-item',
	        'page-tab',
	        '_wpnonce',
	    );

	    $original_title = '';
	    if ( 'taxonomy' == $item->type ) {
	        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
	        if ( is_wp_error( $original_title ) )
	            $original_title = false;
	    } elseif ( 'post_type' == $item->type ) {
	        $original_object = get_post( $item->object_id );
	        $original_title = $original_object->post_title;
	    }

	    $classes = array(
	        'menu-item menu-item-depth-' . $depth,
	        'menu-item-' . esc_attr( $item->object ),
	        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
	    );

	    $title = $item->title;

	    if ( ! empty( $item->_invalid ) ) {
	        $classes[] = 'menu-item-invalid';
	        /* translators: %s: title of menu item which is invalid */
	        $title = sprintf( wp_kses_post( __('%s (Invalid)', 'enside' )), $item->title );
	    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
	        $classes[] = 'pending';
	        /* translators: %s: title of menu item in draft status */
	        $title = sprintf( wp_kses_post(__('%s (Pending)', 'enside')), $item->title );
	    }

	    $title = empty( $item->label ) ? $title : $item->label;

	    // Color picker
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );

	    ?>
	    <li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo esc_attr(implode(' ', $classes )); ?>">
	        <dl class="menu-item-bar">
	            <dt class="menu-item-handle">
	                <span class="item-title"><?php echo esc_html( $title ); ?></span>
	                <span class="item-controls">
	                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
	                    <span class="item-order hide-if-js">
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                esc_url(add_query_arg(
	                                    array(
	                                        'action' => 'move-up-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    esc_url(remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) ))
	                                )),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'enside'); ?>">&#8593;</abbr></a>
	                        |
	                        <a href="<?php
	                            echo wp_nonce_url(
	                                esc_url(add_query_arg(
	                                    array(
	                                        'action' => 'move-down-menu-item',
	                                        'menu-item' => $item_id,
	                                    ),
	                                    esc_url(remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) ))
	                                )),
	                                'move-menu_item'
	                            );
	                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'enside'); ?>">&#8595;</abbr></a>
	                    </span>
	                    <a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item', 'enside'); ?>" href="<?php
	                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : esc_url(add_query_arg( 'edit-menu-item', $item_id, esc_url(remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) )) ));
	                    ?>"><?php esc_html_e( 'Edit Menu Item', 'enside' ); ?></a>
	                </span>
	            </dt>
	        </dl>

	        <div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
	            <?php if( 'custom' == $item->type ) : ?>
	                <p class="field-url description description-wide">
	                    <label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
	                        <?php esc_html_e( 'URL', 'enside' ); ?><br />
	                        <input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
	                    </label>
	                </p>
	            <?php endif; ?>
	            <p class="description description-thin">
	                <label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Navigation Label', 'enside' ); ?><br />
	                    <input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
	                </label>
	            </p>
	            <p class="description description-thin">
	                <label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Title Attribute', 'enside' ); ?><br />
	                    <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
	                </label>
	            </p>
	            <p class="description description-thin">
	                <label for="edit-menu-item-badgetitle-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Badge title', 'enside' ); ?><br />
	                    <input type="text" id="edit-menu-item-badgetitle-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-badgetitle" name="menu-item-badgetitle[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->badgetitle ); ?>" />
	                </label>
	            </p>
	            <p class="description description-thin">
	                <label for="edit-menu-item-badgecolor-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Badge color', 'enside' ); ?><br />
	                    <input type="text" id="edit-menu-item-badgecolor-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-badgecolor" name="menu-item-badgecolor[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->badgecolor ); ?>" />
	                </label>
	            </p>
	            <p class="field-link-target description">
	                <label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
	                    <input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
	                    <?php esc_html_e( 'Open link in a new window/tab', 'enside' ); ?>
	                </label>
	            </p>
	            <p class="field-css-classes description description-thin">
	                <label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'CSS Classes (optional)', 'enside' ); ?><br />
	                    <input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
	                </label>
	            </p>
	            <p class="field-xfn description description-thin">
	                <label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Link Relationship (XFN)', 'enside' ); ?><br />
	                    <input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
	                </label>
	            </p>
	            <p class="field-description description description-wide">
	                <label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Description', 'enside' ); ?><br />
	                    <textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
	                    <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'enside'); ?></span>
	                </label>
	            </p>
	            <?php
	            /* New fields insertion starts here */
	            ?>
	            <?php if($item->type == 'custom'): ?>
	            <p class="field-onepage description description-wide">
					<label for="edit-menu-item-onepage-<?php echo esc_attr($item_id); ?>">

						<?php esc_html_e( 'Use this menu item for Onepage navigation', 'enside' ); ?><br />
	                    <select id="edit-menu-item-onepage-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-onepage[<?php echo esc_attr($item_id); ?>]">
	                    	<option value="off"<?php if(esc_attr( $item->onepage ) == 'off') { echo ' selected'; }?>>No</option>
	                    	<option value="on"<?php if(esc_attr( $item->onepage ) == 'on') { echo ' selected'; }?>>Yes</option>
	                    </select>
					</label>
				</p>
				<?php endif; ?>
	            <?php if($depth == 0 && (isset($enside_theme_options['header_position']) && $enside_theme_options['header_position'] !== 'left')): ?>
	            <p class="field-columns description description-wide">
	                <label for="edit-menu-item-columns-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Megamenu columns', 'enside' ); ?><br />
	                    <select id="edit-menu-item-columns-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-columns[<?php echo esc_attr($item_id); ?>]">
	                    	<option value="1"<?php if(esc_attr( $item->columns ) == 1) { echo ' selected'; }?>>1</option>
	                    	<option value="2"<?php if(esc_attr( $item->columns ) == 2) { echo ' selected'; }?>>2</option>
	                    	<option value="3"<?php if(esc_attr( $item->columns ) == 3) { echo ' selected'; }?>>3</option>
	                    	<option value="4"<?php if(esc_attr( $item->columns ) == 4) { echo ' selected'; }?>>4</option>
	                    	<option value="5"<?php if(esc_attr( $item->columns ) == 5) { echo ' selected'; }?>>5</option>
	                    </select>

	                </label>
	            </p>
				<p class="field-fullwidth description description-wide">
					<label for="edit-menu-item-fullwidth-<?php echo esc_attr($item_id); ?>">

						<?php esc_html_e( 'Show this submenu fullwidth', 'enside' ); ?><br />
	                    <select id="edit-menu-item-fullwidth-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-fullwidth[<?php echo esc_attr($item_id); ?>]">
	                    	<option value="off"<?php if(esc_attr( $item->fullwidth ) == 'off') { echo ' selected'; }?>><?php esc_html_e( 'No', 'enside' ); ?></option>
	                    	<option value="on"<?php if(esc_attr( $item->fullwidth ) == 'on') { echo ' selected'; }?>><?php esc_html_e( 'Yes', 'enside' ); ?></option>
	                    </select>
					</label>
				</p>
				<p class="field-dropdownposition description description-wide">
					<label for="edit-menu-item-dropdownposition-<?php echo esc_attr($item_id); ?>">

						<?php esc_html_e( 'Sublevels dropdown menus position', 'enside' ); ?><br />
	                    <select id="edit-menu-item-dropdownposition-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-dropdownposition[<?php echo esc_attr($item_id); ?>]">
	                    	<option value="right"<?php if(esc_attr( $item->dropdownposition ) == 'right') { echo ' selected'; }?>><?php esc_html_e( 'Right', 'enside' ); ?></option>
	                    	<option value="left"<?php if(esc_attr( $item->dropdownposition ) == 'left') { echo ' selected'; }?>><?php esc_html_e( 'Left', 'enside' ); ?></option>
	                    </select>
					</label>
				</p>
				<p class="field-sidebar description description-wide">
	        	<label for="edit-menu-item-sidebar-<?php echo esc_attr($item_id); ?>">
                    <?php esc_html_e( 'Show sidebar with widgets inside this submenu', 'enside' ); ?><br />
                    <select class="sidebar-select code edit-menu-item-custom" id="edit-menu-item-sidebar-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-sidebar[<?php echo esc_attr($item_id); ?>]">

					    <option value=""><?php esc_html_e( 'Do not add sidebar', 'enside' ); ?></option>
					    <?php foreach ($wp_registered_sidebars as $registered_sidebar) {
					    	if((strpos($registered_sidebar["id"],'megamenu_sidebar') !== false)) {
					    		if((esc_attr( $item->sidebar ) !== '') && $registered_sidebar["id"] == esc_attr( $item->sidebar)) {
					    			echo '<option value="'.esc_attr($registered_sidebar["id"]).'" selected>'.esc_html($registered_sidebar['name']).'</option>';
					    		} else {
					    			echo '<option value="'.esc_attr($registered_sidebar["id"]).'">'.esc_html($registered_sidebar['name']).'</option>';
					    		}

					    	}
					    }
					    ?>

					</select>
				</label>
				</p>
				<p class="field-background-url description description-wide">
	                <label for="edit-menu-item-background_url-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Background image URL', 'enside' ); ?><br />
	                    <input type="text" id="edit-menu-item-background_url-<?php echo esc_attr($item_id); ?>" class="code edit-menu-item-custom" name="menu-item-background_url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->background_url ); ?>" />
	                	<input class="button upload-menu-item-bg" name="upload-menu-item-bg" type="text" data-uploader_button_text="Select image" data-uploader_title="<?php esc_attr_e('Select submenu background image', 'enside'); ?>" value="<?php esc_attr_e('Select image', 'enside'); ?>" />
	                	<input class="button remove-menu-item-bg" name="remove-menu-item-bg" type="text" style="width: 80px;" value="<?php esc_attr_e('Remove', 'enside'); ?>" />
	                </label>
	            </p>
	            <p class="field-backgroundrepeat description description-wide">
	                <label for="edit-menu-item-backgroundrepeat-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Background repeat', 'enside' ); ?><br />
	                    <select id="edit-menu-item-backgroundrepeat-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-backgroundrepeat[<?php echo esc_attr($item_id); ?>]">
	                    	<option value="no-repeat"<?php if(esc_attr( $item->backgroundrepeat ) == 'no-repeat') { echo ' selected'; }?>><?php esc_html_e( 'No repeat', 'enside' ); ?></option>
	                    	<option value="repeat"<?php if(esc_attr( $item->backgroundrepeat ) == 'repeat') { echo ' selected'; }?>><?php esc_html_e( 'Repeat', 'enside' ); ?></option>
	                    	<option value="repeat-x"<?php if(esc_attr( $item->backgroundrepeat ) == 'repeat-x') { echo ' selected'; }?>><?php esc_html_e( 'Repeat X', 'enside' ); ?></option>
	                    	<option value="repeat-y"<?php if(esc_attr( $item->backgroundrepeat ) == 'repeat-y') { echo ' selected'; }?>><?php esc_html_e( 'Repeat Y', 'enside' ); ?></option>
	                    </select>
	                </label>
	            </p>
	            <p class="field-backgroundpositionx description description-wide">
	                <label for="edit-menu-item-backgroundpositionx-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Background position X', 'enside' ); ?><br />
	                    <select id="edit-menu-item-backgroundpositionx-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-backgroundpositionx[<?php echo esc_attr($item_id); ?>]">
	                    	<option value="center"<?php if(esc_attr( $item->backgroundpositionx ) == 'center') { echo ' selected'; }?>><?php esc_html_e( 'Center', 'enside' ); ?></option>
	                    	<option value="left"<?php if(esc_attr( $item->backgroundpositionx ) == 'left') { echo ' selected'; }?>><?php esc_html_e( 'Left', 'enside' ); ?></option>
	                    	<option value="right"<?php if(esc_attr( $item->backgroundpositionx ) == 'right') { echo ' selected'; }?>><?php esc_html_e( 'Right', 'enside' ); ?></option>
	                  	</select>
	                </label>
	            </p>
	            <p class="field-backgroundpositiony description description-wide">
	                <label for="edit-menu-item-backgroundpositiony-<?php echo esc_attr($item_id); ?>">
	                    <?php esc_html_e( 'Background position Y', 'enside' ); ?><br />
	                    <select id="edit-menu-item-backgroundpositiony-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-backgroundpositiony[<?php echo esc_attr($item_id); ?>]">
	                    	<option value="center"<?php if(esc_attr( $item->backgroundpositiony ) == 'center') { echo ' selected'; }?>><?php esc_html_e( 'Center', 'enside' ); ?></option>
	                    	<option value="top"<?php if(esc_attr( $item->backgroundpositiony ) == 'top') { echo ' selected'; }?>><?php esc_html_e( 'Top', 'enside' ); ?></option>
	                    	<option value="bottom"<?php if(esc_attr( $item->backgroundpositiony ) == 'bottom') { echo ' selected'; }?>><?php esc_html_e( 'Bottom', 'enside' ); ?></option>
	                  	</select>
	                </label>
	            </p>
	        	<?php endif; ?>
	        	<p class="field-icon description description-wide">
	        	<label for="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>">
                    <?php esc_html_e( 'Menu item Icon', 'enside' ); ?><br />
                    <select class="fontawesome-select code edit-menu-item-custom" id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-custom" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]">
					    <?php if(esc_attr( $item->icon ) !== ''): ?>
					    <option value="<?php echo esc_attr( $item->icon ); ?>" selected><?php esc_html_e( 'Current icon', 'enside' ); ?></option>
					    <?php endif; ?>
					    <option value="">Do not add icon</option>
					    <option value="fa-adjust">&#xf042; adjust</option>
						<option value="fa-adn">&#xf170; adn</option>
						<option value="fa-align-center">&#xf037; align-center</option>
						<option value="fa-align-justify">&#xf039; align-justify</option>
						<option value="fa-align-left">&#xf036; align-left</option>
						<option value="fa-align-right">&#xf038; align-right</option>
						<option value="fa-ambulance">&#xf0f9; ambulance</option>
						<option value="fa-anchor">&#xf13d; anchor</option>
						<option value="fa-android">&#xf17b; android</option>
						<option value="fa-angellist">&#xf209; angellist</option>
						<option value="fa-angle-double-down">&#xf103; angle-double-down</option>
						<option value="fa-angle-double-left">&#xf100; angle-double-left</option>
						<option value="fa-angle-double-right">&#xf101; angle-double-right</option>
						<option value="fa-angle-double-up">&#xf102; angle-double-up</option>
						<option value="fa-angle-down">&#xf107; angle-down</option>
						<option value="fa-angle-left">&#xf104; angle-left</option>
						<option value="fa-angle-right">&#xf105; angle-right</option>
						<option value="fa-angle-up">&#xf106; angle-up</option>
						<option value="fa-apple">&#xf179; apple</option>
						<option value="fa-archive">&#xf187; archive</option>
						<option value="fa-area-chart">&#xf1fe; area-chart</option>
						<option value="fa-arrow-circle-down">&#xf0ab; arrow-circle-down</option>
						<option value="fa-arrow-circle-left">&#xf0a8; arrow-circle-left</option>
						<option value="fa-arrow-circle-o-down">&#xf01a; arrow-circle-o-down</option>
						<option value="fa-arrow-circle-o-left">&#xf190; arrow-circle-o-left</option>
						<option value="fa-arrow-circle-o-right">&#xf18e; arrow-circle-o-right</option>
						<option value="fa-arrow-circle-o-up">&#xf01b; arrow-circle-o-up</option>
						<option value="fa-arrow-circle-right">&#xf0a9; arrow-circle-right</option>
						<option value="fa-arrow-circle-up">&#xf0aa; arrow-circle-up</option>
						<option value="fa-arrow-down">&#xf063; arrow-down</option>
						<option value="fa-arrow-left">&#xf060; arrow-left</option>
						<option value="fa-arrow-right">&#xf061; arrow-right</option>
						<option value="fa-arrow-up">&#xf062; arrow-up</option>
						<option value="fa-arrows">&#xf047; arrows</option>
						<option value="fa-arrows-alt">&#xf0b2; arrows-alt</option>
						<option value="fa-arrows-h">&#xf07e; arrows-h</option>
						<option value="fa-arrows-v">&#xf07d; arrows-v</option>
						<option value="fa-asterisk">&#xf069; asterisk</option>
						<option value="fa-at">&#xf1fa; at</option>
						<option value="fa-automobile (alias)">&#xf1b9; automobile (alias)</option>
						<option value="fa-backward">&#xf04a; backward</option>
						<option value="fa-ban">&#xf05e; ban</option>
						<option value="fa-bank (alias)">&#xf19c; bank (alias)</option>
						<option value="fa-bar-chart">&#xf080; bar-chart</option>
						<option value="fa-bar-chart-o (alias)">&#xf080; bar-chart-o (alias)</option>
						<option value="fa-barcode">&#xf02a; barcode</option>
						<option value="fa-bars">&#xf0c9; bars</option>
						<option value="fa-bed">&#xf236; bed</option>
						<option value="fa-beer">&#xf0fc; beer</option>
						<option value="fa-behance">&#xf1b4; behance</option>
						<option value="fa-behance-square">&#xf1b5; behance-square</option>
						<option value="fa-bell">&#xf0f3; bell</option>
						<option value="fa-bell-o">&#xf0a2; bell-o</option>
						<option value="fa-bell-slash">&#xf1f6; bell-slash</option>
						<option value="fa-bell-slash-o">&#xf1f7; bell-slash-o</option>
						<option value="fa-bicycle">&#xf206; bicycle</option>
						<option value="fa-binoculars">&#xf1e5; binoculars</option>
						<option value="fa-birthday-cake">&#xf1fd; birthday-cake</option>
						<option value="fa-bitbucket">&#xf171; bitbucket</option>
						<option value="fa-bitbucket-square">&#xf172; bitbucket-square</option>
						<option value="fa-bitcoin (alias)">&#xf15a; bitcoin (alias)</option>
						<option value="fa-bold">&#xf032; bold</option>
						<option value="fa-bolt">&#xf0e7; bolt</option>
						<option value="fa-bomb">&#xf1e2; bomb</option>
						<option value="fa-book">&#xf02d; book</option>
						<option value="fa-bookmark">&#xf02e; bookmark</option>
						<option value="fa-bookmark-o">&#xf097; bookmark-o</option>
						<option value="fa-briefcase">&#xf0b1; briefcase</option>
						<option value="fa-btc">&#xf15a; btc</option>
						<option value="fa-bug">&#xf188; bug</option>
						<option value="fa-building">&#xf1ad; building</option>
						<option value="fa-building-o">&#xf0f7; building-o</option>
						<option value="fa-bullhorn">&#xf0a1; bullhorn</option>
						<option value="fa-bullseye">&#xf140; bullseye</option>
						<option value="fa-bus">&#xf207; bus</option>
						<option value="fa-buysellads">&#xf20d; buysellads</option>
						<option value="fa-cab (alias)">&#xf1ba; cab (alias)</option>
						<option value="fa-calculator">&#xf1ec; calculator</option>
						<option value="fa-calendar">&#xf073; calendar</option>
						<option value="fa-calendar-o">&#xf133; calendar-o</option>
						<option value="fa-camera">&#xf030; camera</option>
						<option value="fa-camera-retro">&#xf083; camera-retro</option>
						<option value="fa-car">&#xf1b9; car</option>
						<option value="fa-caret-down">&#xf0d7; caret-down</option>
						<option value="fa-caret-left">&#xf0d9; caret-left</option>
						<option value="fa-caret-right">&#xf0da; caret-right</option>
						<option value="fa-caret-square-o-down">&#xf150; caret-square-o-down</option>
						<option value="fa-caret-square-o-left">&#xf191; caret-square-o-left</option>
						<option value="fa-caret-square-o-right">&#xf152; caret-square-o-right</option>
						<option value="fa-caret-square-o-up">&#xf151; caret-square-o-up</option>
						<option value="fa-caret-up">&#xf0d8; caret-up</option>
						<option value="fa-cart-arrow-down">&#xf218; cart-arrow-down</option>
						<option value="fa-cart-plus">&#xf217; cart-plus</option>
						<option value="fa-cc">&#xf20a; cc</option>
						<option value="fa-cc-amex">&#xf1f3; cc-amex</option>
						<option value="fa-cc-discover">&#xf1f2; cc-discover</option>
						<option value="fa-cc-mastercard">&#xf1f1; cc-mastercard</option>
						<option value="fa-cc-paypal">&#xf1f4; cc-paypal</option>
						<option value="fa-cc-stripe">&#xf1f5; cc-stripe</option>
						<option value="fa-cc-visa">&#xf1f0; cc-visa</option>
						<option value="fa-certificate">&#xf0a3; certificate</option>
						<option value="fa-chain (alias)">&#xf0c1; chain (alias)</option>
						<option value="fa-chain-broken">&#xf127; chain-broken</option>
						<option value="fa-check">&#xf00c; check</option>
						<option value="fa-check-circle">&#xf058; check-circle</option>
						<option value="fa-check-circle-o">&#xf05d; check-circle-o</option>
						<option value="fa-check-square">&#xf14a; check-square</option>
						<option value="fa-check-square-o">&#xf046; check-square-o</option>
						<option value="fa-chevron-circle-down">&#xf13a; chevron-circle-down</option>
						<option value="fa-chevron-circle-left">&#xf137; chevron-circle-left</option>
						<option value="fa-chevron-circle-right">&#xf138; chevron-circle-right</option>
						<option value="fa-chevron-circle-up">&#xf139; chevron-circle-up</option>
						<option value="fa-chevron-down">&#xf078; chevron-down</option>
						<option value="fa-chevron-left">&#xf053; chevron-left</option>
						<option value="fa-chevron-right">&#xf054; chevron-right</option>
						<option value="fa-chevron-up">&#xf077; chevron-up</option>
						<option value="fa-child">&#xf1ae; child</option>
						<option value="fa-circle">&#xf111; circle</option>
						<option value="fa-circle-o">&#xf10c; circle-o</option>
						<option value="fa-circle-o-notch">&#xf1ce; circle-o-notch</option>
						<option value="fa-circle-thin">&#xf1db; circle-thin</option>
						<option value="fa-clipboard">&#xf0ea; clipboard</option>
						<option value="fa-clock-o">&#xf017; clock-o</option>
						<option value="fa-close (alias)">&#xf00d; close (alias)</option>
						<option value="fa-cloud">&#xf0c2; cloud</option>
						<option value="fa-cloud-download">&#xf0ed; cloud-download</option>
						<option value="fa-cloud-upload">&#xf0ee; cloud-upload</option>
						<option value="fa-cny (alias)">&#xf157; cny (alias)</option>
						<option value="fa-code">&#xf121; code</option>
						<option value="fa-code-fork">&#xf126; code-fork</option>
						<option value="fa-codepen">&#xf1cb; codepen</option>
						<option value="fa-coffee">&#xf0f4; coffee</option>
						<option value="fa-cog">&#xf013; cog</option>
						<option value="fa-cogs">&#xf085; cogs</option>
						<option value="fa-columns">&#xf0db; columns</option>
						<option value="fa-comment">&#xf075; comment</option>
						<option value="fa-comment-o">&#xf0e5; comment-o</option>
						<option value="fa-comments">&#xf086; comments</option>
						<option value="fa-comments-o">&#xf0e6; comments-o</option>
						<option value="fa-compass">&#xf14e; compass</option>
						<option value="fa-compress">&#xf066; compress</option>
						<option value="fa-connectdevelop">&#xf20e; connectdevelop</option>
						<option value="fa-copy (alias)">&#xf0c5; copy (alias)</option>
						<option value="fa-copyright">&#xf1f9; copyright</option>
						<option value="fa-credit-card">&#xf09d; credit-card</option>
						<option value="fa-crop">&#xf125; crop</option>
						<option value="fa-crosshairs">&#xf05b; crosshairs</option>
						<option value="fa-css3">&#xf13c; css3</option>
						<option value="fa-cube">&#xf1b2; cube</option>
						<option value="fa-cubes">&#xf1b3; cubes</option>
						<option value="fa-cut (alias)">&#xf0c4; cut (alias)</option>
						<option value="fa-cutlery">&#xf0f5; cutlery</option>
						<option value="fa-dashboard (alias)">&#xf0e4; dashboard (alias)</option>
						<option value="fa-dashcube">&#xf210; dashcube</option>
						<option value="fa-database">&#xf1c0; database</option>
						<option value="fa-dedent (alias)">&#xf03b; dedent (alias)</option>
						<option value="fa-delicious">&#xf1a5; delicious</option>
						<option value="fa-desktop">&#xf108; desktop</option>
						<option value="fa-deviantart">&#xf1bd; deviantart</option>
						<option value="fa-diamond">&#xf219; diamond</option>
						<option value="fa-digg">&#xf1a6; digg</option>
						<option value="fa-dollar (alias)">&#xf155; dollar (alias)</option>
						<option value="fa-dot-circle-o">&#xf192; dot-circle-o</option>
						<option value="fa-download">&#xf019; download</option>
						<option value="fa-dribbble">&#xf17d; dribbble</option>
						<option value="fa-dropbox">&#xf16b; dropbox</option>
						<option value="fa-drupal">&#xf1a9; drupal</option>
						<option value="fa-edit (alias)">&#xf044; edit (alias)</option>
						<option value="fa-eject">&#xf052; eject</option>
						<option value="fa-ellipsis-h">&#xf141; ellipsis-h</option>
						<option value="fa-ellipsis-v">&#xf142; ellipsis-v</option>
						<option value="fa-empire">&#xf1d1; empire</option>
						<option value="fa-envelope">&#xf0e0; envelope</option>
						<option value="fa-envelope-o">&#xf003; envelope-o</option>
						<option value="fa-envelope-square">&#xf199; envelope-square</option>
						<option value="fa-eraser">&#xf12d; eraser</option>
						<option value="fa-eur">&#xf153; eur</option>
						<option value="fa-euro (alias)">&#xf153; euro (alias)</option>
						<option value="fa-exchange">&#xf0ec; exchange</option>
						<option value="fa-exclamation">&#xf12a; exclamation</option>
						<option value="fa-exclamation-circle">&#xf06a; exclamation-circle</option>
						<option value="fa-exclamation-triangle">&#xf071; exclamation-triangle</option>
						<option value="fa-expand">&#xf065; expand</option>
						<option value="fa-external-link">&#xf08e; external-link</option>
						<option value="fa-external-link-square">&#xf14c; external-link-square</option>
						<option value="fa-eye">&#xf06e; eye</option>
						<option value="fa-eye-slash">&#xf070; eye-slash</option>
						<option value="fa-eyedropper">&#xf1fb; eyedropper</option>
						<option value="fa-facebook">&#xf09a; facebook</option>
						<option value="fa-facebook-f (alias)">&#xf09a; facebook-f (alias)</option>
						<option value="fa-facebook-official">&#xf230; facebook-official</option>
						<option value="fa-facebook-square">&#xf082; facebook-square</option>
						<option value="fa-fast-backward">&#xf049; fast-backward</option>
						<option value="fa-fast-forward">&#xf050; fast-forward</option>
						<option value="fa-fax">&#xf1ac; fax</option>
						<option value="fa-female">&#xf182; female</option>
						<option value="fa-fighter-jet">&#xf0fb; fighter-jet</option>
						<option value="fa-file">&#xf15b; file</option>
						<option value="fa-file-archive-o">&#xf1c6; file-archive-o</option>
						<option value="fa-file-audio-o">&#xf1c7; file-audio-o</option>
						<option value="fa-file-code-o">&#xf1c9; file-code-o</option>
						<option value="fa-file-excel-o">&#xf1c3; file-excel-o</option>
						<option value="fa-file-image-o">&#xf1c5; file-image-o</option>
						<option value="fa-file-movie-o (alias)">&#xf1c8; file-movie-o (alias)</option>
						<option value="fa-file-o">&#xf016; file-o</option>
						<option value="fa-file-pdf-o">&#xf1c1; file-pdf-o</option>
						<option value="fa-file-photo-o (alias)">&#xf1c5; file-photo-o (alias)</option>
						<option value="fa-file-picture-o (alias)">&#xf1c5; file-picture-o (alias)</option>
						<option value="fa-file-powerpoint-o">&#xf1c4; file-powerpoint-o</option>
						<option value="fa-file-sound-o (alias)">&#xf1c7; file-sound-o (alias)</option>
						<option value="fa-file-text">&#xf15c; file-text</option>
						<option value="fa-file-text-o">&#xf0f6; file-text-o</option>
						<option value="fa-file-video-o">&#xf1c8; file-video-o</option>
						<option value="fa-file-word-o">&#xf1c2; file-word-o</option>
						<option value="fa-file-zip-o (alias)">&#xf1c6; file-zip-o (alias)</option>
						<option value="fa-files-o">&#xf0c5; files-o</option>
						<option value="fa-film">&#xf008; film</option>
						<option value="fa-filter">&#xf0b0; filter</option>
						<option value="fa-fire">&#xf06d; fire</option>
						<option value="fa-fire-extinguisher">&#xf134; fire-extinguisher</option>
						<option value="fa-flag">&#xf024; flag</option>
						<option value="fa-flag-checkered">&#xf11e; flag-checkered</option>
						<option value="fa-flag-o">&#xf11d; flag-o</option>
						<option value="fa-flash (alias)">&#xf0e7; flash (alias)</option>
						<option value="fa-flask">&#xf0c3; flask</option>
						<option value="fa-flickr">&#xf16e; flickr</option>
						<option value="fa-floppy-o">&#xf0c7; floppy-o</option>
						<option value="fa-folder">&#xf07b; folder</option>
						<option value="fa-folder-o">&#xf114; folder-o</option>
						<option value="fa-folder-open">&#xf07c; folder-open</option>
						<option value="fa-folder-open-o">&#xf115; folder-open-o</option>
						<option value="fa-font">&#xf031; font</option>
						<option value="fa-forumbee">&#xf211; forumbee</option>
						<option value="fa-forward">&#xf04e; forward</option>
						<option value="fa-foursquare">&#xf180; foursquare</option>
						<option value="fa-frown-o">&#xf119; frown-o</option>
						<option value="fa-futbol-o">&#xf1e3; futbol-o</option>
						<option value="fa-gamepad">&#xf11b; gamepad</option>
						<option value="fa-gavel">&#xf0e3; gavel</option>
						<option value="fa-gbp">&#xf154; gbp</option>
						<option value="fa-ge (alias)">&#xf1d1; ge (alias)</option>
						<option value="fa-gear (alias)">&#xf013; gear (alias)</option>
						<option value="fa-gears (alias)">&#xf085; gears (alias)</option>
						<option value="fa-genderless (alias)">&#xf1db; genderless (alias)</option>
						<option value="fa-gift">&#xf06b; gift</option>
						<option value="fa-git">&#xf1d3; git</option>
						<option value="fa-git-square">&#xf1d2; git-square</option>
						<option value="fa-github">&#xf09b; github</option>
						<option value="fa-github-alt">&#xf113; github-alt</option>
						<option value="fa-github-square">&#xf092; github-square</option>
						<option value="fa-gittip (alias)">&#xf184; gittip (alias)</option>
						<option value="fa-glass">&#xf000; glass</option>
						<option value="fa-globe">&#xf0ac; globe</option>
						<option value="fa-google">&#xf1a0; google</option>
						<option value="fa-google-plus">&#xf0d5; google-plus</option>
						<option value="fa-google-plus-square">&#xf0d4; google-plus-square</option>
						<option value="fa-google-wallet">&#xf1ee; google-wallet</option>
						<option value="fa-graduation-cap">&#xf19d; graduation-cap</option>
						<option value="fa-gratipay">&#xf184; gratipay</option>
						<option value="fa-group (alias)">&#xf0c0; group (alias)</option>
						<option value="fa-h-square">&#xf0fd; h-square</option>
						<option value="fa-hacker-news">&#xf1d4; hacker-news</option>
						<option value="fa-hand-o-down">&#xf0a7; hand-o-down</option>
						<option value="fa-hand-o-left">&#xf0a5; hand-o-left</option>
						<option value="fa-hand-o-right">&#xf0a4; hand-o-right</option>
						<option value="fa-hand-o-up">&#xf0a6; hand-o-up</option>
						<option value="fa-hdd-o">&#xf0a0; hdd-o</option>
						<option value="fa-header">&#xf1dc; header</option>
						<option value="fa-headphones">&#xf025; headphones</option>
						<option value="fa-heart">&#xf004; heart</option>
						<option value="fa-heart-o">&#xf08a; heart-o</option>
						<option value="fa-heartbeat">&#xf21e; heartbeat</option>
						<option value="fa-history">&#xf1da; history</option>
						<option value="fa-home">&#xf015; home</option>
						<option value="fa-hospital-o">&#xf0f8; hospital-o</option>
						<option value="fa-hotel (alias)">&#xf236; hotel (alias)</option>
						<option value="fa-html5">&#xf13b; html5</option>
						<option value="fa-ils">&#xf20b; ils</option>
						<option value="fa-image (alias)">&#xf03e; image (alias)</option>
						<option value="fa-inbox">&#xf01c; inbox</option>
						<option value="fa-indent">&#xf03c; indent</option>
						<option value="fa-info">&#xf129; info</option>
						<option value="fa-info-circle">&#xf05a; info-circle</option>
						<option value="fa-inr">&#xf156; inr</option>
						<option value="fa-instagram">&#xf16d; instagram</option>
						<option value="fa-institution (alias)">&#xf19c; institution (alias)</option>
						<option value="fa-ioxhost">&#xf208; ioxhost</option>
						<option value="fa-italic">&#xf033; italic</option>
						<option value="fa-joomla">&#xf1aa; joomla</option>
						<option value="fa-jpy">&#xf157; jpy</option>
						<option value="fa-jsfiddle">&#xf1cc; jsfiddle</option>
						<option value="fa-key">&#xf084; key</option>
						<option value="fa-keyboard-o">&#xf11c; keyboard-o</option>
						<option value="fa-krw">&#xf159; krw</option>
						<option value="fa-language">&#xf1ab; language</option>
						<option value="fa-laptop">&#xf109; laptop</option>
						<option value="fa-lastfm">&#xf202; lastfm</option>
						<option value="fa-lastfm-square">&#xf203; lastfm-square</option>
						<option value="fa-leaf">&#xf06c; leaf</option>
						<option value="fa-leanpub">&#xf212; leanpub</option>
						<option value="fa-legal (alias)">&#xf0e3; legal (alias)</option>
						<option value="fa-lemon-o">&#xf094; lemon-o</option>
						<option value="fa-level-down">&#xf149; level-down</option>
						<option value="fa-level-up">&#xf148; level-up</option>
						<option value="fa-life-bouy (alias)">&#xf1cd; life-bouy (alias)</option>
						<option value="fa-life-buoy (alias)">&#xf1cd; life-buoy (alias)</option>
						<option value="fa-life-ring">&#xf1cd; life-ring</option>
						<option value="fa-life-saver (alias)">&#xf1cd; life-saver (alias)</option>
						<option value="fa-lightbulb-o">&#xf0eb; lightbulb-o</option>
						<option value="fa-line-chart">&#xf201; line-chart</option>
						<option value="fa-link">&#xf0c1; link</option>
						<option value="fa-linkedin">&#xf0e1; linkedin</option>
						<option value="fa-linkedin-square">&#xf08c; linkedin-square</option>
						<option value="fa-linux">&#xf17c; linux</option>
						<option value="fa-list">&#xf03a; list</option>
						<option value="fa-list-alt">&#xf022; list-alt</option>
						<option value="fa-list-ol">&#xf0cb; list-ol</option>
						<option value="fa-list-ul">&#xf0ca; list-ul</option>
						<option value="fa-location-arrow">&#xf124; location-arrow</option>
						<option value="fa-lock">&#xf023; lock</option>
						<option value="fa-long-arrow-down">&#xf175; long-arrow-down</option>
						<option value="fa-long-arrow-left">&#xf177; long-arrow-left</option>
						<option value="fa-long-arrow-right">&#xf178; long-arrow-right</option>
						<option value="fa-long-arrow-up">&#xf176; long-arrow-up</option>
						<option value="fa-magic">&#xf0d0; magic</option>
						<option value="fa-magnet">&#xf076; magnet</option>
						<option value="fa-mail-forward (alias)">&#xf064; mail-forward (alias)</option>
						<option value="fa-mail-reply (alias)">&#xf112; mail-reply (alias)</option>
						<option value="fa-mail-reply-all (alias)">&#xf122; mail-reply-all (alias)</option>
						<option value="fa-male">&#xf183; male</option>
						<option value="fa-map-marker">&#xf041; map-marker</option>
						<option value="fa-mars">&#xf222; mars</option>
						<option value="fa-mars-double">&#xf227; mars-double</option>
						<option value="fa-mars-stroke">&#xf229; mars-stroke</option>
						<option value="fa-mars-stroke-h">&#xf22b; mars-stroke-h</option>
						<option value="fa-mars-stroke-v">&#xf22a; mars-stroke-v</option>
						<option value="fa-maxcdn">&#xf136; maxcdn</option>
						<option value="fa-meanpath">&#xf20c; meanpath</option>
						<option value="fa-medium">&#xf23a; medium</option>
						<option value="fa-medkit">&#xf0fa; medkit</option>
						<option value="fa-meh-o">&#xf11a; meh-o</option>
						<option value="fa-mercury">&#xf223; mercury</option>
						<option value="fa-microphone">&#xf130; microphone</option>
						<option value="fa-microphone-slash">&#xf131; microphone-slash</option>
						<option value="fa-minus">&#xf068; minus</option>
						<option value="fa-minus-circle">&#xf056; minus-circle</option>
						<option value="fa-minus-square">&#xf146; minus-square</option>
						<option value="fa-minus-square-o">&#xf147; minus-square-o</option>
						<option value="fa-mobile">&#xf10b; mobile</option>
						<option value="fa-mobile-phone (alias)">&#xf10b; mobile-phone (alias)</option>
						<option value="fa-money">&#xf0d6; money</option>
						<option value="fa-moon-o">&#xf186; moon-o</option>
						<option value="fa-mortar-board (alias)">&#xf19d; mortar-board (alias)</option>
						<option value="fa-motorcycle">&#xf21c; motorcycle</option>
						<option value="fa-music">&#xf001; music</option>
						<option value="fa-navicon (alias)">&#xf0c9; navicon (alias)</option>
						<option value="fa-neuter">&#xf22c; neuter</option>
						<option value="fa-newspaper-o">&#xf1ea; newspaper-o</option>
						<option value="fa-openid">&#xf19b; openid</option>
						<option value="fa-outdent">&#xf03b; outdent</option>
						<option value="fa-pagelines">&#xf18c; pagelines</option>
						<option value="fa-paint-brush">&#xf1fc; paint-brush</option>
						<option value="fa-paper-plane">&#xf1d8; paper-plane</option>
						<option value="fa-paper-plane-o">&#xf1d9; paper-plane-o</option>
						<option value="fa-paperclip">&#xf0c6; paperclip</option>
						<option value="fa-paragraph">&#xf1dd; paragraph</option>
						<option value="fa-paste (alias)">&#xf0ea; paste (alias)</option>
						<option value="fa-pause">&#xf04c; pause</option>
						<option value="fa-paw">&#xf1b0; paw</option>
						<option value="fa-paypal">&#xf1ed; paypal</option>
						<option value="fa-pencil">&#xf040; pencil</option>
						<option value="fa-pencil-square">&#xf14b; pencil-square</option>
						<option value="fa-pencil-square-o">&#xf044; pencil-square-o</option>
						<option value="fa-phone">&#xf095; phone</option>
						<option value="fa-phone-square">&#xf098; phone-square</option>
						<option value="fa-photo (alias)">&#xf03e; photo (alias)</option>
						<option value="fa-picture-o">&#xf03e; picture-o</option>
						<option value="fa-pie-chart">&#xf200; pie-chart</option>
						<option value="fa-pied-piper">&#xf1a7; pied-piper</option>
						<option value="fa-pied-piper-alt">&#xf1a8; pied-piper-alt</option>
						<option value="fa-pinterest">&#xf0d2; pinterest</option>
						<option value="fa-pinterest-p">&#xf231; pinterest-p</option>
						<option value="fa-pinterest-square">&#xf0d3; pinterest-square</option>
						<option value="fa-plane">&#xf072; plane</option>
						<option value="fa-play">&#xf04b; play</option>
						<option value="fa-play-circle">&#xf144; play-circle</option>
						<option value="fa-play-circle-o">&#xf01d; play-circle-o</option>
						<option value="fa-plug">&#xf1e6; plug</option>
						<option value="fa-plus">&#xf067; plus</option>
						<option value="fa-plus-circle">&#xf055; plus-circle</option>
						<option value="fa-plus-square">&#xf0fe; plus-square</option>
						<option value="fa-plus-square-o">&#xf196; plus-square-o</option>
						<option value="fa-power-off">&#xf011; power-off</option>
						<option value="fa-print">&#xf02f; print</option>
						<option value="fa-puzzle-piece">&#xf12e; puzzle-piece</option>
						<option value="fa-qq">&#xf1d6; qq</option>
						<option value="fa-qrcode">&#xf029; qrcode</option>
						<option value="fa-question">&#xf128; question</option>
						<option value="fa-question-circle">&#xf059; question-circle</option>
						<option value="fa-quote-left">&#xf10d; quote-left</option>
						<option value="fa-quote-right">&#xf10e; quote-right</option>
						<option value="fa-ra (alias)">&#xf1d0; ra (alias)</option>
						<option value="fa-random">&#xf074; random</option>
						<option value="fa-rebel">&#xf1d0; rebel</option>
						<option value="fa-recycle">&#xf1b8; recycle</option>
						<option value="fa-reddit">&#xf1a1; reddit</option>
						<option value="fa-reddit-square">&#xf1a2; reddit-square</option>
						<option value="fa-refresh">&#xf021; refresh</option>
						<option value="fa-remove (alias)">&#xf00d; remove (alias)</option>
						<option value="fa-renren">&#xf18b; renren</option>
						<option value="fa-reorder (alias)">&#xf0c9; reorder (alias)</option>
						<option value="fa-repeat">&#xf01e; repeat</option>
						<option value="fa-reply">&#xf112; reply</option>
						<option value="fa-reply-all">&#xf122; reply-all</option>
						<option value="fa-retweet">&#xf079; retweet</option>
						<option value="fa-rmb (alias)">&#xf157; rmb (alias)</option>
						<option value="fa-road">&#xf018; road</option>
						<option value="fa-rocket">&#xf135; rocket</option>
						<option value="fa-rotate-left (alias)">&#xf0e2; rotate-left (alias)</option>
						<option value="fa-rotate-right (alias)">&#xf01e; rotate-right (alias)</option>
						<option value="fa-rouble (alias)">&#xf158; rouble (alias)</option>
						<option value="fa-rss">&#xf09e; rss</option>
						<option value="fa-rss-square">&#xf143; rss-square</option>
						<option value="fa-rub">&#xf158; rub</option>
						<option value="fa-ruble (alias)">&#xf158; ruble (alias)</option>
						<option value="fa-rupee (alias)">&#xf156; rupee (alias)</option>
						<option value="fa-save (alias)">&#xf0c7; save (alias)</option>
						<option value="fa-scissors">&#xf0c4; scissors</option>
						<option value="fa-search">&#xf002; search</option>
						<option value="fa-search-minus">&#xf010; search-minus</option>
						<option value="fa-search-plus">&#xf00e; search-plus</option>
						<option value="fa-sellsy">&#xf213; sellsy</option>
						<option value="fa-send (alias)">&#xf1d8; send (alias)</option>
						<option value="fa-send-o (alias)">&#xf1d9; send-o (alias)</option>
						<option value="fa-server">&#xf233; server</option>
						<option value="fa-share">&#xf064; share</option>
						<option value="fa-share-alt">&#xf1e0; share-alt</option>
						<option value="fa-share-alt-square">&#xf1e1; share-alt-square</option>
						<option value="fa-share-square">&#xf14d; share-square</option>
						<option value="fa-share-square-o">&#xf045; share-square-o</option>
						<option value="fa-shekel (alias)">&#xf20b; shekel (alias)</option>
						<option value="fa-sheqel (alias)">&#xf20b; sheqel (alias)</option>
						<option value="fa-shield">&#xf132; shield</option>
						<option value="fa-ship">&#xf21a; ship</option>
						<option value="fa-shirtsinbulk">&#xf214; shirtsinbulk</option>
						<option value="fa-shopping-cart">&#xf07a; shopping-cart</option>
						<option value="fa-sign-in">&#xf090; sign-in</option>
						<option value="fa-sign-out">&#xf08b; sign-out</option>
						<option value="fa-signal">&#xf012; signal</option>
						<option value="fa-simplybuilt">&#xf215; simplybuilt</option>
						<option value="fa-sitemap">&#xf0e8; sitemap</option>
						<option value="fa-skyatlas">&#xf216; skyatlas</option>
						<option value="fa-skype">&#xf17e; skype</option>
						<option value="fa-slack">&#xf198; slack</option>
						<option value="fa-sliders">&#xf1de; sliders</option>
						<option value="fa-slideshare">&#xf1e7; slideshare</option>
						<option value="fa-smile-o">&#xf118; smile-o</option>
						<option value="fa-soccer-ball-o (alias)">&#xf1e3; soccer-ball-o (alias)</option>
						<option value="fa-sort">&#xf0dc; sort</option>
						<option value="fa-sort-alpha-asc">&#xf15d; sort-alpha-asc</option>
						<option value="fa-sort-alpha-desc">&#xf15e; sort-alpha-desc</option>
						<option value="fa-sort-amount-asc">&#xf160; sort-amount-asc</option>
						<option value="fa-sort-amount-desc">&#xf161; sort-amount-desc</option>
						<option value="fa-sort-asc">&#xf0de; sort-asc</option>
						<option value="fa-sort-desc">&#xf0dd; sort-desc</option>
						<option value="fa-sort-down (alias)">&#xf0dd; sort-down (alias)</option>
						<option value="fa-sort-numeric-asc">&#xf162; sort-numeric-asc</option>
						<option value="fa-sort-numeric-desc">&#xf163; sort-numeric-desc</option>
						<option value="fa-sort-up (alias)">&#xf0de; sort-up (alias)</option>
						<option value="fa-soundcloud">&#xf1be; soundcloud</option>
						<option value="fa-space-shuttle">&#xf197; space-shuttle</option>
						<option value="fa-spinner">&#xf110; spinner</option>
						<option value="fa-spoon">&#xf1b1; spoon</option>
						<option value="fa-spotify">&#xf1bc; spotify</option>
						<option value="fa-square">&#xf0c8; square</option>
						<option value="fa-square-o">&#xf096; square-o</option>
						<option value="fa-stack-exchange">&#xf18d; stack-exchange</option>
						<option value="fa-stack-overflow">&#xf16c; stack-overflow</option>
						<option value="fa-star">&#xf005; star</option>
						<option value="fa-star-half">&#xf089; star-half</option>
						<option value="fa-star-half-empty (alias)">&#xf123; star-half-empty (alias)</option>
						<option value="fa-star-half-full (alias)">&#xf123; star-half-full (alias)</option>
						<option value="fa-star-half-o">&#xf123; star-half-o</option>
						<option value="fa-star-o">&#xf006; star-o</option>
						<option value="fa-steam">&#xf1b6; steam</option>
						<option value="fa-steam-square">&#xf1b7; steam-square</option>
						<option value="fa-step-backward">&#xf048; step-backward</option>
						<option value="fa-step-forward">&#xf051; step-forward</option>
						<option value="fa-stethoscope">&#xf0f1; stethoscope</option>
						<option value="fa-stop">&#xf04d; stop</option>
						<option value="fa-street-view">&#xf21d; street-view</option>
						<option value="fa-strikethrough">&#xf0cc; strikethrough</option>
						<option value="fa-stumbleupon">&#xf1a4; stumbleupon</option>
						<option value="fa-stumbleupon-circle">&#xf1a3; stumbleupon-circle</option>
						<option value="fa-subscript">&#xf12c; subscript</option>
						<option value="fa-subway">&#xf239; subway</option>
						<option value="fa-suitcase">&#xf0f2; suitcase</option>
						<option value="fa-sun-o">&#xf185; sun-o</option>
						<option value="fa-superscript">&#xf12b; superscript</option>
						<option value="fa-support (alias)">&#xf1cd; support (alias)</option>
						<option value="fa-table">&#xf0ce; table</option>
						<option value="fa-tablet">&#xf10a; tablet</option>
						<option value="fa-tachometer">&#xf0e4; tachometer</option>
						<option value="fa-tag">&#xf02b; tag</option>
						<option value="fa-tags">&#xf02c; tags</option>
						<option value="fa-tasks">&#xf0ae; tasks</option>
						<option value="fa-taxi">&#xf1ba; taxi</option>
						<option value="fa-tencent-weibo">&#xf1d5; tencent-weibo</option>
						<option value="fa-terminal">&#xf120; terminal</option>
						<option value="fa-text-height">&#xf034; text-height</option>
						<option value="fa-text-width">&#xf035; text-width</option>
						<option value="fa-th">&#xf00a; th</option>
						<option value="fa-th-large">&#xf009; th-large</option>
						<option value="fa-th-list">&#xf00b; th-list</option>
						<option value="fa-thumb-tack">&#xf08d; thumb-tack</option>
						<option value="fa-thumbs-down">&#xf165; thumbs-down</option>
						<option value="fa-thumbs-o-down">&#xf088; thumbs-o-down</option>
						<option value="fa-thumbs-o-up">&#xf087; thumbs-o-up</option>
						<option value="fa-thumbs-up">&#xf164; thumbs-up</option>
						<option value="fa-ticket">&#xf145; ticket</option>
						<option value="fa-times">&#xf00d; times</option>
						<option value="fa-times-circle">&#xf057; times-circle</option>
						<option value="fa-times-circle-o">&#xf05c; times-circle-o</option>
						<option value="fa-tint">&#xf043; tint</option>
						<option value="fa-toggle-down (alias)">&#xf150; toggle-down (alias)</option>
						<option value="fa-toggle-left (alias)">&#xf191; toggle-left (alias)</option>
						<option value="fa-toggle-off">&#xf204; toggle-off</option>
						<option value="fa-toggle-on">&#xf205; toggle-on</option>
						<option value="fa-toggle-right (alias)">&#xf152; toggle-right (alias)</option>
						<option value="fa-toggle-up (alias)">&#xf151; toggle-up (alias)</option>
						<option value="fa-train">&#xf238; train</option>
						<option value="fa-transgender">&#xf224; transgender</option>
						<option value="fa-transgender-alt">&#xf225; transgender-alt</option>
						<option value="fa-trash">&#xf1f8; trash</option>
						<option value="fa-trash-o">&#xf014; trash-o</option>
						<option value="fa-tree">&#xf1bb; tree</option>
						<option value="fa-trello">&#xf181; trello</option>
						<option value="fa-trophy">&#xf091; trophy</option>
						<option value="fa-truck">&#xf0d1; truck</option>
						<option value="fa-try">&#xf195; try</option>
						<option value="fa-tty">&#xf1e4; tty</option>
						<option value="fa-tumblr">&#xf173; tumblr</option>
						<option value="fa-tumblr-square">&#xf174; tumblr-square</option>
						<option value="fa-turkish-lira (alias)">&#xf195; turkish-lira (alias)</option>
						<option value="fa-twitch">&#xf1e8; twitch</option>
						<option value="fa-twitter">&#xf099; twitter</option>
						<option value="fa-twitter-square">&#xf081; twitter-square</option>
						<option value="fa-umbrella">&#xf0e9; umbrella</option>
						<option value="fa-underline">&#xf0cd; underline</option>
						<option value="fa-undo">&#xf0e2; undo</option>
						<option value="fa-university">&#xf19c; university</option>
						<option value="fa-unlink (alias)">&#xf127; unlink (alias)</option>
						<option value="fa-unlock">&#xf09c; unlock</option>
						<option value="fa-unlock-alt">&#xf13e; unlock-alt</option>
						<option value="fa-unsorted (alias)">&#xf0dc; unsorted (alias)</option>
						<option value="fa-upload">&#xf093; upload</option>
						<option value="fa-usd">&#xf155; usd</option>
						<option value="fa-user">&#xf007; user</option>
						<option value="fa-user-md">&#xf0f0; user-md</option>
						<option value="fa-user-plus">&#xf234; user-plus</option>
						<option value="fa-user-secret">&#xf21b; user-secret</option>
						<option value="fa-user-times">&#xf235; user-times</option>
						<option value="fa-users">&#xf0c0; users</option>
						<option value="fa-venus">&#xf221; venus</option>
						<option value="fa-venus-double">&#xf226; venus-double</option>
						<option value="fa-venus-mars">&#xf228; venus-mars</option>
						<option value="fa-viacoin">&#xf237; viacoin</option>
						<option value="fa-video-camera">&#xf03d; video-camera</option>
						<option value="fa-vimeo-square">&#xf194; vimeo-square</option>
						<option value="fa-vine">&#xf1ca; vine</option>
						<option value="fa-vk">&#xf189; vk</option>
						<option value="fa-volume-down">&#xf027; volume-down</option>
						<option value="fa-volume-off">&#xf026; volume-off</option>
						<option value="fa-volume-up">&#xf028; volume-up</option>
						<option value="fa-warning (alias)">&#xf071; warning (alias)</option>
						<option value="fa-wechat (alias)">&#xf1d7; wechat (alias)</option>
						<option value="fa-weibo">&#xf18a; weibo</option>
						<option value="fa-weixin">&#xf1d7; weixin</option>
						<option value="fa-whatsapp">&#xf232; whatsapp</option>
						<option value="fa-wheelchair">&#xf193; wheelchair</option>
						<option value="fa-wifi">&#xf1eb; wifi</option>
						<option value="fa-windows">&#xf17a; windows</option>
						<option value="fa-won (alias)">&#xf159; won (alias)</option>
						<option value="fa-wordpress">&#xf19a; wordpress</option>
						<option value="fa-wrench">&#xf0ad; wrench</option>
						<option value="fa-xing">&#xf168; xing</option>
						<option value="fa-xing-square">&#xf169; xing-square</option>
						<option value="fa-yahoo">&#xf19e; yahoo</option>
						<option value="fa-yelp">&#xf1e9; yelp</option>
						<option value="fa-yen (alias)">&#xf157; yen (alias)</option>
						<option value="fa-youtube">&#xf167; youtube</option>
						<option value="fa-youtube-play">&#xf16a; youtube-play</option>
					</select>
					<i class="fa <?php echo esc_attr( $item->icon ); ?>"></i>
                </label>
				</p>

	            <?php
	            /* New fields insertion ends here */
	            ?>
	            <div class="menu-item-actions description-wide submitbox">
	                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
	                    <p class="link-to-original">
	                        <?php printf( esc_html__('Original: %s', 'enside'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
	                    </p>
	                <?php endif; ?>
	                <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
	                echo wp_nonce_url(
	                    esc_url(add_query_arg(
	                        array(
	                            'action' => 'delete-menu-item',
	                            'menu-item' => $item_id,
	                        ),
	                        esc_url(remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) ))
	                    )),
	                    'delete-menu_item_' . $item_id
	                ); ?>"><?php esc_html_e('Remove', 'enside'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), esc_url(remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )) ) );
	                    ?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel', 'enside'); ?></a>
	            </div>

	            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
	            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
	            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
	            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
	            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
	            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
	        </div><!-- .menu-item-settings-->
	        <ul class="menu-item-transport"></ul>
	    <?php

	    $output .= ob_get_clean();

	    }
}
