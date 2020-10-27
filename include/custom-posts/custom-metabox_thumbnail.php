<?php

/**
*
* Metabox visuel
*
**/

if ( class_exists('PC_Add_metabox') ) {


	/*----------  Associé à  ----------*/
	
	$metabox_thumbnail_for = array( 'page' );
	$metabox_thumbnail_for = apply_filters( 'pc_filter_metabox_thumbnail_for', $metabox_thumbnail_for );


	/*----------  Aide  ----------*/
	
	$metabox_thumbnail_desc = '<p>Sélectionnez le visuel utilisé pour : ';
	$metabox_thumbnail_desc .= '<br/>- <strong>afficher cette page sous sa forme résumée (liste de sous-pages ou l\'accueil)</strong>, ';
	$metabox_thumbnail_desc .= '<br/>- <strong>le partage sur les réseaux sociaux</strong>.';
	$metabox_thumbnail_desc .= '</p>';
	$metabox_thumbnail_desc .= ' <p><em><strong>Remarque :</strong> la taille minimum conseillée est de 700 x 440 pixels, si un visuel n\'est pas sélectionné, le logo est utilisé pour le résumé et les réseaux sociaux.</em></p>';
	$metabox_thumbnail_desc .= '</p>';

	$metabox_thumbnail_desc = apply_filters( 'pc_filter_metabox_thumbnail_desc', $metabox_thumbnail_desc );


	/*----------  Paramètres du champ  ----------*/
	
	$metabox_thumbnail_fields = array(
		'desc'          => $metabox_thumbnail_desc,
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

	$metabox_thumbnail_fields = apply_filters( 'pc_filter_metabox_thumbnail_fields', $metabox_thumbnail_fields );


	/*----------  Déclaration  ----------*/
	
	$metabox_thumbnail_declaration = new PC_Add_Metabox( $metabox_thumbnail_for, 'Visuel', 'page-metabox-thumbnail', $metabox_thumbnail_fields, 'normal', 'low' );


} // FIN if class_exist()