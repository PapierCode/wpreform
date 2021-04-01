<?php

global $pc_home;

get_header();

do_action( 'pc_action_home_main_start', $pc_home );

	do_action( 'pc_action_home_main_header', $pc_home );
	
	do_action( 'pc_action_home_main_content', $pc_home );

	do_action( 'pc_action_home_main_footer', $pc_home );

do_action( 'pc_action_home_main_end', $pc_home );

get_footer();