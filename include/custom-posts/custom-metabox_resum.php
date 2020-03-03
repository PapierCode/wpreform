<?php

/**
*
* Metabox Résumé
*
**/

if ( class_exists('PC_Add_metabox') ) {

$metabox_resum_for = array( 'page' );
$metabox_resum_for = apply_filters( 'pc_filter_metabox_resum_for', $metabox_resum_for );

$metabox_resum_fields = array(
    'desc'          => '<p><strong>Remplissez ces champs pour afficher cette page sous sa forme résumée</strong> (dans une liste de pages par exemple).</p><p><em><strong>Remarques :</strong> si ces champs ne sont pas saisis, le titre de la page et les premiers mots du contenu sont utilisés.</em></p>',
    'prefix'        => 'resum',
    'fields'        => array(
        array(
            'type'      => 'text',
            'label'     => 'Titre',
            'desc'      => '',
            'id'        => 'title',
            'attr'      => 'class="pc-counter" data-counter-max="40"',
            'css'       => 'width:100%'
        ),
        array(
            'type'      => 'textarea',
            'label'     => 'Description',
            'desc'      => '',
            'id'        => 'desc',
            'attr'      => 'class="pc-counter" data-counter-max="150"',
            'css'       => 'width:100%'
        )
    )
);

$metabox_resum_declaration = new PC_Add_Metabox( $metabox_resum_for, 'Résumé', 'page-metabox-resum', $metabox_resum_fields, 'normal', 'low' );


} // FIN if class_exist();