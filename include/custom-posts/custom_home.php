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

// toutes les pages
// select page
$all_pages = get_posts( array(
    'post_type' => 'page',
	'nopaging' => true,
	'order' => 'ASC',
	'orderby' => 'title'
) );
$pages_list = array();
foreach ($all_pages as $page) {
    $pages_list[$page->post_title] = $page->ID;
}

// sections et champs associés
global $settings_home_fields;
$settings_home_fields = array(
    array(
        'title'     => 'Présentation',
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
                'label_for' => 'txt',
                'label'     => 'Texte',
                'options'   => array(
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                    'tinymce'       => array (
                        'toolbar1'  => 'fullscreen,undo,redo,removeformat,|,bullist,numlist,|,bold,italic,strikethrough,superscript,charmap,|,link,unlink'
                    )
                ),
                'required'  => true
        	)
        )
    ),
    array(
		'title'     => 'Pages à la une',
		'desc'		=> 'Si le champ <em>Titre</em> n\'est pas rempli, le titre de la page est utilisé.',
        'id'        => 'pages',
        'prefix'    => 'pages',
        'fields'    => array(
			array(
                'type'      => 'select',
                'label_for' => 'page-1',
                'label'     => 'Page #1',
                'options'   => $pages_list
			),
			array(
                'type'      => 'text',
                'label_for' => 'title-1',
                'label'     => 'Titre #1',
                'css'       => 'width:50%',
                'attr'      => 'class="pc-counter" data-counter-max="40"',
            ),
			array(
                'type'      => 'select',
                'label_for' => 'page-2',
                'label'     => 'Page #2',
                'options'   => $pages_list
            ),
			array(
                'type'      => 'text',
                'label_for' => 'title-2',
                'label'     => 'Titre #2',
                'css'       => 'width:50%',
                'attr'      => 'class="pc-counter" data-counter-max="40"',
            ),
			array(
                'type'      => 'select',
                'label_for' => 'page-3',
                'label'     => 'Page #3',
                'options'   => $pages_list
            ),
			array(
                'type'      => 'text',
                'label_for' => 'title-3',
                'label'     => 'Titre #3',
                'css'       => 'width:50%',
                'attr'      => 'class="pc-counter" data-counter-max="40"',
            ),
			array(
                'type'      => 'select',
                'label_for' => 'page-4',
                'label'     => 'Page #4',
                'options'   => $pages_list
            ),
			array(
                'type'      => 'text',
                'label_for' => 'title-4',
                'label'     => 'Titre #4',
                'css'       => 'width:50%',
                'attr'      => 'class="pc-counter" data-counter-max="40"',
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

    global $settings_home_fields;
    return pc_sanitize_settings_fields( $settings_home_fields, $datas );

}

} // FIN if class_exists
