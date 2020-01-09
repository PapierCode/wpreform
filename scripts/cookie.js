/**
*
* Gestion de cookie
*
** Création / Modification
** Test / Lecture
** Suppression
*
**/

/*===============================================
=            Création / Modification            =
===============================================*/

// name     : nom du cookie (string)
// value    : valeur du cookie (string)
// dead     : durée de vie du cookie en jours (number)

var setCookie = function( name, value, dead ) {

    var start = new Date(), // date du jour
        end; // date d'expiration

    // calcul de la date d'expiration
    // convertie au format international
    start.setTime( start.getTime() + ( dead*24*60*60*1000 ) );
    end = "expires="+start.toGMTString();

    // si le cookie doit être présent sur plusieurs sous domaine
    // document.cookie = name + '=' + value + ';' + end + ';domain=ndd; path=/' ;
    // où ndd est le nom de domaine sans le préfixe du sous domaine
    // exemple : ".papier-code.fr", sans les guillements, ne pas oublier le point
    document.cookie = name + '=' + value + ';' + end + '; path=/' ;

};


/*=====  FIN Création / Modification  ======*/

/*======================================
=            Test / Lecture            =
======================================*/

// name : nom du cookie (string)

var getCookie = function( name ) {

    var cible       = name + "=",
        allCookies  = document.cookie.split( ';' ); // tous les cookies du site dans un tableau

    for( var i = 0 ; i < allCookies.length ; i++ ) {

        allCookies[i] = allCookies[i].trim(); // suppression des espaces aux extrémités

        // si cette entrée du tableau contient la chaine recherchée
        // la fonction retourne la valeur du cookie (le reste de la chaine de caractères)
        if ( allCookies[i].indexOf( cible ) === 0 ) return allCookies[i].substring( cible.length, allCookies[i].length );

    }

    // sinon rien !
    return "";

};


/*=====  FIN Test / Lecture  ======*/

/*===================================
=            Suppression            =
===================================*/

// name : nom du cookie (string)

var killCookie = function( name ) {
    
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT"; 

};


/*=====  FIN Suppression  ======*/