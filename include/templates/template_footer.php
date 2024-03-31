<?php 
/**
 * 
 * Template : header
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

add_action( 'pc_wp_footer', 'pc_display_js_footer', 10 );


/*=====  FIN Hooks  =====*/

/*==================================================
=            Footer structure & contenu            =
==================================================*/

/*----------  Début du pied de page  ----------*/

function pc_display_footer_start() {

	$tag = '<footer class="footer" role="contentinfo">';
	if ( apply_filters( 'pc_display_footer_inner', false ) ) { $tag .= '<div class="footer-inner">'; }

	echo apply_filters( 'pc_filter_footer_start', $tag );

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
	$logo_datas = array(
		'url' => get_bloginfo('template_directory').'/images/logo-footer.svg',
		'width' => 100,
		'height' => 25,
		'alt' => $settings_project['coord-name']
	);
	// filtre
	$logo_datas = apply_filters( 'pc_filter_footer_logo_datas', $logo_datas, $settings_project );
	// html
	$logo_tag = '<img src="'.$logo_datas['url'].'" alt="'.$logo_datas['alt'].'" width="'.$logo_datas['width'].'" height="'.$logo_datas['height'].'" loading="lazy" />';


	/*----------  Adresse  ----------*/
	
	$address = $settings_project['coord-address'].' <br/>'.$settings_project['coord-postal-code'].' '.$settings_project['coord-city'].', '.$settings_project['coord-country'];
	if ( $settings_project['coord-lat'] != '' && $settings_project['coord-long'] != '' ) {
		$address .= '<br aria-hidden="true" class="no-print"/><button class="reset-btn js-button-map no-print" data-lat="'.$settings_project['coord-lat'].'" data-long="'.$settings_project['coord-long'].'">Afficher la carte</button>';
	}
	$dd['list']['addr'] = array(
		'ico' => 'map',
		'txt' => $address
	);


	/*----------  Téléphone  ----------*/
	
	$phone = '<a href="tel:'.pc_phone($settings_project['coord-phone-1']).'">'.pc_phone($settings_project['coord-phone-1'],false).'</a>';
	if ( isset( $settings_project['coord-phone-2'] ) && $settings_project['coord-phone-2'] ) {
		$phone .= '<br/><span class="coord-sep"> / </span><a href="tel:'.pc_phone($settings_project['coord-phone-2']).'">'.pc_phone($settings_project['coord-phone-2'],false).'</a>';
	}
	$dd['list']['phone'] = array(
		'ico' => 'phone',
		'txt' => $phone
	);
	

	/*----------  Affichage  ----------*/

	// filtres	
	$dt = apply_filters( 'pc_filter_footer_contact_dt', $logo_tag, $logo_datas, $settings_project );
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

	echo '<nav class="f-nav" role="navigation" aria-label="Navigation du pied de page">';
	echo '<ul class="f-nav-list f-nav-list--l1 f-p-nav-list f-p-nav-list--l1 reset-list">';
	
		do_action( 'pc_footer_nav_items_before' );

		if ( apply_filters( 'pc_filter_footer_copyright_display', false ) ) {
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

		do_action( 'pc_footer_nav_items_after' );
		
	echo '</ul>';
	echo '</nav>';

}


/*----------  Fin du pied de page  ----------*/

function pc_display_footer_end() {

	$tag = '</footer>';
	if ( apply_filters( 'pc_display_footer_inner', false ) ) { $tag = '</div>'.$tag; }

	echo apply_filters( 'pc_filter_footer_end', $tag );

}


/*=====  FIN Footer structure & contenu  =====*/

/*=============================================
=            Fin du container body            =
=============================================*/

/*----------  Javascript  ----------*/

function pc_display_js_footer() {

	/*----------  PHP to JS  ----------*/
	
	$sprite_selection = apply_filters( 'pc_filter_sprite_to_js', array('arrow','cross','more','less') );
	if ( !empty( $sprite_selection ) ) {
		global $sprite;
		$sprite_to_json = array();
		foreach ( $sprite_selection as $id ) {
			$sprite_to_json[$id] = str_replace( '<svg', '<svg aria-hidden="true" focusable="false"', $sprite[$id] );
		}
	}

	$h_nav_js_args = apply_filters( 'pc_filter_header_nav_js_args', array(
		'heightAnimation' => array(
			'small' => true,
			'full' => true
		)
	) );

	echo '<script>';
		echo 'var navArgs='.json_encode( $h_nav_js_args, JSON_PRETTY_PRINT ).';';
		echo 'var sprite='.json_encode( $sprite_to_json, JSON_PRETTY_PRINT ).';';
	echo '</script>';
	

	/*----------  Fichiers JS  ----------*/

	$js_preform_path = '/scripts/pc-preform-jquery.min.js';
	$js_files = apply_filters( 'pc_filter_js_files', array(
		'wpreform' => get_template_directory_uri().$js_preform_path.'?ver='.filemtime(get_template_directory().$js_preform_path)
	) );
	
	if ( !empty( $js_files ) ) { 
		foreach ( $js_files as $id => $url ) {
			echo '<script defer src="'.$url.'"></script>';
		}
	}

}


/*=====  FIN Fin du container body  =====*/