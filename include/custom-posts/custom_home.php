<?php

/**
*
* Paramètres de la page d'accueil
*
*
*/

// si la class est disponible
if ( class_exists('PC_Add_Admin_Page') ) {

/*==============================
=            Champs            =
==============================*/

/*----------  Contenu select pages  ----------*/

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


/*----------  Sections et champs communs aux thèmes  ----------*/

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
                'label'     => 'Texte de présentation',
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
		'desc'		=> '<p><strong>Mettez en avant jusqu\'à 4 pages du menu de navigation sur la page d\'accueil.</strong> <br/><em>Si le champ <em>Titre</em> n\'est pas rempli, le titre de la page est utilisé. <br/>Le Visuel configuré dans la page est utilisé, si il n\'est pas sélectionné, le logo est utilisé.</em></p>',
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
        'title'     => 'Référencement & réseaux sociaux',
        'desc'      => '<p><strong>Optimisez le titre et le résumé pour les moteurs de recherche et les réseaux sociaux.</strong> <br/><em>Si ces champs ne sont pas saisis, le titre de la page et les premiers mots du texte de présentation sont utilisés.</em></p>',
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
            )
        )
    )
);

/*----------  Section et champ visuel  ----------*/

$home_visual_field = array(
	'title'     => 'Visuel',
	'desc'      => '',
	'id'        => 'visual',
	'prefix'    => 'visual',
	'fields'    => array(
		array(
			'type'      => 'img',
			'label_for' => 'img',
			'label'     => 'Visuel'
		),
	)
);

if ( $settings_project['theme'] == 'fullscreen' ) {

	$home_visual_field['desc'] = '<p><strong>Sélectionnez le visuel qui s\'affiche en pleine page et pour le partage sur les réseaux sociaux</strong>, <em>dimensions minimum conseillées 2000x1500 pixels</em>.</p>';
	$home_visual_field['fields'][0]['required'] = true;
	$home_visual_field['fields'][0]['options'] = array( 'btnremove' => false );

	array_unshift( $settings_home_fields, $home_visual_field );

} else {

	$home_visual_field['desc'] = '<p><strong>Sélectionnez le visuel pour le partage sur réseaux sociaux</strong>, <em>dimensions minimum conseillées 300x300 pixels, si un visuel n\'est pas sélectionné, le logo est utilisé.</em></p>';
	$home_visual_field['fields'][0]['options'] = array( 'btnremove' => true );

	$settings_home_fields[] = $home_visual_field;
}


/*----------  Filtre  ----------*/

$settings_home_fields = apply_filters( 'pc_filter_settings_home_fields', $settings_home_fields );


/*=====  FIN Champs  =====*/

/*================================
=            Création            =
================================*/

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


/*=====  FIN Création  =====*/

/*================================
=            Sanitize            =
================================*/

function pc_sanitize_settings_home( $datas ) {

    $datas = apply_filters( 'pc_filter_settings_home_sanitize_fields', $datas );

    global $settings_home_fields;
    return pc_sanitize_settings_fields( $settings_home_fields, $datas );

}


/*=====  FIN Sanitize  =====*/

} // FIN if class_exists
