<?php
/**
 * 
 * Customisation de l'administration
 * 
 ** Css & js imports
 ** Formats d'images acceptés
 ** Nom des tailles d'images
 ** Actions groupées
 ** Labels dans la liste de page
 ** Colonnes des listes d'articles
 ** TinyMCE custom
 * 
 */

/*========================================
=            Css & js imports            =
========================================*/

add_action( 'admin_enqueue_scripts', 'pc_admin_enqueue_scripts', 999 );

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

/*========================================
=            Actions groupées            =
========================================*/

add_filter( 'bulk_actions-edit-page', 'pc_page_bluk_actions' );

	function pc_page_bluk_actions( $actions ) {

		unset($actions['edit']);
		return $actions;

	}



/*=====  FIN Actions groupées  =====*/

/*====================================================
=            Labels dans la liste de page            =
====================================================*/
 
add_filter( 'display_post_states', 'pc_display_page_states', 99, 2 );

    function pc_display_page_states( $states, $post ) {

            $current_screen = get_current_screen();
            if ( $current_screen->id == 'edit-page') {

                global $settings_project; // cf. functions.php

                switch ( $post->ID ) {
                    case $settings_project['cgu-page']:
                        $states[] = 'Conditions générales d\'utilisation';
                        break;
                }

                // contenu supplémentaire
                $content_from = get_post_meta( $post->ID, 'content-from', true );
                foreach ( $settings_project['page-content-from'] as $id => $datas ) {
                    if ( $content_from == $id ) { $states[] = $datas[0]; }
                }

            }

        return $states;

    }


/*=====  FIN Labels dans la liste de page  =====*/

/*======================================================
=            Colonnes des listes d'articles            =
======================================================*/

/*----------  Page  ----------*/

add_filter( 'manage_page_posts_columns', 'pc_admin_list_column_img' );

    function pc_admin_list_column_img( $columns ) {

        unset($columns['author']);

        // nouvelle colonne "image" en 2e position
        $new_columns = array();
        foreach($columns as $key => $value) {
            $new_columns[$key] = $value;
            if ( $key == 'cb' ){
                $new_columns['visual'] = 'Visuel';
            }
        }
        return $new_columns;

    }


/*----------  Visuel  ----------*/

add_action( 'manage_page_posts_custom_column', 'pc_admin_list_column_img_content', 10, 2);

    function pc_admin_list_column_img_content( $column, $postId ) {

        if ( 'visual' === $column ) {
            
            $img_id = get_post_meta( $postId,'visual-id',true );
            if ( $img_id != '' ) {
                echo pc_get_img( $img_id, 'share' );
            } else {
                echo '<img src="'.get_bloginfo('template_directory').'/images/admin-no-thumb.jpg" />';
            }
            
        }

    }



/*=====  FIN Colonnes des listes d'articles  =====*/

/*======================================
=            TinyMCE custom            =
======================================*/

add_action( 'admin_init', 'pc_admin_add_tinymce_css' );

	function pc_admin_add_tinymce_css() {

		add_editor_style( get_bloginfo( 'template_directory').'/include/custom-admin/custom-admin.css' );

	}


add_filter( 'tiny_mce_before_init', 'pc_admin_tinymce_formats' ); 

    function pc_admin_tinymce_formats( $init_array ) {  
        
        $style_formats = array(  
            array(  
                'title' => 'Introduction',
                'block' => 'p',
                'classes' => 'wysi-intro'
            )
		);      
		
        $init_array['style_formats'] = json_encode( $style_formats );  
        return $init_array;  
      
	}


/*=====  FIN TinyMCE custom  =====*/