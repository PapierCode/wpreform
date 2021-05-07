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

	add_action( 'pc_header', 'pc_display_header_form_search', 25 );

	add_action( 'pc_header', 'pc_display_header_start', 30 );

		add_action( 'pc_header', 'pc_display_header_logo', 40 );
		add_action( 'pc_header', 'pc_display_nav_button_open_close', 50 );
		add_action( 'pc_header', 'pc_display_header_nav', 60 );
		add_action( 'pc_header', 'pc_display_header_tools', 60 );

	add_action( 'pc_header', 'pc_display_header_end', 70 );

	add_action( 'pc_header', 'pc_display_nav_overlay', 80 );


/*=====  FIN Hooks  =====*/

/*=====================================
=            Accès directs            =
=====================================*/

function pc_display_skip_nav() {
	
	$skip_nav_list = array(
		'#header-nav' => array( 'Navigation principale', 'Accès direct à la navigation principale' ),
		'#main' => array( 'Contenu de la page', 'Accès direct au contenu' ),
		'#footer-nav' => array( 'Navigation du pied de page', 'Accès direct à la navigation du pied de page' )
	);

	global $settings_pc;
	if ( isset( $settings_pc['wpreform-search']) ) {
		$skip_nav_list['#form-search'] = array( 'Recherche', 'Accès direct au formulaire de recherche' );
	}

	$skip_nav_list = apply_filters( 'pc_filter_skip_nav', $skip_nav_list );

	echo '<ul class="skip-nav no-print">';
		if( !is_home() ) { echo '<li><a href="'.get_bloginfo('url').'" title="Retour à la page d\'accueil">Accueil</a></li>'; }
		foreach ( $skip_nav_list as $anchor => $texts ) {
			echo '<li><a href="'.$anchor.'" title="'.$texts[1].'">'.$texts[0].'</a></li>';
		}
	echo '</ul>';

}


/*=====  FIN Accès directs  =====*/

/*==============================
=            Layout            =
==============================*/

/*----------  Début de l'entête  ----------*/

function pc_display_header_start() {

	echo apply_filters( 'pc_filter_header_start', '<header class="header"><div class="header-inner">' );

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

		echo '<a href="'.get_bloginfo('url').'" class="h-logo-link" title="Accueil '.$settings_project['coord-name'].'">';

			$logo_datas = array(
				'url' => get_bloginfo('template_directory').'/images/logo.svg',
				'width' => 150,
				'height' => 150,
				'alt' => 'Logo '.$settings_project['coord-name']
			);
			$logo_datas = apply_filters( 'pc_filter_header_logo_img_datas', $logo_datas );

			$logo_tag = '<img class="h-logo-img" src="'.$logo_datas['url'].'" alt="'.$logo_datas['alt'].'" width="'.$logo_datas['width'].'" height="'.$logo_datas['height'].'" loading="lazy" />';
			$logo_tag = apply_filters( 'pc_filter_header_logo_img_tag', $logo_tag, $logo_datas );
			
			echo $logo_tag;

		echo '</a>';

	echo '</div>';

}


/*=====  FIN Logo  =====*/

/*==================================
=            Navigation            =
==================================*/

/*----------  Bouton menu  ----------*/

function pc_display_nav_button_open_close() {

	echo '<div class="h-nav-btn-box no-print"><button type="button" title="Ouvrir/fermer le menu" class="h-nav-btn js-button-h-nav reset-btn" aria-hidden="true" tabindex="-1"><span class="txt">Menu</span><span class="h-nav-btn-ico"><span class="h-nav-btn-ico h-nav-btn-ico--inner"></span></span></button></div>';

}


/*----------  Navigation  ----------*/

function pc_display_header_nav() {

	echo '<nav id="header-nav" class="h-nav js-overlay-h-nav"><div class="h-nav-inner">';
		
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
		$items['search'] = array(
			'attrs' => 'aria-hidden="true"',
			'html' => '<button type="button" title="Ouvrir/fermer la recherche" class="reset-btn js-button-search h-tools-link" aria-hidden="true"><span class="txt">Recherche</span><span class="ico">'.pc_svg( 'zoom' ).'</span></button>'
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

/*=================================
=            Recherche            =
=================================*/

function pc_display_header_form_search() {

	global $settings_pc;
	if ( isset( $settings_pc['wpreform-search']) ) {

		echo '<div class="form-search-box no-print"><div class="form-search-box-inner">';
			pc_display_form_search();
		echo '</div></div>';

	}

}


/*=====  FIN Recherche  =====*/