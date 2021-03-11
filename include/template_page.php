<?php 
/**
 * 
 * Template page
 * 
 */


/*=============================
=            Hooks            =
=============================*/

add_action( 'pc_page_content_before', 'pc_display_main_start', 10 ); // layout commun -> templates_layout.php

add_action( 'pc_page_content_before', 'pc_display_main_title_start', 20 ); // layout commun -> templates_layout.php
add_action( 'pc_page_content_before', 'pc_display_main_title', 30, 1 ); // layout commun -> templates_layout.php
add_action( 'pc_page_content_before', 'pc_display_main_title_end', 40 ); // layout commun -> templates_layout.php

add_action( 'pc_page_content_before', 'pc_display_main_content_start', 50 ); // layout commun -> templates_layout.php

add_action( 'pc_page_content_after', 'pc_display_st_list_start', 10, 2 ); // début container st
add_action( 'pc_page_content_after', 'pc_display_specific_content', 20, 2 ); // contenu supplémentaire
add_action( 'pc_page_content_after', 'pc_display_st_list_end', 30, 2 ); // fin container st

add_action( 'pc_page_content_after', 'pc_display_main_content_end', 40 ); // layout commun -> templates_layout.php

add_action( 'pc_page_content_after', 'pc_display_main_footer_start', 50 ); // layout commun -> templates_layout.php
add_action( 'pc_page_content_after', 'pc_display_subpage_backlink', 60, 1 ); // lien retour
add_action( 'pc_page_content_after', 'pc_display_share_links', 70 ); // layout commun -> templates_layout.php
add_action( 'pc_page_content_after', 'pc_display_main_footer_end', 80 ); // layout commun -> templates_layout.php

add_action( 'pc_page_content_after', 'pc_display_schema_post', 90, 2 ); // données structurées
add_action( 'pc_page_content_after', 'pc_display_sub_pages_schema_collection_page', 100, 2 ); // données structurées

add_action( 'pc_page_content_after', 'pc_display_main_end', 110 ); // layout commun -> templates_layout.php


/*=====  FIN Hooks  =====*/

/*===============================================
=            Contenu supplémentaire             =
===============================================*/

function pc_display_st_list_start( $post, $post_metas ) {

	if ( !post_password_required() && isset( $post_metas['content-subpages'] ) ) {
		echo '<ul class="st-list reset-list">';
	}

}

function pc_display_specific_content( $post, $post_metas ) {

	if ( !post_password_required() ) {

		/*----------  Contenu spécifique  ----------*/
			
		if ( isset($post_metas['content-from']) ) {

			global $settings_project;
			include $settings_project['page-content-from'][$post_metas['content-from'][0]][1];


		/*----------  Sous-pages  ----------*/		

		} else if ( isset($post_metas['content-subpages']) ) {

			// affichage des résumés de pages
			$sub_pages_ids = explode( ',', $post_metas['content-subpages'][0] );
			
			foreach ( $sub_pages_ids as $key => $post_id ) {
				pc_display_post_resum( $post_id, 'st--subpage', 2 );
			}

		}

	} // FIN if !post_password_required()

}

function pc_display_st_list_end( $post, $post_metas ) {

	if ( !post_password_required() && isset( $post_metas['content-subpages'] ) ) {
		
		echo '</ul>';

	}

}


/*=====  FIN Contenu supplémentaire   =====*/

/*==============================================
=            Sous-page, lien retour            =
==============================================*/

function pc_display_subpage_backlink( $post ) {

    if ( $post->post_type == 'page' && $post->post_parent > 0 ) {

        echo '<a href="'.get_the_permalink($post->post_parent).'" class="previous button" title="'.get_the_title($post->post_parent).'">'.pc_svg('arrow').'<span>Retour</span></a>';

    }

}


/*=====  FIN Sous-page, lien retour  =====*/

/*===========================================
=            Données structurées            =
===========================================*/

function pc_display_schema_post( $post, $post_metas ) {

	$schema = pc_get_schema_article( $post, $post_metas, true );
	$schema = apply_filters( 'pc_filter_schema_post', $schema, $post, $post_metas );

	if ( !post_password_required() ) {
		echo '<script type="application/ld+json">'.json_encode($schema,JSON_UNESCAPED_SLASHES).'</script>';
	}

}

function pc_display_sub_pages_schema_collection_page( $post, $post_metas ) {

	if ( !post_password_required() && isset( $post_metas['content-subpages'] ) ) {

		// liste
		$sub_pages_ids = explode( ',', $post_metas['content-subpages'][0] );
		// global
		$sub_pages_schema = array(
			'@context' => 'http://schema.org/',
			'@type'=> 'CollectionPage',
			'mainEntity' => array(
				'@type' => 'ItemList',
				'itemListElement' => array()
			),
			'isPartOf' => pc_get_schema_article( $post, $post_metas, $sub_pages_ids )
		);
		// ajout articles
		foreach ( $sub_pages_ids as $key => $post_id ) {
			global $post_resum_schema;
			$post_resum_schema['position'] = $key + 1;
			$sub_pages_schema['mainEntity']['itemListElement'][] = $post_resum_schema;
		}
		// affichage
		echo '<script type="application/ld+json">'.json_encode( $sub_pages_schema, JSON_UNESCAPED_SLASHES ).'</script>';

	}

}


/*=====  FIN Données structurées  =====*/