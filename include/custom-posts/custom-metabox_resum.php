<?php

/**
*
* Metabox Résumé
*
**/

if ( class_exists('PC_Add_metabox') ) {


/*----------  Cibles  ----------*/

$resumFor = array( 'page', NEWS_POST_SLUG );


/*===========================
=            SEO            =
===========================*/

$resumMetaboxSeoContent = array(
    'desc'          => '<p>Pour l\'affichage de cette page sous sa forme résumée dans votre site (dans une liste d\'articles par exemple).</p><p><strong>Remarques :<br/></strong>- si ces champs ne sont pas saisis, le titre de la page et les premiers mots du contenu sont utilisés,<br/>- si un visuel n\'est pas sélectionné (encart "Visuel" ci-dessus), une image générique est utilisée.</p>',
    'prefix'        => 'resum',
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

$resumMetaboxSeo = new PC_Add_Metabox( $resumFor, 'Résumé', 'page-metabox-resum', $resumMetaboxSeoContent, 'normal', 'low' );


/*=====  FIN SEO  ======*/

} // FIN if class_exist()