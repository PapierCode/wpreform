<?php
/**
*
* Contenu de la balise head
*
**/

/*====================================================
=            Class CSS sur la balise HTML            =
====================================================*/

function pc_html_css_class() {

	// type de page
	if ( is_home() ) { $class = 'is-home'; }
	else if ( is_page() ) { $class = 'is-page'; }
	else if ( is_404() ) { $class = 'is-404'; }
	else { $class = ''; }
	// pour modifier
	$class = apply_filters( 'pc_filter_html_css_class', $class );
	// retour
	return $class;

}


/*=====  FIN Class CSS sur la balise HTML  =====*/

/*====================================
=            Fichiers CSS            =
====================================*/

add_action( 'wp_enqueue_scripts', 'pc_enqueue_preform_style' );

    function pc_enqueue_preform_style() {		
		
		/*----------  Font-face  ----------*/		
		
		// par defaut
		$font = get_template_directory_uri().'/css/font-face/font-face.css';
		// pour modifier
		// ou retourner une chaine vide pour désactiver
		$font = apply_filters( 'pc_filter_font_face', $font );
		// affichage si non vide
		if (  '' != trim($font) ) {
			wp_enqueue_style( 'preform-font-face', $font, null, null, 'screen');
		}


		/*----------  Défaut  ----------*/
    
        wp_enqueue_style( 'preform-style', get_template_directory_uri().'/style.css', null, null, 'screen' );
		wp_enqueue_style( 'preform-print-style', get_template_directory_uri().'/css/print.css', null, null, 'print' );


	}


/*=====  FIN Fichiers CSS  =====*/

/*===============================
=            Favicon            =
===============================*/

add_action( 'wp_head', 'pc_favicon' );

	function pc_favicon() {

		// défaut
		$url = get_bloginfo( 'template_directory' ).'/images/favicon.png';
		// pour modifier
		$url = apply_filters( 'pc_filter_favicon', $url );
		// affichage
		echo '<link rel="icon" type="image/png" href="'.$url.'" />';

	};


/*=====  FIN Favicon  =====*/

/*==========================================
=            Metas SEO & social            =
==========================================*/

add_action( 'wp_head', 'pc_metas_seo_and_social', 1 );

	function pc_metas_seo_and_social() {

		global $images_project_sizes; // tailles d'images déclarées, cf. templates/_templates_images.php
		global $settings_project; // config projet, cf. functions.php

		// réutilisable
		global $meta_title;
		global $meta_description;
		global $img_to_share;

		// url de la page en cours
		$url = 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		
		// défaut
		$img_to_share		= get_bloginfo( 'template_directory' ).'/images/logo.jpg';
		$meta_title 		= $settings_project['coord-name'];
		$meta_description 	= $settings_project['micro-desc'];


		/*----------  home.php  ----------*/

		if ( is_home() ) {

			// contenu home
			$settings_home = get_option('home-settings-option');

			// titre
			$meta_title = ( isset( $settings_home['seo-title'] ) && trim($settings_home['seo-title']) != '' ) ? $settings_home['seo-title'] : trim($settings_home['content-title']).' - '.trim($settings_project['coord-name']);
			// description
			$meta_description = ( isset( $settings_home['seo-desc'] ) && trim($settings_home['seo-desc']) != '' ) ? $settings_home['seo-desc'] : wp_trim_words($settings_home['content-intro'],30,'...');
			
			// visuel
			if ( isset( $settings_home['seo-img'] ) && $settings_home['seo-img'] != '' ) {
				$img_to_share_datas = pc_get_img($settings_home['seo-img'],'share','datas');
				$img_to_share = $img_to_share_datas[0];
			}


		/*----------  page.php & single.php  ----------*/

		} elseif ( is_page() || is_singular() ) {

			// custom fields
			$postId = get_the_id();
			$page_metas = get_post_meta( $postId );

			// titre
			$meta_title = ( isset( $page_metas['seo-title'] ) ) ? $page_metas['seo-title'][0] : get_the_title($postId).' - '.trim($settings_project['coord-name']);
			// description
			$meta_description = ( isset( $page_metas['seo-desc'] ) ) ? $page_metas['seo-desc'][0] : get_the_excerpt($postId);
			
			// visuel
			if ( isset( $page_metas['thumbnail-img'] ) ) {
				$img_to_share_datas = pc_get_img($page_metas['thumbnail-img'][0],'share','datas');
				$img_to_share = $img_to_share_datas[0];
			}


		/*----------  404.php  ----------*/

		} elseif ( is_404() ) {

			// metas title & description
			$meta_title = 'Page non trouvée - '.trim($settings_project['coord-name']);
			$meta_description = 'Désolé, cette page n\'existe pas ou a été supprimée.';
			
		}

		
		/*----------  Filtres  ----------*/
		
		$meta_title = apply_filters( 'pc_filter_meta_title', $meta_title );
		$meta_description = apply_filters( 'pc_filter_meta_description', $meta_description );


		/*----------  Affichage  ----------*/

		echo '<title>'.$meta_title.'</title>'.PHP_EOL;
		
		$metasDatas = array(
			array( 'name',	'description', $meta_description ),
			array( 'property', 'og:url', $url ),
			array( 'property', 'og:type', 'article' ),
			array( 'property', 'og:title', $meta_title ),
			array( 'property', 'og:description', $meta_description ),
			array( 'property', 'og:image', $img_to_share ),
			array( 'property', 'og:image:width', $images_project_sizes['square-300']['width'] ),
			array( 'property', 'og:image:height', $images_project_sizes['square-300']['height'] ),
			array( 'name', 'twitter:card', 'summary' ),
			array( 'name', 'twitter:url', $url ),
			array( 'name', 'twitter:title', $meta_title ),
			array( 'name', 'twitter:description', $meta_description ),
			array( 'name', 'twitter:image', $img_to_share )
		);
		
		foreach ($metasDatas as $meta) {
			echo '<meta '.$meta[0].'="'.$meta[1].'" content="'.$meta[2].'" />'.PHP_EOL;
		}

	};


/*=====  FIN Metas SEO & social  =====*/