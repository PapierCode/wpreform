$(document).ready(function(){

/*=================================
=            variables            =
=================================*/

var $win 		= $(window),
	$html 		= $('html'),
	$body 		= $('body'),
	$main 		= $('.main'),
	$primaryNav = $('#primary-nav'),

	urlIcons 	= '/wp-content/themes/preform/images/icons/';

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


} // fin winWidthChange()

winChange();

$win.resize(winChange);


/*=====  End of Responsive  ======*/

/*==================================
=            navigation            =
==================================*/

var $overlay = $('.btn-overlay');


/*----------  Navigation avec menu déroulants  ----------*/

// $primaryNav.nav({
// 	// timerClose (temporisation avant de supprimer .is-open, défaut 1000 ms)
// 	// mediaQuery (point de changement menu accordéon / déroulant, défaut 768)
// });

/*----------  btn open/close  ----------*/

$('.btn-h-nav').click(function() {
	$html.toggleClass('h-nav-is-open');
});


/*----------  overlay  ----------*/

$overlay.click(function() {
    $html.removeClass('nav-is-open');
    $(this).addClass('visually-hidden');
});


/*----------  back to top  ----------*/

$('.back-to-top').click(function() {
	$('html, body').animate({ scrollTop:0 }, 500);
});


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
