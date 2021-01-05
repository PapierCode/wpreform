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
$settings_project = get_option('project-settings-option');


/*----------  Contenu spécifique ajouté dans les pages (formulaire, liste d'actualités,...)  ----------*/

$settings_project['page-content-from'] = array();
$settings_project['page-content-from'] = apply_filters( 'pc_filter_page_content_from', $settings_project['page-content-from'] );


/*----------  Rôle utilisateur connecté  ----------*/

$current_user_role = ( is_user_logged_in() ) ? wp_get_current_user()->roles[0] : '';


/*----------  Custom posts & métaboxes  ----------*/

// Metaboxes
include 'include/custom-posts/custom-metabox_visual.php';
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

// https://codex.wordpress.org/User:Amereservant/Editing_and_Customizing_htaccess_Indirectly

// add_filter('mod_rewrite_rules', 'my_htaccess_contents');

// function my_htaccess_contents( $rules ) {

// $pc_rules = <<<EOD
// \n# Files protection
// <files .htaccess>
// 	order allow,deny
// 	deny from all
// </files>
// <files wp-config.php>
// 	order allow,deny
// 	deny from all
// </files>

// # Disable Directory Listings in this Directory and Subdirectories
// Options -Indexes

// # Expires caching
// <IfModule mod_expires.c>
// ExpiresActive On
// ExpiresByType image/svg+xml "access plus 1 month"
// ExpiresByType image/jpg "access plus 1 month"
// ExpiresByType image/jpeg "access plus 1 month"
// ExpiresByType image/gif "access plus 1 month"
// ExpiresByType image/png "access plus 1 month"
// ExpiresByType text/css "access plus 1 month"
// ExpiresByType text/javascript "access plus 1 month"
// ExpiresByType text/x-javascript "access plus 1 month"
// ExpiresByType application/pdf "access plus 1 month"
// ExpiresByType application/javascript "access plus 1 month"
// ExpiresByType image/icon "access plus 1 month"
// ExpiresDefault "access plus 2 days"
// </IfModule>

// <IfModule mod_headers.c>

// # disabled MIME-Type sniffing
// Header always set X-Content-Type-Options "nosniff"

// # X-XSS-Protection
// Header always set X-XSS-Protection "1; mode=block"

// # prevent Clickjacking
// Header always set X-FRAME-OPTIONS "DENY"

// # cookies https
// Header edit Set-Cookie ^(.*)$ $1;HttpOnly;Secure

// # cache
// <FilesMatch ".(js|css|svg|html)$">
// Header append Vary: Accept-Encoding
// </FilesMatch>

// </IfModule>\n
// EOD;


// $rules = str_replace( 'RewriteBase /', 'RewriteBase / '.PHP_EOL.'RewriteCond %{SERVER_PORT} 80', $rules);
// $rules = str_replace( '80', '80'.PHP_EOL.'RewriteRule ^(.*)$ https://%{SERVER_NAME}%{REQUEST_URI} [L,R=301]', $rules);
// // pc_var($rules);
// // exit();

// return $rules.$pc_rules;

// }


/*=====  FIN Expérimentations  =====*/