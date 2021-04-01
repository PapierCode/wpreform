<?php 
/**
 * 
 * Template : header
 * 
 ** Hooks
 ** Contenu des hooks
 * 
 */

/*=============================
=            Hooks            =
=============================*/

add_action( 'pc_header', 'pc_display_skip_nav', 10 );

add_action( 'pc_header', 'pc_display_body_inner_start', 20 );

	add_action( 'pc_header', 'pc_display_header_start', 30 );

		add_action( 'pc_header', 'pc_display_header_logo', 40 );
		add_action( 'pc_header', 'pc_display_nav_button_open_close', 50 );
		add_action( 'pc_header', 'pc_display_header_nav', 60 );

	add_action( 'pc_header', 'pc_display_header_end', 70 );

	add_action( 'pc_header', 'pc_display_nav_overlay', 80 );


/*=====  FIN Hooks  =====*/

/*=========================================
=            Contenu des hooks            =
=========================================*/

/*----------  Accès direct  ----------*/

function pc_display_skip_nav() {
	
	$skip_nav_list = apply_filters( 'pc_filter_skip_nav', array(
		'#header-nav' => array( 'Navigation principale', 'Accès direct à la navigation principale' ),
		'#main' => array( 'Contenu de la page', 'Accès direct au contenu' ),
		'#footer-nav' => array( 'Navigation du pied de page', 'Accès direct à la navigation du pied de page' )
	) );
	
	echo '<ul class="skip-nav no-print">';
		if( !is_home() ) { echo '<li><a href="'.get_bloginfo('url').'" title="Retour à la page d\'accueil">Accueil</a></li>'; }
		foreach ( $skip_nav_list as $anchor => $texts ) {
			echo '<li><a href="'.$anchor.'" title="'.$texts[1].'">'.$texts[0].'</a></li>';
		}
	echo '</ul>';

}


/*----------  Début du container body  ----------*/

function pc_display_body_inner_start() {

	echo '<div class="body-inner">';

}


/*----------  Début de l'entête  ----------*/

function pc_display_header_start() {

	echo '<header class="header"><div class="header-inner">';

}


/*----------  Logo  ----------*/

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


/*----------  Bouton menu  ----------*/

function pc_display_nav_button_open_close() {

	echo '<div class="h-nav-btn-box"><button type="button" title="Ouvrir/fermer le menu" class="h-nav-btn js-h-nav reset-btn" aria-hidden="true" tabindex="-1"><span class="h-nav-btn-ico"><span class="h-nav-btn-ico h-nav-btn-ico--inner"></span></span><span class="h-nav-btn-txt">Menu</span></button></div>';

}


/*----------  Navigation  ----------*/

function pc_display_header_nav() {

	echo '<nav id="header-nav" class="h-nav"><div class="h-nav-inner">';
		
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


/*----------  Fin de l'entête  ----------*/

function pc_display_header_end() {

	echo '</div></header>';

}


/*----------  Overlay navigation  ----------*/

function pc_display_nav_overlay() {

	echo '<button type="button" title="Fermer le menu" class="btn-overlay reset-btn js-h-nav" aria-hidden="true" tabindex="-1"><span class="visually-hidden">Fermer le menu</span></button>';

}

/*----------  Réseaux sociaux  ----------*/

add_action( 'pc_header_nav_list_after', 'pc_display_header_social', 10 );

	function pc_display_header_social() {

		pc_display_social_links( 'social-list--header' );

	}


/*=====  FIN Contenu des hooks  =====*/