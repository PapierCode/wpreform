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

    add_meta_box(
        'page-content-sup',
        'Contenu supplémentaire',
        'pc_page_content_sub',
        array('page'),
        'normal',
        'high'
    );

} );


/*=====  FIN Déclaration métaboxe  =====*/

/*=================================
=            Fonctions            =
=================================*/

/*----------  Repeater sous-pages : affichage d'une ligne  ----------*/

function pc_meta_subpage_line( $classes, $options, $current = '', $save = array() ) {
    echo '<div class="'.$classes.'"><select><option value=""></option>';
    foreach ($options as $subpage ) {
        if ( $subpage->post_parent < 1 || in_array($subpage->ID,$save) ) { // si ce n'est pas déjà une sous-page
            echo '<option value="'.$subpage->ID.'" '.selected($current,$subpage->ID,false).'>'.$subpage->post_title.'</option>';
        }
    }
    echo '</select>';
    echo ' <span title="Effacer" style="vertical-align:middle; cursor:pointer;" class="pc-repeater-btn-delete dashicons dashicons-no"></span>';
    echo ' <span title="Déplacer" style="vertical-align:middle; cursor:move;" class="dashicons dashicons-move"></span>';
    echo '</div>';
}


/*----------  Update sous-page  ----------*/

function pc_update_subpage( $postId, $postParent ) {
    
    // prévention contre une boucle infinie 1/2
    remove_action( 'save_post', 'pc_sub_page_save' );
    // update
    wp_update_post(array(
        'ID' => $postId,
        'post_parent' => $postParent
    ));
    // prévention contre une boucle infinie 2/2
    add_action( 'save_post', 'pc_sub_page_save' );

}


/*=====  FIN Fonctions  =====*/

/*==============================================
=            Contenu de la metaboxe            =
==============================================*/

function pc_page_content_sub( $post ) {

    global $pcSettings;  // cf. functions.php
    global $pageContentFrom; // cf. functions.php

    // input hidden de vérification pour la sauvegarde
    wp_nonce_field( basename( __FILE__ ), 'none-page-content-sup' );

    // début mise en page
    if( $post->post_parent < 1 ) { // si parent ou à devenir
        echo '<p>Sélectionnez un contenu spécifique <strong style="font-weight:700">OU</strong> des sous-pages.</p>';
        echo '<p><em><strong>Remarque :</strong> lorsqu\'une page devient sous-page, son adresse (URL) est préfixée avec l\'adresse de la page parent, pour indiquer la hiérarchie.</em></p>';
    } else { // si enfant
        echo '<p>Sélectionnez un contenu spécifique.<br/>';
    }
    echo '<table class="form-table"><tbody>';


    /*======================================================
    =            Sélection d'un contenu formaté            =
    ======================================================*/
    
    // en bdd
    $selectedArchive = get_post_meta( $post->ID, 'content-from', true );

    // affichage
    echo '<tr><th><label for="content-from">Contenu spécifique</label></th><td>';
        echo '<select id="content-from" name="content-from"><option value=""></option>';
        foreach ($pageContentFrom as $slug => $datas ) {
            echo '<option value="'.$slug.'" '.selected($selectedArchive,$slug,false).'>'.$datas[0].'</option>';
        }
        echo '</select>';
    echo '</td></tr>';
    
    
    /*=====  FIN Sélection d'un contenu formaté  =====*/

    /*=============================================================
    =            Sélection de pages enfants (repeater)            =
    =============================================================*/
    
    if( $post->post_parent < 1 ) { // si la page en cours n'est pas enfant

        // pages pour le select
        $allSubpages = get_posts(array(
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
        $subpagesSaved = get_post_meta( $post->ID, 'content-subpages', true );
        $subpagesSavedArray = explode(',',$subpagesSaved);

        // affichage
        echo '<tr><th><label>Sous-pages</label></th><td>';
            echo '<div class="pc-repeater" data-type="subpage">';
            foreach ($subpagesSavedArray as $key => $id) {
                pc_meta_subpage_line( 'pc-repeater-item', $allSubpages, $id, $subpagesSavedArray );
            }
            echo '</div>';
            // c'est ce input qui est sauvegardé !
            echo '<input type="hidden" value="'.$subpagesSaved.'" name="content-subpages" class="pc-repeater-input" />';
            // btn ajout ligne
            echo '<p><button type="button" class="pc-repeater-btn-more button">Ajouter une sous-page</button></p>';
        echo '</td></tr>';

        // source pour le js
        echo '<tr style="display:none"><td colspan="2">';
            pc_meta_subpage_line( 'pc-repeater-item pc-repeater-src', $allSubpages );
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

function pc_sub_page_save( $postId ) {

    // check input hidden de vérification
    if ( isset($_POST['none-page-content-sup']) && wp_verify_nonce( $_POST['none-page-content-sup'], basename( __FILE__ ) ) ) {

        // champs à traiter
        $fields = array(
            'content-from' => $_POST['content-from'],
            'content-subpages' => $_POST['content-subpages'],
        );

        foreach ($fields as $name => $value) {

            // valeur renvoyée par le form
            $temp = $value;
            // valeur en bdd
            $save = get_post_meta( $postId, $name, true );


            /*----------  Traitement des sous-pages  ----------*/
            
            // si ce n'est pas une révision et si c'est la liste de sous-pages
            if ( !wp_is_post_revision( $postId ) && $name == 'content-subpages' ) {

                $subpagesTemp = explode(',',$temp);
                $subpagesSave = explode(',',$save);
                
                // nouvelle liste de sous-pages
                if ( $temp != '' && count($subpagesTemp) > 0 ) {
                    foreach ($subpagesTemp as $tempId) {
                        // si ce n'est pas déjà une sous-page
                        if ( !in_array($tempId,$subpagesSave) ) {
                            pc_update_subpage( $tempId, $postId );
                        // si c'est déjà une sous-page
                        } else {
                            // suppression dans le tableau représentant la sauvegarde
                            // voir "sous-page à détacher" ci-dessous
                            unset($subpagesSave[array_search($tempId, $subpagesSave)]);
                        }
                    }
                }

                // sous-page à détacher 
                if ( $save != '' && count($subpagesSave) > 0 ) {
                    foreach ($subpagesSave as $saveId) { pc_update_subpage( $saveId, '' ); }
                }
            }


            /*----------  Traitement du champ  ----------*/
            
            // si une valeur arrive & si rien en bdd
            if ( $temp && '' == $save ) {
                add_post_meta( $postId, $name, $temp, true );

            // si une valeur arrive & différente de la bdd
            } elseif ( $temp && $temp != $save ) {
                update_post_meta( $postId, $name, $temp );

            // si rien n'arrive & si un truc en bdd
            } elseif ( '' == $temp && $save ) {
                delete_post_meta( $postId, $name );
            }

        };

    }

}
    

/*=====  FIN Sauvegarde  =====*/