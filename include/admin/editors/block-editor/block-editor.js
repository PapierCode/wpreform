/*=====================================
=            Blocks Editor            =
=====================================*/

( function() {

    wp.domReady( function() {
      
		/*----------  Page sidebar  ----------*/
		
        wp.data.dispatch( 'core/edit-post' ).removeEditorPanel( 'page-attributes' );
        // wp.data.dispatch( 'core/edit-post').removeEditorPanel( 'template' );


		/*----------  Options de texte  ----------*/

		wp.richText.unregisterFormatType( 'core/image' );
		wp.richText.unregisterFormatType( 'core/code' );
		wp.richText.unregisterFormatType( 'core/keyboard' );
		wp.richText.unregisterFormatType( 'core/text-color' );
		wp.richText.unregisterFormatType( 'core/language' );
		wp.richText.unregisterFormatType( 'core/footnote' );
   
    });

	function pcRemoveOptions( settings, name ) {
		if( 'core/paragraph' === name || 'core/heading' === name || 'core/list' === name || 'core/list-item' === name ) {
			return lodash.assign( {}, settings, {
				supports: lodash.assign( {}, settings.supports, {
					align: [], // pas de wide
					html: false // pas d'édition en html
				} )
			} );
		}
		return settings;

	}
	 
	wp.hooks.addFilter(
		'blocks.registerBlockType',
		'pc/pcRemoveOptions',
		pcRemoveOptions
	);

} )()


/*=====  FIN Blocks Editor  =====*/