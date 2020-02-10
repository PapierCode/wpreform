<?php
/**
 * 
 * Templates : structure globale
 * 
 */


/*----------  Accueil  ----------*/

add_action( 'pc_home_content_before', 'pc_display_main_start', 10 );

add_action( 'pc_home_content', 'pc_display_home_content', 10, 1 );

add_action( 'pc_home_content_footer', 'pc_display_main_footer_start', 10 );
add_action( 'pc_home_content_footer', 'pc_display_share_links', 20 );
add_action( 'pc_home_content_footer', 'pc_display_main_footer_end', 30 );

add_action( 'pc_home_content_after', 'pc_display_main_end', 10 );


/*----------  Page & post  ----------*/

add_action( 'pc_content_before', 'pc_display_main_start', 10 );

add_action( 'pc_content_before', 'pc_display_main_title', 20, 1 );

add_action( 'pc_content_footer', 'pc_display_main_footer_start', 10 );
add_action( 'pc_content_footer', 'pc_display_main_footer_subpage_backlink', 20, 1 );
add_action( 'pc_content_footer', 'pc_display_share_links', 30 );
add_action( 'pc_content_footer', 'pc_display_main_footer_end', 40 );

add_action( 'pc_content_after', 'pc_display_main_end', 10 );


/*----------  Fonctions associées  ----------*/

function pc_display_main_start() {

    echo '<main id="main" class="main layout"><div class="main-inner">';

}

function pc_display_main_end() {

    echo '</div></main>';

}

function pc_display_main_title( $post ) {

    echo '<h1>'.get_the_title( $post->ID ).'</h1>';

}

function pc_display_main_footer_start() {

    echo '<footer>';

}

function pc_display_main_footer_end() {

    echo '</footer>';

}

function pc_display_main_footer_subpage_backlink( $post ) {

    if ( $post->post_type == 'page' && $post->post_parent > 0 ) {

        echo '<a href="'.get_the_permalink($post->post_parent).'" class="" title="">< page parent</a>';

    }

}

function pc_display_home_content( $settings_home ) {

    echo '<h1>'.$settings_home['content-title'].'</h1>';
    echo pc_wp_wysiwyg( $settings_home['content-intro'] );

}


/*=========================================
=            Wysiwyg container            =
=========================================*/

add_filter( 'the_content', 'pc_filter_content' );
    
    function pc_filter_content( $content ) {
    
        if ( in_the_loop() && is_main_query() ) {
            return '<div class="editor">'.$content.'</div>';
        }
    
        return $content;
    }


/*=====  FIN Wysiwyg container  =====*/