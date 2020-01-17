<?php

/**
*
* Paramètres de la page d'accueil
*
*
*/

// si la class est disponible
if ( class_exists('PC_Add_Admin_Page') ) {

/*----------  Contenu  ----------*/

// sections et champs associés
$settings_home_fields = array(
    array(
        'title'     => 'Contenu',
        'id'        => 'content',
        'prefix'    => 'content',
        'fields'    => array(
            array(
                'type'      => 'text',
                'label_for' => 'title',
                'label'     => 'Titre de la page',
                'css'       => 'width:100%',
                'required'  => true
            ),
            array(
                'type'      => 'wysiwyg',
                'label_for' => 'intro',
                'label'     => 'Introduction',
                'options'   => array(
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                    'tinymce'       => array (
                        'toolbar1'  => 'fullscreen,undo,redo,removeformat,|,bullist,numlist,|,bold,italic,strikethrough,superscript,charmap,|,link,unlink'
                    )
                ),
                'required'  => true
            ),
            array(
                'type'      => 'text',
                'label_for' => 'newstitle',
                'label'     => 'Titre des actualités',
                'css'       => 'width:100%',
                'required'  => true
            ),
            array(
                'type'      => 'select',
                'label_for' => 'nbnews',
                'label'     => 'Nombre d\'actualités',
                'required'  => true,
                'options'   => array(
                    '2' => '2',
                    '4' => '4'
                )
            ),
        )
    ),
    array(
        'title'     => 'Optimisation référencement & réseaux sociaux',
        'desc'      => '<p>Pour l\'affichage de cette page sous sa forme résumée dans les résultats des moteurs de recherche et les réseaux sociaux.</p><p><strong>Remarques :<br/></strong>- si ces champs ne sont pas saisis, le titre de la page et les premiers mots du contenu sont utilisés,<br/>- si un visuel n\'est pas sélectionné, le logo est utilisé.</p>',
        'id'        => 'seo',
        'prefix'    => 'seo',
        'fields'    => array(
            array(
                'type'      => 'text',
                'label_for' => 'title',
                'label'     => 'Titre',
                'attr'      => 'class="pc-counter" data-counter-max="70"',
                'css'       => 'width:100%'
            ),
            array(
                'type'      => 'textarea',
                'label_for' => 'desc',
                'label'     => 'Description',
                'attr'      => 'class="pc-counter" data-counter-max="200"',
                'css'       => 'width:100%'
            ),
            array(
                'type'      => 'img',
                'label_for' => 'img',
                'label'     => 'Visuel',
                'options'   => array(
                    'btnremove' => true
                )
            ),
        )
    )
);

$settings_home_fields = apply_filters( 'pc_filter_settings_home_fields', $settings_home_fields );


/*----------  Création  ----------*/

$settings_home_declaration = new PC_Add_Admin_Page(
    'Page d\'accueil',
	'',
    'Accueil',
    'home-settings',
    $settings_home_fields,
    'editor',
    11,
    'dashicons-admin-home',
    'pc_sanitize_settings_home'
);


/*----------  Sanitize  ----------*/

function pc_sanitize_settings_home( $datas ) {

    $datas = apply_filters( 'pc_filter_settings_home_sanitize_fields', $datas );

    global $settings_home_field;

    return pc_sanitize_fields( $settings_home_field, $datas );

}

} // FIN if class_exists
