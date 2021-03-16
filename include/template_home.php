<?php
/**
 * 
 * Template accueil
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
add_action( 'pc_action_home_main_start', 'pc_display_main_start', 10 ); // layout commun -> templates_layout.php

	// header
	add_action( 'pc_action_home_main_header', 'pc_display_main_header_start', 10 ); // layout commun -> templates_layout.php
		add_action( 'pc_action_home_main_header', 'pc_display_home_main_title', 20 ); // titre
	add_action( 'pc_action_home_main_header', 'pc_display_main_header_end', 100 ); // layout commun -> templates_layout.php

	// content
	add_action( 'pc_action_home_main_content', 'pc_display_main_content_start', 10 ); // layout commun -> templates_layout.php
		add_action( 'pc_action_home_main_content', 'pc_display_home_wysiwyg', 20, 1 ); // introduction
		add_action( 'pc_action_home_main_content', 'pc_display_home_shortcuts', 30, 1 ); // raccourcis
		add_action( 'pc_action_home_main_content', 'pc_display_home_schema_collection_page', 90, 1 ); // données structurées
	add_action( 'pc_action_home_main_content', 'pc_display_main_content_end', 100 ); // layout commun -> templates_layout.php

	// footer
	add_action( 'pc_action_home_main_footer', 'pc_display_main_footer_start', 10 ); // layout commun -> templates_layout.php
		add_action( 'pc_action_home_main_footer', 'pc_display_share_links', 90 ); // layout commun -> templates_layout.php
	add_action( 'pc_action_home_main_footer', 'pc_display_main_footer_end', 100 ); // layout commun -> templates_layout.php

// main end
add_action( 'pc_action_home_main_end', 'pc_display_main_end', 10 ); // layout commun -> templates_layout.php


/*=====  FIN Hooks  =====*/ 
 
/*=============================
=            Titre            =
=============================*/

function pc_display_home_main_title( $settings_home ) {
	
	echo '<h1><span>'.$settings_home['content-title'].'</span></h1>';

}

/*=====  FIN Titre  =====*/

/*===============================
=            Wysiwyg            =
===============================*/

function pc_display_home_wysiwyg( $settings_home ) {
	
	echo pc_wp_wysiwyg( $settings_home['content-txt'] );

}


/*=====  FIN Wysiwyg  =====*/

/*==================================
=            Raccourcis            =
==================================*/

function pc_display_home_shortcuts( $settings_home ) {
	
	if ( isset($settings_home['content-pages']) && $settings_home['content-pages'] != '' ) {

		// id des pages mises en avant
		$home_shortcuts = pc_get_home_shortcuts_bdd_to_array($settings_home['content-pages']);

		// pour les CSS, pair ou impair ?
		$shortcuts_nb = ( count($home_shortcuts)%2 == 1 ) ? 'home-shortcuts--odd' : 'home-shortcuts--even';

		echo '<div class="home-shortcuts">';
		echo '<ul class="home-shortcuts-list '.$shortcuts_nb.' reset-list">';
			foreach ($home_shortcuts as $post_id => $post_title_alt) {

				// post métas
				$post_metas = get_post_meta( $post_id );

				// titre
				$post_title = ( $post_title_alt != '' ) ? $post_title_alt : get_the_title( $post_id );
				// lien
				$post_url = get_the_permalink( $post_id );				
				// image datas
				$post_img_datas = pc_get_post_resum_img_datas( $post_id, $post_title, $post_metas );

				// affichage
				echo '<li class="home-shortcut-item"><a title="'.$post_title.'" href="'.$post_url.'" class="home-shortcut-link">';
					echo '<span class="home-shortcut-img">';
						pc_display_post_resum_img_tag( $post_img_datas, $post_id );
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

function pc_display_home_schema_collection_page( $settings_home ) {
	
	$schema_collection_page = array(
		'@context' => 'http://schema.org/',
		'@type'=> 'CollectionPage',
		'name' => $settings_home['content-title'],
		'headline' => $settings_home['content-title'],
		'description' => ( isset( $settings_home['seo-desc'] ) && $settings_home['seo-desc'] != '' ) ? $settings_home['seo-desc'] : wp_trim_words($settings_home['content-txt'],30,'...'),
		'mainEntity' => array(
			'@type' => 'ItemList',
			'itemListElement' => array()
		),
		'isPartOf' => pc_get_schema_website()
	);

	if ( isset($settings_home['content-pages']) && $settings_home['content-pages'] != '' ) {

		// id des pages mises en avant
		$home_shortcuts = pc_get_home_shortcuts_bdd_to_array($settings_home['content-pages']);

		foreach ($home_shortcuts as $post_id => $post_title_alt) {

			// titre
			$post_title = ( $post_title_alt != '' ) ? $post_title_alt : get_the_title( $post_id );
			// metas
			$post_metas = get_post_meta( $post_id );		

			// image du post ou image par défaut
			if ( isset( $post_metas['visual-id'] ) ) {
				$post_img = pc_get_img( $post_metas['visual-id'][0], 'share', 'datas' );
			} else {
				$post_img = pc_get_img_default_to_share();
			}
			
			$schema_collection_page['mainEntity']['itemListElement'][] = array(
				'@type' => 'ListItem',
				'name' => $post_title,
				'description' => pc_get_post_resum_excerpt( $post_id, $post_metas ),
				'url' => get_the_permalink($post_id),
				'image' => array(
					'@type'		=>'ImageObject',
					'url' 		=> $post_img[0],
					'width' 	=> $post_img[1],
					'height' 	=> $post_img[2]
				)
			);

		}

	}

	$schema_collection_page = apply_filters( 'pc_filter_home_schema_collection_page', $schema_collection_page );
	echo '<script type="application/ld+json">'.json_encode($schema_collection_page,JSON_UNESCAPED_SLASHES).'</script>';

}


/*=====  FIN Données structurées  =====*/