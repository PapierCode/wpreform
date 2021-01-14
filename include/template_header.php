<?php 
/**
 * 
 * Template header
 * 
 ** Hooks
 ** Contenu des hooks
 * 
 */

/*=============================
=            Hooks            =
=============================*/

add_action( 'pc_body_start', 'pc_display_body_inner_start', 10 );

add_action( 'pc_header_start', 'pc_display_header_start', 10 );

add_action( 'pc_header_logo', 'pc_display_header_logo', 10 );
add_action( 'pc_header_nav', 'pc_display_header_nav', 10 );

add_action( 'pc_header_end', 'pc_display_header_end', 10 );
add_action( 'pc_header_end', 'pc_display_nav_overlay', 20 );


/*=====  FIN Hooks  =====*/

/*=========================================
=            Contenu des hooks            =
=========================================*/

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

			$img_datas = array(
				'url' => get_bloginfo('template_directory').'/images/logo.svg',
				'width' => 150,
				'height' => 150,
				'alt' => 'Logo '.$settings_project['coord-name']
			);
			$img_datas = apply_filters( 'pc_filter_header_logo_img_datas', $img_datas );

			$img_tag = '<img class="h-logo-img" src="'.$img_datas['url'].'" alt="'.$img_datas['alt'].'" width="'.$img_datas['width'].'" height="'.$img_datas['height'].'" loading="lazy" />';
			$img_tag = apply_filters( 'pc_filter_header_logo_img_tag', $img_tag, $img_datas );
			
			echo $img_tag;

		echo '</a>';

		echo '<div class="h-nav-btn-box"><button type="button" title="Ouvrir/fermer le menu" class="h-nav-btn js-h-nav reset-btn" aria-hidden="true" tabindex="-1"><span class="h-nav-btn-ico"><span class="h-nav-btn-ico h-nav-btn-ico--inner"></span></span><span class="h-nav-btn-txt">Menu</span></button></div>';

	echo '</div>';

}


/*----------  Navigation  ----------*/

function pc_display_header_nav() {

	echo '<nav id="header-nav" class="h-nav"><div class="h-nav-inner">';
		
		do_action( 'pc_header_nav_inner_before' );

		$nav_args = array(
			'theme_location'  	=> 'nav-header',
			'nav_prefix'		=> array('h-nav', 'h-p-nav'), // custom
			'menu_class'      	=> 'h-nav-list h-nav-list--l1 h-p-nav-list h-p-nav-list--l1 reset-list',
			'items_wrap'      	=> '<ul class="%2$s">%3$s</ul>',
			'depth'           	=> 1,
			'container'       	=> '',
			'item_spacing'		=> 'discard',
			'fallback_cb'     	=> false,
			'walker'          	=> new Pc_Walker_Nav_Menu()
		);
		wp_nav_menu( $nav_args ); // + include/navigation.php
		
		do_action( 'pc_header_nav_inner_after' );

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

add_action( 'pc_header_nav_inner_after', 'pc_display_header_social', 10);

	function pc_display_header_social() {

		pc_display_social_links( 'social-list--header' );

	}


/*=====  FIN Contenu des hooks  =====*/