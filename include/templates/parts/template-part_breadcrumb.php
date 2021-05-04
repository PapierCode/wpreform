<?php
/**
 * 
 * Commun templates : fil d'ariane
 * 
 */


function pc_display_breadcrumb() {

	global $settings_pc;

	// si autorisé
	if ( isset( $settings_pc['wpreform-breadcrumb'] ) ) {


		/*----------  Lien accueil et filtre  ----------*/
		
		$links = apply_filters( 'pc_filter_breadcrumb', 
			array(
				array(
					'name' => 'Accueil',
					'permalink' => get_bloginfo('url')
				)
			)
		);
		

		/*----------  Single  ----------*/
		
		if ( is_singular() ) {

			global $pc_post;

			if ( $pc_post->parent > 0 ) {

				$pc_post_parent = new PC_Post( get_post( $pc_post->parent ) );
				$links[] = array(
					'name' => $pc_post_parent->get_card_title(),
					'permalink' => $pc_post_parent->permalink
				);

			}

			$links[] = array(
				'name' => $pc_post->get_card_title(),
				'permalink' => $pc_post->permalink
			);
		}


		/*----------  Taxonomy  ----------*/
		
		if ( is_tax() ) {

			global $pc_term;

			if ( $pc_term->parent > 0 ) {
				
				$term_parent_id = $pc_term->parent;
				$links_term = array();

				while ( $term_parent_id > 0 ) {

					$pc_term_parent = new PC_Term( get_term_by( 'term_taxonomy_id', $term_parent_id ) );
					array_unshift( $links_term, array(
						'name' => $pc_term_parent->get_card_title(),
						'permalink' => $pc_term_parent->permalink
					));

					$term_parent_id = ( $pc_term_parent->parent > 0 ) ? $pc_term_parent->parent : 0;

				}

				$links = array_merge( $links, $links_term );

			}

			$links[] = array(
				'name' => $pc_term->get_card_title(),
				'permalink' => $pc_term->permalink
			); 

		}


		/*----------  Recherche  ----------*/
		
		if ( is_search() ) {

			$links[] = array(
				'name' => 'Recherche',
				'permalink' => ''
			); 

		}

		
		/*----------  Séparateur  ----------*/
		
		$separator = apply_filters( 'pc_filter_breadcrumb_ico', '<span class="breadcrumb-ico" aria-hidden="true">'.pc_svg('arrow').'</span>' );


		/*----------  Affichage  ----------*/
		
		echo '<nav class="breadcrumb no-print" aria-label="breadcrumbs"><ol class="breadcrumb-list reset-list">';

			foreach ( $links as $key => $link ) {

				if ( $key == ( count($links) - 1 ) ) {

					echo '<li class="breadcrumb-item">'.$link['name'].'</li>';

				} else {

					echo '<li class="breadcrumb-item"><a href="'.$link['permalink'].'">'.$link['name'].'</a>'.$separator.'</li>';
				
				}
			}

		echo '</ol></nav>';

	}

}