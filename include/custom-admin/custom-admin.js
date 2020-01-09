/**
*
* Javascript Admin
*
**/


jQuery(document).ready(function($){

    /*===========================================
    =            Sous-pages repeater            =
    ===========================================*/
    
    var $pcRepeater = $('.pc-repeater'), // conteneur
    $pcRepeaterInput = $('.pc-repeater-input') // champ sauvegardé

    var pc_repeater_update = function( type ) {
        var toSave = '';
        $pcRepeater.children().each(function() {
            switch (type) {
                case 'subpage':
                    if ( toSave != '' ) { toSave += ','; }
                    toSave += $(this).children('select').val();
                    break;
            }
        });
        $pcRepeaterInput.val(toSave);
    }
    
    if ( $pcRepeater.length > 0 ) {

        var $pcRepeaterSrc = $('.pc-repeater-src'),
        pcRepeaterType = $pcRepeater.data('type');

        $('.pc-repeater-btn-more').click(function(){
            $pcRepeaterSrc
                .clone()
                .appendTo($pcRepeater)
                .removeClass('pc-repeater-src');
            pc_repeater_update(pcRepeaterType);
        });

        $pcRepeater.on( 'click', '.pc-repeater-btn-delete', function() {
            $(this).parent().remove();
            pc_repeater_update(pcRepeaterType);
        });
        $pcRepeater.on( 'change', 'select', function() {
            pc_repeater_update(pcRepeaterType);
        });
    
        $pcRepeater.sortable({
            update: function( event, ui ) {
                pc_repeater_update(pcRepeaterType);
            }
        });
        
    
    }

    
    /*=====  FIN Sous-pages repeater  =====*/

});