/**
*
* Javascript Admin
*
**/


jQuery(document).ready(function($){

    /*===========================================
    =            Sous-pages repeater            =
    ===========================================*/
    
	var $pcRepeater = $('.wpr-repeater');	
    
    if ( $pcRepeater.length > 0 ) {

    	$pcRepeaterInput = $('.wpr-repeater-input') // champ sauvegardé

		var wpr_repeater_update = function( type ) {
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

        var $pcRepeaterSrc = $('.wpr-repeater-src'),
        pcRepeaterType = $pcRepeater.data('type');

        $('.wpr-repeater-btn-more').click(function(){
            $pcRepeaterSrc
                .clone()
                .appendTo($pcRepeater)
                .removeClass('wpr-repeater-src');
        });

        $pcRepeater.on( 'click', '.wpr-repeater-btn-delete', function() {
            $(this).parent().remove();
            wpr_repeater_update(pcRepeaterType);
        });
        $pcRepeater.on( 'change', 'select', function() {
            wpr_repeater_update(pcRepeaterType);
        });
        $pcRepeater.on( 'focusout', 'input', function() {
            wpr_repeater_update(pcRepeaterType);
        });
    
        $pcRepeater.sortable({
            update: function( event, ui ) {
                wpr_repeater_update(pcRepeaterType);
            }
        });
        
    
    }

    
    /*=====  FIN Sous-pages repeater  =====*/

});