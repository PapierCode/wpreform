<?php
/**
 * 
 * Block Editor configuration
 * 
 */


 	
add_theme_support( 'disable-custom-font-sizes' );
add_theme_support( 'editor-font-sizes', array() );

add_theme_support( 'disable-custom-colors' );
add_theme_support( 'editor-color-palette', array() );

add_theme_support( 'disable-custom-gradients' );
add_theme_support( '__experimental-editor-gradient-presets', array() );



add_filter( 'block_editor_settings', 'pc_settings_block_editor' );

function pc_settings_block_editor( $settings ) {

	$settings['codeEditingEnabled'] = false;
	return $settings;

}

/*==============================
=            Police            =
==============================*/

/*----------  Taille  ----------*/

// désactive les tailles personnalisées
// add_theme_support('disable-custom-font-sizes');

// Modifie les tailles prédéfinies
// add_theme_support( 'editor-font-sizes', array(
//     array(
//         'name' => 'Défaut',
//         'size' => 16,
//         'slug' => 'default'
//     )
// ) );

/*----------  Notes  ----------*/

// Désactiver le selecteur de tailles prédéfinies ?


/*=====  FIN Police  =====*/

/*============================================
=            Couleurs (selecteur)            =
============================================*/

// désactive les couleurs prédéfinies
// add_theme_support( 'editor-color-palette' );

// désactive les couleurs personnalisées
// add_theme_support( 'disable-custom-colors' );


/*----------  Notes  ----------*/

// Désactiver la sélection d'une couleur de fond ?

// définir les couleurs prédéfinies
// add_theme_support( 'editor-color-palette', array(
//     array(
//         'name' => __( 'strong magenta', 'themeLangDomain' ),
//         'slug' => 'strong-magenta',
//         'color' => '#a156b4',
//     ),
// ) );


/*=====  FIN Couleurs (selecteur)  =====*/

/*=====================================
=            Types de Bloc            =
=====================================*/

// plus efficace en JS

// add_filter( 'allowed_block_types', 'pc_block_editor_allowed_block_types', 10, 2 );
 
// function pc_block_editor_allowed_block_types( $allowed_blocks, $post ) {
    
//     return array(

//         'core/paragraph',
//         'core/heading',
//         'core/list',
//         'core/quote',
//         'core/button',
        
//         'core/separator',
//         'core/spacer',
//         'core/columns',
//         'core/media-text',

//         'core/image',
//         'core/gallery',
//         'core/file',

//         'core/embed',
//         'core-embed/youtube',
//         'core-embed/dailymotion',
//         'core-embed/vimeo',
//         'core-embed/facebook',
//         'core-embed/instagram',
//         'core-embed/twitter',
        
//     );

// }


/*----------  Catégories  ----------*/

// function my_plugin_block_categories( $categories, $post ) {
//     pc_var($categories,true);
//     return $categories;
// }
// add_filter( 'block_categories', 'my_plugin_block_categories', 10, 2 );


/*=====  FIN Types de Bloc  =====*/

/*============================
=            test            =
============================*/


function pc_enqueue() {
    wp_enqueue_script(
        'pc-script',
        get_template_directory_uri().'/include/block-editor/block-editor.js',
        array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post', 'wp-element', 'wp-i18n', 'wp-editor', 'wp-hooks' )
    );
}
add_action( 'enqueue_block_editor_assets', 'pc_enqueue' );



/*=====  FIN test  =====*/

