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

	$tag = '<main id="main" class="main" role="main" tabindex="-1">';
	if ( apply_filters( 'pc_display_main_inner', false ) ) { $tag .= '<div class="main-inner">'; }

    echo apply_filters( 'pc_filter_main_start', $tag );

}

function pc_display_main_end() {

	$tag = '</main>';
	if ( apply_filters( 'pc_display_main_inner', false ) ) { $tag = '</div>'.$tag; }

    echo apply_filters( 'pc_filter_main_end', $tag );

}


/*----------  Header  ----------*/

function pc_display_main_header_start() {

	$tag = '<header class="main-header" aria-label="Entête du contenu principal">';
	if ( apply_filters( 'pc_display_main_header_inner', false ) ) { $tag .= '<div class="main-header-inner">'; }

	echo apply_filters( 'pc_filter_main_header_start', $tag );

}

function pc_display_main_title() {
	
	echo '<h1><span>'.get_the_title().'</span></h1>';

}

function pc_display_main_header_end() {

	$tag = '</header>';
	if ( apply_filters( 'pc_display_main_header_inner', false ) ) { $tag .= '</div>'.$tag; }
	
	echo apply_filters( 'pc_filter_main_header_end', $tag );

}


/*----------  Content  ----------*/

function pc_display_main_content_start() {

	$tag = '';
	if ( apply_filters( 'pc_display_main_content', false ) ) { $tag .= '<div class="main-content">'; }
	if ( apply_filters( 'pc_display_main_content_inner', false ) ) { $tag .= '<div class="main-content-inner">'; }

	if ( $tag ) { echo apply_filters( 'pc_filter_main_content_start', $tag ); }

}

function pc_display_main_content_end() {

	$tag = '';
	if ( apply_filters( 'pc_display_main_content', false ) ) { $tag .= '</div>'; }
	if ( apply_filters( 'pc_display_main_content_inner', false ) ) { $tag .= '</div>'; }

	if ( $tag ) { echo apply_filters( 'pc_filter_main_content_end', $tag ); }

}


/*----------  Footer  ----------*/

function pc_display_main_footer_start() {

	$tag = '<footer class="main-footer" aria-label="Pied de page du contenu principal">';
	if ( apply_filters( 'pc_display_main_footer_inner', false ) ) { $tag .= '<div class="main-footer-inner">'; }

    echo apply_filters( 'pc_filter_main_footer_start', $tag );

}

function pc_display_main_footer_end() {

	$tag = '</footer>';
	if ( apply_filters( 'pc_display_main_footer_inner', false ) ) { $tag .= '</div>'.$tag; }

    echo apply_filters( 'pc_filter_main_footer_end', $tag );

}


/*=====  FIN Main  =====*/
