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