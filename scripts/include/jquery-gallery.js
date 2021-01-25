/*

    jQuery Gallery by Julien S.
    ---------------------------

    Updates
    -------
    15/12/2015 : first version on production

*/

(function($) {

    // plugin constructor (class)
    $.gallery = function(element, options) {

        /*================================================
        =            Plugin's default options            =
        ================================================*/

        // this is private property and is accessible only from inside the plugin
        var defaults = {

            // simple variable : string, number, boolean
            btnPrevClass            : '',
            btnNextClass            : '',
            btnPrevInner            : 'Image précédente',
            btnNextInner            : 'Image suivante',
            btnCloseClass           : '',
            btnCloseInner           : 'Fermer la galerie',
            loaderContent           : '<div class="loader-item loader-item--1"></div><div class="loader-item loader-item--2"></div><div class="loader-item loader-item--3"></div>',
            closingDuration         : 400, // wait for css transition
            moveDuration            : 500, // animation between 2 slides
            responsiveImg           : false,
            responsiveKeyPoint      : 1000,

            // callbacks functions
            beforeAddStructure      : function() {},
            afterAddStructure       : function() {},
            beforeChangeSlide       : function() {},
            afterChangeSlide        : function() {}

        };


        /*=====  End of Plugin's default options  ======*/

        /*=========================================
        =            Plugin definition            =
        =========================================*/

        // to avoid confusions, use "plugin" to reference the current instance of the object
        var plugin = this;

        // this will merge default and user-provided options
        // plugin's properties will be available through this object like:
        // plugin.settings.propertyName from inside the plugin or
        // element.data('gallery').settings.propertyName from outside the plugin,
        // where "element" is the element the plugin is attached to;
        plugin.settings = {};


        /*=====  End of Plugin definition  ======*/

        /*=================================
        =            Variables            =
        =================================*/

        var $element    = $(element),           // jQuery version of DOM element, return an object
            $body       = $('body'),            // page body, return an object

            $itemLinks  = $element.find('a'),   // link list in element, return an object
            imgUrls     = [],                   // images's urls, return array
            imgCaptions = [],                   // images's captions, return array
            imgNb,                              // number of images, return number

            currentImg,                         // current image index, return number

            $glMain,                            // gallery main container, return an object
            $glHeader,                          // gallery header, return an object
            $glSlides,                       // gallery moving container, return an object
            $allSlide,                          // slides list, return an object
            $slidePrev,                         // active slide before gallery move, return an object
            $slideActive,                       // current active slide, return an object

            $loader,                            // loader, return an object
            $btnNav,                            // button previous & next, return an object
            $btnPrev,                           // button previous, return an object
            $btnNext,                           // button next, return an object
            $btnClose,                          // button close, return an object

            $caption,                           // caption, return an object
            $counter,                           // counter, return an object
            $counterCurrent,                    // display current slide, return an object

            $console;                           // to display messages or value


        /*=====  End of Variables  ======*/

        /*=============================================
        =            Plugin initialisation            =
        =============================================*/

        // the "constructor" method that gets called when the object is created
        plugin.init = function() {

            // the plugin's final properties are the merged default and
            // user-provided options (if any)
            plugin.settings = $.extend({}, defaults, options);

            // click on a thumbnail
            $element.on('click', 'a', function(event) {

                // remove default action
                event.preventDefault();
                // save all urls to an array
                // save all caption to an array
                // save img current index
                // save numbers of images
                if (plugin.settings.responsiveImg && $(window).width() < plugin.settings.responsiveKeyPoint) {
                    for (var i = 0; i < $itemLinks.length; i++) {
                        imgUrls[i] = $itemLinks.eq(i).data('gl-responsive');
                        imgCaptions[i] = $itemLinks.eq(i).data('gl-caption');
                    }
                    currentImg = imgUrls.indexOf($(this).data('gl-responsive'));
                } else {
                    for (var j = 0; j < $itemLinks.length; j++) {
                        imgUrls[j] = $itemLinks.eq(j).attr('href');
                        imgCaptions[j] = $itemLinks.eq(j).data('gl-caption');
                    }
                    currentImg = imgUrls.indexOf($(this).attr('href'));
                }
                // numbers of images
                imgNb = imgUrls.length;
                // add gallery
                addStructure();
                // indicates activation
                // add key events
                $body.addClass('gl-active').on('keydown', onKeyDown);
                // if it's not the first item
                // prepare gallery as if it had moved
                $itemsToMove = $allSlide.eq(currentImg).prevAll();
                for (var k = $itemsToMove.length; k > 0; k--) {
                   $itemsToMove.eq(k-1).appendTo($glSlides);
                }
                // save and add class to the active slide
                // add class "is-hidden" for gallery opening
                $slideActive = $allSlide.eq(currentImg).addClass('is-active is-hidden');
                // download img
                addImg($slideActive,imgUrls[currentImg],0);
                // update caption
                $caption.html(imgCaptions[currentImg]);

            }); // end $element.on()

        };


        /*=====  End of Plugin initialisation  ======*/

        /*==================================================
        =            Add structure and controls            =
        ==================================================*/

        var addStructure = function() {

            /*----------  base  ----------*/

            var imgContainerHtml = '<div class="gl" aria-hidden="true"><div class="gl-main"><div class="gl-slides" style="width:'+imgNb*100+'%" ></div></div></div>';

            $body.append(imgContainerHtml);
            $glMain = $('.gl').on('click',overlayClic);
            $glSlides = $('.gl-slides');


            /*----------  add slides  ----------*/

            // create slides
            for (var i = 0; i < imgNb; i++) {
                $glSlides.append('<div class="gl-slide is-hidden slide-'+i+'" style="width:'+(100/imgNb).toFixed(4)+'%"><div class="gl-slide-inner"></div></div>');
            }

            $allSlide = $('.gl-slide');


            /*----------  add header & footer  ----------*/

			$glMain.prepend('<div class="gl-header"><div class="gl-counter"><span class="gl-counter-current">'+(currentImg+1)+'</span> / <span class="gl-counter-all">'+imgUrls.length+'</span></div></div>');
			$glMain.append('<div class="gl-footer"><div class="gl-caption"></div></div>');

			$glHeader = $('.gl-header');
            $caption = $('.gl-caption');
            $counter = $('.gl-counter');
            $counterCurrent = $('.gl-counter-current');


            /*----------  add controls  ----------*/

            if (imgNb > 1) {

                $glHeader.append('<button class="gl-btn gl-btn-nav gl-btn-nav--prev reset-btn '+plugin.settings.btnPrevClass+'" aria-hidden="true" tabindex="-1">'+plugin.settings.btnPrevInner+'</button><button class="gl-btn gl-btn-nav gl-btn-nav--next reset-btn '+plugin.settings.btnNextClass+'" aria-hidden="true" tabindex="-1">'+plugin.settings.btnPrevInner+'</button>');

                $btnNav = $('.gl-btn-nav').on('mouseup', function() { $(this).blur(); });
                $btnPrev = $('.gl-btn-nav--prev').on('click', function(){ prevImg(); });
				$btnNext = $('.gl-btn-nav--next').on('click', function(){ nextImg(); });
				
				$glHeader.append('<button class="gl-btn gl-btn-close reset-btn '+plugin.settings.btnCloseClass+'">'+plugin.settings.btnCloseInner+'</button>');

				
				$btnClose = $('.gl-btn-close').on('click', function(){ galleryHide(); });

            }


            /*----------  add loader  ----------*/

            $glMain.append('<div class="gl-loader loader">'+plugin.settings.loaderContent+'</div>');

            $loader = $('.loader');


            /*----------  my console  ----------*/

            //$glMain.append('<div class="console">console...</div>');
            //$console = $('.console');


            /*----------  callback  ----------*/

            plugin.settings.afterAddStructure($glMain, $loader, $counter, $btnPrev, $btnNext, $btnClose, $btnNav);


        };

        /*----------  keys navigation  ----------*/

        var onKeyDown = function(event) {

            switch (event.keyCode) {
                case 27: // escape
                    galleryHide();
                    break;
                case 37: // left arrow
                    if (imgNb > 1 ) { prevImg(); }
                    break;
                case 39: // right arrow
                    if (imgNb > 1 ) { nextImg(); }
                    break;
            }

        };


        /*----------  prev img  ----------*/

        var prevImg = function() {

            currentImg = currentImg - 1;
            // if the last image was the first of the list
            // loop to the last
            if (currentImg === -1) {
                currentImg = imgUrls.length-1;
            }

            // download img
            addImg($allSlide.eq(currentImg),imgUrls[currentImg],-1);

        };


        /*----------  next img  ----------*/

        var nextImg = function() {

            currentImg = currentImg + 1;
            // if the first image was the last of the list
            // loop to the first
            if (currentImg > imgUrls.length-1) {
                currentImg = 0;
            }

            // download img
            addImg($allSlide.eq(currentImg),imgUrls[currentImg],1);

        };


        /*=====  End of Add structure and controls  ======*/

        /*====================================
        =            Hide gallery            =
        ====================================*/

        var galleryHide = function() {

            // remove gallery
            $glMain.addClass('is-hidden');
            // wait for css transition
            setTimeout(function(){ $glMain.remove(); }, plugin.settings.closingDuration);
            // remove key events
            $body.removeClass('gl-active').off('keydown',onKeyDown);

        }; // end galleryHide()


        /*----------  Overlay clic  ----------*/

        var overlayClic = function(event) {

            // if img is clicked
            if ( $( event.target ).is('img, button') ) { return; }
            // hide
            galleryHide();

        }; // end overlayClic()


        /*=====  End of Hide gallery  ======*/

        /*=================================
        =            Add image            =
        =================================*/

        var addImg = function(slide,cible,move) {

            // if the image has not been downloaded
            if (!slide.hasClass('is-loaded')) {

                // show loader
                $loader.removeClass('is-hidden');
                // to add an effect
                if (imgNb > 1 ) { $btnNav.addClass('is-loading'); }

                $.ajax({
                    url : cible,
                    cache: true, // put in browser cache
                    processData : false, // do not treat as data
                }).always(function(){ // dowload ok

                    // hide loader
                    $loader.addClass('is-hidden');
                    // to remove an effect
                    if (imgNb > 1 ) { $btnNav.removeClass('is-loading'); }
                    // add img to slide
					slide.addClass('is-loaded').children().append('<img src="'+cible+'" />');
                    // add touche event
                    touchEvent(slide.find('img'));
                    // gallery opening
                    if(move === 0) {
                        slide.removeClass('is-hidden');
                    } else {
                        // move to prev/next if required
                        changeSlide(move);
                    }

                }); // end always()

            // image has been already downloaded
            } else if (move !== 0) {
                // juste move to the prev/next
                changeSlide(move);
            }

        };


        /*=====  End of Add image  ======*/


        /*====================================
        =            Change image            =
        ====================================*/

        var changeSlide = function(x) {

            /*----------  call before moving  ----------*/
            plugin.settings.beforeChangeSlide(currentImg);


            /*----------  controls  ----------*/
            // disabled controls during animation
            $btnNav.attr('disabled','disabled').addClass('is-disabled');
            $body.off('keydown',onKeyDown);

            // switch active slide
            $slidePrev = $slideActive.removeClass('is-active').addClass('is-leaving');
            $slideActive = $allSlide.eq(currentImg).addClass('is-coming');

            // if gallery will move to the right (negative x)
            // move it to the left
            // move last child to first position
            if (x < 0) {
                $glSlides.css('left',x*100+'%').children(':last').prependTo($glSlides);
                $slidePrev.addClass('is-leaving-to-right');
                $slideActive.addClass('is-coming-from-left');
            } else {
                $slidePrev.addClass('is-leaving-to-left');
                $slideActive.addClass('is-coming-from-right');
            }


            /*----------  gallery animation  ----------*/

            // animation
            $glSlides.animate({
                left:'-='+x*100+'%'
            },{
                duration:plugin.settings.moveDuration*Math.abs(x), // animation time
                complete:function(){ // after animation...

                    // new active slide
                    $slideActive.addClass('is-active').removeClass('is-coming');
                    $slidePrev.removeClass('is-leaving');
                    // enable controls
                    $btnNav.removeAttr('disabled').removeClass('is-disabled');
                    $body.on('keydown',onKeyDown);

                    // if gallery move to the left (positif x)
                    // reset gallery's position
                    // move first child to last position
                    if (x > 0) {
                        $glSlides.css('left','0').children(':first').appendTo($glSlides);
                        $slidePrev.removeClass('is-leaving-to-left');
                        $slideActive.removeClass('is-coming-from-right');
                    } else {
                        $slidePrev.removeClass('is-leaving-to-right');
                        $slideActive.removeClass('is-coming-from-left');
                    }

                    // update counter
                    $counterCurrent.text(currentImg+1);
                    // update caption
                    $caption.html(imgCaptions[currentImg]);

                    /*----------  call after moving  ----------*/
                    plugin.settings.afterChangeSlide(currentImg);

                } // end complete
            }); // end animate

        };


        /*=====  End of Change image  ======*/

        /*====================================
        =            Touch events            =
        ====================================*/

        var touchEvent = function(cible) {

            var startX;

            cible[0].addEventListener('touchstart', function(e){
                var touchobj = e.changedTouches[0]; // reference first touch point (ie: first finger)
                startX = parseInt(touchobj.clientX); // get x position of touch point relative to left edge of browser
                $console.text(startX);
                e.preventDefault();
            }, false);

            // cible[0].addEventListener('touchmove', function(e){
            //     var touchobj = e.changedTouches[0]; // reference first touch point for this event
            //     var dist = parseInt(touchobj.clientX) - startX;
            //     e.preventDefault();
            // }, false)

            cible[0].addEventListener('touchend', function(e){
                var touchobj = e.changedTouches[0], // reference first touch point for this event
                    endX = parseInt(touchobj.clientX),
                    distX = endX - startX;
                if (Math.abs(distX) > 50) {
                    if (distX > 0) {
                        prevImg();
                    } else {
                        nextImg();
                    }
                }
                e.preventDefault();
            }, false);

        };

        /*=====  End of Touch events  ======*/

        /*======================================
        =            Public methods            =
        ======================================*/

        // these methods can be called like:
        // plugin.methodName(arg1, arg2, ... argn) from inside the plugin or
        // element.data('gallery').publicMethod(arg1, arg2, ... argn) from outside
        // the plugin, where "element" is the element the plugin is attached to;

        // a public method. for demonstration purposes only - remove it!
        plugin.foo_public_method = function() {

            // code goes here

        };


        /*=====  End of Public methods  ======*/

        /*===========================================
        =            Fire up the plugin!            =
        ===========================================*/

        // call the "constructor" method
        plugin.init();


        /*=====  End of Fire up the plugin!  ======*/

    }; // end $.gallery()

    /*==============================================================
    =            Add the plugin to the jQuery.fn object            =
    ==============================================================*/

    $.fn.gallery = function(options) {

        // iterate through the DOM elements we are attaching the plugin to
        return this.each(function() {

            // if plugin has not already been attached to the element
            if (undefined === $(this).data('gallery')) {

                // create a new instance of the plugin
                // pass the DOM element and the user-provided options as arguments
                var plugin = new $.gallery(this, options);

                // in the jQuery version of the element
                // store a reference to the plugin object
                // you can later access the plugin and its methods and properties like
                // element.data('gallery').publicMethod(arg1, arg2, ... argn) or
                // element.data('gallery').settings.propertyName
                $(this).data('gallery', plugin);

            }

        });

    };


    /*=====  End of Add the plugin to the jQuery.fn object  ======*/

})(jQuery);
