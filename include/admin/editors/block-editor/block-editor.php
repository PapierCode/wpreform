<?php
/**
 * 
 * Block Editor configuration & blocs ACF
 * 
 */


/*----------  Dépendances JS & CSS  ----------*/

add_action( 'enqueue_block_editor_assets', 'pc_block_editor_admin_enqueue_scripts' );

function pc_block_editor_admin_enqueue_scripts() {

	wp_enqueue_script( 'pc-block-editor-js-admin', get_bloginfo( 'template_directory').'/include/admin/editors/block-editor/block-editor.js', ['wp-blocks', 'wp-dom', 'wp-hooks', 'wp-dom-ready', 'lodash'] );
	
}


/*----------  Suppressions divers  ----------*/

// Autres suppressions, voir les fichiers CSS & JS

add_action( 'init', 'pc_block_editir_init' );

	function pc_block_editir_init() { 

		remove_post_type_support( 'page', 'page-attributes' ); 
		
	}

add_action( 'after_setup_theme', 'pc_block_editor_after_setup_theme' );

	function pc_block_editor_after_setup_theme() {

		// modèle de page 
		remove_theme_support( 'block-templates' );
		// ensembles de bloc prédéfinis
		remove_theme_support( 'core-block-patterns' );

	}


add_filter( 'block_editor_settings_all', 'pc_block_editor_settings_all', 10, 2 );

	function pc_block_editor_settings_all( $settings, $context ) {

		$is_administrator = current_user_can( 'activate_plugins' );

		if ( !$is_administrator ) {
			// verrouillage des block 
			$settings[ 'canLockBlocks' ] = false;
			// Éditeur de code 
			$settings[ 'codeEditingEnabled' ] = false;
		}

		return $settings;

	}


/*----------  Blocs ACF  ----------*/

$blocks_acf = array(
	'quote',
	'cta',
	'image',
	'embed',
	'gallery',
);

foreach ( $blocks_acf as $block_id ) {
	if ( apply_filters( 'pc_filter_add_acf_'.$block_id.'_block', true ) ) { register_block_type( __DIR__.'/'.$block_id ); }
}

add_filter( 'allowed_block_types_all', 'pc_allowed_block_types_all' );

	function pc_allowed_block_types_all( $blocks ) {

		$blocks = array(
			'core/paragraph',
			'core/heading',
			'core/list',
			'core/list-item'
		);
		
		global $blocks_acf;
		foreach ( $blocks_acf as $block_id ) {
			if ( apply_filters( 'pc_filter_add_acf_'.$block_id.'_block', true ) ) { $blocks[] = 'acf/pc-'.$block_id; }
		}
	
		return $blocks;
		
	}
