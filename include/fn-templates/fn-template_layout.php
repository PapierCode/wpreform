<?php
/**
 * 
 * Fonctions pour les templates : structure globale
 *  
 */


/*----------  Main  ----------*/

function pc_display_main_start() {

    echo '<main id="main" class="main cl-bloc"><div class="main-inner">';

}

function pc_display_main_end() {

    echo '</div></main>';

}


/*----------  Header & title  ----------*/

function pc_display_main_title_start( ) {

	echo '<header class="main-header"><div class="main-header-title">';

}

function pc_display_main_title( $post ) {
	
	echo '<h1>'.get_the_title( $post->ID ).'</h1>';

}

function pc_display_main_title_end( $post ) {
	
	pc_fs_btn_scroll_to_content();
	echo '</div></header>';

}


/*----------  Footer  ----------*/

function pc_display_main_footer_start() {

    echo '<footer class="main-footer fs-bloc"><div class="main-footer-inner">';

}

function pc_display_main_footer_end() {

    echo '</div></footer>';

}

