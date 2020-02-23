<?php

/**
*
* Metabox visuel
*
**/

if ( class_exists('PC_Add_metabox') ) {

$metabox_thumbnail_for = array( 'page' );
$metabox_thumbnail_for = apply_filters( 'pc_filter_metabox_thumbnail_for', $metabox_thumbnail_for );

$metabox_thumbnail_fields = array(
    'desc'          => '<p>Le visuel utilisé pour afficher cette page sous sa forme résumée dans votre site et le partage sur les réseaux sociaux.<br/><strong>Taille minimum conseillée : 700 x 440 pixels.</strong></p>',
    'prefix'        => 'thumbnail',
    'fields'        => array(
        array(
            'type'      => 'img',
            'id'        => 'img',
            'label'     => 'Visuel',
            'options'   => array(
                'btnremove' => true
            )
        )
    )
);

$metabox_thumbnail_declaration = new PC_Add_Metabox( $metabox_thumbnail_for, 'Visuel', 'page-metabox-thumbnail', $metabox_thumbnail_fields, 'normal', 'low' );


} // FIN if class_exist()