<?php

/**
*
* Metabox visuel
*
**/

if ( class_exists('PC_Add_metabox') ) {

$metabox_thumbnail_for = array( 'page', NEWS_POST_SLUG );

$metabox_thumbnail_fields = array(
    'desc'          => '<p>Le visuel utilisé pour afficher cette page sous sa forme résumée et le partage sur les réseaux sociaux.</p>',
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