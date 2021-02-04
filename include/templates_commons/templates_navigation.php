<?php
/**
*
** Customisation menu 
** Item parent actif si page enfatn affichée
*
**/


/*==========================================
=            Customisation menu            =
==========================================*/

class Pc_Walker_Nav_Menu extends Walker_Nav_Menu {

	// création des ul level 2 et sup
	function start_lvl( &$output, $depth = 0, $args = array() ) {

		// parceque...
		$display_depth = ($depth + 2);
		// css
		$class_names = 'reset-list';
		foreach ($args->nav_prefix as $prefix) {
			$class_names .= ' '.$prefix.'-list '.$prefix.'-list--l'.$display_depth;
		}
		// 
		$output .= '<ul class="' . $class_names . '">';

	} // end start_lvl()

	// création des li tous level
	function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		// parceque...
		$display_depth = ( $depth + 1);
		// classes communes et en fonction de la profondeur
		$li_class_name = '';
		$link_class_name = '';
		$span_class_name = '';
		foreach ($args->nav_prefix as $prefix) {
			$li_class_name .= $prefix.'-item '.$prefix.'-item--l'.$display_depth.' ';
			$link_class_name .= $prefix.'-link '.$prefix.'-link--l'.$display_depth.' ';
			$span_class_name .= $prefix.'-link-inner '.$prefix.'-link-inner--l'.$display_depth.' ';
		}
		
		// supprime tous les classes sauf celles précisées dans le tableau
		$clean_classes = is_array($item->classes) ? array_intersect($item->classes, array('current-menu-item','menu-item-has-children','current-menu-parent')) : '';
		// remplace les classes restantes
		$new_classes = array(
			'current-menu-item' => 'is-active',
			'menu-item-has-children' => 'is-parent',
			'current-menu-parent' => 'is-active'
		);
		$clean_classes = str_replace(array_keys($new_classes), $new_classes, $clean_classes);
		// array to string + classes ajoutées depuis l'admin
		$li_class_name .= esc_attr( implode(' ', $clean_classes )).' '.$item->classes[0];

		// construction du li
		$output .= '<li class="'.$li_class_name.'">';

		// si c'est un item parent
		if ( in_array('is-parent', $clean_classes) ) {
			// pas de lien mais un bouton
			$output .= '<button type="button" class="'.$link_class_name.'reset-btn">';
			$output .= '<span class="'.$span_class_name.'">'.$item->title.'</span>';
			$output .= '</button>';

		// si ce n'est pas un parent
		} else {

			// construction du <a>
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : ' title="' . $item->title . '"';
			$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn ) ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			$attributes .= ' class="'.$link_class_name.'"';
			$attributes .= ( in_array('is-active', $clean_classes) ) ? ' aria-current="page"' : '';

			// création du lien
			$output .= '<a '.$attributes.'>';
			$output .= '<span class="'.$span_class_name.'">'.$item->title.'</span>';
			$output .= '</a>';

		}

		$output = apply_filters( 'pc_filter_menu_walker_item_output', $output, $item, $args );

	} // end start_el()

} // end Primary_Walker()


/*=====  End of Customisation menu  ======*/

/*=================================================================
=            Item parent actif si page enfant affichée            =
=================================================================*/

add_filter( 'wp_nav_menu_objects', 'pc_nav_page_parent_active', NULL, 2 );

	function pc_nav_page_parent_active( $menu_items, $args ) {

		// si menu d'entête
		if ( $args->theme_location == 'nav-header' ) {

			// si page.php
			if ( is_page() ) {
				
				global $post;
				// si la page a un parent
				if ( $post->post_parent > 0 ) { $id_to_search = $post->post_parent; }

			}
			
			// recherche de l'item
			if ( isset($id_to_search) ) {

				foreach ( $menu_items as $object ) {
					if ( $object->object_id == $id_to_search ) {
						// ajout classe WP (remplacée dans le Walker du menu)
						$object->classes[] = 'current-menu-item';
					}
				}

			}

		}

		return $menu_items;

	};


/*=====  FIN Item parent actif si page enfant affichée  ======*/