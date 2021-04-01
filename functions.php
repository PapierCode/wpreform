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


/*----------  Configuration projet (client)  ----------*/

include 'include/settings.php';
$settings_project = get_option('project-settings-option');
$settings_project['page-content-from'] = array();
$settings_project = apply_filters( 'pc_filter_settings_project', $settings_project );


/*----------  Rôle utilisateur connecté  ----------*/

$current_user_role = ( is_user_logged_in() ) ? wp_get_current_user()->roles[0] : '';


/*----------  Classes  ----------*/

include 'include/classes/class-pc-post.php';
include 'include/classes/class-pc-term.php';
include 'include/classes/class-pc-home.php';


/*----------  Administration  ----------*/

// généralités
include 'include/admin/admin.php';


/*----------  Templates : communs  ----------*/

// sprite SVG
include 'include/templates/parts/sprite.php';
// navigation
include 'include/templates/parts/navigation.php';
// wysiwyg par défaut
include 'include/templates/parts/editor.php';
// images & galerie
include 'include/templates/parts/images.php';
// Données structurées
include 'include/templates/parts/schemas.php';
// liens réseaux sociaux & partage
include 'include/templates/parts/social.php';
// layout global
include 'include/templates/parts/layout.php';
// contenu de l'entête (head)
include 'include/templates/parts/head.php';
// image pleine page
include 'include/templates/parts/fullscreen.php';
// recherche
include 'include/templates/parts/search.php';


/*----------  Templates : spécifiques  ----------*/

// entête (header)
include 'include/templates/header.php';
// Pied de page (footer)
include 'include/templates/footer.php';
// page
include 'include/templates/page.php';
// 404
include 'include/templates/404.php';
// accueil
include 'include/templates/home.php';


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
