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

add_action( 'pc_header_start', 'pc_display_header_start', 10 );

add_action( 'pc_header_logo', 'pc_display_header_logo', 10 );
add_action( 'pc_header_nav', 'pc_display_header_nav', 10 );

add_action( 'pc_header_end', 'pc_display_header_end', 10 );
add_action( 'pc_header_end', 'pc_display_nav_overlay', 20 );


/*=====  FIN Hooks  =====*/

/*=========================================
=            Contenu des hooks            =
=========================================*/

/*----------  Début de l'entête  ----------*/

function pc_display_header_start() {

	echo '<header class="header layout"><div class="header-inner">';

}


/*----------  Logo  ----------*/

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


/*----------  Navigation  ----------*/

function pc_display_social_links() {

	global $settings_project, $settings_project_fields;

	$prefix = $settings_project_fields[2]['prefix'];
	$ul = false;
	
	foreach( $settings_project_fields[2]['fields'] as $field ) {

		$id = $prefix.'-'.$field['label_for'];
		
		if ( isset($settings_project[$id]) && $settings_project[$id] != '' ) {

			if ( !$ul ) { echo '<ul class="social-list social-list--header reset-list no-print">'; $ul = true; };

			echo '<li class="social-item"><a class="social-link social-link--'.$field['label_for'].'" href="'.$settings_project[$id].'" title="'.$field['label'].' (nouvelle fenêtre)" target="_blank"><span class="visually-hidden">'.$field['label'].'</span>'.pc_svg($field['label_for']).'</a></li>';		
			
		}

	}

	if ( $ul ) { echo '</ul>'; };	

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
		
		pc_display_social_links();

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


/*=====  FIN Contenu des hooks  =====*/