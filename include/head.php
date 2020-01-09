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
	else if ( is_singular( NEWS_POST_SLUG ) ) { $class = 'is-news'; }
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

		global $imgSizes; // tailles d'images déclarées, cf. templates/_templates_images.php
		global $projectSettings; // config projet, cf. functions.php

		// url de la page en cours
		$url		= 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		
		// défaut
		$image			= get_bloginfo( 'template_directory' ).'/images/logo.jpg';
		$title 			= $projectSettings['coord-name'];
		$description 	= $projectSettings['micro-desc'];


		/*----------  home.php  ----------*/

		if ( is_home() ) {

			// contenu home
			$homeSettings = get_option('home-settings-option');

			// titre
			$title = ( isset( $homeSettings['seo-title'] ) && trim($homeSettings['seo-title']) != '' ) ? $homeSettings['seo-title'] : trim($homeSettings['content-title']).' - '.trim($projectSettings['coord-name']);
			// description
			$description = ( isset( $homeSettings['seo-desc'] ) && trim($homeSettings['seo-desc']) != '' ) ? $homeSettings['seo-desc'] : wp_trim_words($homeSettings['content-intro'],30,'...');
			
			// visuel
			if ( isset( $homeSettings['seo-img'] ) && $homeSettings['seo-img'] != '' ) {
				$imageDatas = pc_get_img($homeSettings['seo-img'],'share','datas');
				$image = $imageDatas[0];
			}


		/*----------  page.php & single-news.php  ----------*/

		} elseif ( is_page() || is_singular( NEWS_POST_SLUG ) ) {

			// custom fields
			$postId = get_the_id();
			$postMetas = get_post_meta( $postId );

			// titre
			$title = ( isset( $postMetas['seo-title'] ) ) ? $postMetas['seo-title'][0] : get_the_title($postId).' - '.trim($projectSettings['coord-name']);
			// description
			$description = ( isset( $postMetas['seo-desc'] ) ) ? $postMetas['seo-desc'][0] : get_the_excerpt($postId);
			
			// visuel
			if ( isset( $postMetas['thumbnail-img'] ) ) {
				$imageDatas = pc_get_img($postMetas['thumbnail-img'][0],'share','datas');
				$image = $imageDatas[0];
			}


		/*----------  404.php  ----------*/

		} elseif ( is_404() ) {

			// metas title & description
			$title = 'Page non trouvée - '.trim($projectSettings['coord-name']);
			$description = 'Désolé, cette page n\'existe pas ou a été supprimée.';
			
		}


		/*----------  Affichage  ----------*/

		echo '<title>'.$title.'</title>'.PHP_EOL;
		
		$metasDatas = array(
			array( 'name',	'description', $description ),
			array( 'property', 'og:url', $url ),
			array( 'property', 'og:type', 'article' ),
			array( 'property', 'og:title', $title ),
			array( 'property', 'og:description', $description ),
			array( 'property', 'og:image', $image ),
			array( 'property', 'og:image:width', $imgSizes['share']['width'] ),
			array( 'property', 'og:image:height', $imgSizes['share']['height'] ),
			array( 'name', 'twitter:card', 'summary' ),
			array( 'name', 'twitter:url', $url ),
			array( 'name', 'twitter:title', $title ),
			array( 'name', 'twitter:description', $description ),
			array( 'name', 'twitter:image', $image )
		);
		
		foreach ($metasDatas as $meta) {
			echo '<meta '.$meta[0].'="'.$meta[1].'" content="'.$meta[2].'" />'.PHP_EOL;
		}

	};


/*=====  FIN Metas SEO & social  =====*/