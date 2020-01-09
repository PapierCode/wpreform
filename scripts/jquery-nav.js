/**
*
* Menu de navigation 2 niveaux
*
* V 1.0.1
*
**/


(function($) {

    /*==============================================
    =            Construction du plugin            =
    ==============================================*/

    $.nav = function(element, options) {

        /*======================================
        =            Initialisation            =
        ======================================*/

        /*----------  Variables  ----------*/

        // options par défaut
        var defaults = {
            // simple variable : string, number, boolean
            timerClose      : 1000,
            mediaQuery      : 768,
            // callback function
            // XXX      : function() {}
        };

        // instance de l'object
        var plugin = this;

        // propriété contenant les options
        // plugin.settings.propertyName depuis ce script
        // element.data('pluginName').settings.propertyName depuis l'extérieur
        plugin.settings = {};

        var $html           = $('html'),                                // élément html
            $element        = $(element),                               // référence à l'élément (objet)
            $allLiParent    = $element.find('.is-parent'),              // tous les items "parent"
            $allL1Link      = $element.find('.p-nav-link--l1'),    // tous les lien de niveau 1
            $allBtn         = $allLiParent.children('button'),          // tous les boutons des items parents
            $allSubList     = $allLiParent.children('ul'),              // toutes les listes de niveau 2

            mouseleaveTimer;    // timer mouseleave


        /*----------  Start  ----------*/

        plugin.init = function() {

            // fusion des options
            plugin.settings = $.extend({}, defaults, options);

            aria_init();

            switch_type(); // première fois
            $(window).resize(switch_type); // au redimmensionnement de la fenêtre

        }; // FIN init()


        /*=====  FIN Initialisation  ======*/

        /*==================================
        =            Responsive            =
        ==================================*/

        var switch_type = function() {

            // conversion de l'option mediaQuery en em, arrondi à 3 décimales
            var mediaQueryEm = Math.round( (plugin.settings.mediaQuery / 16) * 1000 ) / 1000;

            // Media Query
            if (window.matchMedia('(min-width: '+mediaQueryEm+'em)').matches) {

                // désactive menu accordéon
                if ( $html.hasClass('menu-is-invisible') ) {

                    $html.removeClass('menu-is-invisible');
                    acc_destroy();

                }

                // active menu déroulant
                if ( !$html.hasClass('menu-is-visible') ) {

                    $html.addClass('menu-is-visible');
                    // active le plugin si nécessaire
                    if ( $allLiParent.length > 0 ) {
                        mouse_controls();
                        keyboard_controls();
                    }

                }

            } else {

                // désactive le menu déroulant
                if ( $html.hasClass('menu-is-visible') ) {

                    $html.removeClass('menu-is-visible');
                    dp_destroy();

                }

                // active le menu accordéon
                if ( !$html.hasClass('menu-is-invisible') ) {

                    $html.addClass('menu-is-invisible');
                    $allLiParent.filter('.is-active').addClass('is-open');
                    accordion();

                }

            }


        }; // fin switch_type()


        /*=====  FIN Responsive  ======*/

        /*===============================
        =            Destroy            =
        ===============================*/

        /*----------  Menu déroulant  ----------*/

        var dp_destroy = function() {

            // ferme les menus ouvert
            $allLiParent.removeClass('is-open');
            // supprime les événements
            $element
                .off('mouseenter mouseleave', '.is-parent')
                .off('focus', 'button.p-nav-link--l1')
                .off('focus mouseenter', 'a.p-nav-link--l1')
                .off('focus', '.p-nav-link--l2');

        };

        /*----------  Menu accordéon  ----------*/

        var acc_destroy = function() {

            // ferme les menus ouvert
            $allLiParent.removeClass('is-open');
            // supprime les événements
            $element.off('click', 'button.p-nav-link--l1');

        };


        /*=====  FIN Destroy  ======*/

        /*============================
        =            ARIA            =
        ============================*/

        var aria_init = function() {

            // pour chaque btn de niveau 1
            // ajout d'attribut id et ARIA correspondant
            $allBtn.each(function() {

                // index du parent
                var index = $(this).parent().index();
                // ajout des attributs
                $(this).attr({
                    'id': 'btn-submenu-'+index,
                    'aria-controls': 'submenu-'+index,
                    'aria-expanded': 'false'
                });

            });

            // pour chaque liste de niveau 2
            // ajout d'attribut id et ARIA correspondant
            $allSubList.each(function() {

                // index du parent
                var index = $(this).parent().index();
                // ajout des attibuts
                $(this).attr({
                    'id': 'submenu-'+index,
                    'aria-labelledby' : 'btn-submenu-'+index
                });

            });


        }; // FIN aria_init()


        /*=====  FIN ARIA  ======*/

        /*==================================
        =            Open/Close            =
        ==================================*/

        var menu_open = function($li, $btn, $list) {

            // si un timer est en cours, y mettre fin
            if (mouseleaveTimer && $html.hasClass('menu-is-visible')) { clearTimeout(mouseleaveTimer); }
            // ferme les autres menus
            $allLiParent.filter('.is-open').removeClass('is-open');
            // ouvre celui en cours
            $li.addClass('is-open');
            // ARIA
            $btn.attr('aria-expanded', 'true');
            $list.attr('aria-hidden', 'false');

        };

        var menu_close = function($li, $btn, $list) {

            // ferme menu
            $li.removeClass('is-open');
            // ARIA
            $btn.attr('aria-expanded', 'false');
            $list.attr('aria-hidden', 'true');

        };


        /*=====  FIN Open/Close  ======*/

        /*======================================
        =            Menu accordéon            =
        ======================================*/

        var accordion = function() {

            $element.on('click', 'button.p-nav-link--l1', function() {

                var $btn = $(this),
                    $li = $btn.parent(),
                    $list = $btn.next();

                if ( !$li.hasClass('is-open') ) {

                    menu_open($li, $btn, $list);

                } else {

                    menu_close($li, $btn, $list);

                }

            });

        };


        /*=====  FIN Menu accordéon  ======*/

        /*===========================================
        =            Menu Déroulant (dp)            =
        ===========================================*/

        /*----------  Sourie  ----------*/

        var mouse_controls = function() {

            /*----------  Enter li.is-parent  ----------*/

            $element.on('mouseenter', '.is-parent', function() {

                var $li = $(this),
                    $btn = $li.children('button'),
                    $list = $li.children('ul');

                // ouvre le menu enfant
                menu_open($li, $btn, $list);

            }) // FIN mouseenter


            /*----------  Leave li.is-parent  ----------*/

            .on('mouseleave', '.is-parent', function() {

                var $li = $(this),
                    $btn = $li.children('button'),
                    $list = $li.children('ul');

                // timer (options plugin)
                mouseleaveTimer = setTimeout(function(){

                    // ferme le menu
                    menu_close($li, $btn, $list);

                }, plugin.settings.timerClose);

            })   // FIN mouseleave


            /*----------  Focus liens niveau 1  ----------*/


            .on('mouseenter', 'a.p-nav-link--l1', function() {

                // si un timer est en cours, y mettre fin
                if (mouseleaveTimer) { clearTimeout(mouseleaveTimer); }
                // ferme un menu ouvert
                $allLiParent.filter('.is-open').removeClass('is-open');

            }); // FIN focus liens niveau 1



        }; // FIN mouse_controls()


        /*----------  Clavier  ----------*/

        var keyboard_controls = function() {

            /*----------  Focus liens niveau 2  ----------*/

            $element.on('focus', '.p-nav-link--l2', function() {

                var $a = $(this),
                    $li = $a.parents('.is-parent'),
                    $btn = $li.children('button'),
                    $list = $li.next('ul');

                if ( !$li.hasClass('is-open') ) {

                    menu_open($li, $btn, $list);

                }

            }) // FIN focus liens niveau 2


            /*----------  Focus bouttons  ----------*/

            .on('focus', 'button.p-nav-link--l1', function() {

                var $btn = $(this),
                    $li = $btn.parent(),
                    $list = $btn.next('ul');

                if ( !$li.hasClass('is-open') ) {

                    menu_open($li, $btn, $list);

                }

            }) // FIN focus boutton


            /*----------  Focus liens niveau 1  ----------*/


            .on('focus', 'a.p-nav-link--l1', function() {

                // si un timer est en cours, y mettre fin
                if (mouseleaveTimer) { clearTimeout(mouseleaveTimer); }
                // ferme un menu ouvert
                $allLiParent.filter('.is-open').removeClass('is-open');

            }); // FIN focus liens niveau 1


        }; // FIN keyboard_controls()


        /*=====  FIN Menu déroulant  ======*/

        /*====================================
        =            Start plugin            =
        ====================================*/

        plugin.init();


        /*=====  FIN Start plugin  ======*/


    }; //FIN $.nav


    /*=====  FIN Construction du plugin  ======*/

    /*============================================================
    =            Ajout du plugin à l'object jQuery.fn            =
    ============================================================*/

    $.fn.nav = function(options) {

        // pour tous les éléments concernés par le plugin
        return this.each(function() {

            // si le plugin n'a pas déjà été attaché
            if (undefined === $(this).data('nav')) {

                // crée une nouvelle instance du plugin
                // passe l'élément DOM et les options
                var plugin = new $.nav(this, options);

                // référence le plugin dans l'object jQuery de l'élément
                // pour accéder aux méthodes et propriétés
                // element.data('pluginName').publicMethod(arg1, arg2, ... argn) ou
                // element.data('pluginName').settings.propertyName
                $(this).data('nav', plugin);

            }

        });

    };


    /*=====  FIN Ajout du plugin à l'object jQuery.fn  ======*/

})(jQuery);
