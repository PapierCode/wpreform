<?php

$settings_home = get_option('home-settings-option');

get_header();

do_action( 'pc_action_home_main_start', $settings_home );

	do_action( 'pc_action_home_main_header', $settings_home );
	
	do_action( 'pc_action_home_main_content', $settings_home );

	do_action( 'pc_action_home_main_footer', $settings_home );

do_action( 'pc_action_home_main_end', $settings_home );

get_footer();