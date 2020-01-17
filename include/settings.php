<?php

/**
*
* Paramètres du site
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
) );
$pages_list = array();
foreach ($all_pages as $page) {
    $pages_list[$page->post_title] = $page->ID;
}


/*----------  Contenu  ----------*/

// sections et champs associés
$settings_project_field = array(
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
        'id'        => 'micro',
        'prefix'    => 'micro',
        'fields'    => array(
            array(
                'type'      => 'text',
                'label_for' => 'desc',
                'label'     => 'Description',
                'css'       => 'width:100%',
                'required'  => true,
                'desc'      => 'Votre activité en quelques mots.'
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
                'type'      => 'text',
                'label_for' => 'fb',
                'label'     => 'Facebook',
                'css'       => 'width:100%'
            ),
            array(
                'type'      => 'text',
                'label_for' => 'tw',
                'label'     => 'Twitter',
                'css'       => 'width:100%'
            ),
            array(
                'type'      => 'text',
                'label_for' => 'in',
                'label'     => 'LinkedIn',
                'css'       => 'width:100%'
            )
        )
    ),
    array(
        'title'     => 'Conditions générales d\'utilisation',
        'id'        => 'cgu',
        'prefix'    => 'cgu',
        'fields'    => array(
            array(
                'type'      => 'select',
                'label_for' => 'page',
                'label'     => 'Page des CGU',
                'options'   => $pages_list,
                'required'  => true
            )
        )
    ),
    array(
        'title'     => 'Formulaire de contact',
        'id'        => 'contact-form',
        'prefix'    => 'form',
        'fields'    => array(
            array(
                'type'      => 'text',
                'label_for' => 'for',
                'label'     => 'Destinataires',
                'desc'      => '1 ou plusieurs e-mails séparés par des virgules, sans espaces.',
                'css'       => 'width:100%;',
                'attr'      => 'placeholder="contact@mon-site.fr,devis@gmail.com"',
                'required'  => true
            ),
            array(
                'type'      => 'text',
                'label_for' => 'subject',
                'label'     => 'Sujet de l\'e-mail',
                'css'       => 'width:100%;',
                'attr'      => 'placeholder="Formulaire de contact"',
                'required'  => true
            )
        )
    )
);

$settings_project_fields = apply_filters( 'pc_filter_settings_project_fields', $settings_project_field );


/*----------  Création  ----------*/

$settings_project_declaration = new PC_Add_Admin_Page(
    'Paramètres du site',
	'',
    'Paramètres',
    'project-settings',
    $settings_project_fields,
    'editor',
    61,
    'dashicons-clipboard',
    'pc_sanitize_settings_project'
);


/*----------  Sanitize  ----------*/

function pc_sanitize_settings_project( $datas ) {

    $datas = apply_filters( 'pc_filter_settings_project_sanitize_fields', $datas );

    global $settings_project_field;

    return pc_sanitize_fields( $settings_project_field, $datas );

}

} // FIN if class_exists
