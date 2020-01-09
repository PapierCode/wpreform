<?php
/**
 * 
 * Templates : structre globale
 * 
 */

/*======================================
=            Main structure            =
======================================*/

/*----------  Ouverture  ----------*/

function pc_get_main_start( $classes = '' ) {

    echo '<main id="main" class="main '.$classes.'"><div class="main-inner">';

}


/*----------  Titre (H1)  ----------*/

function pc_get_main_title( $text ) {

    echo '<h1>'.$text.'</h1>';

    // actualités filtrées, affichage de la catégorie en sous titre
    if ( get_query_var( NEWS_TAX_QUERY_VAR ) ) {
        $currentNewsTax = get_term_by( 'slug', get_query_var( NEWS_TAX_QUERY_VAR ), NEWS_TAX_SLUG );
        echo '<p>Pour la catégorie <em>'.$currentNewsTax->name.'</em></p>';
    }

}


/*----------  Fermeture  ----------*/

function pc_get_main_end() {

    echo '</div></main>';

}


/*=====  FIN Main structure  =====*/

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