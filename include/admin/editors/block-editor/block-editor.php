<?php
/**
 * 
 * Block Editor configuration & blocs ACF
 * 
 */


/*----------  Dépendances JS & CSS  ----------*/

add_action( 'admin_enqueue_scripts', 'pc_block_editor_admin_enqueue_scripts' );

function pc_block_editor_admin_enqueue_scripts() {

	wp_enqueue_script( 'pc-block-editor-js-admin', get_bloginfo( 'template_directory').'/include/block-editor/block-editor.js', ['wp-blocks', 'wp-block-library', 'wp-element', 'wp-editor', 'wp-hooks', 'wp-dom-ready', 'wp-edit-post'] );
	
}


/*----------  Suppressions divers  ----------*/

// révisions
add_action( 'init', function() { remove_post_type_support( 'page', 'revisions' ); });
// modèle de page 
remove_theme_support( 'block-templates' );
// ensembles de bloc prédéfinis
remove_theme_support( 'core-block-patterns' );


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
