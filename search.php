<?php

// identique à index.php

get_header();

	do_action( 'pc_action_search_main_start' );

		do_action( 'pc_action_search_main_header' );
		
		do_action( 'pc_action_search_main_content' );

		do_action( 'pc_action_search_main_footer' );

	do_action( 'pc_action_search_main_end' );

get_footer();