<?php

/**
*
* Metabox SEO & Résaux sociaux
*
**/

if ( class_exists('PC_Add_metabox') ) {


/*----------  Cibles  ----------*/

$seoFor = array( 'page', NEWS_POST_SLUG );


/*===========================
=            SEO            =
===========================*/

$seoMetaboxSeoContent = array(
    'desc'          => $pcSettings['help-seo-social'],
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

$seoMetaboxSeo = new PC_Add_Metabox( $seoFor, 'Optimisations référencement (SEO) & Réseaux sociaux', 'page-metabox-seo', $seoMetaboxSeoContent, 'normal', 'low' );


/*=====  FIN SEO  ======*/

} // FIN if class_exist()