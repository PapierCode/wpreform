<?php
/**
*
** Réglages projet
** Slug custom post & tax
** Variables utiles
** Includes
** Expérimentations
*
**/


/*----------  Classes  ----------*/

include 'include/classes/class-pc-post.php';
include 'include/classes/class-pc-term.php';
include 'include/classes/class-pc-home.php';


/*----------  Configuration projet (agence)  ----------*/

global $settings_pc; // défini dans le plugin [PC] Custom WP 

$texts_lengths = array(
	'excerpt' => 100, // mots
	'resum-title' => 40, // signes
	'resum-desc' => 150, // signes
	'seo-title' => 70, // signes
	'seo-desc' => 200 // signes
);
$texts_lengths = apply_filters( 'pc_filter_texts_lengths', $texts_lengths );


/*----------  Rôle utilisateur connecté  ----------*/

$current_user_role = ( is_user_logged_in() ) ? wp_get_current_user()->roles[0] : '';

add_filter( 'admin_body_class', 'pc_edit_admin_body_class' );

	function pc_edit_admin_body_class( $classes ) {

		global $current_user_role;
		$classes .= ' role_'.$current_user_role;

		return $classes;

	}


/*----------  Administration  ----------*/

include 'include/admin/admin.php';


/*----------  Templates  ----------*/

include 'include/templates/templates.php';



/*----------  Init  ----------*/

add_action( 'wp', 'pc_wpreform_init', 10 );

	function pc_wpreform_init() {

		if ( is_home() && class_exists( 'PC_Home' ) ) {

			global $pc_home;
			$pc_home = new PC_Home();

		}

		if ( is_singular() && class_exists( 'PC_Post' ) ) {

			global $post, $pc_post;
			$pc_post = new PC_Post( $post );

		}

		if ( is_tax() && class_exists( 'PC_term' ) ) {

			global $pc_term;
			$pc_term = new PC_Term( get_queried_object() );

		}

	}



/*----------  Setup thème  ----------*/

$is_fresh_site = get_option('fresh_site');
if ( $is_fresh_site ) {
	include 'include/theme-setup/theme-setup_pages.php';
}
include 'include/theme-setup/theme-setup.php';

