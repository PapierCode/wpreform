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
	'excerpt' => 20,
	'resum-title' => 40,
	'resum-desc' => 150,
	'seo-title' => 70,
	'seo-desc' => 200
);
$texts_lengths = apply_filters( 'pc_filter_texts_lengths', $texts_lengths );


/*----------  Configuration projet (client)  ----------*/

include 'include/settings_project.php';
$settings_project = apply_filters( 'pc_filter_settings_project', get_option('project-settings-option') );


/*----------  Rôle utilisateur connecté  ----------*/

$current_user_role = ( is_user_logged_in() ) ? wp_get_current_user()->roles[0] : '';


/*----------  Custom posts & métaboxes  ----------*/

// Metaboxes
include 'include/custom-posts/custom-metabox_img.php';
include 'include/custom-posts/custom-metabox_resum.php';
include 'include/custom-posts/custom-metabox_seo-social.php';
include 'include/custom-posts/custom-metabox_subpage.php';

// accueil
include 'include/custom-posts/custom_home.php';


/*----------  Templates : communs  ----------*/

// sprite SVG
include 'images/sprite.php';
// navigation
include 'include/templates_commons/templates_navigation.php';
// wysiwyg par défaut
include 'include/templates_commons/templates_editor.php';
// images & galerie
include 'include/templates_commons/templates_images.php';
// liens réseaux sociaux & partage
include 'include/templates_commons/templates_social.php';
// layout global
include 'include/templates_commons/templates_layout.php';
// article résumé
include 'include/templates_commons/templates_st.php';
// contenu de l'entête (head)
include 'include/templates_commons/templates_head.php';


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


/*----------  Expérimentations  ----------*/

// include 'include/_temp.php'