<?php
/**
 * 
 * Customisation de l'administration
 * 
 ** Include
 ** Css & js imports
 ** Formats d'images acceptés
 ** Nom des tailles d'images
 ** Liste de pages
 ** TinyMCE custom
 * 
 */


/*===============================
=            Include            =
===============================*/


/*----------  Configuration projet (client)  ----------*/

include 'settings/settings_project.php';
$settings_project = get_option('project-settings-option');
$settings_project['page-content-from'] = array();
$settings_project = apply_filters( 'pc_filter_settings_project', $settings_project );


/*----------  Métaboxes  ----------*/

include 'metaboxes/metabox_page-content-sup.php';
include 'metaboxes/metabox_image.php';
include 'metaboxes/metabox_card.php';
include 'metaboxes/metabox_seo-social.php';


/*----------  Accueil  ----------*/

include 'settings/settings_home.php';


/*=====  FIN Include  =====*/

/*========================================
=            Css & js imports            =
========================================*/

add_action( 'admin_enqueue_scripts', 'pc_admin_enqueue_scripts', 999 );

    function pc_admin_enqueue_scripts() {

        wp_enqueue_style( 'pc-css-admin', get_bloginfo( 'template_directory').'/include/admin/admin.css' );
        wp_enqueue_script( 'pc-js-admin', get_bloginfo( 'template_directory').'/include/admin/admin.js' );
        
    };


/*=====  FIN Css & js imports  =====*/


/*=================================================
=            Formats d'images acceptés            =
=================================================*/

add_filter( 'upload_mimes', 'pc_edit_upload_mimes' );

    function pc_edit_upload_mimes( $mimes ) {

        return $mimes = array (
            'jpg|jpeg' => 'image/jpeg',
            'pdf' => 'application/pdf'
        );

    };

 
/*=====  FIN Formats d'images acceptés  =====*/

/*================================================
=            Nom des tailles d'images            =
================================================*/

add_filter( 'image_size_names_choose', 'pc_edit_image_size_names_choose' );

    function pc_edit_image_size_names_choose( $sizes ) {

        return $sizes = array(
            'thumbnail' => '1/4 de page',
            'medium'    => '1/2 page',
            'large'     => 'Pleine largeur'
        );

    }


/*=====  FIN Nom des tailles d'images  =====*/

/*=============================
=            Pages            =
=============================*/

/*----------  Actions groupées  ----------*/

add_filter( 'bulk_actions-edit-page', 'pc_page_edit_bluk_actions' );

function pc_page_edit_bluk_actions( $actions ) {

	unset($actions['edit']);
	return $actions;

}


/*----------  Labels  ----------*/
 
add_filter( 'display_post_states', 'pc_edit_page_states', 99, 2 );

function pc_edit_page_states( $states, $post ) {

	if ( is_admin() && !is_customize_preview() ) {

		$current_screen = get_current_screen();
		if ( $current_screen->id == 'edit-page') {

			global $settings_project; // cf. functions.php

			// contenu supplémentaire
			$content_from = get_post_meta( $post->ID, 'content-from', true );

			foreach ( $settings_project['page-content-from'] as $id => $datas ) {
				if ( $content_from == $id ) { $states[] = $datas[0]; }
			}

		}
	
	}

	return $states;

}


/*----------  Colonnes  ----------*/

add_filter( 'manage_pages_columns', 'pc_page_edit_manage_posts_columns' );

    function pc_page_edit_manage_posts_columns( $columns ) {

        unset($columns['author']);

        // nouvelle colonne "image" en 2e position
        $new_columns = array();
        foreach($columns as $key => $value) {
            $new_columns[$key] = $value;
            if ( $key == 'cb' ){
                $new_columns['thumb'] = 'Visuel';
            }
        }
        return $new_columns;

    }

add_action( 'manage_pages_custom_column', 'pc_page_manage_posts_custom_column', 10, 2);

function pc_page_manage_posts_custom_column( $column_name, $post_id ) {

	if ( 'thumb' === $column_name ) {
		
		$img_id = get_post_meta( $post_id, 'visual-id', true );
		if ( $img_id != '' ) {
			echo pc_get_img( $img_id, 'share' );
		} else {
			echo '<img src="'.get_bloginfo('template_directory').'/images/admin-no-thumb.png" />';
		}
		
	}

}

/*----------  Page CGU pour les éditeurs  ----------*/

// modifiable mais pas supprimable
add_filter( 'map_meta_cap', 'pc_cgu_map_meta_cap', 10, 4 );

	function pc_cgu_map_meta_cap( $caps, $cap, $user_id, $args ) {

		global $current_user_role;

		if ( 'editor' == $current_user_role || 'shop_manager' == $current_user_role ) {

			// modifier oui
			if ( 'manage_privacy_options' === $cap ) {
				$caps = array_diff( $caps, ['manage_options'] );
			}
			// supprimer non
			if ( 'delete_post' == $cap && $args[0] == get_option( 'wp_page_for_privacy_policy' ) ) {
				$caps[] = 'do_not_allow';
			}

		}

		return $caps;
	}

// toujours publié
add_filter( 'wp_insert_post_data', 'pc_cgu_status', 10, 2 );

	function pc_cgu_status( $data, $postarr ) {
		
		if ( 'page' == $data['post_type'] && get_option( 'wp_page_for_privacy_policy' ) == $postarr['ID'] ) {
			$data['post_status'] = 'publish';
			$data['post_password'] = '';
		}

		return $data;
		
	}

// ne peut être sélectionner
add_filter( 'wp_list_table_show_post_checkbox', 'pc_cgu_checkbox', 10, 2 );

	function pc_cgu_checkbox( $show, $post ) {

		global $current_user_role;

		if ( 'editor' == $current_user_role || 'shop_manager' == $current_user_role ) {
			if ( $post->ID == get_option( 'wp_page_for_privacy_policy' ) ) {
				$show = false;
			}
		}

		return $show;

	}


/*=====  FIN Pages  =====*/

/*======================================
=            TinyMCE custom            =
======================================*/

add_action( 'admin_init', 'pc_tinymce_css' );

	function pc_tinymce_css() {

		add_editor_style( get_bloginfo( 'template_directory').'/include/admin/admin.css' );

	}


add_filter( 'tiny_mce_before_init', 'pc_tinymce_edit_formats' ); 

    function pc_tinymce_edit_formats( $init_array ) {  
        
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