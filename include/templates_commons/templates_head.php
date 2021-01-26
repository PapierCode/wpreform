<?php
/**
*
* Contenu de la balise head
*
** Classe CSS sur la balise HTML
** Metas SEO & social, CSS inline
** CSS d'impression
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

	// fullscreen
	$css_classes = pc_fullscreen_edit_html_css_class( $css_classes );

	// pour modifier
	$css_classes = apply_filters( 'pc_filter_html_css_class', $css_classes );

	// retour
	return implode( ' ', $css_classes );

}


/*=====  FIN Classe CSS sur la balise HTML  =====*/

/*======================================================
=            Metas SEO & social, CSS inline            =
======================================================*/

add_action( 'wp_head', 'pc_metas_seo_and_social', 5 );

	function pc_metas_seo_and_social() {

		global $images_project_sizes; // tailles d'images déclarées
		global $settings_project; // config projet
		global $texts_lengths; // limites de textes

		// réutilisable
		global $meta_title, $meta_description, $img_to_share;

		// url de la page en cours
		$url = 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		
		// défaut
		$img_to_share		= pc_get_img_default_to_share()[0];
		$meta_title 		= $settings_project['coord-name'];
		$meta_description 	= $settings_project['micro-desc'];
		
		$post_metas		 	= '';
		$css_custom 		= '';


		/*============================================
		=            Accueil / Page / 404            =
		============================================*/

			if ( is_home() ) {

				// contenu home
				$post_metas = get_option('home-settings-option');

				// titre
				$meta_title = ( isset( $post_metas['seo-title'] ) && $post_metas['seo-title'] != '' ) ? $post_metas['seo-title'] : $post_metas['content-title'];

				// description
				$meta_description = ( isset( $post_metas['seo-desc'] ) && $post_metas['seo-desc'] != '' ) ? $post_metas['seo-desc'] : wp_trim_words( $post_metas['content-txt'], $texts_lengths['excerpt'], '...' );

				// visuel
				if ( isset($datas['visual-id']) && $datas['visual-id'] != '' ) {
					$img_to_share = wp_get_attachment_image_src($datas['visual-id'],'share')[0];
				}

			} elseif ( is_page() ) {

				$post_id = get_the_id();
				$post_metas = get_post_meta( $post_id );

				// titre
				$meta_title = ( isset( $post_metas['seo-title'] ) ) ? $post_metas['seo-title'][0] : get_the_title($post_id);

				// description
				$meta_description = pc_get_page_excerpt( $post_id, $post_metas, true );

				// visuel
				if ( isset( $datas['visual-id'] ) ) {
					$img_to_share = wp_get_attachment_image_src($datas['visual-id'][0],'share')[0];
				}

			} elseif ( is_404() ) {

				// metas title & description
				$meta_title = 'Page non trouvée - '.$settings_project['coord-name'];
				$meta_description = 'Désolé, cette page n\'existe pas ou a été supprimée.';
				
			}


		/*=====  FIN Accueil / Page / 404  =====*/

		/*===============================
		=            Filtres            =
		===============================*/
			
			$meta_title = apply_filters( 'pc_filter_meta_title', $meta_title, $post_metas );
			$meta_description = apply_filters( 'pc_filter_meta_description', $meta_description, $post_metas );
			$img_to_share = apply_filters( 'pc_filter_img_to_share', $img_to_share, $post_metas );
			$css_custom = apply_filters( 'pc_filter_css_custom', $css_custom, $post_metas );
		
		
		/*=====  FIN Filtres  =====*/

		/*=====================================================
		=            Affichage métas et CSS inline            =
		=====================================================*/

			/*----------  Affichage métas  ----------*/

			echo '<title>'.$meta_title.'</title>'.PHP_EOL;
			
			$post_metasDatas = array(
				array( 'name',	'description', $meta_description ),
				array( 'property', 'og:url', $url ),
				array( 'property', 'og:type', 'article' ),
				array( 'property', 'og:title', $meta_title ),
				array( 'property', 'og:description', $meta_description ),
				array( 'property', 'og:image', $img_to_share ),
				array( 'property', 'og:image:width', $images_project_sizes['share']['width'] ),
				array( 'property', 'og:image:height', $images_project_sizes['share']['height'] ),
				array( 'name', 'twitter:card', 'summary' ),
				array( 'name', 'twitter:url', $url ),
				array( 'name', 'twitter:title', $meta_title ),
				array( 'name', 'twitter:description', $meta_description ),
				array( 'name', 'twitter:image', $img_to_share )
			);
			
			foreach ( $post_metasDatas as $meta ) {
				echo '<meta '.$meta[0].'="'.$meta[1].'" content="'.$meta[2].'" />'.PHP_EOL;
			}


			/*----------  CSS custom  ----------*/
			if ( $css_custom != '' ) { echo '<style>'.$css_custom.'</style>'; }
			
		
		/*=====  FIN Affichage métas et CSS inline  =====*/

	};


/*=====  FIN Metas SEO & social, CSS inline  =====*/

/*========================================
=            CSS d'impression            =
========================================*/

add_action( 'wp_enqueue_scripts', 'pc_enqueue_style', 10 );

    function pc_enqueue_style() {

		/*----------  Print  ----------*/
    
		wp_enqueue_style( 'preform-print-style', get_template_directory_uri().'/print.css', null, null, 'print' );


	}


/*=====  FIN CSS d'impression  =====*/

/*===============================
=            Favicon            =
===============================*/

add_action( 'wp_head', 'pc_favicon', 5 );

	function pc_favicon() {

		// défaut
		$url = get_bloginfo( 'template_directory' ).'/images/favicon.jpg';
		// pour modifier
		$url = apply_filters( 'pc_filter_favicon', $url );
		// affichage
		echo '<link rel="icon" type="image/jpg" href="'.$url.'" />';

	};


/*=====  FIN Favicon  =====*/

/*====================================
=            Statistiques            =
====================================*/

add_action( 'wp_head', 'pc_statistics_tracker', 20 );

	function pc_statistics_tracker() {

		global $settings_pc;

		if ( isset($settings_pc['matomo-analytics-code']) && $settings_pc['matomo-analytics-code'] != '' ) {

			pc_display_tag_matomo( $settings_pc['matomo-analytics-code'] );

		}

	};


/*=====  FIN Statistiques  =====*/