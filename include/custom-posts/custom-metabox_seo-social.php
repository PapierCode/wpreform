<?php

/**
*
* Metabox SEO & Résaux sociaux
*
**/

if ( class_exists('PC_Add_metabox') ) {

$metabox_seo_for = array( 'page' );
$metabox_seo_for = apply_filters( 'pc_filter_metabox_seo_for', $metabox_seo_for );

$metabox_seo_fields = array(
    'desc'          => '<p><strong>Optimisez le titre et le résumé pour les moteurs de recherche et les réseaux sociaux.</strong></p><p><em><strong>Remarques :</strong> Si ces champs ne sont pas saisis, le titre de la page et la description du résumé (encart "Résumé" ci-dessus) sont utilisés</em>.</p>',
    'prefix'        => 'seo',
    'fields'        => array(
        array(
            'type'      => 'text',
            'label'     => 'Titre',
            'desc'      => '',
            'id'        => 'title',
            'attr'      => 'class="pc-counter" data-counter-max="70"',
            'css'       => 'width:100%'
        ),
        array(
            'type'      => 'textarea',
            'label'     => 'Description',
            'desc'      => '',
            'id'        => 'desc',
            'attr'      => 'class="pc-counter" data-counter-max="200"',
            'css'       => 'width:100%'
        )
    )
);

$metabox_seo_declaration = new PC_Add_Metabox( $metabox_seo_for, 'Référencement (SEO) & Réseaux sociaux', 'page-metabox-seo', $metabox_seo_fields, 'normal', 'low' );


} // FIN if class_exist()