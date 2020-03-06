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

/*----------  Contenu repeater Pages à la une  ----------*/

// affichage d'une ligne du repeater
function pc_home_pages_line( $css_classe, $options, $current = '', $title = '' ) {
    $return = '<div class="'.$css_classe.'"><select><option value=""></option>';
    foreach ($options as $subpage ) {
        $return .= '<option value="'.$subpage->ID.'" '.selected($current,$subpage->ID,false).'>'.$subpage->post_title.'</option>';
    }
	$return .= '</select>';
	$return .= '<input type="text"value="'.$title.'" style="vertical-align:middle;width:260px" maxlength="40"/>';
    $return .= ' <span title="Effacer" style="vertical-align:middle; cursor:pointer;" class="pc-repeater-btn-delete dashicons dashicons-no"></span>';
    $return .= ' <span title="Déplacer" style="vertical-align:middle; cursor:move;" class="dashicons dashicons-move"></span>';
	$return .= '</div>';
	return $return;
}
// bdd to array
function pc_home_pages_bdd_to_array( $datas ) {
	$return = array();
	if ( $datas != '' ) {
		$set = explode('|',$datas);
		foreach ($set as $value) {
			$temp = explode('§',$value);
			$return[$temp[0]] = $temp[1];
		}
	}
	return $return;
}

// valeur en base
$settings_home = get_option('home-settings-option');
$home_pages_in_bdd = ( isset($settings_home['content-pages']) ) ? $settings_home['content-pages'] : '';
$home_pages = pc_home_pages_bdd_to_array($home_pages_in_bdd);
// affichage
$home_pages_fields = '<div class="pc-repeater" data-type="homepages">';
foreach ($home_pages as $id => $title) {
	$home_pages_fields .= pc_home_pages_line( 'pc-repeater-item', $all_pages, $id, $title );
}
$home_pages_fields .= '</div>';
$home_pages_fields .= '<input type="hidden" value="'.$home_pages_in_bdd.'" name="home-settings-option[content-pages]" class="pc-repeater-input" />';
$home_pages_fields .= '<p><button type="button" class="pc-repeater-btn-more button">Ajouter une page</button></p>';
// ligne cachée et copiée par le JS (ajout)
$home_pages_fields .= '<div style="display:none">';
$home_pages_fields .= pc_home_pages_line( 'pc-repeater-item pc-repeater-src', $all_pages );
$home_pages_fields .= '</div>';


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
			),
			array(
                'type'      => 'custom',
                'label_for' => 'pages',
                'label'     => 'Pages à la une',
                'desc'      => 'Aide ou description du champ',
                'display'   => $home_pages_fields
            )
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
	
	$datas['content-pages'] = sanitize_text_field($datas['content-pages']);
	$datas['content-pages'] = esc_attr($datas['content-pages']);

    global $settings_home_fields;
    return pc_sanitize_settings_fields( $settings_home_fields, $datas );

}


/*=====  FIN Sanitize  =====*/

} // FIN if class_exists
