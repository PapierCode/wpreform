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
	
	$metabox_visual_desc = '<p>Sélectionnez le visuel pour : <strong>afficher cette page sous sa forme résumée, le référencement et le partage sur les réseaux sociaux</strong>.</p>';
	$metabox_visual_desc .= '<p><em><strong>Remarque :</strong> Si un visuel n\'est pas sélectionné, le logo est utilisé.</em></p>';

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