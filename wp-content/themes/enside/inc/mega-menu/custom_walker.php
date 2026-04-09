<?php
/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
class enside_megamenu_walker extends Walker_Nav_Menu
{
	
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
	{
	   
		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );

		if ($depth == 0) {

			if($item->fullwidth == 'on') {
				$class_names .= " mgt-menu-fullwidth-inside";
				$class_names .= " menu-item-multicolumn";
			}

			if($item->dropdownposition == 'left') {
				$class_names .= " mgt-menu-dropdown-left";
			}

			if($item->sidebar !== '') {
				$class_names .= " menu-item-has-children";
			}

			if($item->columns > 1) {
				$class_names .= " menu-item-multicolumn";
			}

		}

		if($item->onepage == 'on') {
			$class_names .= " onepage-link-inside";
		}

		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="mgt-menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

		if($item->onepage == 'on') {
			if(is_front_page()) {
				$attributes .= ! empty( $item->url )        ? ' class="onepage-link" href="'   . esc_attr( $item->url        ) .'"' : '';
			}
			else {
				$attributes .= ! empty( $item->url )        ? ' class="onepage-link-page" href="'   . esc_attr( get_site_url().'/'.$item->url        ) .'"' : '';
			}
			
		} else {
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		}

		$prepend = '<span>';
		$append = '</span>';

		if($depth != 0)
		{
		   $description = $append = $prepend = "";
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';

		if(isset($item->icon) && ($item->icon !== "")) {
			$item_output .= '<i class="fa '.esc_attr($item->icon).'"></i>';
		}

		$item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;

		if($item->badgetitle !== '') {
			if($item->badgecolor !== '') {
				$item_output .= '<sup data-style="background-color: '.esc_attr($item->badgecolor).'">'.wp_kses_post($item->badgetitle).'</sup>';
			} else {
				$item_output .= '<sup>'.wp_kses_post($item->badgetitle).'</sup>';
			}
			
		}
		
		$item_output .= '</a>';
		$item_output .= $args->after;


		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

		apply_filters( 'walker_nav_menu_start_lvl', $item_output, $depth, $args->background_url = $item->background_url, $args->backgroundrepeat = $item->backgroundrepeat, $args->backgroundpositionx = $item->backgroundpositionx, $args->backgroundpositiony = $item->backgroundpositiony, $args->columns = $item->columns, $args->fullwidth = $item->fullwidth, $args->dropdownposition = $item->dropdownposition, $args->sidebar = $item->sidebar );
		apply_filters( 'walker_nav_menu_end_el', $item_output, $depth, $args->background_url = $item->background_url, $args->backgroundrepeat = $item->backgroundrepeat, $args->backgroundpositionx = $item->backgroundpositionx, $args->backgroundpositiony = $item->backgroundpositiony, $args->columns = $item->columns, $args->fullwidth = $item->fullwidth, $args->dropdownposition = $item->dropdownposition, $args->sidebar = $item->sidebar );
	 }

	   
	 // Before </li>
	 public function end_el( &$output, $object, $depth = 0, $args = array() ) {

	 	if(($args->sidebar !== '')&&($depth == 0)) {

		 	if ($args->background_url !== "") {
				$bg_class = "mgt-menu-bg-image";
				$bg_style = 'data-style="background-image:url('.esc_url($args->background_url).'); background-repeat: '.esc_attr($args->backgroundrepeat).'; background-position: '.esc_attr($args->backgroundpositionx).' '.esc_attr($args->backgroundpositiony).';"';
			} else {
				$bg_class = "";
				$bg_style = "";
			}
		
			$bg_class .= " megamenu-column-".$args->columns;

			if($args->fullwidth == 'on') {
				$bg_class .= " mgt-menu-fullwidth";
			}

			if($args->dropdownposition == 'left') {
				$bg_class .= " mgt-menu-dropdown-left";
			}
							
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"sub-menu sidebar-inside ".esc_attr($bg_class)." level-".intval($depth)."\" ".$bg_style.">\n";
			$output .= '<div class="sidebar">';

			ob_start();
			dynamic_sidebar( $args->sidebar );
			$sidebar_html = ob_get_clean();

			$output .= $sidebar_html;

			$output .= '</div>';

			$output .= '</ul>';
			
		}

		$output .= '</li>';

	 }
	 
	 function start_lvl(&$output, $depth = 0, $args = array()) {
	
		if ($depth == 0) {
			if ($args->background_url !== "") {
				$bg_class = "mgt-menu-bg-image";
				$bg_style = 'data-style="background-image:url('.esc_attr($args->background_url).'); background-repeat: '.esc_attr($args->backgroundrepeat).'; background-position: '.esc_attr($args->backgroundpositionx).' '.esc_attr($args->backgroundpositiony).';"';
			} else {
				$bg_class = "";
				$bg_style = "";
			}

			$bg_class .= " megamenu-column-".$args->columns;

			if($args->fullwidth == 'on') {
				$bg_class .= " mgt-menu-fullwidth";
			}

			if($args->dropdownposition == 'left') {
				$bg_class .= " mgt-menu-dropdown-left";
			}
		} else {
			$bg_class = "";
			$bg_style = "";
		}
			
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu ".esc_attr($bg_class)." level-".intval($depth)."\" ".$bg_style.">\n";
	}
	
}