<?php

/**
*
* Métaboxe : résumé d'article
*
**/

if ( class_exists('PC_Add_metabox') ) {

	/*----------  Associé à  ----------*/
	
	$metabox_card_for = array( 'page' );
	$metabox_card_for = apply_filters( 'pc_filter_metabox_card_for', $metabox_card_for );


	/*----------  Aide  ----------*/
	
	$metabox_card_desc = '<p><strong>Optimisez le titre et la description de cette page pour sa forme résumée</strong>.</p><p><em><strong>Remarques :</strong> si ce titre n\'est pas saisi, le titre de la page est utilisé. Si cette description n\'est pas saisie, les premiers mots du contenu sont utilisés.</em></p>';


	/*----------  Paramètres des champs  ----------*/

	$metabox_card_fields = array(
		'desc'          => apply_filters( 'pc_filter_metabox_card_desc', $metabox_card_desc, $metabox_card_for ),
		'prefix'        => 'resum',
		'fields'        => array(
			array(
				'type'      => 'text',
				'label'     => 'Titre',
				'desc'      => '',
				'id'        => 'title',
				'attr'      => 'class="pc-counter" data-counter-max="'.$texts_lengths['resum-title'].'"',
				'css'       => 'width:100%'
			),
			array(
				'type'      => 'textarea',
				'label'     => 'Description',
				'desc'      => '',
				'id'        => 'desc',
				'attr'      => 'class="pc-counter" data-counter-max="'.$texts_lengths['resum-desc'].'"',
				'css'       => 'width:100%'
			)
		)
	);

	$metabox_card_fields = apply_filters( 'pc_filter_metabox_card_fields', $metabox_card_fields, $metabox_card_for );
	

	/*----------  Déclaration  ----------*/
	
	$register_metabox_card = new PC_Add_Metabox( $metabox_card_for, 'Résumé', 'page-metabox-card', $metabox_card_fields, 'normal', 'high' );


} // FIN if class_exist();