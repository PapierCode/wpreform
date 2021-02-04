<?php
/**
 * 
 * Initialisation du thème
 * 
 */

add_action( 'after_setup_theme', 'pc_preform_after_setup_theme', );

	function pc_preform_after_setup_theme() {

		/*===================================================
		=            Emplacements de navigations            =
		===================================================*/
		
		$nav_locations = array( 
			'nav-header' => 'Entête',
			'nav-footer' => 'Pied de page'
		);

		register_nav_menus( $nav_locations );		
		
		
		/*=====  FIN Emplacements de navigations  =====*/		

		/*=============================================
		=            Création des contenus            =
		=============================================*/

		/*
		if ( get_option('fresh_site') ) {

			// location => id
			$nav_ids = array();


			// menus

			foreach ( $nav_locations as $location => $name ) {
			
				$nav = wp_get_nav_menu_object( $name );

				if ( !$nav ) {

					$nav_id = wp_create_nav_menu( $name );

					$nav_theme_mod_locations = get_theme_mod('nav_menu_locations');
					$nav_theme_mod_locations[$location] = $nav_id;
					set_theme_mod( 'nav_menu_locations', $nav_theme_mod_locations );
					$nav_ids[$location] = $nav_id;

				}
			}
			

			// pages

			include get_template_directory().'\include\theme-setup\theme-setup_pages.php';
			global $theme_setup_pages;

			foreach ( $theme_setup_pages as $args ) {

				$page_id = wp_insert_post( $args );

				if ( null != $args['menu_location'] ) {

					wp_update_nav_menu_item(
						$nav_ids[$args['menu_location']],
						0,
						array(
							'menu-item-title' 		=> $args['post_title'],
							'menu-item-object-id' 	=> $page_id,
							'menu-item-object' 		=> 'page',
							'menu-item-status' 		=> 'publish',
							'menu-item-type' 		=> 'post_type',
						)
					);

				}

			}
			

		} // FIN if get_option('fresh_site')
		*/		
		
		/*=====  FIN Création des contenus  =====*/


	}
