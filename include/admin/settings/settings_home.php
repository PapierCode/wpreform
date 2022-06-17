<?php

/**
*
* Page d'administration : accueil
*
*
*/

// si la class est disponible
if ( is_admin() && class_exists('PC_Add_Admin_Page') ) {

/*==============================
=            Champs            =
==============================*/

/*----------  Textes  ----------*/

$home_pages_field_name = 'home-settings-option[content-pages]';
$settings_home = get_option( 'home-settings-option' );
$home_pages_field_save = ( isset($settings_home['content-pages']) ) ? $settings_home['content-pages'] : '';

$home_pages_repeater = new PC_posts_Selector(
	$home_pages_field_name,
	$home_pages_field_save,
	array(
		'post_type' => 'page',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post__not_in' => array( get_option( 'wp_page_for_privacy_policy' ) ), // page CGU
	),
	array(
		'add_button_txt' => 'Ajouter une page'
	)
);


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
                        'toolbar1'  => 'undo,redo,removeformat,|,bold,italic,strikethrough,superscript,charmap,|,link,unlink'
                    )
                ),
                'required'  => true
			),
			array(
                'type'      => 'custom',
                'label_for' => 'pages',
                'label'     => 'Pages à la une',
                'display'   => $home_pages_repeater->display()
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

$register_settings_home = new PC_Add_Admin_Page(
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
