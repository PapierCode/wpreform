<?php

/**
*
* Metabox Résumé
*
**/

if ( class_exists('PC_Add_metabox') ) {

$metabox_resum_for = array( 'page', NEWS_POST_SLUG );

$metabox_resum_fields = array(
    'desc'          => '<p>Pour l\'affichage de cette page sous sa forme résumée dans votre site (dans une liste d\'articles par exemple).</p><p><strong>Remarques :<br/></strong>- si ces champs ne sont pas saisis, le titre de la page et les premiers mots du contenu sont utilisés,<br/>- si un visuel n\'est pas sélectionné (encart "Visuel" ci-dessus), une image générique est utilisée.</p>',
    'prefix'        => 'resum',
    'fields'        => array(
        array(
            'type'      => 'text',
            'label'     => 'Titre',
            'desc'      => '',
            'id'        => 'title',
            'attr'      => 'class="pc-counter" data-counter-max="70"',
            'css'       => 'width:100%'
        ),
        array(
            'type'      => 'textarea',
            'label'     => 'Description',
            'desc'      => '',
            'id'        => 'desc',
            'attr'      => 'class="pc-counter" data-counter-max="200"',
            'css'       => 'width:100%'
        )
    )
);

$metabox_resum_declaration = new PC_Add_Metabox( $metabox_resum_for, 'Résumé', 'page-metabox-resum', $metabox_resum_fields, 'normal', 'low' );


} // FIN if class_exist()