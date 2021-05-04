/*=============================
=            Tools            =
=============================*/

/*----------  Conversion rem  ----------*/

var rem = function( size, base ) {
	if ( base == undefined ) { base = 16; }
	return size / base + 'rem';
};


/*=====  FIN Tools  ======*/

jQuery(document).ready(function($){

/*=================================
=            variables            =
=================================*/

var $html = $('html'),
	$body = $('body'),
	$head = $('head');
	

/*=====  End of variables  ======*/

/*==================================
=            navigation            =
==================================*/

/*----------  btn open/close  ----------*/

$('.js-button-h-nav').click(function() {
	
	$html.toggleClass('h-nav-is-open');
	
	if ( $html.hasClass('search-is-open') ) {

		$html.removeClass('search-is-open');
		$search_form.find('input,button').attr('tabindex','-1');

	}
	
});

$('.js-overlay-h-nav').click(function(event) {

	if ( $( event.target ).is('.h-nav *') ) { return; }
	$html.removeClass('h-nav-is-open');

});


/*=====  End of navigation  ======*/

/*=========================================
=            Toggle open/close            =
=========================================*/

if ( $html.hasClass('has-search') ) {

	var $search_form = $('.form-search-box');
	$search_form.find('input,button').attr('tabindex','-1');

	$('.js-button-search').click(function() {

		if ( $html.hasClass('search-is-open') ) {

			$html.removeClass('search-is-open');
			$search_form.find('input,button').attr('tabindex','-1');

		} else {

			$html.addClass('search-is-open');
			$search_form.find('input,button').removeAttr('tabindex');
			$search_form.find('input').focus();

		}

	});

}


/*=====  FIN Toggle open/close  =====*/

/*==============================
=            divers            =
==============================*/

/*----------  Supprimme le focus après un clic  ----------*/

$('button').mouseup(function() {
	$(this).blur();	
});


/*----------  gallery  ----------*/

$('.wp-gallery').gallery({
	btnNextInner:sprite.arrow,
	btnPrevInner:sprite.arrow,
	btnCloseInner:sprite.cross,
	moveDuration:500,
	responsiveImg:true
});


/*----------  iframe  ----------*/

$('.editor iframe').each(function() {
	$(this).wrap('<div class="iframe iframe_16-10"></div>');
});


/*=====  End of divers  ======*/

/*=============================
=            Carte            =
=============================*/

var $js_button_map = $('.js-button-map');

if ( $js_button_map.length > 0 ) {

	$body.append('<div class="map"></div>');

	var $map = $('.map'), 
	jsMap = false, // Leaflet chargé ?
	mapLat,
	mapLong, 
	mapZoomDefault = 15,
	mapZoomCurrent = mapZoomDefault,
	mapZoomMin = 10,
	mapZoomMax = 18;
	
	var map_map_close = function() {
		$map.removeClass('is-visible').empty();
		$body.off('keydown', map_map_escap);
	};

	var map_map_escap = function() {
		if ( event.keyCode == 27 ) { // échap
			map_map_close();
		}
	};

	$js_button_map.click(function() {

		var $this = $(this);

		// ajout  container map et contrôles
		$map.append('<div id="map" class="map-inner"></div><div class="map-controls"><button type="button" class="map-btn-zoom map-btn-zoom--in button">'+sprite.more+'</button><button type="button" class="map-btn-zoom map-btn-zoom--out button">'+sprite.less+'</button><button type="button" class="map-btn-hide button" title="Fermer" data-cible="map">'+sprite.cross+'</button></div>');
		// coordonnées GPS
		var mapLat = $this.data('lat'),
		mapLong = $this.data('long'),
		// boutons du zoom
		$mapBtnZoom = $map.find('.map-btn-zoom').mouseup(function() { $(this).blur();}),
		$mapBtnZoomIn = $map.find('.map-btn-zoom--in'),
		$mapBtnZoomOut = $map.find('.map-btn-zoom--out');
		// actions pour fermer la map
		$map.find('.map-btn-hide').on('click', map_map_close);
		$body.on('keydown', map_map_escap);

		// chargement Leaflet si pas déjà fait
		if ( !jsMap ) {

			jsMap = true;

			// css
			var $contactMapCssTag = $(document.createElement('link'));

			$contactMapCssTag.attr('href', 'https://unpkg.com/leaflet@1.6.0/dist/leaflet.css');
			$contactMapCssTag.attr('rel', 'stylesheet');
			$contactMapCssTag.attr('integrity', 'sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==');
			$contactMapCssTag.attr('crossorigin', '');

			$head.append($contactMapCssTag);

			// js
			var $contactMapJsTag = $(document.createElement('script'));

			$contactMapJsTag.attr('src', 'https://unpkg.com/leaflet@1.6.0/dist/leaflet.js');
			$contactMapJsTag.attr('integrity', 'sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==');
			$contactMapJsTag.attr('crossorigin', '');

			$body.append($contactMapJsTag);

		}


		var map_add = function() {
			
			// fonction appelée toutes les 100 ms tant que la méthode Leaflet n'est pas prête
			if ( typeof L === 'undefined' ) { return; } else {

				// stop l'appel toutes 100 ms
				clearInterval(waitForMapReady);

				$map.addClass('is-visible');
				$body.on('keydown', map_map_escap);

				// création de l'object
				var map = L.map('map', {
					minZoom : mapZoomMin,
					maxZoom : mapZoomMax,
					zoomControl : false,
					scrollWheelZoom : false,
					tap : false
				}).setView([mapLat, mapLong], mapZoomDefault);

				L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoicGFwaWVyY29kZSIsImEiOiJja203a3E5N3kweXplMnhuNjBuOTV2bmQ1In0.UtKowadsitAGdxDUpMv5aA', {
					id: 'mapbox/streets-v11',
					tileSize: 512,
					zoomOffset: -1
				}).addTo(map);

				// marqueur
				var mapIcon = L.divIcon({
					iconSize: [40,60],
					iconAnchor: [20,60],
					className: 'map-marker'
				});
				var marker = L.marker([mapLat, mapLong], {icon: mapIcon}).addTo(map);
		
				// zoom +
				$mapBtnZoomIn.click(function() {
					map.zoomIn();
					mapZoomCurrent++;
					if ( mapZoomCurrent == mapZoomMax ) { $(this).prop('disabled',true); }
					if ( mapZoomCurrent == mapZoomMin + 1 ) { $mapBtnZoomOut.prop('disabled',false); }
					
				});

				// zoom -
				$mapBtnZoomOut.click(function() {
					map.zoomOut();
					mapZoomCurrent--;
					if ( mapZoomCurrent == mapZoomMin ) { $(this).prop('disabled',true); }
					if ( mapZoomCurrent == mapZoomMax - 1 ) { $mapBtnZoomIn.prop('disabled',false); }
				});
	
			}
		};

		// toutes les 100 ms tant que la méthode Leaflet n'est pas prête
		var waitForMapReady = setInterval( map_add, 100 );


	}); // FIN $js_button_map.click

} // FIN if $js_button_map


/*=====  FIN Carte  =====*/

}); // end $(document).ready()
