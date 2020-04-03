<?php 
/**
 * 
 * Fonctions pour les templates : entête (header)
 * 
 */

/*=============================
=            Hooks            =
=============================*/

add_action( 'pc_header_start', 'pc_display_header_start', 10 );

add_action( 'pc_header_logo', 'pc_display_header_logo', 10 );
add_action( 'pc_header_nav', 'pc_display_header_nav', 10 );

add_action( 'pc_header_end', 'pc_display_header_end', 10 );
add_action( 'pc_header_end', 'pc_display_nav_overlay', 20 );


/*=====  FIN Hooks  =====*/

function pc_display_header_start() {

	echo '<header class="header layout"><div class="header-inner cl-bloc fs-bloc">';

}

function pc_display_header_logo() {

	echo '<div class="h-logo">';

		echo '<a href="'.get_bloginfo('url').'" class="h-logo-link" title="Accueil '.get_bloginfo('name').'">';

			global $settings_project;
			$logo_header_datas = array(
				'url' => get_bloginfo('template_directory').'/images/logo.svg',
				'width' => 150,
				'height' => 150,
				'alt' => 'Logo '.$settings_project['coord-name']
			);
			$logo_header_datas = apply_filters( 'pc_filter_header_logo', $logo_header_datas );

			echo '<img class="h-logo-img" src="'.$logo_header_datas['url'].'" alt="'.$logo_header_datas['alt'].'" width="'.$logo_header_datas['width'].'" height="'.$logo_header_datas['height'].'" />';

		echo '</a>';

		echo '<div class="h-nav-btn-box"><button type="button" title="Ouvrir/fermer le menu" class="h-nav-btn js-h-nav reset-btn" aria-hidden="true" tabindex="-1"><span class="h-nav-btn-ico"><span class="h-nav-btn-ico h-nav-btn-ico--inner"></span></span><span class="h-nav-btn-txt">Menu</span></button></div>';

	echo '</div>';

}

function pc_display_header_nav() {

	echo '<nav id="header-nav" class="h-nav"><div class="h-nav-inner">';
	$nav_header_config = array(
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
	wp_nav_menu( $nav_header_config ); // + include/navigation.php
	pc_nav_social_links();
	echo '</div></nav>';

}

function pc_display_header_end() {

	echo '</div></header>';

}

function pc_display_nav_overlay() {

	echo '<button type="button" title="Fermer le menu" class="btn-overlay reset-btn js-h-nav" aria-hidden="true" tabindex="-1"><span class="visually-hidden">Fermer le menu</span></button>';

}