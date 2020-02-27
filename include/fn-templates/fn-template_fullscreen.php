<?php
/**
 * 
 * Fonctions pour les templates : particularités du thème Fullscreen
 * 
 */

function pc_fs_btn_scroll_to_content() {

	global $preform_theme;
	if ( $preform_theme == 'fullscreen' ) {
		echo '<div class="fs-more">';
		echo '<button type="button" class="fs-more-btn btn reset-btn" aria-hidden="true">'.pc_svg('arrow',null,'svg_block').'</button>';
		echo '</div>';
	}

}