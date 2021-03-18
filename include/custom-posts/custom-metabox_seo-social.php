<?php

/**
*
* Metabox SEO & Résaux sociaux
*
**/

if ( class_exists('PC_Add_metabox') ) {

	/*----------  Associé à  ----------*/
	
	$metabox_seo_for = array( 'page' );
	$metabox_seo_for = apply_filters( 'pc_filter_metabox_seo_for', $metabox_seo_for );

	/*----------  Aide  ----------*/
	
	$metabox_seo_desc = '<p><strong>Optimisez le titre et la description pour les moteurs de recherche et les réseaux sociaux.</strong></p><p><em><strong>Remarque :</strong> si ce titre n\'est pas saisi, le titre du résumé est utilisé, sinon le titre de la page, si cette description n\'est pas saisie, la description du résumé est utilisée, sinon la description par défaut (cf. Paramètres)';
	$metabox_seo_desc = apply_filters( 'pc_filter_metabox_seo_desc', $metabox_seo_desc );


	/*----------  Paramètres des champs  ----------*/
	
	$metabox_seo_fields = array(
		'desc'          => $metabox_seo_desc,
		'prefix'        => 'seo',
		'fields'        => array(
			array(
				'type'      => 'text',
				'label'     => 'Titre',
				'desc'      => '',
				'id'        => 'title',
				'attr'      => 'class="pc-counter" data-counter-max="'.$texts_lengths['seo-title'].'"',
				'css'       => 'width:100%'
			),
			array(
				'type'      => 'textarea',
				'label'     => 'Description',
				'desc'      => '',
				'id'        => 'desc',
				'attr'      => 'class="pc-counter" data-counter-max="'.$texts_lengths['seo-desc'].'"',
				'css'       => 'width:100%'
			)
		)
	);

	$metabox_seo_fields = apply_filters( 'pc_filter_metabox_seo_fields', $metabox_seo_fields );


	/*----------  Déclaration  ----------*/
	
	$metabox_seo_declaration = new PC_Add_Metabox( $metabox_seo_for, 'Référencement (SEO) & Réseaux sociaux', 
	'page-metabox-seo', $metabox_seo_fields, 'normal', 'high' );


} // FIN if class_exist()