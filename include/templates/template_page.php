<?php 
/**
 * 
 * Template : page
 * 
 ** Hooks
 ** Titre
 ** Fil d'ariane
 ** Wysiwyg
 ** Sous-pages & contenu spécifique
 ** Sous-pages, lien retour
 ** Données structurées
 * 
 */


/*=============================
=            Hooks            =
=============================*/

// main start
add_action( 'pc_action_page_main_start', 'pc_display_main_start', 10 ); // template-part_layout.php

	// header
	add_action( 'pc_action_page_main_header', 'pc_display_main_header_start', 10 ); // template-part_layout.php
		add_action( 'pc_action_page_main_header', 'pc_display_header_breadcrumb', 20 ); // breadcrumb
		add_action( 'pc_action_page_main_header', 'pc_display_main_title', 30 ); // titre
	add_action( 'pc_action_page_main_header', 'pc_display_main_header_end', 100 ); // template-part_layout.php

	// content
	add_action( 'pc_action_page_main_content', 'pc_display_main_content_start', 10 ); // template-part_layout.php
		add_action( 'pc_action_page_main_content', 'pc_display_main_breadcrumb', 20 ); // breadcrumb
		add_action( 'pc_action_page_main_content', 'pc_display_page_wysiwyg', 30 ); // éditeur
		add_action( 'pc_action_page_main_content', 'pc_display_page_specific_content', 40 ); // contenu supplémentaire
	add_action( 'pc_action_page_main_content', 'pc_display_main_content_end', 100 ); // template-part_layout.php

	// footer
	add_action( 'pc_action_page_main_footer', 'pc_display_main_footer_start', 10 ); // template-part_layout.php
		add_action( 'pc_action_page_main_footer', 'pc_display_sub_page_backlink', 20 ); // lien retour
		add_action( 'pc_action_page_main_footer', 'pc_display_share_links', 90 ); // liens de partage
	add_action( 'pc_action_page_main_footer', 'pc_display_main_footer_end', 100 ); // template-part_layout.php

// main end
add_action( 'pc_action_page_main_end', 'pc_display_main_end', 10 ); // template-part_layout.php


/*=====  FIN Hooks  =====*/

/*====================================
=            Fil d'ariane            =
====================================*/

function pc_display_header_breadcrumb( $pc_post ) {

	if ( !$pc_post->is_fullscreen ) { pc_display_breadcrumb(); }

}

function pc_display_main_breadcrumb( $pc_post ) {

	if ( $pc_post->is_fullscreen ) { pc_display_breadcrumb(); }

}


/*=====  FIN Fil d'ariane  =====*/

/*===============================
=            Wysiwyg            =
===============================*/

function pc_display_page_wysiwyg( $pc_post ) {

	// contenu
	if ( apply_filters( 'pc_filter_page_wysiwyg_display', true, $pc_post ) && '' != $pc_post->content ) {

		$display_container = apply_filters( 'pc_filter_page_wysiwyg_container', true, $pc_post );

		if ( $display_container ) { echo '<div class="editor"><div class="editor-inner">'; }
			the_content();
		if ( $display_container ) { echo '</div></div>'; }
		
	}

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

	if ( is_page() && !post_password_required() ) {

		$metas = $pc_post->metas;

		/*----------  Contenu spécifique  ----------*/
			
		if ( isset($metas['content-from']) && apply_filters( 'pc_filter_page_display_content_from', true, $pc_post ) ) {

			global $settings_project;
			$template = $settings_project['page-content-from'][$metas['content-from']][1];
			if ( $template ) { include $template; }


		/*----------  Sous-pages  ----------*/		

		} else if ( isset($metas['content-subpages']) && apply_filters( 'pc_filter_page_display_content_subpages', true, $pc_post )  ) {

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

    if ( is_page() && $pc_post->parent > 0 ) {

        echo '<nav class="main-footer-prev" role="navigation" aria-label="Retour à la page parente"><a href="'.get_the_permalink($pc_post->parent).'" class="button" title="'.get_the_title($pc_post->parent).'"><span class="ico">'.pc_svg('arrow').'</span><span class="txt">Retour</span></a></nav>';

    }

}


/*=====  FIN Sous-page, lien retour  =====*/