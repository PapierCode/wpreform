<?php 
/**
 * 
 * Fonctions pour les templates : page
 * 
 */


/*=============================
=            Hooks            =
=============================*/

add_action( 'pc_page_content_before', 'pc_display_main_start', 10 );  // layout commun

add_action( 'pc_page_content_before', 'pc_display_main_title_start', 20 );  // layout commun
add_action( 'pc_page_content_before', 'pc_display_main_title', 30, 1 );  // layout commun
add_action( 'pc_page_content_before', 'pc_display_main_title_end', 40 );  // layout commun

add_action( 'pc_page_content_footer', 'pc_display_main_footer_start', 10 );  // layout commun
add_action( 'pc_page_content_footer', 'pc_display_subpage_backlink', 20, 1 );
add_action( 'pc_page_content_footer', 'pc_display_share_links', 30 ); // layout commun
add_action( 'pc_page_content_footer', 'pc_display_main_footer_end', 40 ); // layout commun

add_action( 'pc_page_content_after', 'pc_display_main_end', 10 ); // layout commun


/*=====  FIN Hooks  =====*/

/*==============================================
=            Sous-page, lien retour            =
==============================================*/

function pc_display_subpage_backlink( $post ) {

    if ( $post->post_type == 'page' && $post->post_parent > 0 ) {

        echo '<nav class="main-footer-nav"><a href="'.get_the_permalink($post->post_parent).'" class="btn" title="Page précédente">'.pc_svg('arrow',null,'svg_block').'<span>Retour</span></a></nav>';

    }

}


/*=====  FIN Sous-page, lien retour  =====*/
