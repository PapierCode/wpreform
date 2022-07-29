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

			
			if ( is_page() && get_query_var( 'paged' ) && get_query_var( 'paged' ) > 1 ) {

				$links[] = array(
					'name' => 'Page '.get_query_var( 'paged' ),
					'permalink' => $pc_post->get_canonical()
				);

			}

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
						'name' => $pc_term_parent->name,
						'permalink' => $pc_term_parent->permalink
					));

					$term_parent_id = ( $pc_term_parent->parent > 0 ) ? $pc_term_parent->parent : 0;

				}

				$links = array_merge( $links, $links_term );

			}

			$links[] = array(
				'name' => $pc_term->name,
				'permalink' => $pc_term->permalink
			); 

			if ( get_query_var( 'paged' ) && get_query_var( 'paged' ) > 1 ) {

				$links[] = array(
					'name' => 'Page '.get_query_var( 'paged' ),
					'permalink' => $pc_term->permalink.'page/'.get_query_var( 'paged' ).'/'
				); 
			}


		}


		/*----------  Recherche  ----------*/
		
		if ( is_search() ) {

			$links[] = array(
				'name' => 'Recherche',
				'permalink' => home_url().'/?s='.esc_html( get_search_query() )
			); 		

			if ( get_query_var( 'paged' ) && get_query_var( 'paged' ) > 1 ) {

				$links[] = array(
					'name' => 'Page '.get_query_var( 'paged' ),
					'permalink' => home_url().'/?s='.esc_html( get_search_query() ).'&paged='.get_query_var( 'paged' )
				); 
			}

		}

		
		/*----------  Séparateur  ----------*/
		
		$separator = apply_filters( 'pc_filter_breadcrumb_ico', '<span class="breadcrumb-ico" aria-hidden="true">'.pc_svg('arrow').'</span>' );


		/*----------  Filtre  ----------*/
	
		$links = apply_filters( 'pc_filter_breadcrumb_before_display', $links );
		

		/*----------  Données structurées  ----------*/
		
		$structured_datas = array(
			'@context' => 'https://schema.org',
      		'@type' => 'BreadcrumbList',
      		'itemListElement' => array()
		);


		/*----------  Affichage  ----------*/
		
		echo '<nav class="breadcrumb no-print" role="navigation" aria-label="Fil d\'ariane"><ol class="breadcrumb-list reset-list">';

			foreach ( $links as $key => $link ) {

				$current = ( $key == ( count($links) - 1 ) ) ? ' aria-current="page"' : '';
				echo '<li class="breadcrumb-item">'.$separator.'<a href="'.$link['permalink'].'"'.$current.'>'.$link['name'].'</a></li>';

				$structured_datas['itemListElement'][] = array(
					'@type' => 'ListItem',
					'position' => $key + 1,
					'name' => $link['name'],
					'item' => $link['permalink']
				);
				
			}

			echo '<script type="application/ld+json">'.json_encode($structured_datas,JSON_UNESCAPED_SLASHES).'</script>';

		echo '</ol></nav>';

	}

}