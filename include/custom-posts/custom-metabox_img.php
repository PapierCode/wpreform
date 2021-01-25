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
	
	$metabox_img_desc = '<p>Sélectionnez l\'image associée à cette page pour : <strong>afficher la page sous sa forme résumée, le référencement et le partage sur les réseaux sociaux</strong>.</p><p><em><strong>Remarque :</strong> Si une image n\'est pas sélectionnée, le logo est utilisé.</em></p>';

	if ( isset($settings_pc['wpreform-fullscreen']) ) {
		$metabox_img_desc = '<p>Sélectionnez l\'image associée à cette page pour : <strong>la page sous sa forme résumée, afficher l\'image en pleine page (si activé), le référencement et le partage sur les réseaux sociaux</strong>.<p><em><strong>Remarques :</strong> Si une image n\'est pas sélectionnée, il n\'y a pas d\'image en pleine page et le logo est utilisé pour le référencement et le partage sur les réseaux sociaux. Pour un affichage pleine page, la taille minimum conseillée est de 2000 x 1500 pixels.</em></p>';
	}

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

	if ( isset($settings_pc['wpreform-fullscreen']) ) {

		$metabox_img_fields['fields'] = array_merge(
			$metabox_img_fields['fields'],
			array(
				array(
					'type'      => 'checkbox',
					'id' 		=> 'fullscreen',
					'label'     => 'Afficher en pleine page'
				),
				array(
					'type'      => 'radio',
					'id' 		=> 'title-h',
					'label'     => 'Position horizontale du titre',
					'options'	=> array( 
						'Gauche' => 'left',
						'Centre' => 'center',
						'Droite' => 'right'
					)
				),
				array(
					'type'      => 'radio',
					'id' 		=> 'title-v',
					'label'     => 'Position verticale du titre',
					'options'	=> array( 
						'Haut' => 'top',
						'Centre' => 'center',
						'Bas' => 'bottom'
					)
				)
			)
		);
	}

	$metabox_img_fields = apply_filters( 'pc_filter_metabox_img_fields', $metabox_img_fields );


	/*----------  Déclaration  ----------*/
	
	$metabox_img_declaration = new PC_Add_Metabox( $metabox_img_for, 'Image associée', 'page-metabox-img', $metabox_img_fields, 'normal', 'high' );


} // FIN if class_exist()