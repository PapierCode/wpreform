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
add_action( 'pc_page_content_before', 'pc_display_schema_post', 20, 2 ); // données structurées

add_action( 'pc_page_content_before', 'pc_display_main_title_start', 20 ); // layout commun -> templates_layout.php
add_action( 'pc_page_content_before', 'pc_display_main_title', 30, 1 ); // layout commun -> templates_layout.php
add_action( 'pc_page_content_before', 'pc_display_main_title_end', 100 ); // layout commun -> templates_layout.php

add_action( 'pc_page_wysiwyg_before', 'pc_display_main_content_start', 10 ); // layout commun -> templates_layout.php
add_action( 'pc_page_wysiwyg_after', 'pc_display_st_list_start', 20, 2 ); // début container st
add_action( 'pc_page_wysiwyg_after', 'pc_display_specific_content', 30, 2 ); // contenu supplémentaire
add_action( 'pc_page_wysiwyg_after', 'pc_display_st_list_end', 40, 2 ); // fin container st
add_action( 'pc_page_wysiwyg_after', 'pc_display_main_content_end', 100 ); // layout commun -> templates_layout.php

add_action( 'pc_page_content_footer', 'pc_display_main_footer_start', 10 ); // layout commun -> templates_layout.php
add_action( 'pc_page_content_footer', 'pc_display_subpage_backlink', 20, 1 ); // lien retour
add_action( 'pc_page_content_footer', 'pc_display_share_links', 30 ); // layout commun -> templates_layout.php
add_action( 'pc_page_content_footer', 'pc_display_main_footer_end', 100 ); // layout commun -> templates_layout.php

add_action( 'pc_page_content_after', 'pc_display_main_end', 100 ); // layout commun -> templates_layout.php


/*=====  FIN Hooks  =====*/

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


/*=====  FIN Données structurées  =====*/

/*===============================================
=            Contenu supplémentaire             =
===============================================*/

function pc_display_st_list_start( $post, $post_metas ) {

	if ( !post_password_required() && isset( $post_metas['content-subpages'] ) ) {
		echo '<div class="st-list">';
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

			// affichage des résumés de pages
			foreach ( $sub_pages_ids as $key => $post_id ) {
				pc_display_post_resum( $post_id, '', 2 );
				// données structurées
				global $post_resum_schema;
				$st_schema['position'] = $key + 1;
				$sub_pages_schema['mainEntity']['itemListElement'][] = $post_resum_schema;
			}

			do_action( 'pc_st_list_fake', count($sub_pages_ids), '' );

			// affichage des données structurées
			echo '<script type="application/ld+json">'.json_encode( $sub_pages_schema, JSON_UNESCAPED_SLASHES ).'</script>';

		}

	} // FIN if !post_password_required()

}

function pc_display_st_list_end( $post, $post_metas ) {

	if ( !post_password_required() && isset( $post_metas['content-subpages'] ) ) {
		echo '</div>';
	}

}


/*=====  FIN Contenu supplémentaire   =====*/

/*==============================================
=            Sous-page, lien retour            =
==============================================*/

function pc_display_subpage_backlink( $post ) {

    if ( $post->post_type == 'page' && $post->post_parent > 0 ) {

        echo '<nav class="main-footer-nav"><a href="'.get_the_permalink($post->post_parent).'" class="button" title="Page précédente">'.pc_svg('arrow').'<span>Retour</span></a></nav>';

    }

}


/*=====  FIN Sous-page, lien retour  =====*/