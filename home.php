<?php

$settings_home = get_option('home-settings-option');
// version fullscreen et visuel associé ?
if ( $settings_project['theme'] == 'fullscreen' && isset( $settings_home['visual-img'] ) && $settings_home['visual-img'] != '' ) { $settings_project['is-fullscreen'] = true; }

get_header();

do_action( 'pc_home_content_before', $settings_home );

	/*===============================
	=            Contenu            =
	===============================*/ 

	do_action( 'pc_home_content', $settings_home );


	/*=====  FIN Contenu  =====*/

do_action( 'pc_home_content_footer', $settings_home );

do_action( 'pc_home_content_after', $settings_home );

get_footer();