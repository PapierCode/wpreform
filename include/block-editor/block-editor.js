( function() {

    console.log(wp.blocks);

    function addListBlockClassName( settings, name ) {

        if ( name == 'core/paragraph') {
            console.log(settings);
        }
        
        return settings;
    }
    
     
    wp.hooks.addFilter(
        'blocks.registerBlockType',
        'pc-script/class-names/list-block',
        addListBlockClassName
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
            'core/spacer',
            'core/columns',
            'core/media-text',
    
            'core/image',
            'core/gallery',
            'core/file',
    
            'core/embed',
            'core-embed/youtube',
            'core-embed/dailymotion',
            'core-embed/vimeo',
            'core-embed/facebook',
            'core-embed/instagram',
            'core-embed/twitter',
        ];
        
        wp.blocks.getBlockTypes().forEach( function( blockType ) {
            if ( allowedBlocks.indexOf( blockType.name ) === -1 ) {
                wp.blocks.unregisterBlockType( blockType.name );
            }
        } );
        
        
        /*=====  FIN Blocs disponibles  =====*/
        
        
    
    });

} )()