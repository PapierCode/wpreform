<?php
/**
 * 
 * Customisation de l'administration
 * 
 ** Css & js imports
 ** Formats d'images acceptés
 ** Nom des tailles d'images
 ** Labels dans la liste de page
 ** Colonnes des listes d'articles
 ** TinyMCE custom
 * 
 */

/*========================================
=            Css & js imports            =
========================================*/

add_action( 'admin_enqueue_scripts', 'pc_admin_enqueue_scripts' );

    function pc_admin_enqueue_scripts() {

        wp_enqueue_style( 'pc-css-admin', get_bloginfo( 'template_directory').'/include/custom-admin/custom-admin.css' );
        wp_enqueue_script( 'pc-js-admin', get_bloginfo( 'template_directory').'/include/custom-admin/custom-admin.js' );
        
    };


/*=====  FIN Css & js imports  =====*/


/*=================================================
=            Formats d'images acceptés            =
=================================================*/

add_filter( 'upload_mimes', 'pc_upload_mimes' );

    function pc_upload_mimes( $mimes ) {

        return $mimes = array (
            'jpg|jpeg' => 'image/jpeg',
            'pdf' => 'application/pdf'
        );

    };

 
/*=====  FIN Formats d'images acceptés  =====*/

/*================================================
=            Nom des tailles d'images            =
================================================*/

add_filter( 'image_size_names_choose', 'pc_rename_image_size_names' );

    function pc_rename_image_size_names( $sizes ) {

        return $sizes = array(
            'thumbnail' => '1/4 de page',
            'medium'    => '1/2 page',
            'large'     => 'Pleine largeur',
            'full'      => 'Originale'
        );

    }


/*=====  FIN Nom des tailles d'images  =====*/

/*====================================================
=            Labels dans la liste de page            =
====================================================*/
 
add_filter( 'display_post_states', 'pc_display_page_states', 99, 2 );

    function pc_display_page_states( $states, $post ) {

            $currentScreen = get_current_screen();
            if ( $currentScreen->id == 'edit-page') {

                global $projectSettings; // cf. functions.php
                global $pageContentFrom; // cf. functions.php

                switch ( $post->ID ) {
                    case $projectSettings['cgu-page']:
                        $states[] = 'Conditions générales d\'utilisation';
                        break;
                }

                $contentFrom = get_post_meta( $post->ID, 'content-from', true );
                foreach ( $pageContentFrom as $name => $slug ) {
                    if ( $contentFrom == $slug ) { $states[] = $name; }
                }

            }

        return $states;

    }


/*=====  FIN Labels dans la liste de page  =====*/

/*======================================================
=            Colonnes des listes d'articles            =
======================================================*/

/*----------  Page  ----------*/

add_filter( 'manage_page_posts_columns', 'pc_admin_page_list_custom_columns' );

if ( isset($pcSettings['news-active']) ) {
    add_action( 'manage_'.NEWS_POST_SLUG.'_posts_columns', 'pc_admin_page_list_custom_columns', 10, 2);
}

    function pc_admin_page_list_custom_columns( $columns ) {

        unset($columns['author']);

        // nouvelle colonne "image" en 2e position
        $newColumns = array();
        foreach($columns as $key => $value) {
            $newColumns[$key] = $value;
            if ( $key == 'cb' ){
                $newColumns['thumbnail'] = 'Visuel';
            }
        }
        return $newColumns;

    }

/*----------  Visuel  ----------*/

add_action( 'manage_page_posts_custom_column', 'pc_admin_list_column_img', 10, 2);

if ( isset($pcSettings['news-active']) ) {
    add_action( 'manage_'.NEWS_POST_SLUG.'_posts_custom_column', 'pc_admin_list_column_img', 10, 2);
}

    function pc_admin_list_column_img( $column, $postId ) {

        if ( 'thumbnail' === $column ) {
            
            $imgId = get_post_meta( $postId,'thumbnail-img',true );
            if ( $imgId != '' ) {
                echo pc_get_img( $imgId, 'st' );
            } else {
                echo '<img src="'.get_bloginfo('template_directory').'/images/admin-no-thumb.jpg" />';
            }
            
        }

    }



/*=====  FIN Colonnes des listes d'articles  =====*/

/*======================================
=            TinyMCE custom            =
======================================*/

// https://codex.wordpress.org/TinyMCE_Custom_Styles
// ajouter 'styleselect' dans la configuration de la barre d'outils

/* add_filter( 'tiny_mce_before_init', 'tinymce_project_styles' );

    function tinymce_project_styles( $init_array ) {

        // liste des styles
        $style_formats = array(
            array(
                'title' => 'Vert',
                'inline' => 'span',
                'classes' => 'txt-green',
                'wrapper' => false
            )
        );
        // mise à jour tu tableau en paramétre (JSON encodage)
        $init_array['style_formats'] = json_encode( $style_formats );
        return $init_array;

    } */


/*=====  FIN TinyMCE custom  ======*/