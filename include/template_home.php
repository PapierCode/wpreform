<?php
/**
 * 
 * Template accueil
 * 
 */


/*=============================
=            Hooks            =
=============================*/

add_action( 'pc_home_content_before', 'pc_display_main_start', 10 ); // layout commun -> templates_layout.php

add_action( 'pc_home_content', 'pc_display_main_title_start', 10 ); // layout commun -> templates_layout.php
add_action( 'pc_home_content', 'pc_display_home_main_title', 20, 1 ); // contenu
add_action( 'pc_home_content', 'pc_display_main_title_end', 30 ); // layout commun -> templates_layout.php

add_action( 'pc_home_content', 'pc_display_main_content_start', 40 ); // layout commun -> templates_layout.php
add_action( 'pc_home_content', 'pc_display_home_main_introduction', 50, 1 ); // introduction
add_action( 'pc_home_content', 'pc_display_home_main_shortcuts', 60, 1 ); // raccourcis
add_action( 'pc_home_content', 'pc_display_home_schema_collection_page', 99, 1 ); // données structurées
add_action( 'pc_home_content', 'pc_display_main_content_end', 100 ); // layout commun -> templates_layout.php

add_action( 'pc_home_content_footer', 'pc_display_main_footer_start', 10 ); // layout commun -> templates_layout.php
add_action( 'pc_home_content_footer', 'pc_display_share_links', 20 ); // layout commun -> templates_layout.php
add_action( 'pc_home_content_footer', 'pc_display_main_footer_end', 100 ); // layout commun -> templates_layout.php

add_action( 'pc_home_content_after', 'pc_display_main_end', 10 ); // layout commun -> templates_layout.php


/*=====  FIN Hooks  =====*/

/*===============================
=            Contenu            =
===============================*/

/*----------  Title  ----------*/

function pc_display_home_main_title( $settings_home ) {
	
	echo '<h1><span>'.$settings_home['content-title'].'</span></h1>';

}


/*----------  Wysiwyg  ----------*/

function pc_display_home_main_introduction( $settings_home ) {
	
	echo '<div class="editor"><div class="editor-inner">'.pc_wp_wysiwyg( $settings_home['content-txt'],false ).'</div></div>';

}


/*----------  Pages à la une  ----------*/

function pc_display_home_main_shortcuts( $settings_home ) {
	
	if ( isset($settings_home['content-pages']) && $settings_home['content-pages'] != '' ) {

		// id des pages mises en avant
		$home_shortcuts = pc_home_shortcuts_bdd_to_array($settings_home['content-pages']);

		// pour les CSS, pair ou impair ?
		$shortcuts_nb = ( count($home_shortcuts)%2 == 1 ) ? 'home-shortcuts--odd' : 'home-shortcuts--even';

		echo '<ul class="home-shortcuts '.$shortcuts_nb.' reset-list">';
			foreach ($home_shortcuts as $post_id => $post_new_title) {

				// titre
				$post_title = ( $post_new_title != '' ) ? $post_new_title : get_the_title( $post_id );
				// lien
				$post_url = get_the_permalink( $post_id );
				
				// image du ou image par défaut
				$post_img_id = get_post_meta( $post_id, 'visual-id', true );
				if ( $post_img_id != '' ) {
					$post_img_urls = array(
						wp_get_attachment_image_src( $post_img_id, 'st-400' )[0],
						wp_get_attachment_image_src( $post_img_id, 'st-500' )[0]
					);
					$post_img_alt = get_post_meta( $post_img_id, '_wp_attachment_image_alt', true );			
				} else {
					$post_img_urls = array(
						get_bloginfo( 'template_directory' ).'/images/st-default-400.jpg',
						get_bloginfo( 'template_directory' ).'/images/st-default-500.jpg'
					);
					$post_img_urls = apply_filters( 'pc_filter_img_default_st', $post_img_urls );
					$post_img_alt = $post_title;
				}
				$post_img_srcset = $post_img_urls[0].' 400w, '.$post_img_urls[1].' 500w';
				$post_img_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 500px, (min-width:760px) and (max-width:840px) 400px, (min-width:841px) 500px';
				$post_img = '<img src="'.$post_img_urls[1].'" alt="'.$post_img_alt.'" srcset="'.$post_img_srcset.'" sizes="'.$post_img_sizes.'" loading="lazy" />';
				$post_img = apply_filters( 'pc_filter_home_shortcut_img', $post_img, $post_id );

				// affichage
				echo '<li class="home-shortcut-item"><a title="'.$post_title.'" href="'.$post_url.'" class="home-shortcut-link">';
					echo '<span class="home-shortcut-img">'.$post_img.'</span>';
					echo '<span class="home-shortcut-txt">'.pc_words_limit(htmlspecialchars_decode($post_title),40).'</span>';
					echo '<span class="home-shortcut-ico">'.pc_svg('link').'</span>';
				echo '</a></li>';


			} // FIN foreach $home_shortcuts
		echo '</ul>';

	}

}


/*----------  Données structurées  ----------*/

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
		$home_shortcuts = pc_home_shortcuts_bdd_to_array($settings_home['content-pages']);

		foreach ($home_shortcuts as $post_id => $post_new_title) {

			// titre
			$post_title = ( $post_new_title != '' ) ? $post_new_title : get_the_title( $post_id );
			// metas
			$post_metas = get_post_meta( $post_id );		

			// image du post ou image par défaut
			if ( isset( $post_metas['visual-id'] ) ) {
				$img = pc_get_img( $post_metas['visual-id'][0], 'share', 'datas' );
			} else {
				$img = pc_get_img_default_to_share();
			}
			
			$schema_collection_page['mainEntity']['itemListElement'][] = array(
				'@type' => 'ListItem',
				'name' => $post_title,
				'description' => pc_get_page_excerpt( $post_id, $post_metas ),
				'url' => get_the_permalink($post_id),
				'image' => array(
					'@type'		=>'ImageObject',
					'url' 		=> $img[0],
					'width' 	=> $img[1],
					'height' 	=> $img[2]
				)
			);

		}

	}

	$schema_collection_page = apply_filters( 'pc_filter_home_schema_collection_page', $schema_collection_page );
	echo '<script type="application/ld+json">'.json_encode($schema_collection_page,JSON_UNESCAPED_SLASHES).'</script>';

}


/*=====  FIN Contenu  =====*/

/*==========================================================
=            Classes CSS en fonction du contenu            =
==========================================================*/

add_filter( 'pc_filter_html_css_class', 'pc_home_html_css_class' );
		
	function pc_home_html_css_class( $class ) {

		global $home_shortcuts;
		if ( is_home() && !empty($home_shortcuts) ) { $class[] = 'is-home-with-shortcuts'; }

		return $class;

	}


/*=====  FIN Classes CSS en fonction du contenu  =====*/