<?php

/*----------  Barre d'outils custom  ----------*/

add_filter( 'acf/fields/wysiwyg/toolbars' , 'pc_admin_acf_tinymce_toolbars' );

   function pc_admin_acf_tinymce_toolbars( $toolbars ) {

    unset( $toolbars['Full' ] );
    unset( $toolbars['Basic' ] );

   	$toolbars['light'] = array();
   	$toolbars['light'][1] = array( 'undo,redo,removeformat,|,bold,italic,|,link,unlink,|,charmap' );
   	$toolbars['lightplus'] = array();
   	$toolbars['lightplus'][1] = array( 'undo,redo,removeformat,|,bullist,numlist,|,bold,italic,|,link,unlink,|,charmap' );

   	return $toolbars;

   }

/*----------  Config & plugins  ----------*/

add_filter( 'mce_external_plugins', 'pc_admin_acf_tinymce_plugins' );

	function pc_admin_acf_tinymce_plugins( $plugins ) {

		$path = get_template_directory_uri();

		$plugins['visualblocks'] = $path.'/include/admin/editors/acf-tinymce/plugins/visualblocks.js';

		return $plugins;

	}

add_action( 'acf/input/admin_footer', 'pc_admin_acf_tinymce_settings' );

	function pc_admin_acf_tinymce_settings() { ?>

		<style>.acf-editor-wrap iframe { min-height: 0; } </style>

		<script type="text/javascript">(function($) {
		acf.add_filter( 'wysiwyg_tinymce_settings', function( mceInit, id ) {
			
			// Types de blocs
			mceInit.block_formats = 'Paragraph=p;Heading 2=h2;Heading 3=h3';
			// Visualisation des blocs
			mceInit.plugins = mceInit.plugins + ',visualblocks';
			mceInit.visualblocks_default_state = true;
			mceInit.paste_as_text = true;
			mceInit.wp_autoresize_on = true;
			
			return mceInit;
					
		} );

		acf.add_action('wysiwyg_tinymce_init', function( ed, id, mceInit, $field ) {

			// Taille de la zone de saisie
			ed.settings.autoresize_min_height = 100;
			$('.acf-editor-wrap iframe').css('height', '100px');

      	});
		
	})(jQuery)</script>

	<?php }