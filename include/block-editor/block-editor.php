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

include 'acf-blocks.php';


/*----------  Blocs disponibles  ----------*/

add_filter( 'allowed_block_types_all', 'pc_allowed_block_types_all' );

	function pc_allowed_block_types_all( $blocks ) {

		$blocks = array(
			'core/paragraph',
			'core/heading',
			'core/list',
			'acf/pc-embed',
			'acf/pc-image',
			'acf/pc-gallery',
			'acf/pc-cta',
			//'acf/pc-columns',
			'acf/pc-quote',
			'acf/pc-intro'
		);
	
		return $blocks;
		
	}


/*----------  ACF TinyMCE  ----------*/

add_filter( 'acf/fields/wysiwyg/toolbars' , 'pc_acf_tinymce_toolbars'  );

	function pc_acf_tinymce_toolbars( $toolbars ) {

		$toolbars['Light'] = array( 
			1 => array(
				'undo',
				'redo',
				'removeformat',
				'|',
				'bold',
				'italic',
				'strikethrough',
				'charmap',
				'|',
				'bullist',
				'numlist',
				'|',
				'alignleft',
				'aligncenter',
				'alignright',
				'|',
				'link'
			)
		);

		return $toolbars;

	}
		
add_action('acf/input/admin_footer', 'fnas_acf_input_admin_footer');

	function fnas_acf_input_admin_footer() { ?>

		<script type="text/javascript">
		acf.add_filter( 'wysiwyg_tinymce_settings', function( mceInit, id ) {
			mceInit.paste_as_text = true;			
			mceInit.wp_autoresize_on = true;			
			return mceInit;			
		} );
		</script>

	<?php }