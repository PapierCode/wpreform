<?php 
/**
 * 
 * Fonctions pour les templates : page
 * 
 */


/*=============================
=            Hooks            =
=============================*/

add_action( 'pc_page_content_before', 'pc_display_main_start', 10 );  // layout commun
add_action( 'pc_page_content_before', 'pc_display_schema_article', 20, 2 ); // données structurées

add_action( 'pc_page_content_before', 'pc_display_main_title_start', 20 );  // layout commun
add_action( 'pc_page_content_before', 'pc_display_main_title', 30, 1 );  // layout commun
add_action( 'pc_page_content_before', 'pc_display_main_title_end', 40 );  // layout commun

add_action( 'pc_page_wysiwyg_after', 'pc_display_specific_content', 10, 2 ); // contenu supplémentaire

add_action( 'pc_page_content_footer', 'pc_display_main_footer_start', 10 );  // layout commun
add_action( 'pc_page_content_footer', 'pc_display_subpage_backlink', 20, 1 ); // lien retour
add_action( 'pc_page_content_footer', 'pc_display_share_links', 30 ); // layout commun
add_action( 'pc_page_content_footer', 'pc_display_main_footer_end', 40 ); // layout commun

add_action( 'pc_page_content_after', 'pc_display_main_end', 10 ); // layout commun


/*=====  FIN Hooks  =====*/

/*===============================================
=            Contenu supplémentaire             =
===============================================*/

function pc_display_specific_content( $post, $post_metas ) {

	/*----------  Plugin  ----------*/
		
	if ( isset($post_metas['content-from']) ) {

		global $settings_project;
	
		foreach ( $settings_project['page-content-from'] as $slug => $datas ) {
			if ($slug == $post_metas['content-from'][0]) {
				include $datas[1];
			}
		}


	/*----------  Sous-pages  ----------*/		

	} else if ( isset($post_metas['content-subpages']) ) {

		// liste
		$sub_pages_id = explode( ',',$post_metas['content-subpages'][0] );
		// données structurées
		$sub_pages_schema = array(
			'@context' => 'https://schema.org',
			'@type' => 'ItemList',
			'itemListElement' => array(	)
		);
		global $st_schema;

		// affichage des résumés de pages
		foreach ( $sub_pages_id as $key => $postId ) {
			pc_display_post_resum( $postId, '', 2 );
			// données structurées
			$st_schema['position'] = $key + 1;
			$sub_pages_schema['itemListElement'][] = $st_schema;
		}
		pc_add_fake_st( count($sub_pages_id) );

		// affichage des données structurées
		echo '<script type="application/ld+json">'.json_encode($sub_pages_schema,JSON_UNESCAPED_SLASHES).'</script>';

	}

}


/*=====  FIN Contenu supplémentaire   =====*/

/*==============================
=            Résumé            =
==============================*/

function pc_get_page_excerpt( $post_id, $post_metas ) {

	if ( isset( $post_metas['seo-desc'] ) && $post_metas['seo-desc'][0] != '' ) {

		$excerpt = $post_metas['seo-desc'][0];

	} else if ( isset( $post_metas['resum-desc'] ) && $post_metas['resum-desc'][0] != '' ) {

		$excerpt = $post_metas['resum-desc'][0];

	} else {

		$excerpt = get_the_excerpt( $post_id );
	}
	
	return $excerpt;

}


/*=====  FIN Résumé  =====*/

/*==============================================
=            Sous-page, lien retour            =
==============================================*/

function pc_display_subpage_backlink( $post ) {

    if ( $post->post_type == 'page' && $post->post_parent > 0 ) {

        echo '<nav class="main-footer-nav"><a href="'.get_the_permalink($post->post_parent).'" class="btn" title="Page précédente">'.pc_svg('arrow').'<span>Retour</span></a></nav>';

    }

}


/*=====  FIN Sous-page, lien retour  =====*/
