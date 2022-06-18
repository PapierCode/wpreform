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

if ( !apply_filters('pc_filter_settings_home_disabled', false) ) {
	include 'settings/settings_home.php';
}


/*=====  FIN Include  =====*/

/*=================================================
=            Formats d'images acceptés            =
=================================================*/

add_filter( 'upload_mimes', 'pc_edit_upload_mimes' );

    function pc_edit_upload_mimes( $mimes ) {

        return $mimes = apply_filters( 'pc_filter_upload_mimes', array (
            'jpg|jpeg' => 'image/jpeg',
            'pdf' => 'application/pdf'
        ));

		return $mimes;

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

	if ( 'page' == $post->post_type ) {

		global $settings_project; // cf. functions.php

		// contenu supplémentaire
		$content_from = get_post_meta( $post->ID, 'content-from', true );

		if ( '' != $content_from ) {
			$states[] = $settings_project['page-content-from'][$content_from][0];
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
		if ( '' != $img_id && is_object( get_post( $img_id ) ) ) {
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

		if ( in_array( $current_user_role, array( 'editor', 'shop_manager', 'administrator' ) ) ) {

			// modifier oui
			if ( 'manage_privacy_options' === $cap ) {
				$manage_name = is_multisite() ? 'manage_network' : 'manage_options';
     			$caps = array_diff( $caps, array( $manage_name ) );
			}

		}

		if ( in_array( $current_user_role, array( 'editor', 'shop_manager' ) ) ) {
		
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

// n'a pas certaines métaboxes
add_filter( 'pc_filter_add_metabox', 'pc_cgu_no_metaboxes', 10, 3 );

	function pc_cgu_no_metaboxes( $display, $id, $post ) {

		if ( in_array( $id, array( 'page-metabox-img', 'page-metabox-card' ) ) && get_option( 'wp_page_for_privacy_policy' ) == $post->ID ) {
			$display = false;
		}

		return $display;

	}

// n'a pas la même métaboxe SEO & Social
add_filter( 'pc_filter_metabox_content', 'pc_cgu_edit_metabox_content', 10, 3 );

	function pc_cgu_edit_metabox_content( $content, $id, $post ) {

		if ( 'page-metabox-seo' == $id && get_option( 'wp_page_for_privacy_policy' ) == $post->ID ) {

			$content['desc'] = '<p><strong>Optimisez le titre et la description pour les moteurs de recherche et les réseaux sociaux.</strong></p><p><em><strong>Remarques :</strong> si ce titre n\'est pas saisi, le titre de la page est utilisé. Si cette description n\'est pas saisie, les premiers mots du contenu sont utilisés, sinon la description par défaut (cf. Paramètres)</em></p>';

		}

		return $content;

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