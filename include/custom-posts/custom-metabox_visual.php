<?php

/**
*
* Metabox visuel
*
**/

if ( class_exists('PC_Add_metabox') ) {


	/*----------  Associé à  ----------*/
	
	$metabox_visual_for = array( 'page' );
	$metabox_visual_for = apply_filters( 'pc_filter_metabox_visual_for', $metabox_visual_for );


	/*----------  Aide  ----------*/
	
	$metabox_visual_desc = '<p>Sélectionnez le visuel utilisé pour : ';
	$metabox_visual_desc .= '<br/>- <strong>afficher cette page sous sa forme résumée (liste de sous-pages ou l\'accueil)</strong>, ';
	$metabox_visual_desc .= '<br/>- <strong>le partage sur les réseaux sociaux</strong>.';
	$metabox_visual_desc .= '</p>';
	$metabox_visual_desc .= ' <p><em><strong>Remarque :</strong> la taille minimum conseillée est de 700 x 440 pixels, si un visuel n\'est pas sélectionné, le logo est utilisé pour le résumé et les réseaux sociaux.</em></p>';
	$metabox_visual_desc .= '</p>';

	$metabox_visual_desc = apply_filters( 'pc_filter_metabox_visual_desc', $metabox_visual_desc );


	/*----------  Paramètres du champ  ----------*/
	
	$metabox_visual_fields = array(
		'desc'          => $metabox_visual_desc,
		'prefix'        => 'visual',
		'fields'        => array(
			array(
				'type'      => 'img',
				'id'        => 'id',
				'label'     => 'Visuel',
				'options'   => array(
					'btnremove' => true
				)
			)
		)
	);

	$metabox_visual_fields = apply_filters( 'pc_filter_metabox_visual_fields', $metabox_visual_fields );


	/*----------  Déclaration  ----------*/
	
	$metabox_visual_declaration = new PC_Add_Metabox( $metabox_visual_for, 'Visuel', 'page-metabox-visual', $metabox_visual_fields, 'normal', 'low' );


} // FIN if class_exist()