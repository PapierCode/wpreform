<?php 
/**
 * 
 * Template : header
 * 
 ** Hooks
 ** Layout
 ** Logo
 ** Navigation
 ** Tools
 ** Recherche
 * 
 */


/*=============================
=            Hooks            =
=============================*/

add_action( 'pc_header', 'pc_display_skip_nav', 10 );

add_action( 'pc_header', 'pc_display_body_inner_start', 20 );

	add_action( 'pc_header', 'pc_display_header_start', 40 );

		add_action( 'pc_header', 'pc_display_header_logo', 50 );
		add_action( 'pc_header', 'pc_display_nav_button_open_close', 60 );
		add_action( 'pc_header', 'pc_display_header_nav', 70 );
		add_action( 'pc_header', 'pc_display_header_tools', 80 );

	add_action( 'pc_header', 'pc_display_header_end', 90 );

	add_action( 'pc_header', 'pc_display_nav_overlay', 100 );


/*=====  FIN Hooks  =====*/

/*=====================================
=            Accès directs            =
=====================================*/

function pc_display_skip_nav() {
	
	$skip_nav_list = array();

	global $settings_pc;
	if ( isset( $settings_pc['wpreform-search']) ) {
		if ( is_search() ) {
			$skip_nav_list['#form-search'] = 'Formulaire de recherche';
			global $wp_query;
			if ( '' != get_search_query() && $wp_query->found_posts > 0 ) {
				$skip_nav_list['#search-results'] = 'Résultats de recherche';
			}
		} else {
			$skip_nav_list[get_bloginfo('url').'/?s'] = 'Page de recherche';
		}
	}

	if( !is_home() ) { $skip_nav_list[get_bloginfo('url')] = 'Page d\'accueil'; }
	
	$skip_nav_list = $skip_nav_list + array(
		'#header-nav' => 'Navigation principale',
		'#main' => 'Contenu de la page',
		'#footer-nav' => 'Navigation du pied de page'
	);

	$skip_nav_list = apply_filters( 'pc_filter_skip_nav', $skip_nav_list );

	echo '<nav class="skip-nav no-print" role="navigation" aria-label="Liens d\'accès rapides"><ul class="skip-nav-list reset-list">';
		foreach ( $skip_nav_list as $anchor => $text ) {
			echo '<li><a href="'.$anchor.'">'.$text.'</a></li>';
		}
	echo '</ul></nav>';

}


/*=====  FIN Accès directs  =====*/

/*==============================
=            Layout            =
==============================*/

/*----------  Début de l'entête  ----------*/

function pc_display_header_start() {

	echo apply_filters( 'pc_filter_header_start', '<header class="header" role="banner"><div class="header-inner">' );

}

function pc_display_header_end() {

	echo apply_filters( 'pc_filter_header_end', '</div></header>' );

}


/*=====  FIN Layout  =====*/

/*============================
=            Logo            =
============================*/

function pc_display_header_logo() {
	
	global $settings_project;

	echo '<div class="h-logo">';
		
		if ( !is_home() ) {
			$link_datas = apply_filters( 'pc_filter_header_logo_url', array(
				'href' => get_bloginfo('url'),
				'title' => 'Page d\'accueil'
			) );
			echo '<a href="'.$link_datas['href'].'" class="h-logo-link" title="'.$link_datas['title'].'">';
		}

			$logo_datas = apply_filters( 'pc_filter_header_logo_img_datas', array(
				'url' => get_bloginfo('template_directory').'/images/logo.svg',
				'width' => 150,
				'height' => 150,
				'alt' => $settings_project['coord-name']
			) );

			$logo_tag = '<img class="h-logo-img" src="'.$logo_datas['url'].'" alt="'.$logo_datas['alt'].'" width="'.$logo_datas['width'].'" height="'.$logo_datas['height'].'" loading="lazy" />';
			$logo_tag = apply_filters( 'pc_filter_header_logo_img_tag', $logo_tag, $logo_datas );
			
			echo $logo_tag;

		if ( !is_home() ) { echo '</a>'; }

	echo '</div>';

}


/*=====  FIN Logo  =====*/

/*==================================
=            Navigation            =
==================================*/

/*----------  Bouton menu  ----------*/

function pc_display_nav_button_open_close() {

	echo '<div class="h-nav-btn-box no-print"><button type="button" title="Ouvrir/fermer le menu" id="header-nav-btn" class="h-nav-btn reset-btn" aria-controls="header-nav" aria-expanded="false"><span class="txt">Menu</span><span class="h-nav-btn-ico"><span class="h-nav-btn-ico h-nav-btn-ico--inner"></span></span></button></div>';

}


/*----------  Navigation  ----------*/

function pc_display_header_nav() {

	echo '<nav id="header-nav" class="h-nav" role="navigation" aria-label="Navigation principale"><div class="h-nav-inner">';
		
		do_action( 'pc_header_nav_list_before' );

		$nav_args = apply_filters( 'pc_filter_header_nav_list_args', array(
			'theme_location'  	=> 'nav-header',
			'nav_prefix'		=> array('h-nav', 'h-p-nav'), // custom
			'menu_class'      	=> 'h-nav-list h-nav-list--l1 h-p-nav-list h-p-nav-list--l1 reset-list',
			'items_wrap'      	=> '<ul class="%2$s">%3$s</ul>',
			'depth'           	=> 1,
			'container'       	=> '',
			'item_spacing'		=> 'discard',
			'fallback_cb'     	=> false,
			'walker'          	=> new Pc_Walker_Nav_Menu()
		) );

		wp_nav_menu( $nav_args ); // + include/navigation.php
		
		do_action( 'pc_header_nav_list_after' );

	echo '</div></nav>';

}

/*----------  Réseaux sociaux  ----------*/

add_action( 'pc_header_nav_list_after', 'pc_display_header_social', 10 );

	function pc_display_header_social() {

		pc_display_social_links( 'social-list--header' );

	}


/*----------  Overlay navigation  ----------*/

function pc_display_nav_overlay() {

	if ( apply_filters( 'pc_filter_nav_overlay_display', false ) ) {
		echo '<button type="button" title="Fermer le menu" class="btn-overlay reset-btn js-button-h-nav no-print" aria-hidden="true" tabindex="-1"><span class="visually-hidden">Fermer le menu</span></button>';
	}

}


/*=====  FIN Navigation  =====*/

/*=============================
=            Tools            =
=============================*/

function pc_display_header_tools() {

	$items = array();

	global $settings_pc;
	if ( isset( $settings_pc['wpreform-search']) ) {
		$search_ico = apply_filters( 'pc_filter_header_tools_search_icon', pc_svg( 'zoom' ) );
		$items['search'] = array(
			'attrs' => '',
			'html' => '<a href="'.get_bloginfo('url').'/?s" title="Page de recherche" class="h-tools-link"><span class="txt">Recherche</span><span class="ico">'.$search_ico.'</span></a>'
		);
	}

	$items = apply_filters( 'pc_filter_header_tools', $items );

	if ( count( $items ) > 0 ) {

		echo '<nav class="h-tools"><div class="h-tools-inner"><ul class="h-tools-list reset-list">';

			foreach ( $items as $id => $args ) {
				echo '<li class="h-tools-item h-tools-item--'.$id.'" '.$args['attrs'].'>'.$args['html'].'</li>';
			}

		echo '</ul></div></nav>';

	}

}


/*=====  FIN Tools  =====*/