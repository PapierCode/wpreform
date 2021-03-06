<?php
/**
*
* Contenu de la balise head
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

	$css_classes = array();

	// type de page
	if ( is_home() ) { $css_classes[] = 'is-home'; }
	else if ( is_page() ) {	$css_classes[] = 'is-page'; }
	else if ( is_404() ) { $css_classes[] = 'is-404'; }

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

		global $images_project_sizes; // tailles d'images déclarées
		global $settings_project; // config projet
		global $texts_lengths; // limites de textes

		// réutilisable
		global $seo_metas;

		// url de la page en cours
		$url = 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		
		// défaut
		$seo_metas = array(
			'title' => $settings_project['coord-name'],
			'description' => $settings_project['seo-desc'],
			'img' => pc_get_img_default_to_share()[0]
		);


		/*============================================
		=            Accueil / Page / 404            =
		============================================*/

		if ( is_home() ) {

			// contenu home
			$home_metas = get_option('home-settings-option');

			// titre
			$seo_metas['title'] = ( isset( $home_metas['seo-title'] ) && '' != $home_metas['seo-title'] ) ? $home_metas['seo-title'] : $home_metas['content-title'];

			// description
			$seo_metas['description'] = ( isset( $home_metas['seo-desc'] ) && '' != $home_metas['seo-desc'] ) ? $home_metas['seo-desc'] : wp_trim_words( $home_metas['content-txt'], $texts_lengths['excerpt'], '...' );

			// visuel
			if ( isset( $home_metas['visual-id'] ) && '' != $home_metas['visual-id'] && is_object( get_post( $home_metas['visual-id'] ) ) ) {
				$seo_metas['img'] = wp_get_attachment_image_src($home_metas['visual-id'],'share')[0];
			}


		} elseif ( is_singular() ) {

			$post_id = get_the_ID();
			$post_metas = get_post_meta( $post_id );

			// metas title & description
			$seo_metas = pc_get_post_seo_metas( $seo_metas, $post_id, $post_metas );


		} elseif ( is_404() ) {

			// metas title & description
			$seo_metas['title'] = 'Page non trouvée - '.$settings_project['coord-name'];
			$seo_metas['description'] = 'Désolé, cette page n\'existe pas ou a été supprimée.';
			
		}


		/*=====  FIN Accueil / Page / 404  =====*/

		/*==============================
		=            Filtre            =
		==============================*/
			
		$seo_metas = apply_filters( 'pc_filter_seo_metas', $seo_metas );
		
		
		/*=====  FIN Filtre  =====*/

		/*=================================
		=            Affichage            =
		=================================*/

		echo '<title>'.$seo_metas['title'].'</title>';
		
		$head_metas_datas = array(
			array( 'name',	'description', $seo_metas['description'] ),
			array( 'property', 'og:url', $url ),
			array( 'property', 'og:type', 'article' ),
			array( 'property', 'og:title',$seo_metas['title'] ),
			array( 'property', 'og:description', $seo_metas['description'] ),
			array( 'property', 'og:image', $seo_metas['img'] ),
			array( 'property', 'og:image:width', $images_project_sizes['share']['width'] ),
			array( 'property', 'og:image:height', $images_project_sizes['share']['height'] ),
			array( 'name', 'twitter:card', 'summary' ),
			array( 'name', 'twitter:url', $url ),
			array( 'name', 'twitter:title', $seo_metas['title'] ),
			array( 'name', 'twitter:description', $seo_metas['description'] ),
			array( 'name', 'twitter:image', $seo_metas['img'] )
		);
		
		foreach ( $head_metas_datas as $meta ) {
			echo '<meta '.$meta[0].'="'.$meta[1].'" content="'.$meta[2].'" />';
		}
			
		
		/*=====  FIN Affichage  =====*/

	};


/*=====  FIN Metas SEO & social  =====*/

/*===============================
=            Favicon            =
===============================*/

add_action( 'wp_head', 'pc_display_favicon', 6 );

	function pc_display_favicon() {

		// défaut
		$url = get_bloginfo( 'template_directory' ).'/images/favicon.jpg';
		// pour modifier
		$url = apply_filters( 'pc_filter_favicon', $url );
		// affichage
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