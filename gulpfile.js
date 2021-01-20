/**
*
* Gulp pour Papier Codé
*
** dépendance : package.json
** installation : commande "npm install"
*
**/


/*======================================
=            Initialisation            =
======================================*/

// Chargement des plugins

const { src, dest, watch, series } = require( 'gulp' ); // base

const jshint		= require( 'gulp-jshint' ); // recherche d'erreurs js
const concat		= require( 'gulp-concat' ); // empile plusieurs fichiers js en un seul
const terser		= require( 'gulp-terser' ); // minification js

    
/*=====  FIN Initialisation  ======*/

/*================================
=            Tâche JS            =
================================*/

js_src = [
	'scripts/jquery-gallery.js',
	'scripts/scripts.js'
],

js_src_all = [
	'scripts/jquery-3.4.1.min.js'
].concat(js_src);


/*----------  Fonctions  ----------*/

function js_hint() {

	return src( js_src )
        .pipe(jshint())
        .pipe(jshint.reporter( 'default' ));

}

function js_jquery() {

    return src( js_src_all )
        .pipe(concat( 'scripts.jquery.min.js' ))
        .pipe(terser())
        .pipe(dest( 'scripts/' ));

}

function js() {

    return src( js_src )
        .pipe(concat( 'scripts.min.js' ))
        .pipe(terser())
        .pipe(dest( 'scripts/' ));

}


/*=====  FIN Tâche JS  =====*/

/*==================================
=            Monitoring            =
==================================*/

exports.watch = function() {
	watch( [ 'scripts/**/*.js', '!scripts/scripts.min.js', '!scripts/scripts.jquery.min.js' ], series(js_hint,js_jquery,js)  )
};


/*=====  FIN Monitoring  ======*/