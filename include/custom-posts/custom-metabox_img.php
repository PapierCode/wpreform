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
	
	$metabox_img_desc = '<p><strong>Sélectionnez l\'image associée à cette page pour : afficher cette page sous sa forme résumée, optimiser le référencement et le partage sur les réseaux sociaux</strong>.</p><p><em><strong>Remarque :</strong> Si une image n\'est pas sélectionnée, le logo est utilisé.</em></p>';

	if ( isset($settings_pc['wpreform-fullscreen']) ) {
		$metabox_img_desc = '<p><strong>Sélectionnez l\'image associée à cette page pour : afficher la page sous sa forme résumée ; afficher cette image en plein écran dans l\'entête de la page (si activé ci-dessous) ; optimiser le référencement (SEO) et le partage sur les réseaux sociaux</strong>.<p><em><strong>Remarques :</strong> si une image n\'est pas sélectionnée, il n\'y a pas d\'image en plein écran et le logo est utilisé pour le référencement et le partage sur les réseaux sociaux. Pour un affichage pleine page, la taille minimum conseillée est de 2000 x 1500 pixels.</em></p>';
	}


	/*----------  Paramètres du champ  ----------*/
	
	$metabox_img_fields = array(
		'desc'          => apply_filters( 'pc_filter_metabox_img_desc', $metabox_img_desc ),
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
					'label'     => 'Afficher en plein écran'
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