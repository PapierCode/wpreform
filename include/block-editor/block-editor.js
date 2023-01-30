/*=====================================
=            Blocks Editor            =
=====================================*/

( function() {

    wp.domReady( function() {

		// trop de sauvegarde auto (à confirmer ?)
		wp.data.dispatch( "core/editor" ).updateEditorSettings({
			autosaveInterval: 99999
		});
      
		/*----------  Page sidebar  ----------*/
		
        wp.data.dispatch( 'core/edit-post').removeEditorPanel( 'page-attributes' );
        wp.data.dispatch( 'core/edit-post').removeEditorPanel( 'page-templates' );


		/*----------  Style de blocs  ----------*/
		
	    // wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
	    // wp.blocks.unregisterBlockStyle( 'core/button', 'fill' );
		// wp.blocks.unregisterBlockStyle( 'core/quote', 'large');
		// wp.blocks.unregisterBlockStyle( 'core/quote', 'plain');
		// wp.blocks.unregisterBlockStyle( 'core/quote', 'default');
		// wp.blocks.unregisterBlockStyle( 'core/image', 'default');
		// wp.blocks.unregisterBlockStyle( 'core/image', 'rounded');


		/*----------  Options de texte  ----------*/

		wp.richText.unregisterFormatType( 'core/image' );
		wp.richText.unregisterFormatType( 'core/code' );
		wp.richText.unregisterFormatType( 'core/keyboard' );
		wp.richText.unregisterFormatType( 'core/text-color' );


		/*----------  Pas de plein écran au chargement  ----------*/
				
		const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' );
		if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); }
   
    });

	function pcRemoveOptions( settings, name ) {

		return lodash.assign( {}, settings, {
			supports: lodash.assign( {}, settings.supports, {
				align: [], // pas de wide
				html: false // pas d'édition en html
			} )
		} );

	}
	 
	wp.hooks.addFilter(
		'blocks.registerBlockType',
		'pc/pcRemoveOptions',
		pcRemoveOptions
	);

} )()


/*=====  FIN Blocks Editor  =====*/