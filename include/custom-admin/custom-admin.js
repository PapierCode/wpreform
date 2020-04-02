/**
*
* Javascript Admin
*
**/


jQuery(document).ready(function($){

    /*===========================================
    =            Sous-pages repeater            =
    ===========================================*/
    
	var $pcRepeater = $('.pc-repeater');	
    
    if ( $pcRepeater.length > 0 ) {

    	$pcRepeaterInput = $('.pc-repeater-input') // champ sauvegardé

		var pc_repeater_update = function( type ) {
			var toSave = '';
			$pcRepeater.children().each(function() {
				switch (type) {
					case 'subpage':
						if ( toSave != '' ) { toSave += ','; }
						toSave += $(this).children('select').val();
						break;
					case 'homepages':
						if ( toSave != '' ) { toSave += '|'; }
						toSave += $(this).children('select').val() + '§' + $(this).children('input').val();
						break;
				}
			});
			$pcRepeaterInput.val(toSave);
		}

        var $pcRepeaterSrc = $('.pc-repeater-src'),
        pcRepeaterType = $pcRepeater.data('type');

        $('.pc-repeater-btn-more').click(function(){
            $pcRepeaterSrc
                .clone()
                .appendTo($pcRepeater)
                .removeClass('pc-repeater-src');
        });

        $pcRepeater.on( 'click', '.pc-repeater-btn-delete', function() {
            $(this).parent().remove();
            pc_repeater_update(pcRepeaterType);
        });
        $pcRepeater.on( 'change', 'select', function() {
            pc_repeater_update(pcRepeaterType);
        });
        $pcRepeater.on( 'focusout', 'input', function() {
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