<?php
/**
 * 
 * Communs templates : structure globale
 * 
 ** Hooks
 ** Body inner
 ** Main
 *  
 */


/*==================================
=            Body inner            =
==================================*/

function pc_display_body_inner_start() {

	echo apply_filters( 'pc_filter_body_inner_start', '<div class="body-inner">' );

}

function pc_display_body_inner_end() {

	echo apply_filters( 'pc_filter_body_inner_end', '</div>' );

}


/*=====  FIN Body inner  =====*/

/*============================
=            Main            =
============================*/

function pc_display_main_start() {

    echo apply_filters( 'pc_filter_main_start', '<main id="main" class="main" role="main" tabindex="-1"><div class="main-inner">' );

}

function pc_display_main_end() {

    echo apply_filters( 'pc_filter_main_end', '</div></main>');

}


/*----------  Header  ----------*/

function pc_display_main_header_start() {

	echo apply_filters( 'pc_filter_main_header_start', '<header class="main-header" aria-label="Entête du contenu principal"><div class="main-header-inner">' );

}

function pc_display_main_title() {
	
	echo '<h1><span>'.get_the_title().'</span></h1>';

}

function pc_display_main_header_end() {
	
	echo apply_filters( 'pc_filter_main_header_end', '</div></header>' );

}


/*----------  Content  ----------*/

function pc_display_main_content_start() {

	echo apply_filters( 'pc_filter_main_content_start', '<div class="main-content"><div class="main-content-inner">' );

}

function pc_display_main_content_end() {

	echo apply_filters( 'pc_filter_main_content_end', '</div></div>');

}


/*----------  Footer  ----------*/

function pc_display_main_footer_start() {

    echo apply_filters( 'pc_filter_main_footer_start', '<footer class="main-footer" aria-label="Pied de page du contenu principal"><div class="main-footer-inner">' );

}

function pc_display_main_footer_end() {

    echo apply_filters( 'pc_filter_main_footer_end', '</div></footer>' );

}


/*=====  FIN Main  =====*/
