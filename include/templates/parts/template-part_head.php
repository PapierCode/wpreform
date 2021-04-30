<?php
/**
*
* Communs templates : head
*
** Classe CSS sur la balise HTML
** Metas SEO & social, CSS inline
** Favicon
** Statistiques
*
**/

/*=====================================================
=            Classe CSS sur la balise HTML            =
=====================================================*/

function pc_get_html_css_class() {

	global $settings_pc;
	$css_classes = array();

	// type de page
	if ( is_home() ) { $css_classes[] = 'is-home'; }
	else if ( is_page() ) {	$css_classes[] = 'is-page'; }
	else if ( is_search() ) { $css_classes[] = 'is-search'; }
	else if ( is_404() ) { $css_classes[] = 'is-404'; }

	// recherche
	if ( isset( $settings_pc['wpreform-search']) ) { $css_classes[] = 'has-search'; }
	// breadcrumb
	if ( isset( $settings_pc['wpreform-breadcrumb']) ) { $css_classes[] = 'has-breadcrumb'; }

	// pour modifier
	$css_classes = apply_filters( 'pc_filter_html_css_class', $css_classes );

	// retour
	return implode( ' ', $css_classes );

}


/*=====  FIN Classe CSS sur la balise HTML  =====*/

/*==========================================
=            Metas SEO & social            =
==========================================*/

add_action( 'wp_head', 'pc_display_metas_seo_and_social', 5 );

	function pc_display_metas_seo_and_social() {

		// défaut
		global $settings_project;
		$metas = array(
			'title' => $settings_project['coord-name'],
			'description' => $settings_project['seo-desc'],
			'image' => pc_get_default_image_to_share(),
			'permalink' => 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]
		);
		

		/*============================================
		=            Accueil / Page / 404            =
		============================================*/

		if ( is_home() ) {

			global $pc_home;			
			$metas = apply_filters( 'pc_filter_home_seo_metas', $pc_home->get_seo_metas(), $pc_home );


		} else if ( is_singular() ) {

			global $pc_post;
			$metas = apply_filters( 'pc_filter_post_seo_metas', $pc_post->get_seo_metas(), $pc_post );


		} elseif ( is_tax() ) {

			global $pc_term;
			$metas = apply_filters( 'pc_filter_term_seo_metas', $pc_term->get_seo_metas(), $pc_term );


		} else if ( is_404() ) {

			global $settings_project;
			$metas = apply_filters( 'pc_filter_404_seo_metas', array(
				'title' => 'Page non trouvée - '.$settings_project['coord-name'],
				'description' => 'Cette page n\'existe pas ou a été supprimée.',
				'image' => $metas['image'],
				'permalink' => $metas['permalink']
			) );
			
		}


		/*=====  FIN Accueil / Page / 404  =====*/

		/*==============================
		=            Filtre            =
		==============================*/
			
		$metas = apply_filters( 'pc_filter_seo_metas', $metas );
		
		
		/*=====  FIN Filtre  =====*/

		/*=================================
		=            Affichage            =
		=================================*/

		echo '<title>'.$metas['title'].'</title>';
		
		$metas_tag_attributs = array(
			array( 'name', 'description', $metas['description'] ),
			array( 'property', 'og:url', $metas['permalink'] ),
			array( 'property', 'og:type', 'article' ),
			array( 'property', 'og:title',$metas['title'] ),
			array( 'property', 'og:description', $metas['description'] ),
			array( 'property', 'og:image', $metas['image'][0] ),
			array( 'property', 'og:image:width', $metas['image'][1] ),
			array( 'property', 'og:image:height', $metas['image'][2] ),
			array( 'name', 'twitter:card', 'summary' ),
			array( 'name', 'twitter:url', $metas['permalink'] ),
			array( 'name', 'twitter:title', $metas['title'] ),
			array( 'name', 'twitter:description', $metas['description'] ),
			array( 'name', 'twitter:image', $metas['image'][0] )
		);
		
		foreach ( $metas_tag_attributs as $attribut ) {
			echo '<meta '.$attribut[0].'="'.$attribut[1].'" content="'.$attribut[2].'" />';
		}
			
		
		/*=====  FIN Affichage  =====*/

	};


/*=====  FIN Metas SEO & social  =====*/

/*===============================
=            Favicon            =
===============================*/

add_action( 'wp_head', 'pc_display_favicon', 6 );

	function pc_display_favicon() {

		$url = apply_filters( 'pc_filter_favicon_url', get_bloginfo( 'template_directory' ).'/images/favicon.jpg' );
		echo '<link rel="icon" type="image/jpg" href="'.$url.'" />';

	};


/*=====  FIN Favicon  =====*/

/*==================================
=            CSS inline            =
==================================*/

add_action( 'wp_head', 'pc_display_css_inline', 7 );

	function pc_display_css_inline() {
		
		$css_inline = apply_filters( 'pc_filter_css_inline', '' );
		if ( '' != $css_inline ) { echo '<style>'.$css_inline.'</style>'; }

	};


/*=====  FIN CSS inline  =====*/

/*====================================
=            Statistiques            =
====================================*/

add_action( 'wp_head', 'pc_display_matomo_tracker', 20 );

	function pc_display_matomo_tracker() {

		global $settings_pc;

		if ( isset($settings_pc['matomo-analytics-code']) && '' != $settings_pc['matomo-analytics-code'] ) {

			pc_display_tag_matomo( $settings_pc['matomo-analytics-code'] );

		}

	};


/*=====  FIN Statistiques  =====*/