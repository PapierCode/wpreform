<?php

/**
*
* Metabox SEO & Résaux sociaux
*
**/

if ( class_exists('PC_Add_metabox') ) {

$metabox_seo_for = array( 'page', NEWS_POST_SLUG );

$metabox_seo_fields = array(
    'desc'          => $settings_pc['help-seo-social'],
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

$metabox_seo_declaration = new PC_Add_Metabox( $metabox_seo_for, 'Optimisations référencement (SEO) & Réseaux sociaux', 'page-metabox-seo', $metabox_seo_fields, 'normal', 'low' );


} // FIN if class_exist()