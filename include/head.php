<?php
/**
*
* Contenu de la balise head
*
** Classe CSS sur la balsie HTML
** Fichiers CSS
** Favicon
** Metas SEO & social
*
**/

/*=====================================================
=            Classe CSS sur la balise HTML            =
=====================================================*/

function pc_html_css_class() {

	// thème
	global $settings_project;
	$class = array('theme-'.$settings_project['theme']);
	if ( $settings_project['is-fullscreen'] ) { $class[] = 'is-fullscreen'; }
	// type de page
	if ( is_home() ) { $class[] = 'is-home'; }
	else if ( is_page() ) {	$class[] = 'is-page'; }
	else if ( is_404() ) { $class[] = 'is-404'; }
	// pour modifier
	$class = apply_filters( 'pc_filter_html_css_class', $class );
	// retour
	return implode( ' ', $class );

}


/*=====  FIN Classe CSS sur la balise HTML  =====*/

/*==========================================
=            Metas SEO & social            =
==========================================*/

add_action( 'wp_head', 'pc_metas_seo_and_social', 5 );

	function pc_metas_seo_and_social() {

		global $images_project_sizes; // tailles d'images déclarées
		global $settings_project; // config projet

		// réutilisable
		global $meta_title;
		global $meta_description;
		global $img_to_share;

		// css suivant contenu
		$css_custom = '';

		// url de la page en cours
		$url = 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		
		// défaut
		$img_to_share		= pc_get_img_default_url_to_share();
		$meta_title 		= $settings_project['coord-name'];
		$meta_description 	= $settings_project['micro-desc'];


		/*----------  home.php  ----------*/

		if ( is_home() ) {

			// contenu home
			$settings_home = get_option('home-settings-option');

			// titre
			$meta_title = ( isset( $settings_home['seo-title'] ) && $settings_home['seo-title'] != '' ) ? $settings_home['seo-title'] : $settings_home['content-title'];
			// description
			$meta_description = ( isset( $settings_home['seo-desc'] ) && $settings_home['seo-desc'] != '' ) ? $settings_home['seo-desc'] : wp_trim_words($settings_home['content-txt'],30,'...');
			
			// visuel
			if ( isset($settings_home['visual-img']) && $settings_home['visual-img'] != '' ) {
				$img_to_share = wp_get_attachment_image_src($settings_home['visual-img'],'share')[0];
				if ( $settings_project['theme'] == 'fullscreen' ) { $css_custom .= pc_fs_main_header_css_bg($settings_home['visual-img']); }
			}


		/*----------  page.php  ----------*/

		} elseif ( is_page() ) {

			$post_id = get_the_id();
			$page_metas = get_post_meta( $post_id );

			// titre
			$meta_title = ( isset( $page_metas['seo-title'] ) ) ? $page_metas['seo-title'][0] : get_the_title($post_id);
			// description
			if ( isset( $page_metas['seo-desc'] ) ) {
				$meta_description = $page_metas['seo-desc'][0];
			}
			else if ( isset( $page_metas['resum-desc'] ) ) {
				$meta_description = $page_metas['resum-desc'][0];
			} else {
				$meta_description = get_the_excerpt($post_id);
			}
			
			// visuel
			if ( isset( $page_metas['thumbnail-img'] ) ) {
				$img_to_share = wp_get_attachment_image_src($page_metas['thumbnail-img'][0],'share')[0];
				if ( $settings_project['theme'] == 'fullscreen' ) { $css_custom .= pc_fs_main_header_css_bg($page_metas['thumbnail-img'][0]); }
			}


		/*----------  404.php  ----------*/

		} elseif ( is_404() ) {

			// metas title & description
			$meta_title = 'Page non trouvée - '.$settings_project['coord-name'];
			$meta_description = 'Désolé, cette page n\'existe pas ou a été supprimée.';
			
		}


		/*----------  Affichage métas  ----------*/
		
		$meta_title = apply_filters( 'pc_filter_meta_title', $meta_title );
		$meta_description = apply_filters( 'pc_filter_meta_description', $meta_description );
		$img_to_share = apply_filters( 'pc_filter_img_to_share', $img_to_share );

		echo '<title>'.$meta_title.'</title>'.PHP_EOL;
		
		$metasDatas = array(
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
		
		foreach ($metasDatas as $meta) {
			echo '<meta '.$meta[0].'="'.$meta[1].'" content="'.$meta[2].'" />'.PHP_EOL;
		}


		/*----------  CSS custom  ----------*/
		
		$css_custom = apply_filters( 'pc_filter_css_custom', $css_custom );
		if ( $css_custom != '' ) { echo '<style>'.$css_custom.'</style>'; }

	};


/*=====  FIN Metas SEO & social  =====*/

/*====================================
=            Fichiers CSS            =
====================================*/

add_action( 'wp_enqueue_scripts', 'pc_enqueue_preform_style', 5 );

    function pc_enqueue_preform_style() {

		/*----------  Print  ----------*/
    
		wp_enqueue_style( 'preform-print-style', get_template_directory_uri().'/print.css', null, null, 'print' );


		/*----------  Screen  ----------*/

		wp_enqueue_style( 'preform-style', get_template_directory_uri().'/style.css', null, null, 'screen' );

		global $settings_project;
		if ( $settings_project['theme'] == 'fullscreen' ) {
			wp_enqueue_style( 'preform-fullscreen-style', get_template_directory_uri().'/v-fullscreen.css', null, null, 'screen' );
		} else {
			wp_enqueue_style( 'preform-classic-style', get_template_directory_uri().'/v-classic.css', null, null, 'screen' );
		}


	}


/*=====  FIN Fichiers CSS  =====*/

/*===============================
=            Favicon            =
===============================*/

add_action( 'wp_head', 'pc_favicon', 5 );

	function pc_favicon() {

		// défaut
		$url = get_bloginfo( 'template_directory' ).'/images/favicon.png';
		// pour modifier
		$url = apply_filters( 'pc_filter_favicon', $url );
		// affichage
		echo '<link rel="icon" type="image/png" href="'.$url.'" />';

	};


/*=====  FIN Favicon  =====*/

/*====================================
=            Statistiques            =
====================================*/

add_action( 'wp_head', 'pc_statistics_tracker', 20 );

	function pc_statistics_tracker() {

		global $settings_pc;

		if ( $settings_pc['matomo-analytics-code'] != '' ) {

			pc_display_tag_matomo( $settings_pc['matomo-analytics-code'] );

		}

	};


/*=====  FIN Statistiques  =====*/