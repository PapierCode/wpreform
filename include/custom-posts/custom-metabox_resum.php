<?php

/**
*
* Metabox Résumé
*
**/

if ( class_exists('PC_Add_metabox') ) {

	/*----------  Associé à  ----------*/
	
	$metabox_resum_for = array( 'page' );
	$metabox_resum_for = apply_filters( 'pc_filter_metabox_resum_for', $metabox_resum_for );


	/*----------  Aide  ----------*/
	
	$metabox_resum_desc = '<p><strong>Optimisez le titre et la description de cette page sous sa forme résumée</strong>.</p><p><em><strong>Remarque :</strong> si ce titre n\'est pas saisi, le titre de la page est utilisé, si cette description n\'est pas saisie, les premiers mots du contenu sont utilisés, sinon il n\'a pas de description affichée.</em></p>';

	$metabox_resum_desc = apply_filters( 'pc_filter_metabox_seo_desc', $metabox_resum_desc );


	/*----------  Paramètres des champs  ----------*/

	$metabox_resum_fields = array(
		'desc'          => $metabox_resum_desc,
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

	$metabox_resum_fields = apply_filters( 'pc_filter_metabox_resum_fields', $metabox_resum_fields );
	

	/*----------  Déclaration  ----------*/
	
	$metabox_resum_declaration = new PC_Add_Metabox( $metabox_resum_for, 'Résumé', 'page-metabox-resum', $metabox_resum_fields, 'normal', 'high' );


} // FIN if class_exist();