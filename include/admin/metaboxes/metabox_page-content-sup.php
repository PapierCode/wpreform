<?php
/**
*
* Communs templates : contenu supplémentaire ou sous-pages
*
*
*/

/*============================================
=            Déclaration métaboxe            =
============================================*/

add_action( 'add_meta_boxes', 'pc_page_add_metabox_content_more', 10, 2 );

	function pc_page_add_metabox_content_more( $post_type, $post ) {

		global $settings_project;

		// ne pas afficher
		$not_in = apply_filters( 'pc_filter_metabox_content_more_by_id', array( get_option( 'wp_page_for_privacy_policy' ) ) );
		if ( in_array( $post->ID, $not_in ) ) { return; }
		// titre
		$metabox_title = ( !empty( $settings_project['page-content-from'] ) ) ? 'Contenu supplémentaire' : 'Sous-pages';
		$metabox_title = apply_filters( 'pc_filter_page_metabox_content_more_title', $metabox_title, $post );

		add_meta_box(
			'page-content-sup',
			$metabox_title,
			'pc_page_metabox_content_more',
			array('page'),
			'normal',
			'high'
		);

	}


/*=====  FIN Déclaration métaboxe  =====*/

/*=================================
=            Fonctions            =
=================================*/

/*----------  Ligne du repeater sous-pages  ----------*/

/**
 * 
 * @param string	$css_class	Classes css associées à la ligne
 * @param array		$subpages	Posts sélectionnables (tableau d'objets) 
 * @param int		$current	Id du post associé à ligne
 * @param array		$saved		Toutes les sous-pages sauvegardées (tableau d'id)
 * 
 * @return string	HTML
 * 	
 */

function pc_get_subpage_repeater_line( $css_class, $subpages, $current = '', $saved = array() ) {

	$return = '<div class="'.$css_class.'">';
	
		// sélecteur de page
		$return .= '<select><option value=""></option>';
		foreach ( $subpages as $subpage ) {
			if ( $subpage->post_parent < 1 || in_array( $subpage->ID,$saved ) ) { // si ce n'est pas déjà une sous-page
				$return .= '<option value="'.$subpage->ID.'" '.selected( $current,$subpage->ID,false ).'>'.$subpage->post_title.'</option>';
			}
		}
		$return .= '</select>';

		// effacer la ligne
		$return .= ' <span title="Effacer" style="vertical-align:middle; cursor:pointer;" class="pc-repeater-btn-delete dashicons dashicons-trash"></span>';
		// déplacer la ligne
		$return .= ' <span title="Déplacer" style="vertical-align:middle; cursor:move;" class="dashicons dashicons-move"></span>';
	
	$return .= '</div>';

	return $return;

}


/*=====  FIN Fonctions  =====*/

/*==============================================
=            Contenu de la metaboxe            =
==============================================*/

