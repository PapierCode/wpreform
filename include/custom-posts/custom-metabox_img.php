<?php

/**
*
* Metabox visuel
*
**/

if ( class_exists('PC_Add_metabox') ) {


	/*----------  Associé à  ----------*/
	
	$metabox_img_for = array( 'page' );
	$metabox_img_for = apply_filters( 'pc_filter_metabox_img_for', $metabox_img_for );


	/*----------  Aide  ----------*/
	
	$metabox_img_desc = '<p>Sélectionnez le visuel pour : <strong>afficher cette page sous sa forme résumée, le référencement et le partage sur les réseaux sociaux</strong>.</p>';
	$metabox_img_desc .= '<p><em><strong>Remarque :</strong> Si un visuel n\'est pas sélectionné, le logo est utilisé.</em></p>';

	$metabox_img_desc = apply_filters( 'pc_filter_metabox_img_desc', $metabox_img_desc );


	/*----------  Paramètres du champ  ----------*/
	
	$metabox_img_fields = array(
		'desc'          => $metabox_img_desc,
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

	$metabox_img_fields = apply_filters( 'pc_filter_metabox_img_fields', $metabox_img_fields );


	/*----------  Déclaration  ----------*/
	
	$metabox_img_declaration = new PC_Add_Metabox( $metabox_img_for, 'Visuel', 'page-metabox-visual', $metabox_img_fields, 'normal', 'low' );


} // FIN if class_exist()