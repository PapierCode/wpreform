<?php

/**
*
* Metabox image
*
**/

if ( class_exists('PC_Add_metabox') ) {


	/*----------  Associé à  ----------*/
	
	$metabox_img_for = array( 'page' );
	$metabox_img_for = apply_filters( 'pc_filter_metabox_img_for', $metabox_img_for );


	/*----------  Aide  ----------*/
	
	$metabox_img_desc = '<p>Sélectionnez une image pour : <strong>afficher cette page sous sa forme résumée, le référencement et le partage sur les réseaux sociaux</strong>.</p>';
	$metabox_img_desc .= '<p><em><strong>Remarque :</strong> Si une image n\'est pas sélectionnée, le logo est utilisé.</em></p>';

	$metabox_img_desc = apply_filters( 'pc_filter_metabox_img_desc', $metabox_img_desc );


	/*----------  Paramètres du champ  ----------*/
	
	$metabox_img_fields = array(
		'desc'          => $metabox_img_desc,
		'prefix'        => 'visual',
		'fields'        => array(
			array(
				'type'      => 'img',
				'id'        => 'id',
				'label'     => 'Image',
				'options'   => array(
					'btnremove' => true
				)
			)
		)
	);

	$metabox_img_fields = apply_filters( 'pc_filter_metabox_img_fields', $metabox_img_fields );


	/*----------  Déclaration  ----------*/
	
	$metabox_img_declaration = new PC_Add_Metabox( $metabox_img_for, 'Image', 'page-metabox-img', $metabox_img_fields, 'normal', 'low' );


} // FIN if class_exist()