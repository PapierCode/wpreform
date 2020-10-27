<?php

get_header();

do_action( 'pc_404_content_before' );

	$content_404 = apply_filters( 'pc_filter_404_content', '<h1>Cette page n\'existe pas</h1>' );
	echo $content_404;

do_action( 'pc_404_content_after' );

get_footer();