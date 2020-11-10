<?php
/**
*
* Metaboxe page : contenu supplémentaire ou sous-pages
*
*
*/

/*============================================
=            Déclaration métaboxe            =
============================================*/

add_action( 'admin_init', function() {

    global $settings_project;
    $box_content_more_title = ( !empty( $settings_project['page-content-from'] ) ) ? 'Contenu supplémentaire' : 'Sous-pages';

    add_meta_box(
        'page-content-sup',
        $box_content_more_title,
        'pc_page_content_sup',
        array('page'),
        'normal',
        'high'
    );

} );


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

function pc_repeater_subpage_line( $css_class, $subpages, $current = '', $saved = array() ) {

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
		$return .= ' <span title="Effacer" style="vertical-align:middle; cursor:pointer;" class="pc-repeater-btn-delete dashicons dashicons-no"></span>';
		// déplacer la ligne
		$return .= ' <span title="Déplacer" style="vertical-align:middle; cursor:move;" class="dashicons dashicons-move"></span>';
	
	$return .= '</div>';

	return $return;

}


/*=====  FIN Fonctions  =====*/

/*==============================================
=            Contenu de la metaboxe            =
==============================================*/

function pc_page_content_sup( $post ) {

	global $settings_project;  // cf. functions.php

    // input hidden de vérification pour la sauvegarde
	wp_nonce_field( basename( __FILE__ ), 'nonce-page-content-from' );

	// début mise en page
	echo '<div class="pc-metabox-help">';
    if ( $post->post_parent < 1 ) { // si la page en cours n'est pas déjà une sous-page
        if ( !empty( $settings_project['page-content-from'] ) ) {
            echo '<p><strong>Sélectionnez un contenu spécifique <strong style="font-weight:700">OU</strong> des sous-pages.</strong></p>';
        }
		echo '<p><em><strong>Remarque :</strong> lorsqu\'une page devient sous-page, son adresse (URL) est préfixée avec l\'adresse de la page parent, pour indiquer la hiérarchie.</em></p>';
		
    } else { // si la page courante est une sous-page
        echo '<p><strong>Sélectionnez un contenu spécifique.</strong></p>';
	}
	echo '</div>';
    echo '<table class="form-table"><tbody>';


    /*======================================================
    =            Sélection d'un contenu formaté            =
    ======================================================*/

    if ( !empty( $settings_project['page-content-from'] ) ) {
	
		// les types de contenu
		$metabox_select_content_from = $settings_project['page-content-from'];
		// filtre (par exemple pour supprimer un type déjà sélectionné)
		$metabox_select_content_from = apply_filters( 'pc_filter_metabox_select_content_from', $metabox_select_content_from, $post );
        // en bdd
        $content_from_saved = get_post_meta( $post->ID, 'content-from', true );

        // affichage
        echo '<tr><th><label for="content-from">Contenu spécifique</label></th><td>';
            echo '<select id="content-from" name="content-from"><option value=""></option>';
            foreach ( $metabox_select_content_from as $slug => $datas ) {
                echo '<option value="'.$slug.'" '.selected($content_from_saved,$slug,false).'>'.$datas[0].'</option>';
            }
            echo '</select>';
        echo '</td></tr>';

    }
    
    
    /*=====  FIN Sélection d'un contenu formaté  =====*/

    /*=============================================================
    =            Sélection de pages enfants (repeater)            =
    =============================================================*/
    
    if( $post->post_parent < 1 ) { // si la page en cours n'est pas déjà une sous-page

        // les pages qui sont ou peuvent être sous-page
        $all_subpages = get_posts(array(
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
        ));
        // liste des sous-pages sauvegardées
        $subpages_saved = get_post_meta( $post->ID, 'content-subpages', true );
        $subpages_saved_array = explode( ',', $subpages_saved );

        // affichage
        echo '<tr><th><label>Sous-pages</label></th><td>';
            echo '<div class="pc-repeater" data-type="subpage">';
				foreach ( $subpages_saved_array as $id ) {
					echo pc_repeater_subpage_line( 'pc-repeater-item', $all_subpages, $id, $subpages_saved_array );
				}
            echo '</div>';
            // c'est ce input qui est sauvegardé !
            echo '<input type="hidden" value="'.$subpages_saved.'" name="content-subpages" class="pc-repeater-input" />';
            // btn ajout ligne
            echo '<p><button type="button" class="pc-repeater-btn-more button">Ajouter une sous-page</button></p>';
        echo '</td></tr>';

        // source pour le js
        echo '<tr style="display:none"><td colspan="2">';
            echo pc_repeater_subpage_line( 'pc-repeater-item pc-repeater-src', $all_subpages );
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

add_action( 'save_post', 'pc_sub_page_save' );

	function pc_sub_page_save( $post_id ) {

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