function pc_page_metabox_content_more( $post ) {

	global $settings_project;  // cf. functions.php

    // input hidden de vérification pour la sauvegarde
	wp_nonce_field( basename( __FILE__ ), 'nonce-page-content-from' );

	// début mise en page
	echo '<div class="pc-metabox-help">';
    if ( $post->post_parent < 1 ) { // si la page en cours n'est pas déjà une sous-page
        if ( !empty( $settings_project['page-content-from'] ) ) {
            $metabox_desc = '<p><strong>Sélectionnez un contenu spécifique <strong style="font-weight:700">OU</strong> des sous-pages.</strong></p>';
        }		
    } else { // si la page courante est une sous-page
        $metabox_desc = '<p><strong>Sélectionnez un contenu spécifique.</strong></p>';
	}
	echo apply_filters( 'pc_filter_page_metabox_content_more_desc', $metabox_desc, $post );
	echo '</div>';
    echo '<table class="form-table"><tbody>';


    /*======================================================
    =            Sélection d'un contenu formaté            =
    ======================================================*/

    if ( !empty( $settings_project['page-content-from'] ) ) {
	
		// les types de contenu
		$content_from = $settings_project['page-content-from'];
		// filtre (par exemple pour supprimer un type déjà sélectionné)
		$content_from = apply_filters( 'pc_filter_page_metabox_select_content_from', $content_from, $post );
        // en bdd
        $content_from_saved = get_post_meta( $post->ID, 'content-from', true );

        // affichage
        echo '<tr><th><label for="content-from">Contenu spécifique</label></th><td>';
            echo '<select id="content-from" name="content-from"><option value=""></option>';
            foreach ( $content_from as $slug => $datas ) {
                echo '<option value="'.$slug.'" '.selected($content_from_saved,$slug,false).'>'.$datas[0].'</option>';
            }
            echo '</select>';
        echo '</td></tr>';

    }
    
    
    /*=====  FIN Sélection d'un contenu formaté  =====*/

    /*=============================================================
    =            Sélection de pages enfants (repeater)            =
    =============================================================*/
 
    if ( apply_filters( 'pc_filter_page_metabox_subpages_enabled', true ) && $post->post_parent < 1 ) { // si la page en cours n'est pas déjà une sous-page

		// les pages qui sont ou peuvent être sous-page
		$subpages_args = array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'post__not_in' => array($post->ID), // ne prend pas la page courante
            'meta_query' => array( // ne prend pas les pages parents
                array(
                    'key'     => 'content-subpages',
                    'compare' => 'NOT EXISTS',
                )
            ),
		);
		$subpages_args = apply_filters( 'pc_filter_page_metabox_subpages_args', $subpages_args, $post );
        $subpages = get_posts( $subpages_args );
        // liste des sous-pages sauvegardées
        $subpages_saved = get_post_meta( $post->ID, 'content-subpages', true );
        $subpages_saved_array = explode( ',', $subpages_saved );

        // affichage
        echo '<tr><th><label>Sous-pages</label></th><td>';
            echo '<div class="pc-repeater" data-type="subpage">';
				foreach ( $subpages_saved_array as $id ) {
					echo pc_get_subpage_repeater_line( 'pc-repeater-item', $subpages, $id, $subpages_saved_array );
				}
            echo '</div>';
            // c'est ce input qui est sauvegardé !
            echo '<input type="hidden" value="'.$subpages_saved.'" name="content-subpages" class="pc-repeater-input" />';
            // btn ajout ligne
            echo '<p><button type="button" class="pc-repeater-btn-more button">Ajouter une sous-page</button></p>';
        echo '</td></tr>';

        // source pour le js
        echo '<tr style="display:none"><td colspan="2">';
            echo pc_get_subpage_repeater_line( 'pc-repeater-item pc-repeater-src', $subpages );
        echo '</td></tr>';

    } // FIN if $post->post_parent < 1
    
   
    /*=====  FIN Sélection de pages enfants (repeater)  =====*/

    // fin tableau de mise en page
    echo '</tbody></table>';

}


/*=====  FIN Contenu de la metaboxe  =====*/

/*==================================
=            Sauvegarde            =
==================================*/

add_action( 'save_post', 'pc_page_metabox_content_more_save' );

	function pc_page_metabox_content_more_save( $post_id ) {

		// check input hidden de vérification
		if ( isset($_POST['nonce-page-content-from']) && wp_verify_nonce( $_POST['nonce-page-content-from'], basename( __FILE__ ) ) ) {

			// champs à traiter
			$fields = array(
				'content-from' => $_POST['content-from'],
				'content-subpages' => $_POST['content-subpages'],
			);

			foreach ($fields as $name => $value) {

				// pour manipuler la bdd
				global $wpdb;
				// valeur renvoyée par le form
				$temp = $value;
				// valeur en bdd
				$save = get_post_meta( $post_id, $name, true );


				/*----------  Traitement des sous-pages  ----------*/
				
				// si c'est la liste de sous-pages
				if ( $name == 'content-subpages' ) {

					$subpages_temp = explode(',',$temp);
					$subpages_saved = explode(',',$save);
										
					// nouvelle liste de sous-pages
					if ( $temp != '' && count($subpages_temp) > 0 ) {
						foreach ($subpages_temp as $temp_id) {
							// si ce n'est pas déjà une sous-page
							if ( !in_array($temp_id,$subpages_saved) ) {
								$wpdb->update(
									$wpdb->prefix.'posts',
									array('post_parent' => $post_id),
									array('ID' => $temp_id)
								);
							// si c'est déjà une sous-page
							} else {
								// suppression dans le tableau représentant la sauvegarde
								// voir "sous-page à détacher" ci-dessous
								unset($subpages_saved[array_search($temp_id, $subpages_saved)]);
							}
						}
					}

					// sous-page à détacher 
					if ( $save != '' && count($subpages_saved) > 0 ) {
						foreach ($subpages_saved as $save_id) {
							$wpdb->update(
								$wpdb->prefix.'posts',
								array('post_parent' => 0),
								array('ID' => $save_id)
							);
						}
					}
					
				}


				/*----------  Traitement du champ  ----------*/
				
				// si une valeur arrive & si rien en bdd
				if ( $temp && '' == $save ) {
					add_post_meta( $post_id, $name, $temp, true );

				// si une valeur arrive & différente de la bdd
				} elseif ( $temp && $temp != $save ) {
					update_post_meta( $post_id, $name, $temp );

				// si rien n'arrive & si un truc en bdd
				} elseif ( '' == $temp && $save ) {
					delete_post_meta( $post_id, $name );
				}

			};

		}

	}
		

/*=====  FIN Sauvegarde  =====*/