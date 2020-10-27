<?php
/**
 * 
 * Fonctions Wysiwyg WP
 * 
 */


/*=================================
=            Container            =
=================================*/

add_filter( 'the_content', 'pc_filter_content' );
    
    function pc_filter_content( $content ) {
    
        if ( in_the_loop() && is_main_query() ) {
            return '<div class="editor"><div class="editor-inner">'.$content.'</div></div>';
        }
    
        return $content;
    }


/*=====  FIN Container  =====*/