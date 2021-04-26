<?php 
/**
 * 
 * Template : page
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
add_action( 'pc_action_page_main_start', 'pc_display_main_start', 10 ); // template-part_layout.php

	// header
	add_action( 'pc_action_page_main_header', 'pc_display_main_header_start', 10 ); // template-part_layout.php
		//add_action( 'pc_action_page_main_header', 'pc_display_breadcrumb', 20 ); // breadcrumb
		add_action( 'pc_action_page_main_header', 'pc_display_page_main_title', 30 ); // titre
	add_action( 'pc_action_page_main_header', 'pc_display_main_header_end', 100 ); // template-part_layout.php

	// content
	add_action( 'pc_action_page_main_content', 'pc_display_main_content_start', 10 ); // template-part_layout.php
		add_action( 'pc_action_page_main_content', 'pc_display_page_wysiwyg', 20 ); // éditeur
		add_action( 'pc_action_page_main_content', 'pc_display_page_specific_content', 30 ); // contenu supplémentaire
	add_action( 'pc_action_page_main_content', 'pc_display_main_content_end', 100 ); // template-part_layout.php

	// footer
	add_action( 'pc_action_page_main_footer', 'pc_display_main_footer_start', 10 ); // template-part_layout.php
		add_action( 'pc_action_page_main_footer', 'pc_display_sub_page_backlink', 20 ); // lien retour
		add_action( 'pc_action_page_main_footer', 'pc_display_share_links', 90 ); // template-part_layout.php
	add_action( 'pc_action_page_main_footer', 'pc_display_main_footer_end', 100 ); // template-part_layout.php

// main end
add_action( 'pc_action_page_main_end', 'pc_display_main_end', 10 ); // template-part_layout.php


/*=====  FIN Hooks  =====*/

/*=============================
=            Titre            =
=============================*/

function pc_display_page_main_title( $pc_post ) {
	
	echo '<h1><span>'.get_the_title().'</span></h1>';

}


/*=====  FIN Titre  =====*/

/*===============================
=            Wysiwyg            =
===============================*/

function pc_display_page_wysiwyg( $pc_post ) {

	// contenu
	if ( '' != $pc_post->content ) { the_content(); }

	// schéma Article
	if ( apply_filters( 'pc_filter_page_schema_article_display', true, $pc_post ) ) {
		echo '<script type="application/ld+json">';
			echo json_encode( $pc_post->get_schema_article(), JSON_UNESCAPED_SLASHES );
		echo '</script>';
	}

}


/*=====  FIN Wysiwyg  =====*/

/*========================================================
=            Sous-pages & contenu spécifique             =
========================================================*/

function pc_display_page_specific_content( $pc_post ) {

	if ( !post_password_required() ) {

		$metas = $pc_post->metas;

		/*----------  Contenu spécifique  ----------*/
			
		if ( isset($metas['content-from']) ) {

			global $settings_project;
			include $settings_project['page-content-from'][$metas['content-from']][1];


		/*----------  Sous-pages  ----------*/		

		} else if ( isset($metas['content-subpages']) ) {

			// liste des sous-pages
			$sub_pages_ids = explode( ',', $metas['content-subpages'] );
			$sub_pages_posts = get_posts( array(
				'post_type' => 'page',
				'post__in'	=> $sub_pages_ids,
				'orderby'	=> 'post__in',
				'numberposts' => -1
			) );

			// schéma CollectionPage
			$schema_collection_page = array(
				'@context' => 'http://schema.org/',
				'@type'=> 'CollectionPage',
				'mainEntity' => array(
					'@type' => 'ItemList',
					'itemListElement' => array()
				),
				'isPartOf' => $pc_post->get_schema_article( true )
			);
			
			// début de liste
			echo '<ul class="st-list st-list--subpages reset-list">';

				foreach ( $sub_pages_posts as $key => $sub_page ) {

					// début d'élément
					echo '<li class="st st--subpage">';

					$sub_page = new PC_post( $sub_page );
					// affichage résumé
					$sub_page->display_card();
					
					// schéma itemListElement 
					$schema_collection_page['mainEntity']['itemListElement'][] = $sub_page->get_schema_list_item( $key + 1 );
					
					// fin d'élément
					echo '</li>';

				}

			// fin de liste
			echo '</ul>';

			// affichage schéma CollectionPage
			echo '<script type="application/ld+json">'.json_encode( $schema_collection_page, JSON_UNESCAPED_SLASHES ).'</script>';

		}

	} // FIN if !post_password_required()

}


/*=====  FIN Sous-pages & contenu spécifique   =====*/

/*==============================================
=            Sous-page, lien retour            =
==============================================*/

function pc_display_sub_page_backlink( $pc_post ) {

    if ( $pc_post->parent > 0 ) {

        echo '<div class="main-footer-prev"><a href="'.get_the_permalink($pc_post->parent).'" class="button" title="'.get_the_title($pc_post->parent).'">'.pc_svg('arrow').'<span>Retour</span></a></div>';

    }

}


/*=====  FIN Sous-page, lien retour  =====*/