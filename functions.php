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

include 'include/settings_project.php';
$settings_project = get_option('project-settings-option');
$settings_project['page-content-from'] = array();
$settings_project = apply_filters( 'pc_filter_settings_project', $settings_project );


/*----------  Rôle utilisateur connecté  ----------*/

$current_user_role = ( is_user_logged_in() ) ? wp_get_current_user()->roles[0] : '';


/*----------  Custom posts & métaboxes  ----------*/

// Metaboxes
include 'include/custom-posts/custom-metabox_subpage.php';
include 'include/custom-posts/custom-metabox_img.php';
include 'include/custom-posts/custom-metabox_resum.php';
include 'include/custom-posts/custom-metabox_seo-social.php';

// accueil
include 'include/custom-posts/custom_home.php';


/*----------  Templates : communs  ----------*/

// sprite SVG
include 'images/sprite.php';
// navigation
include 'include/templates-parts/templates_navigation.php';
// wysiwyg par défaut
include 'include/templates-parts/templates_editor.php';
// images & galerie
include 'include/templates-parts/templates_images.php';
// métas SEO
include 'include/templates-parts/templates_seo.php';
// Données structurées
include 'include/templates-parts/templates_schemas.php';
// liens réseaux sociaux & partage
include 'include/templates-parts/templates_social.php';
// layout global
include 'include/templates-parts/templates_layout.php';
// article résumé
include 'include/templates-parts/templates_post-resum.php';
// contenu de l'entête (head)
include 'include/templates-parts/templates_head.php';
// image pleine page
include 'include/templates-parts/templates_fullscreen.php';


/*----------  Templates : spécifiques  ----------*/

// entête (header)
include 'include/template_header.php';
// Pied de page (footer)
include 'include/template_footer.php';
// page
include 'include/template_page.php';
// 404
include 'include/template_404.php';
// accueil
include 'include/template_home.php';


/*----------  Modification de l'admin  ----------*/

// généralités
include 'include/custom-admin/custom-admin.php';
// block editor... work not in progress !
// include 'include/block-editor/block-editor.php';


/*----------  Recherche  ----------*/

// include 'include/search.php';


/*----------  Setup thème  ----------*/

$is_fresh_site = get_option('fresh_site');
if ( $is_fresh_site ) {
	include 'include/theme-setup/theme-setup_pages.php';
}
include 'include/theme-setup/theme-setup.php';



/*----------  Expérimentations  ----------*/

// include 'include/_temp.php';


/*----------  Debug  ----------*/

// affiche les fonctions attachées à un hook
// pc_var(count($wp_filter[ 'pc_home_content' ]->callbacks));
// pc_var($wp_filter[ 'pc_home_content' ]);
