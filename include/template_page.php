<?php 
/**
 * 
 * Template page
 * 
 */


/*=============================
=            Hooks            =
=============================*/

add_action( 'pc_page_content_before', 'pc_display_main_start', 10 ); // layout commun -> fn-template_layout.php
add_action( 'pc_page_content_before', 'pc_display_schema_post', 20, 2 ); // données structurées

add_action( 'pc_page_content_before', 'pc_display_main_title_start', 20 ); // layout commun -> fn-template_layout.php
add_action( 'pc_page_content_before', 'pc_display_main_title', 30, 1 ); // layout commun -> fn-template_layout.php
add_action( 'pc_page_content_before', 'pc_display_main_title_end', 40 ); // layout commun -> fn-template_layout.php

add_action( 'pc_page_wysiwyg_after', 'pc_display_specific_content', 10, 2 ); // contenu supplémentaire

add_action( 'pc_page_content_footer', 'pc_display_main_footer_start', 10 ); // layout commun -> fn-template_layout.php
add_action( 'pc_page_content_footer', 'pc_display_subpage_backlink', 20, 1 ); // lien retour
add_action( 'pc_page_content_footer', 'pc_display_share_links', 30 ); // layout commun -> fn-template_layout.php
add_action( 'pc_page_content_footer', 'pc_display_main_footer_end', 40 ); // layout commun -> fn-template_layout.php

add_action( 'pc_page_content_after', 'pc_display_main_end', 10 ); // layout commun -> fn-template_layout.php


/*=====  FIN Hooks  =====*/

/*===========================================
=            Données structurées            =
===========================================*/

function pc_display_schema_post( $post, $post_metas ) {

	$schema = pc_get_schema_article( $post, $post_metas, true );
	$schema = apply_filters( 'pc_filter_schema_post', $schema, $post, $post_metas );

	echo '<script type="application/ld+json">'.json_encode($schema,JSON_UNESCAPED_SLASHES).'</script>';

}


/*=====  FIN Données structurées  =====*/

/*===============================================
=            Contenu supplémentaire             =
===============================================*/

function pc_display_specific_content( $post, $post_metas ) {

	/*----------  Contenu spécifique  ----------*/
		
	if ( isset($post_metas['content-from']) ) {

		global $settings_project;

		// avant le contenu
		do_action( 'pc_page_content_from_before', $post, $post_metas, $settings_project['page-content-from'] );
		// contenu
		include $settings_project['page-content-from'][$post_metas['content-from'][0]][1];
		// après le contenu
		do_action( 'pc_page_content_from_after', $post, $post_metas, $settings_project['page-content-from'] );


	/*----------  Sous-pages  ----------*/		

	} else if ( isset($post_metas['content-subpages']) ) {

		// liste
		$sub_pages_ids = explode( ',', $post_metas['content-subpages'][0] );
		// données structurées
		$sub_pages_schema = array(
			'@context' => 'http://schema.org/',
			'@type'=> 'CollectionPage',
			'mainEntity' => array(
				'@type' => 'ItemList',
				'itemListElement' => array()
			),
			'isPartOf' => pc_get_schema_article( $post, $post_metas, $sub_pages_ids )
		);
		global $st_schema;

		// hook avant la liste
		do_action( 'pc_page_subpages_st_list_before', $post, $post_metas, '' );

		// affichage des résumés de pages
		foreach ( $sub_pages_ids as $key => $post_id ) {
			pc_display_post_resum( $post_id, '', 2 );
			// données structurées
			$st_schema['position'] = $key + 1;
			$sub_pages_schema['mainEntity']['itemListElement'][] = $st_schema;
		}

		// hook après la liste
		do_action( 'pc_page_subpages_st_list_after', $sub_pages_ids, '' );

		// affichage des données structurées
		echo '<script type="application/ld+json">'.json_encode( $sub_pages_schema, JSON_UNESCAPED_SLASHES ).'</script>';

	}

}


/*=====  FIN Contenu supplémentaire   =====*/
