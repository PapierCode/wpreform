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
    
    function pc_filter_content( $the_content ) {
    
        if ( in_the_loop() && is_main_query() ) {

			$return_before = apply_filters( 'pc_the_content_before', '<div class="editor"><div class="editor-inner">' );
			$return_after = apply_filters( 'pc_the_content_after', '</div></div>' );
			$return = $return_before.$the_content.$return_after;
			

        } else {

			$return = $the_content;

		}
    
        return $return;
    }


/*=====  FIN Container  =====*/