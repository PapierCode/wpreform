<?php
/**
 * 
 * Template : accueil
 * 
 ** Titre
 ** Wysiwyg
 ** Raccourcis
 ** Données structurées
 * 
 */


/*=============================
=            Hooks            =
=============================*/

// main start
add_action( 'pc_action_home_main_start', 'pc_display_main_start', 10 ); // template-part_layout.php

	// header
	add_action( 'pc_action_home_main_header', 'pc_display_main_header_start', 10 ); // template-part_layout.php
		add_action( 'pc_action_home_main_header', 'pc_display_home_main_title', 20 ); // titre
	add_action( 'pc_action_home_main_header', 'pc_display_main_header_end', 100 ); // template-part_layout.php

	// content
	add_action( 'pc_action_home_main_content', 'pc_display_main_content_start', 10 ); // template-part_layout.php
		add_action( 'pc_action_home_main_content', 'pc_display_home_wysiwyg', 20 ); // introduction
		add_action( 'pc_action_home_main_content', 'pc_display_home_shortcuts', 30 ); // raccourcis
		add_action( 'pc_action_home_main_content', 'pc_display_home_schema_collection_page', 90 ); // données structurées
	add_action( 'pc_action_home_main_content', 'pc_display_main_content_end', 100 ); // template-part_layout.php

	// footer
	add_action( 'pc_action_home_main_footer', 'pc_display_main_footer_start', 10 ); // template-part_layout.php
		add_action( 'pc_action_home_main_footer', 'pc_display_share_links', 90 ); // template-part_layout.php
	add_action( 'pc_action_home_main_footer', 'pc_display_main_footer_end', 100 ); // template-part_layout.php

// main end
add_action( 'pc_action_home_main_end', 'pc_display_main_end', 10 ); // template-part_layout.php


/*=====  FIN Hooks  =====*/ 
 
/*=============================
=            Titre            =
=============================*/

function pc_display_home_main_title( $pc_home ) {
	
	$metas = $pc_home->metas;
	echo '<h1><span>'.$metas['content-title'].'</span></h1>';

}

/*=====  FIN Titre  =====*/

/*===============================
=            Wysiwyg            =
===============================*/

function pc_display_home_wysiwyg( $pc_home ) {
	
	$metas = $pc_home->metas;
	if ( '' != $metas['content-txt'] ) {
		echo pc_wp_wysiwyg( $metas['content-txt'] );
	}

}


/*=====  FIN Wysiwyg  =====*/

/*==================================
=            Raccourcis            =
==================================*/

function pc_display_home_shortcuts( $pc_home ) {

	$metas = $pc_home->metas;
	
	if ( isset($metas['content-pages']) && $metas['content-pages'] != '' ) {

		// id des pages mises en avant
		$home_shortcuts = pc_convert_home_shortcuts_bdd_to_array($metas['content-pages']);

		// pour les CSS, pair ou impair ?
		$shortcuts_nb = ( count($home_shortcuts)%2 == 1 ) ? 'home-shortcuts--odd' : 'home-shortcuts--even';

		echo '<div class="home-shortcuts">';
		echo '<ul class="home-shortcuts-list '.$shortcuts_nb.' reset-list">';
			foreach ($home_shortcuts as $post_id => $post_title_alt) {

				$post = new PC_post( get_post( $post_id ) );
				$post_title = ( '' != $post_title_alt ) ? $post_title_alt : $post->title;

				// affichage
				echo '<li class="home-shortcut-item"><a title="'.$post_title.'" href="'.$post->permalink.'" class="home-shortcut-link">';
					echo '<span class="home-shortcut-img">';
						$post->display_card_image();
					echo '</span>';
					echo '<span class="home-shortcut-txt">'.pc_words_limit(htmlspecialchars_decode($post_title),40).'</span>';
					echo '<span class="home-shortcut-ico">'.pc_svg('link').'</span>';
				echo '</a></li>';


			} // FIN foreach $home_shortcuts
		echo '</ul>';
		echo '</div>';

	}

}


/*=====  FIN Raccourcis  =====*/

/*===========================================
=            Données structurées            =
===========================================*/

function pc_display_home_schema_collection_page( $pc_home ) {
	
	global $texts_lengths;
	$metas = $pc_home->metas;

	$schema_collection_page = array(
		'@context' => 'http://schema.org/',
		'@type'=> 'CollectionPage',
		'name' => $pc_home->get_seo_meta_title(),
		'headline' => $pc_home->get_seo_meta_title(),
		'description' => $pc_home->get_seo_meta_description(),
		'mainEntity' => array(
			'@type' => 'ItemList',
			'itemListElement' => array()
		),
		'isPartOf' => pc_get_schema_website()
	);

	if ( isset($metas['content-pages']) && $metas['content-pages'] != '' ) {

		// id des pages mises en avant
		$home_shortcuts = pc_convert_home_shortcuts_bdd_to_array($metas['content-pages']);
		// compteur position itemListElement
		$list_item_key = 1;

		foreach ($home_shortcuts as $post_id => $post_title_alt) {

			$pc_post = new PC_post( get_post( $post_id ) );
			
			$schema_collection_page['mainEntity']['itemListElement'][] = $pc_post->get_schema_list_item( $list_item_key );
			$list_item_key++;

		}

	}

	$schema_collection_page = apply_filters( 'pc_filter_home_schema_collection_page', $schema_collection_page );
	echo '<script type="application/ld+json">'.json_encode($schema_collection_page,JSON_UNESCAPED_SLASHES).'</script>';

}


/*=====  FIN Données structurées  =====*/