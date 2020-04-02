<?php

/**
 * 
 * Nettoyage wp_head() & wp_footer()
 * 
 */


// si ce n'est pas l'adminstration
if ( !is_admin() ) {

    // si ce n'est pas Papier Codé !
    if ( $current_user_role != 'administrator' ) {

        show_admin_bar(false); // barre d'admin coté public

        /*----------  JS embed  ----------*/

        add_action( 'wp_footer', 'pc_remove_js_embed' );

        function pc_remove_js_embed(){
            wp_deregister_script( 'wp-embed' );
        }

    }

    add_action( 'wp_enqueue_scripts', function() {

        /*----------  Nettoyage des option de wordpress  ----------*/

        remove_action( 'wp_head', 'rel_canonical' ); // lien canonical
        remove_action( 'wp_head', 'wp_resource_hints', 2 ); // lien prefetch

        // flux
        remove_action( 'wp_head', 'feed_links_extra', 3 );
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );

        // divers
        remove_action( 'wp_head', 'wp_shortlink_wp_head' );
        remove_action( 'wp_head', 'rest_output_link_wp_head' );
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );


        /*----------  Suppression des Emoji  ----------*/

        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );

        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );

    });


    /*----------  CSS Block Editor  ----------*/

    add_action( 'wp_print_styles', 'pc_remove_block_editor_css', 100 );

        function pc_remove_block_editor_css() {
            wp_dequeue_style( 'wp-block-library' );
            wp_deregister_style( 'wp-block-library' );
        }
        

    /*----------  Tags attributs  ----------*/
    
    add_filter('script_loader_tag', 'pc_remove_tag_attribut', 10, 3);

        function pc_remove_tag_attribut( $tag, $handle, $src ) {
            $tag = str_replace( "type='text/javascript' ", '', $tag );
            return str_replace( "'", '"', $tag );
        }
 

}