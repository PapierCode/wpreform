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

$settings_pc = get_option('pc-settings-option');


/*----------  Configuration projet (client)  ----------*/

include 'include/settings.php';
$settings_project = get_option('project-settings-option');


/*----------  Thème (fullscreen ou classic)  ----------*/

// si le thème n'est pas défini
$settings_project['theme'] = ( $settings_pc['preform-theme'] && $settings_pc['preform-theme'] != '' ) ? $settings_pc['preform-theme'] : 'classic';
// pour changer de thème en direct
$settings_project['theme'] = ( isset($_GET['dev_theme']) ) ? $_GET['dev_theme'] : $settings_pc['preform-theme'];
// version fullscreen, une page peut être plein écran ou pas
$settings_project['is-fullscreen'] = false;


/*----------  Contenu spécifique ajouté dans les pages (formulaire, liste d'actualités,...)  ----------*/

$settings_project['page-content-from'] = array();
$settings_project['page-content-from'] = apply_filters( 'pc_filter_page_content_from', $settings_project['page-content-from'] );


/*----------  Rôle utilisateur connecté  ----------*/

$current_user_role = ( is_user_logged_in() ) ? wp_get_current_user()->roles[0] : '';


/*----------  Custom posts & métaboxes  ----------*/

// accueil
include 'include/custom-posts/custom_home.php';
// Metaboxes
include 'include/custom-posts/custom-metabox_thumbnail.php';
include 'include/custom-posts/custom-metabox_resum.php';
include 'include/custom-posts/custom-metabox_seo-social.php';
include 'include/custom-posts/custom-metabox_subpage.php';


/*----------  Templates : communs  ----------*/

// sprite SVG
include 'images/sprite.php';
// contenu de l'entête (head)
include 'include/clean-wp_head.php';
include 'include/head.php';
// navigation
include 'include/navigation.php';
// wysiwyg classique
include 'include/fn-templates/fn-template_editor.php';
// images & galerie
include 'include/fn-templates/fn-template_images.php';
// réseaux sociaux (liens et partage)
include 'include/fn-templates/fn-template_social.php';
// article résumé
include 'include/fn-templates/fn-template_st.php';


/*----------  Templates : layouts  ----------*/

// layout global
include 'include/fn-templates/fn-template_layout.php';
// spécificités fullscreen
include 'include/fn-templates/fn-template_fullscreen.php';
// page
include 'include/fn-templates/fn-template_page.php';
// accueil
include 'include/fn-templates/fn-template_home.php';


/*----------  Modification de l'admin  ----------*/

// généralités
include 'include/custom-admin/custom-admin.php';
// block editor
// include 'include/block-editor/block-editor.php';


/*----------  Recherche  ----------*/

// include 'include/search.php';


/*========================================
=            Expérimentations            =
========================================*/

// masquer les sous pages dans la gestion des menus ?
// add_filter( 'nav_menu_items_page_recent', 'pc_test', 10, 3 );
// add_filter( 'nav_menu_items_page', 'pc_test', 10, 3 );
// function pc_test($posts, $args, $post_type) {
//     foreach ($posts as $key => $post) {
//         if ( $post->post_parent > 0 ) { unset($posts[$key]); }
//     }
//     return $posts;
// }

/*=====  FIN Expérimentations  =====*/