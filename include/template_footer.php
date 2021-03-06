<?php 
/**
 * 
 * Template header
 * 
 ** Hooks
 ** Footer structure & contenu
 ** Fin du container body
 * 
 */

/*=============================
=            Hooks            =
=============================*/

	add_action( 'pc_footer', 'pc_display_footer_start', 10 );

		add_action( 'pc_footer', 'pc_display_footer_contact', 20 );
		add_action( 'pc_footer', 'pc_display_footer_nav', 30 );
		
	add_action( 'pc_footer', 'pc_display_footer_end', 40 );

add_action( 'pc_footer', 'pc_display_body_inner_end', 50 );

add_action( 'pc_wp_footer', 'pc_display_pop_container', 10 );
add_action( 'pc_wp_footer', 'pc_display_js_footer', 20 );


/*=====  FIN Hooks  =====*/

/*==================================================
=            Footer structure & contenu            =
==================================================*/

/*----------  Début du pied de page  ----------*/

function pc_display_footer_start() {

	echo '<footer class="footer"><div class="footer-inner">';

}


/*----------  Adresse  ----------*/

function pc_display_footer_contact() {
	
	global $settings_project;
	$dd = array(
		'with-icons' => true,
		'list' => array()
	);


	/*----------  Logo  ----------*/
	
	// datas
	$img_datas = array(
		'url' => get_bloginfo('template_directory').'/images/logo-footer.svg',
		'width' => 100,
		'height' => 25,
		'alt' => 'Logo '.$settings_project['coord-name']
	);
	// filtre
	$img_datas = apply_filters( 'pc_filter_footer_logo_img_datas', $img_datas, $settings_project );
	// html
	$img_tag = '<img src="'.$img_datas['url'].'" alt="'.$img_datas['alt'].'" width="'.$img_datas['width'].'" height="'.$img_datas['height'].'" loading="lazy" />';


	/*----------  Adresse  ----------*/
	
	$address = $settings_project['coord-address'].' <br/>'.$settings_project['coord-postal-code'].' '.$settings_project['coord-city'].', '.$settings_project['coord-country'];
	if ( $settings_project['coord-lat'] != '' && $settings_project['coord-long'] != '' ) {
		$address .= '<br aria-hidden="true"/><button class="reset-btn btn-display-pop no-print" data-cible="map" data-lat="'.$settings_project['coord-lat'].'" data-long="'.$settings_project['coord-long'].'" aria-hidden="true">Afficher la carte</button>';
	}
	$dd['list']['addr'] = array(
		'ico' => 'map',
		'txt' => $address
	);


	/*----------  Téléphone  ----------*/
	
	$phone = '<a href="tel:'.pc_phone($settings_project['coord-phone-1']).'">'.pc_phone($settings_project['coord-phone-1'],false).'</a>';
	if ( $settings_project['coord-phone-2'] != '' ) {
		$phone .= '<br/><span class="coord-sep"> / </span><a href="tel:'.pc_phone($settings_project['coord-phone-2']).'">'.pc_phone($settings_project['coord-phone-2'],false).'</a>';
	}
	$dd['list']['phone'] = array(
		'ico' => 'phone',
		'txt' => $phone
	);
	

	/*----------  Affichage  ----------*/

	// filtres	
	$dt = apply_filters( 'pc_filter_footer_contact_dt', $img_tag, $img_datas, $settings_project );
	$dd = apply_filters( 'pc_filter_footer_contact_dd', $dd, $settings_project );

	echo '<address class="coord"><dl class="coord-list">';
		echo '<dt class="coord-item coord-item--logo">'.$dt.'</dt>';
		foreach ($dd['list'] as $id => $content) {
			echo '<dd class="coord-item coord-item--'.$id.'">';
				if ( $dd['with-icons'] ) { echo '<span class="coord-ico">'.pc_svg($content['ico']).'</span>'; }
				echo '<span class="coord-txt">'.$content['txt'].'</span>';
			echo '</dd>';
		}
	echo '</dl></address>';

	// données structurées
	pc_display_schema_local_business();

}


/*----------  Navigation  ----------*/

function pc_display_footer_nav() {

	echo '<nav id="footer-nav" class="f-nav">';
	echo '<ul class="f-nav-list f-nav-list--l1 f-p-nav-list f-p-nav-list--l1 reset-list">';
	
		do_action( 'pc_footer_nav_list_inner_before' );

		$display_copyright = apply_filters( 'pc_filter_footer_display_copyright', false );
		if ( $display_copyright ) {
			global $settings_project;
			echo '<li class="f-nav-item f-nav-item--l1 f-p-nav-item f-p-nav-item--l1">&copy; '.$settings_project['coord-name'].'</li>';
		}
		
		$nav_footer_args = apply_filters( 'pc_filter_footer_nav_args', array(
			'theme_location'  	=> 'nav-footer',
			'nav_prefix'		=> array('f-nav','f-p-nav'),
			'items_wrap'      	=> '%3$s',
			'depth'           	=> 1,
			'item_spacing'		=> 'discard',
			'container'       	=> '',
			'fallback_cb'     	=> false,
			'walker'          	=> new Pc_Walker_Nav_Menu()
		) );
		wp_nav_menu( $nav_footer_args );

		do_action( 'pc_footer_nav_list_inner_after' );
		
	echo '</ul>';
	echo '</nav>';

}


/*----------  Fin du pied de page  ----------*/

function pc_display_footer_end() {

	echo '</div></footer>';

}


/*=====  FIN Footer structure & contenu  =====*/

/*=============================================
=            Fin du container body            =
=============================================*/

/*----------  Fin body inner  ----------*/

function pc_display_body_inner_end() {

	echo '</div>';

}


/*----------  Container pop-up  ----------*/

function pc_display_pop_container() {

	echo '<div class="pop no-print" aria-hidden="true"></div>';

}


/*----------  Javascript  ----------*/

function pc_display_js_footer() {

	/*----------  Sprite to JS  ----------*/
	
	$sprite_to_js_array = apply_filters( 'pc_filter_sprite_to_js', array('arrow','cross') );
	pc_sprite_to_js( $sprite_to_js_array ); 
	

	/*----------  Fichiers JS  ----------*/

	$js_files = apply_filters( 'pc_filter_js_files', array(
		'wpreform' => get_bloginfo('template_directory').'/scripts/scripts-jquery.min.js'
	) );
	
	foreach ( $js_files as $id => $url ) {
		echo '<script src="'.$url.'"></script>';
	}

}


/*=====  FIN Fin du container body  =====*/