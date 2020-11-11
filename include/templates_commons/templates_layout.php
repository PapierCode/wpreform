<?php
/**
 * 
 * Fonctions pour les templates : structure globale
 *  
 */


/*----------  Main  ----------*/

function pc_display_main_start() {

    echo '<main id="main" class="main"><div class="main-inner">';

}

function pc_display_main_end() {

    echo '</div></main>';

}


/*----------  Header & title  ----------*/

function pc_display_main_title_start( ) {

	echo '<header class="main-header"><div class="main-header-inner">';

}

function pc_display_main_title( $post ) {
	
	echo '<h1>'.get_the_title( $post->ID ).'</h1>';

}

function pc_display_main_title_end( $post ) {
	
	echo '</div></header>';

}


/*----------  Main content  ----------*/

function pc_display_main_content_start() {

	echo '<div class="main-content">';

}

function pc_display_main_content_end() {

	echo '</div>';

}


/*----------  Footer  ----------*/

function pc_display_main_footer_start() {

    echo '<footer class="main-footer"><div class="main-footer-inner">';

}

function pc_display_main_footer_end() {

    echo '</div></footer>';

}

