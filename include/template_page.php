<?php 
/**
 * 
 * Template page
 * 
 ** Hooks
 ** Titre
 ** Wysiwyg
 ** Sous-pages & contenu spécifique
 ** Sous-pages, lien retour
 ** Données structurées
 * 
 */


/*=============================
=            Hooks            =
=============================*/

// maint start
add_action( 'pc_action_page_main_start', 'pc_display_main_start', 10 ); // layout commun -> templates_layout.php

	// header
	add_action( 'pc_action_page_main_header', 'pc_display_main_header_start', 10 ); // layout commun -> templates_layout.php
		add_action( 'pc_action_page_main_header', 'pc_display_page_main_title', 20 ); // titre
	add_action( 'pc_action_page_main_header', 'pc_display_main_header_end', 100 ); // layout commun -> templates_layout.php

	// content
	add_action( 'pc_action_page_main_content', 'pc_display_main_content_start', 10 ); // layout commun -> templates_layout.php
		add_action( 'pc_action_page_main_content', 'pc_display_page_wysiwyg', 20, 2 ); // éditeur
		add_action( 'pc_action_page_main_content', 'pc_display_page_specific_content', 30, 2 ); // contenu supplémentaire
		add_action( 'pc_action_page_main_content', 'pc_display_page_schema_article', 80, 2 ); // données structurées
		add_action( 'pc_action_page_main_content', 'pc_display_page_schema_collection_page', 90, 2 ); // données structurées
	add_action( 'pc_action_page_main_content', 'pc_display_main_content_end', 100 ); // layout commun -> templates_layout.php

	// footer
	add_action( 'pc_action_page_main_footer', 'pc_display_main_footer_start', 10 ); // layout commun -> templates_layout.php
		add_action( 'pc_action_page_main_footer', 'pc_display_page_backlink', 20 ); // lien retour
		add_action( 'pc_action_page_main_footer', 'pc_display_share_links', 90 ); // layout commun -> templates_layout.php
	add_action( 'pc_action_page_main_footer', 'pc_display_main_footer_end', 100 ); // layout commun -> templates_layout.php

// main end
add_action( 'pc_action_page_main_end', 'pc_display_main_end', 10 ); // layout commun -> templates_layout.php


/*=====  FIN Hooks  =====*/

/*=============================
=            Titre            =
=============================*/

function pc_display_page_main_title() {
	
	echo '<h1><span>'.get_the_title().'</span></h1>';

}


/*=====  FIN Titre  =====*/

/*===============================
=            Wysiwyg            =
===============================*/

function pc_display_page_wysiwyg( $post, $post_metas  ) {

	if ( $post->post_content != '' ) { the_content(); }

}


/*=====  FIN Wysiwyg  =====*/

/*========================================================
=            Sous-pages & contenu spécifique             =
========================================================*/

function pc_display_page_specific_content( $post, $post_metas ) {

	if ( !post_password_required() ) {

		/*----------  Contenu spécifique  ----------*/
			
		if ( isset($post_metas['content-from']) ) {

			global $settings_project;
			include $settings_project['page-content-from'][$post_metas['content-from'][0]][1];


		/*----------  Sous-pages  ----------*/		

		} else if ( isset($post_metas['content-subpages']) ) {

			// affichage des résumés de pages
			$sub_pages_ids = explode( ',', $post_metas['content-subpages'][0] );
			
			echo apply_filters( 'pc_filter_st_list_start', '<ul class="st-list reset-list">' );

			foreach ( $sub_pages_ids as $key => $post_id ) {
				pc_display_post_resum( $post_id, 'st--subpage', 2 );
			}

			echo apply_filters( 'pc_filter_st_list_end', '</ul>' );

		}

	} // FIN if !post_password_required()

}


/*=====  FIN Sous-pages & contenu spécifique   =====*/

/*==============================================
=            Sous-page, lien retour            =
==============================================*/

function pc_display_page_backlink( $post ) {

    if ( $post->post_type == 'page' && $post->post_parent > 0 ) {

        echo '<a href="'.get_the_permalink($post->post_parent).'" class="previous button" title="'.get_the_title($post->post_parent).'">'.pc_svg('arrow').'<span>Retour</span></a>';

    }

}


/*=====  FIN Sous-page, lien retour  =====*/

/*===========================================
=            Données structurées            =
===========================================*/

function pc_display_page_schema_article( $post, $post_metas ) {

	if ( !post_password_required() ) {

		$schema = pc_get_schema_article( $post, $post_metas, true );
		echo '<script type="application/ld+json">'.json_encode($schema,JSON_UNESCAPED_SLASHES).'</script>';

	}

}

function pc_display_page_schema_collection_page( $post, $post_metas ) {

	if ( !post_password_required() && isset( $post_metas['content-subpages'] ) ) {

		

		global $pc_post;
		pc_var($pc_post->get_post_seo_description());

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