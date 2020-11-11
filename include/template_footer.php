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

add_action( 'pc_footer_start', 'pc_display_footer_start', 10 );

add_action( 'pc_footer_end', 'pc_display_footer_end', 10 );
add_action( 'pc_footer_end', 'pc_display_body_inner_end', 20 );
add_action( 'pc_footer_end', 'pc_display_pop_container', 30 );

add_action( 'pc_wp_footer', 'pc_display_js_footer', 40 );


/*=====  FIN Hooks  =====*/

/*=========================================
=            Contenu des hooks            =
=========================================*/

/*----------  Début du pied de page  ----------*/

function pc_display_footer_start() {

	echo '<footer class="footer"><div class="footer-inner">';

}


/*----------  Fin du pied de page  ----------*/

function pc_display_footer_end() {

	echo '</div></footer>';

}


/*----------  Fin du container body  ----------*/

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
	
	$sprite_to_js_array = array('arrow','cross');
	apply_filters( 'pc_filter_sprite_to_svg', $sprite_to_js_array );
	pc_sprite_to_js( $sprite_to_js_array ); 
	

	/*----------  JS global  ----------*/
	
	echo '<script src="'.get_bloginfo('template_directory').'/scripts/scripts.min.js"></script>';

}


/*=====  FIN Contenu des hooks  =====*/