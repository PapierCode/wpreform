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

	global $settings_project;
	$css_class = ( $settings_project['is-fullscreen'] ) ? 'main-header' : 'main-header fs-bloc';

	echo '<header class="'.$css_class.'"><div class="main-header-inner">';

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

