<?php
/**
 * 
 * Communs templates : Wysiwyg WP
 * 
 ** Container
 ** Excerpt
 * 
 */


/*=================================
=            Container            =
=================================*/

add_filter( 'the_content', 'pc_filter_the_content' );
    
    function pc_filter_the_content( $the_content ) {
    
        if ( in_the_loop() && is_main_query() ) {

			$content_before = apply_filters( 'pc_the_content_before', '<div class="editor"><div class="editor-inner">' );
			$content_after = apply_filters( 'pc_the_content_after', '</div></div>' );
			return $content_before.$the_content.$content_after;

        } else {

			return $the_content;

		}
    
        
    }


/*=====  FIN Container  =====*/

/*===============================
=            Excerpt            =
===============================*/

add_filter( 'excerpt_length', function() use ( $texts_lengths ) { return $texts_lengths['excerpt']; }, 999 );
add_filter( 'excerpt_more', function() { return ''; }, 999 );


/*=====  FIN Excerpt  =====*/