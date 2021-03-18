<?php

/**
*
* Paramètres de la page d'accueil
*
*
*/

// si la class est disponible
if ( class_exists('PC_Add_Admin_Page') ) {

/*=================================
=            Fonctions            =
=================================*/

/*----------  Pages à la une : ligne du repeater  ----------*/

/**
 * 
 * @param string	$css_class		Classes css associées à la ligne
 * @param array		$pages			Posts sélectionnables (tableau d'objets)
 * @param int		$current		Id du post associé à ligne
 * @param string	$title			Titre de remplacement
 * 
 * @return string	HTML
 * 
 */

function pc_get_home_shortcut_repeater_line( $css_class, $pages, $current = '', $title = '' ) {

	$return = '<div class="'.$css_class.'">';
	$return .= '<select><option value=""></option>';
		
		// selecteur
		foreach ($pages as $subpage ) {
			$return .= '<option value="'.$subpage->ID.'" '.selected($current,$subpage->ID,false).'>'.$subpage->post_title.'</option>';
		}
		$return .= '</select>';
		// titre
		$return .= '<input type="text"value="'.$title.'" style="vertical-align:middle;width:260px" maxlength="40"/>';
		// effacer la ligne
		$return .= ' <span title="Effacer" style="vertical-align:middle; cursor:pointer;" class="pc-repeater-btn-delete dashicons dashicons-no"></span>';
		// supprimer la ligne
		$return .= ' <span title="Déplacer" style="vertical-align:middle; cursor:move;" class="dashicons dashicons-move"></span>';

	$return .= '</div>';

	return $return;

}

/*----------  Pages à la une : conversion valeur sauvegardée  ----------*/

/**
 * 
 * @param string	$datas		Valeur du champ en bdd
 * 
 * @return array	id => titre
 * 
 */

function pc_get_home_shortcuts_bdd_to_array( $datas ) {

	$return = array();
	if ( $datas != '' ) {
		$set = explode( '|', $datas );
		foreach ( $set as $value ) {
			$temp = explode( '§', $value );
			$return[$temp[0]] = $temp[1];
		}
	}
	return $return;

}


/*=====  FIN Fonctions  =====*/

/*=========================================================
=            Pages à la une : contenu repeater            =
=========================================================*/

/*----------  Valeur en bdd  ----------*/

// tout le contenu de l'accueil
$settings_home = get_option('home-settings-option');
// pages à la une sauvegardées
$home_pages_in_bdd = ( isset($settings_home['content-pages']) && $settings_home['content-pages'] !='' ) ? $settings_home['content-pages'] : '';
// conversion
$home_pages = pc_get_home_shortcuts_bdd_to_array($home_pages_in_bdd);

// html à afficher
$home_pages_fields = '<div class="pc-repeater" data-type="homepages">';
	// une ligne par page à la une
	foreach ($home_pages as $id => $title) {
		$home_pages_fields .= pc_get_home_shortcut_repeater_line( 'pc-repeater-item', $all_pages, $id, $title );
	}
$home_pages_fields .= '</div>';
// c'est ce input qui est sauvegardé !
$home_pages_fields .= '<input type="hidden" value="'.$home_pages_in_bdd.'" name="home-settings-option[content-pages]" class="pc-repeater-input" />';
// btn ajout ligne
$home_pages_fields .= '<p><button type="button" class="pc-repeater-btn-more button">Ajouter une page</button></p>';
// source pour le js
$home_pages_fields .= '<div style="display:none">';
	$home_pages_fields .= pc_get_home_shortcut_repeater_line( 'pc-repeater-item pc-repeater-src', $all_pages );
$home_pages_fields .= '</div>';


/*=====  FIN Pages à la une : contenu repeater  =====*/


/*==============================
=            Champs            =
==============================*/

/*----------  Textes  ----------*/

$settings_home_fields = array(
    array(
        'title'     => 'Contenu',
        'id'        => 'content',
        'prefix'    => 'content',
        'fields'    => array(
            array(
                'type'      => 'text',
                'label_for' => 'title',
                'label'     => 'Titre',
                'css'       => 'width:100%',
                'required'  => true
            ),
            array(
                'type'      => 'wysiwyg',
                'label_for' => 'txt',
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
                'type'      => 'custom',
                'label_for' => 'pages',
                'label'     => 'Pages à la une',
                'display'   => $home_pages_fields
            )
        )
	)    
);


/*----------  Image associée pleine page  ----------*/

$settings_home_fields[] = array(
	'title'     => 'Image associée',
	'desc'		=> '<p>Sélectionnez l\'image associée à cette page pour : <strong> le référencement et le partage sur les réseaux sociaux</strong>.</p><p><em><strong>Remarques :</strong> Si une image n\'est pas sélectionnée, le logo est utilisé.</em></p>',
	'id'        => 'visual',
	'prefix'    => 'visual',
	'fields'    => array(
		array(
			'type'      => 'img',
			'label_for' => 'id',
			'label'     => 'Image',
			'options'	=> array( 'btnremove' => true )
		)
	)
);


if ( isset($settings_pc['wpreform-fullscreen']) ) {

	$settings_home_fields[1]['desc'] = '<p>Sélectionnez l\'image associée à cette page pour : <strong>s\'afficher en pleine page (si activé ci-dessous), le référencement et le partage sur les réseaux sociaux</strong>.</p><p><em><strong>Remarques :</strong> Si une image n\'est pas sélectionnée, il n\'y a pas d\'image en pleine page et le logo est utilisé pour le référencement et le partage sur les réseaux sociaux. Pour un affichage pleine page, la taille minimum conseillée est de 2000 x 1500 pixels.</em></p>';

	$settings_home_fields[1]['fields'] = array_merge( 
		$settings_home_fields[1]['fields'], 
		array(
			array(
				'type'      => 'checkbox',
				'label_for' => 'fullscreen',
				'label'     => 'Afficher en pleine page'
			),
			array(
				'type'      => 'radio',
				'label_for' => 'title-h',
				'label'     => 'Position horizontale du titre',
				'options'	=> array( 
					'Gauche' => 'left',
					'Centre' => 'center',
					'Droite' => 'right'
				)
			),
			array(
				'type'      => 'radio',
				'label_for' => 'title-v',
				'label'     => 'Position verticale du titre',
				'options'	=> array( 
					'Haut' => 'top',
					'Centre' => 'center',
					'Bas' => 'bottom'
				)
			)
		)
	);

}


/*----------  SEO  ----------*/

$settings_home_fields[] = array(
	'title'     => 'Référencement (SEO) & réseaux sociaux',
	'desc'      => '<p><strong>Optimisez le titre et le résumé pour les moteurs de recherche et les réseaux sociaux.</strong> </p><p><em><strong>Remarque :</strong> Si ces champs ne sont pas saisis, le titre de la page et les premiers mots du texte de présentation sont utilisés.</em></p>',
	'id'        => 'seo',
	'prefix'    => 'seo',
	'fields'    => array(
		array(
			'type'      => 'text',
			'label_for' => 'title',
			'label'     => 'Titre',
			'attr'      => 'class="pc-counter" data-counter-max="'.$texts_lengths['seo-title'].'"',
			'css'       => 'width:100%'
		),
		array(
			'type'      => 'textarea',
			'label_for' => 'desc',
			'label'     => 'Description',
			'attr'      => 'class="pc-counter" data-counter-max="'.$texts_lengths['seo-desc'].'"',
			'css'       => 'width:100%'
		)
	)
);


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
