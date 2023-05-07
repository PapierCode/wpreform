<?php
/**
*
* Communs templates : navigation
*
** Menus
** Item parent actif si page enfatn affichée
*
**/


/*=============================
=            Menus            =
=============================*/

add_action( 'after_setup_theme', 'pc_preform_register_nav_menus' );

	function pc_preform_register_nav_menus() {

		$nav_locations = apply_filters( 'pc_filter_nav_locations', array( 
			'nav-header' => 'Entête',
			'nav-footer' => 'Pied de page'
		) );

		register_nav_menus( $nav_locations );	

	}


/*=====  FIN Menus  =====*/

/*=================================================================
=            Item parent actif si page enfant affichée            =
=================================================================*/

add_filter( 'wp_nav_menu_objects', 'pc_nav_page_parent_active', NULL, 2 );

	function pc_nav_page_parent_active( $items, $args ) {

		if ( $args->theme_location == 'nav-header' ) {

			if ( is_page() ) {

				global $post;

				if ( $post->post_parent ) {					

					$page_parent_ids = array();
					$parent_id = wp_get_post_parent_id( $post );

					if ( $parent_id ) {

						$pc_items = array();
						foreach ( $items as $item ) { $pc_items[$item->ID] = $item; }
						
						// toutes les pages parentes (custom post hierarchical) de la page courante
						$page_parent_ids[] = $parent_id;
						while ( $parent_id ) {
							$sup_parent_id = wp_get_post_parent_id( $parent_id );
							if ( $sup_parent_id ) { $page_parent_ids[] = $sup_parent_id; }
							$parent_id = $sup_parent_id;
						}
						
						// recherche des pages parentes dans le menu
						// et recherche des ancêtres des items associés à ces pages parentes
						$all_items_ancestor = array();
						foreach ( $pc_items as $id => $item ) {
							if ( in_array( $item->object_id, $page_parent_ids ) && !in_array( $item->menu_item_parent, $all_items_ancestor ) ) {
								$ancestor_id = $item->menu_item_parent;
								$all_items_ancestor[] = $ancestor_id;
								while ( $ancestor_id ) {
									$ancestor_id = $pc_items[$ancestor_id]->menu_item_parent;
									if ( $ancestor_id && !in_array( $ancestor_id, $all_items_ancestor ) ) {
										$all_items_ancestor[] = $ancestor_id;
									}
								}
							}
						}

						// active les ancêtres d'items si nécessaire
						foreach ( $items as $key => $item ) {
							if ( in_array( $item->ID, $all_items_ancestor ) && !in_array( 'current-menu-ancestor', $item->classes ) ) {
								$items[$key]->classes[] = 'current-menu-ancestor';
							}
						}

					}

				}

			}

		}

		return $items;

	};


/*=====  FIN Item parent actif si page enfant affichée  ======*/