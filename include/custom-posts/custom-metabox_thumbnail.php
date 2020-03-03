<?php

/**
*
* Metabox visuel
*
**/

if ( class_exists('PC_Add_metabox') ) {

$metabox_thumbnail_for = array( 'page' );

$metabox_thumbnail_fields = array(
    'desc'          => '',
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

$metabox_thumbnail_fields['desc'] = '<p>Sélectionnez le visuel utilisé pour : ';
$metabox_thumbnail_size = '700 x 440';

if ( $settings_project['theme'] == 'fullscreen' ) {
	$metabox_thumbnail_fields['desc'] .= '<br/>- <strong>s\'afficher en plein écran</strong>, ';
	$metabox_thumbnail_size = '2000 x 1500';
}

$metabox_thumbnail_fields['desc'] .= '<br/>- <strong>afficher cette page sous sa forme résumée</strong> (dans une liste de pages par exemple), <br/>- <strong>le partage sur les réseaux sociaux</strong> .</p><p><em><strong>Remarques :</strong> la taille minimum conseillée est de '.$metabox_thumbnail_size.' pixels, si un visuel n\'est pas sélectionné, le logo est utilisé pour le résumé et les réseaux sociaux, il n\'y aura pas de visuel en plein écran.</em></p>';

$metabox_thumbnail_for = apply_filters( 'pc_filter_metabox_thumbnail_for', $metabox_thumbnail_for );

$metabox_thumbnail_declaration = new PC_Add_Metabox( $metabox_thumbnail_for, 'Visuel', 'page-metabox-thumbnail', $metabox_thumbnail_fields, 'normal', 'low' );


} // FIN if class_exist()