<?php

/**
*
* Page d'administration : paramètres du project
*
*
*/


// si la class est disponible
if ( class_exists('PC_Add_Admin_Page') ) {

/*----------  Communs  ----------*/

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


/*----------  Contenu  ----------*/

// sections et champs associés
$settings_project_fields = array(
    array(
        'title'     => 'Coordonnées',
        'id'        => 'contact-informations',
        'prefix'    => 'coord',
        'fields'    => array(
            array(
                'type'      => 'text',
                'label_for' => 'name',
                'label'     => 'Nom',
                'css'       => 'width:100%;',
                'required'  => true
            ),
            array(
                'type'      => 'text',
                'label_for' => 'address',
                'label'     => 'Adresse',
                'css'       => 'width:100%;',
                'required'  => true
            ),
            array(
                'type'      => 'text',
                'label_for' => 'postal-code',
                'label'     => 'Code postal',
                'required'  => true
            ),
            array(
                'type'      => 'text',
                'label_for' => 'city',
                'label'     => 'Ville',
                'css'       => 'width:100%;',
                'required'  => true
            ),
            array(
                'type'      => 'text',
                'label_for' => 'country',
                'label'     => 'Pays',
                'css'       => 'width:100%;',
                'required'  => true
            ),
            array(
                'type'      => 'number',
                'label_for' => 'lat',
                'label'     => 'Latitude',
                'required'  => true,
                'attr'      => 'step="any"',
                'desc'      => 'Saisissez la valeur avec une virgule.'
            ),
            array(
                'type'      => 'number',
                'label_for' => 'long',
                'label'     => 'Longitude',
                'required'  => true,
                'attr'      => 'step="any"',
                'desc'      => 'Saisissez la valeur avec une virgule.'
            ),
            array(
                'type'      => 'text',
                'label_for' => 'phone-1',
                'label'     => 'Téléphone 1',
                'desc'      => 'Sous la forme "00 00 00 00 00"',
                'attr'      => 'placeholder="00 00 00 00 00" pattern="^\d{2} \d{2} \d{2} \d{2} \d{2}$"',
                'required'  => true
            ),
            array(
                'type'      => 'text',
                'label_for' => 'phone-2',
                'label'     => 'Téléphone 2',
                'desc'      => 'Sous la forme "00 00 00 00 00"',
                'attr'      => 'placeholder="00 00 00 00 00" pattern="^\d{2} \d{2} \d{2} \d{2} \d{2}$"'
            )
        )
    ),
    array(
        'title'     => 'Optimisation référencement (SEO)',
        'id'        => 'seo',
        'prefix'    => 'seo',
        'fields'    => array(
            array(
                'type'      => 'text',
                'label_for' => 'desc',
                'label'     => 'Description',
                'css'       => 'width:100%',
                'required'  => true,
                'desc'      => 'Votre activité en quelques mots.'
            ),
            array(
                'type'      => 'text',
                'label_for' => 'author-first-name',
                'label'     => 'Auteur : prénom',
                'css'       => 'width:100%',
				'desc'		=> 'Utilisé si votre prénom n\'est pas renseigné dans votre profil.',
                'required'  => true
            ),
            array(
                'type'      => 'text',
                'label_for' => 'author-last-name',
                'label'     => 'Auteur : nom',
                'css'       => 'width:100%',
				'desc'		=> 'Utilisé si votre nom n\'est pas renseigné dans votre profil.',
                'required'  => true
            ),	
            array(
                'type'      => 'checkbox',
                'label_for' => 'author-default',
                'label'     => 'Auteur par défaut',
				'desc'		=> 'Associe l\'auteur ci-dessus à tous les contenus.'
            ),
        )
    ),
    array(
        'title'     => 'Réseaux sociaux',
        'desc'      => '<p>Adresses (URL) de vos pages sur les réseaux sociaux.</p>',
        'id'        => 'social',
        'prefix'    => 'social',
        'fields'    => array(
            array(
                'type'      => 'url',
                'label_for' => 'facebook',
                'label'     => 'Facebook',
                'css'       => 'width:100%'
            ),
            array(
                'type'      => 'url',
                'label_for' => 'twitter',
                'label'     => 'Twitter',
                'css'       => 'width:100%'
            ),
            array(
                'type'      => 'url',
                'label_for' => 'instagram',
                'label'     => 'Instagram',
                'css'       => 'width:100%'
			),
            array(
                'type'      => 'url',
                'label_for' => 'linkedin',
                'label'     => 'LinkedIn',
                'css'       => 'width:100%'
            )
        )
    )
);

$settings_project_fields = apply_filters( 'pc_filter_settings_project_fields', $settings_project_fields, $pages_list );


/*----------  Création  ----------*/

$register_settings_project = new PC_Add_Admin_Page(
    'Paramètres du site',
	'', // niveau 1
    'Paramètres',
    'project-settings',
    $settings_project_fields,
    'editor',
    62,
    'dashicons-clipboard',
    'pc_sanitize_settings_project'
);


/*----------  Sanitize  ----------*/

function pc_sanitize_settings_project( $datas ) {

    $datas = apply_filters( 'pc_filter_settings_project_sanitize_fields', $datas );

    global $settings_project_fields;

    return pc_sanitize_settings_fields( $settings_project_fields, $datas );

}

} // FIN if class_exists
