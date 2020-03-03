<?php
/**
 * 
 * Fonctions pour les templates : particularités du thème Fullscreen
 * 
 */

/*====================================================
=            Main header background image            =
====================================================*/

function pc_fs_main_header_css_bg( $img_id ) {

	$em = 16; // medias queries en em
	$return = '';
	$sizes = array( 
		array( '', 'fs-s'), 
		array( 600/$em, 'fs-m'), 
		array( 1200/$em, 'fs-l')
	);

	foreach ($sizes as $size) {
		if ( $size[0] != '' ) { $return .= '@media(min-width:'.$size[0].'em){'; }
		$return .= '.main-header{background-image:url("'.wp_get_attachment_image_src( $img_id, $size[1] )[0].'")}';
		if ( $size[0] != '' ) { $return .= '}'; }
	}

	return $return;

}

/*=====  FIN Main header background image  =====*/

/*=================================================
=            Bouton d'accès au contenu            =
=================================================*/

function pc_fs_btn_scroll_to_content() {

	global $settings_project;
	
	if ( $settings_project['theme'] == 'fullscreen' && $settings_project['is-fullscreen'] ) {
		echo '<div class="fs-more">';
		echo '<button type="button" class="fs-more-btn btn reset-btn" aria-hidden="true">'.pc_svg('arrow',null,'svg_block').'</button>';
		echo '</div>';
	}

}


/*=====  FIN Bouton d'accès au contenu  =====*/