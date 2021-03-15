<?php

$settings_home = get_option('home-settings-option');

get_header();

do_action( 'pc_home_content', $settings_home );

get_footer();