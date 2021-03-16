<?php

// identique à index.php

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post(); // Boucle WP (1/2)

	$post_metas = get_post_meta( $post->ID );

	do_action( 'pc_action_page_main_start', $post, $post_metas );

		do_action( 'pc_action_page_main_header', $post, $post_metas );
		
		do_action( 'pc_action_page_main_content', $post, $post_metas );

		do_action( 'pc_action_page_main_footer', $post, $post_metas );

	do_action( 'pc_action_page_main_end', $post, $post_metas );

endwhile; endif; // Boucle WP (2/2)

get_footer();