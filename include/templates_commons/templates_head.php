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

function pc_get_post_seo_metas( $post_seo_metas, $post_id, $post_metas ) {

	// titre
	if ( isset( $post_metas['seo-title'] ) && '' != $post_metas['seo-title'][0] ) {
		
		$post_seo_metas['title'] = $post_metas['seo-title'][0];

	} else if ( isset( $post_metas['resum-title'] ) && '' != $post_metas['resum-title'][0] ) {

		$post_seo_metas['title'] = $post_metas['resum-title'][0];

	} else {

		$post_seo_metas['title'] = get_the_title($post_id);

	}

	// description
	$post_seo_metas['description'] = pc_get_page_excerpt( $post_id, $post_metas, true );

	// visuel
	if ( isset( $post_metas['visual-id'] ) && is_object( get_post( $post_metas['visual-id'][0] ) ) ) {
		$post_seo_metas['img'] = wp_get_attachment_image_src($post_metas['visual-id'][0],'share')[0];
	}

	return $post_seo_metas;

}

add_action( 'wp_head', 'pc_metas_seo_and_social', 5 );

	function pc_metas_seo_and_social() {

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
			'description' => $settings_project['micro-desc'],
			'img' => pc_get_img_default_to_share()[0]
		);
		
		$css_custom = '';


		/*============================================
		=            Accueil / Page / 404            =
		============================================*/

		if ( is_home() ) {

			// contenu home
			$home_metas = get_option('home-settings-option');

			// titre
			$seo_metas['title'] = ( isset( $home_metas['seo-title'] ) && $home_metas['seo-title'] != '' ) ? $home_metas['seo-title'] : $home_metas['content-title'];

			// description
			$seo_metas['description'] = ( isset( $home_metas['seo-desc'] ) && $home_metas['seo-desc'] != '' ) ? $home_metas['seo-desc'] : wp_trim_words( $home_metas['content-txt'], $texts_lengths['excerpt'], '...' );

			// visuel
			if ( isset( $home_metas['visual-id'] ) && $home_metas['visual-id'] != '' && is_object( get_post( $home_metas['visual-id'] ) ) ) {
				$seo_metas['img'] = wp_get_attachment_image_src($home_metas['visual-id'],'share')[0];
			}


		} elseif ( is_page() ) {

			$post_id = get_the_id();
			$post_metas = get_post_meta( $post_id );

			// metas title & description
			$seo_metas = pc_get_post_seo_metas( $seo_metas, $post_id, $post_metas );


		} elseif ( is_404() ) {

			// metas title & description
			$seo_metas['title'] = 'Page non trouvée - '.$settings_project['coord-name'];
			$seo_metas['description'] = 'Désolé, cette page n\'existe pas ou a été supprimée.';
			
		}


		/*=====  FIN Accueil / Page / 404  =====*/

		/*===============================
		=            Filtres            =
		===============================*/
			
		$seo_metas = apply_filters( 'pc_filter_seo_metas', $seo_metas );
		$css_custom = apply_filters( 'pc_filter_css_custom', $css_custom );
		
		
		/*=====  FIN Filtres  =====*/

		/*=====================================================
		=            Affichage métas et CSS inline            =
		=====================================================*/

			/*----------  Affichage métas  ----------*/

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