<?php

// identique à page.php

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post(); // Boucle WP (1/2)

	global $pc_post;

	do_action( 'pc_action_page_main_start', $pc_post );

		do_action( 'pc_action_page_main_header', $pc_post );
		
		do_action( 'pc_action_page_main_content', $pc_post );

		do_action( 'pc_action_page_main_footer', $pc_post );

	do_action( 'pc_action_page_main_end', $pc_post );

endwhile; endif; // Boucle WP (2/2)

get_footer();