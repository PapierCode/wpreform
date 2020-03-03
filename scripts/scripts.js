/*=============================
=            Tools            =
=============================*/

/*----------  Conversion em  ----------*/

var rem = function(size,base) {
	if ( base == undefined ) { base = 16; }
	return size / base + 'rem';
};


/*=====  FIN Tools  ======*/

$(document).ready(function(){

/*=================================
=            variables            =
=================================*/

var $win 			= $(window),
	$html 			= $('html'),
	$body 			= $('body'),
	$header 		= $('.header'),
	$main 			= $('.main'),
	$main_header 	= $main.find('.main-header'),
	$primaryNav 	= $('#primary-nav'),

	urlIcons 		= '/wp-content/themes/preform/images/icons/',
	
	win_h, win_w, header_h, win_w_old = 0;

/*=====  End of variables  ======*/

/*==================================
=            Responsive            =
==================================*/

// fonction executée au chargement de la page et à chaque modification de taille de la fenêtre
function winChange() {

	// 768px
	if (window.matchMedia('(min-width: 48em)').matches) {

	} else {

	}

	/*----------  Fullscreen  ----------*/
	
	if ( $html.hasClass('is-fullscreen') ) {

		win_h = $win.height() + 100;
		win_w = $win.width();
		header_h = $header.outerHeight();

		console.log(win_h);
		

		if ( win_w != win_w_old ) {
			// éléments concernés par le plein écran
			$main_header.css( 'min-height', rem(win_h) );
			$main.css( 'margin-top', rem(win_h-header_h) );
			win_w_old = win_w;
		}

	}
	


} // fin winWidthChange()

winChange();

$win.resize(winChange);


/*=====  End of Responsive  ======*/

/*==================================
=            navigation            =
==================================*/

/*----------  btn open/close  ----------*/

$('.js-h-nav').click(function() {
	$html.toggleClass('h-nav-is-open');
});

/*----------  Thème fullscreen  ----------*/

if ( $html.hasClass('theme-fullscreen')) {

	$('.fs-more-btn').click(function() {
		$('html, body').animate({ scrollTop:win_h }, 500);
	});

}




/*=====  End of navigation  ======*/

/*==============================
=            divers            =
==============================*/

/*----------  remove focus after click  ----------*/

$('button:not(.overlay), .p-nav-link').mouseup(function() {
	$(this).blur();
});


/*----------  gallery  ----------*/

// var btnArrow = sprite.arrow.replace('<svg','<svg class="svg-block"'),
// 	btnCross = sprite.cross.replace('<svg','<svg class="svg-block"');

// $('.wp-gallery').gallery({
// 	btnNextInner:btnArrow,
// 	btnPrevInner:btnArrow,
// 	btnCloseInner:btnCross,
// 	moveDuration:500,
// 	responsiveImg:true
// });


/*----------  iframe  ----------*/

$('iframe').each(function() {
	$(this).wrap('<div class="iframe iframe_16-10"></div>');
});


/*=====  End of divers  ======*/

/*=======================================
=            Message cookies            =
=======================================*/

// cookie es-tu là ?
/*
if (getCookie('cookies') === '') {

	// création du message
	$('body').prepend('<p class="cookies-msg is-hidden no-print">En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de <strong>cookies</strong>, <a href="'+cguUrl+'" title="Conditions générales d\'utilisation" class="cookies-msg-link" rel="nofollow">en savoir plus</a>. <button type="button" class="btn cookies-msg-btn reset-btn">J\'accepte</button></p>');

	var $cookiesMsg = $('.cookies-msg');

	// apparition du message
	$cookiesMsg.removeClass('is-hidden');

	// btn de validation des cookies
	$('.btn-alert-cookie').click(function() {

		// création du cookie, valable un an
		setCookie('cookies', 'accepted', 365);
		// disparition du message
		$cookiesMsg.addClass('is-hidden');
		// suppression du message
		setTimeout(function(){ $cookiesMsg.remove(); }, 500); // durée à reporter en css

	});

}
*/


/*=====  FIN Message cookies  ======*/

}); // end $(document).ready()
