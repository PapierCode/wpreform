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


/*=======================================
=            Réglages projet            =
=======================================*/

// cf. plugin [PC] Custom WP
$settings_pc = get_option('pc-settings-option');


/*=====  FIN Réglages projet  ======*/

/*==============================================
=            Slug custom post & tax            =
==============================================*/

// Actualités
define('NEWS_POST_SLUG', 'news');
define('NEWS_TAX_SLUG', 'newstax');
define('NEWS_TAX_QUERY_VAR', 'actucat');

// Formulaire du contact
define('CONTACT_POST_SLUG', 'contact');


/*=====  FIN Slug custom post & tax  =====*/

/*========================================
=            Variables utiles            =
========================================*/

/*----------  Rôle utilisateur connecté  ----------*/

$current_user_role = ( is_user_logged_in() ) ? wp_get_current_user()->roles[0] : '';


/*=====  FIN Variables utiles  =====*/

/*=============================================================
=            Contenu supplémentaire dans les pages            =
=============================================================*/

// défaut
$page_content_from = array(
    'contactform' => array('Formulaire de contact','include/forms/form-contact/form-contact_template.php'),
);

// si actualités activées
if ( isset($settings_pc['news-active']) ) {
    $page_content_from[NEWS_POST_SLUG] = array('Liste des actualités','include/templates/template_news-list.php');
}

// ajout par plugin
$page_content_from = apply_filters( 'pc_filter_page_content_from', $page_content_from );


/*=====  FIN Contenu supplémentaire dans les pages  =====*/

/*================================
=            includes            =
================================*/

/*----------  Custom admin  ----------*/

include 'include/custom-admin/custom-admin.php';


/*----------  Global  ----------*/

// configuration projet
include 'include/settings.php';
$settings_project = get_option('project-settings-option');

// block editor
include 'include/block-editor/block-editor.php';

// recherche
// include 'include/search.php';

// nettoyage de wp_head & wp_footer
include 'include/clean-wp_head.php';


/*----------  Formulaires  ----------*/

include 'include/forms/forms-functions.php';


/*----------  Templates communs  ----------*/

// sprite SVG
include 'images/sprite.php';

// head
include 'include/head.php';
// navigation
include 'include/navigation.php';
// fonctions utiles
include 'include/templates/_templates_functions.php';
// layout global
include 'include/templates/_templates_layout.php';
// images & galerie
include 'include/templates/_templates_images.php';


/*----------  Custom posts  ----------*/

include 'include/custom-posts/custom_home.php';
include 'include/custom-posts/custom-post_news.php';

// Metaboxes
include 'include/custom-posts/custom-metabox_thumbnail.php';
include 'include/custom-posts/custom-metabox_resum.php';
include 'include/custom-posts/custom-metabox_seo-social.php';
include 'include/custom-posts/custom-metabox_subpage.php';


/*----------  Formulaires  ----------*/

// contact
include 'include/forms/form-contact/form-contact_post.php';


/*=====  End of includes  ======*/

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