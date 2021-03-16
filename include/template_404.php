<?php 
/**
 * 
 * Template 404
 * 
 */


add_action( 'pc_action_404_main_start', 'pc_display_main_start', 10 ); // layout commun -> templates_layout.php

	add_action( 'pc_action_404_main_header', 'pc_display_main_header_start', 10 ); // layout commun -> templates_layout.php
	add_action( 'pc_action_404_main_header', 'pc_display_404_main_header_title', 20 ); // layout commun -> templates_layout.php
	add_action( 'pc_action_404_main_header', 'pc_display_main_header_end', 100 ); // layout commun -> templates_layout.php

add_action( 'pc_action_404_main_end', 'pc_display_main_end', 10 ); // layout commun -> templates_layout.php


function pc_display_404_main_header_title() {

	echo apply_filters( 'pc_filter_404_main_header_title', '<h1><span>Cette page n\'existe pas.</span></h1>' );

} 