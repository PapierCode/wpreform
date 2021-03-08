<?php

// identique à index.php

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post(); // Boucle WP (1/2)

	$post_metas = get_post_meta( $post->ID );

	do_action( 'pc_page_content_before', $post, $post_metas );

		if ( $post->post_content != '' ) { the_content(); }

	do_action( 'pc_page_content_after', $post, $post_metas );

endwhile; endif; // Boucle WP (2/2)

get_footer();