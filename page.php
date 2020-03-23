<?php

if ( have_posts() ) : while ( have_posts() ) : the_post(); // Boucle WP (1/2)

$page_metas = get_post_meta($post->ID);

// version fullscreen et visuel associé ?
if ( $settings_project['theme'] == 'fullscreen' && isset($page_metas['thumbnail-img'])) { $settings_project['is-fullscreen'] = true; }

get_header();

do_action( 'pc_page_content_before', $post, $page_metas );

	do_action( 'pc_page_wysiwyg_before', $post, $page_metas );

	if ( $post->post_content != '' ) { the_content(); }

	do_action( 'pc_page_wysiwyg_after', $post, $page_metas );	

	do_action( 'pc_page_content_footer', $post, $page_metas );

do_action( 'pc_page_content_after', $post, $page_metas );

get_footer();

endwhile; endif; // Boucle WP (2/2)