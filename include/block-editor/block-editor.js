( function() {

    // console.log(wp.blocks);

    function pcTest( settings, name ) {

		// if ( name === 'core/heading' ) {
		
		// 	return lodash.assign( {}, settings, {
		// 		supports: lodash.assign( {}, settings.supports, {
		// 			anchor: false,
		// 		} ),
		// 	} );

		// }
		if ( name === 'core/paragraph' ) {
	 
			console.log(settings);
		

		}
        
        return settings;
    }
    
     
    wp.hooks.addFilter(
        'blocks.getBlockAttributes',
        'pc-script/test',
        pcTest
    );

    wp.domReady( function() {

        /*=========================================
        =            Blocs disponibles            =
        =========================================*/

        var allowedBlocks = [
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/quote',
            'core/button',
            
            'core/separator',
            'core/columns',
            'core/column',
            'core/media-text',
    
            'core/image',
            'core/gallery',
            'core/file',
    
            'core-embed/youtube',
            'core-embed/dailymotion',
            'core-embed/vimeo',
		];

		var blocksToRemove = [
			'core-embed/wordpress',
			'core-embed/soundcloud',
			'core-embed/spotify',
			'core-embed/flickr',
			'core-embed/animoto',
			'core-embed/cloudup',
			'core-embed/collegehumor',
			'core-embed/crowdsignal',
			'core-embed/hulu',
			'core-embed/imgur',
			'core-embed/issuu',
			'core-embed/kickstarter',
			'core-embed/meetup-com',
			'core-embed/mixcloud',
			'core-embed/polldaddy',
			'core-embed/reddit',
			'core-embed/reverbnation',
			'core-embed/screencast',
			'core-embed/scribd',
			'core-embed/slideshare',
			'core-embed/smugmug',
			'core-embed/speaker',
			'core-embed/speaker-deck',
			'core-embed/ted',
			'core-embed/tumblr',
			'core-embed/videopress',
			'core-embed/wordpress-tv',
			'core-embed/amazon-kindle',
			
            'core/embed',
            'core-embed/facebook',
            'core-embed/instagram',
            'core-embed/twitter',
        ];

		        
        // wp.blocks.getBlockTypes().forEach( function( blockType ) {
		// 	console.log(blockType.name);
		// } );
        
        // blocksToRemove.forEach( function( block ) {
		// 	wp.blocks.unregisterBlockType( block );
		// } );

	 
		wp.blocks.getBlockTypes().forEach( function( blockType ) {
			if ( allowedBlocks.indexOf( blockType.name ) === -1 ) {
				wp.blocks.unregisterBlockType( blockType.name );
			}
		} );
		

		
        
		/*=====  FIN Blocs disponibles  =====*/
        
        
    
    });

} )()