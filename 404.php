<?php

get_header();

do_action( 'pc_404_content_before' );

	echo apply_filters( 'pc_filter_404_title', '<h1><span>Cette page n\'existe pas.</span></h1>' );

do_action( 'pc_404_content_after' );

get_footer();