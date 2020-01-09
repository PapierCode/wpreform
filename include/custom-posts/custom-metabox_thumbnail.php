<?php

/**
*
* Metabox visuel
*
**/

if ( class_exists('PC_Add_metabox') ) {


/*----------  Cibles  ----------*/

$thumbnailFor = array( 'page', NEWS_POST_SLUG );


/*===========================
=            SEO            =
===========================*/

$thumbnailMetaboxSeoContent = array(
    'desc'          => '<p>Le visuel utilisé pour afficher cette page sous sa forme résumée et le partage sur les réseaux sociaux.</p>',
    'prefix'        => 'thumbnail',
    'fields'        => array(
        array(
            'type'      => 'img',
            'id'        => 'img',
            'label'     => 'Visuel',
            'options'   => array(
                'btnremove' => true
            )
        )
    )
);

$thumbnailMetaboxSeo = new PC_Add_Metabox( $thumbnailFor, 'Visuel', 'page-metabox-thumbnail', $thumbnailMetaboxSeoContent, 'normal', 'low' );


/*=====  FIN SEO  ======*/

} // FIN if class_exist()