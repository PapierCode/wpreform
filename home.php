<?php

$settings_home = get_option('home-settings-option');

get_header();

do_action( 'pc_home_content_before', $settings_home );

	do_action( 'pc_home_content', $settings_home );

	do_action( 'pc_home_content_footer', $settings_home );

do_action( 'pc_home_content_after', $settings_home );

get_footer();