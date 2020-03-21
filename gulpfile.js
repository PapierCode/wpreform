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

const sass          = require( 'gulp-sass' ); // scss to css
const postcss 		= require( 'gulp-postcss' ); // package
const cssnano 		= require( 'cssnano' ); // minification css
const autoprefixer 	= require( 'autoprefixer' ); // ajout des préfixes
const mqcombine 	= require( 'postcss-sort-media-queries' ); // factorisation des medias queries
const inlinesvg		= require( 'postcss-inline-svg' ); // svg to data:URI

const jshint		= require( 'gulp-jshint' ); // recherche d'erreurs js
const concat		= require( 'gulp-concat' ); // empile plusieurs fichiers js en un seul
const terser		= require( 'gulp-terser' ); // minification js

    
/*=====  FIN Initialisation  ======*/

/*=================================
=            Tâche CSS            =
=================================*/

sass.compiler = require('sass');

// plugins CSS
var plugins = [
	inlinesvg(),
	autoprefixer({ grid: 'false' }),
	mqcombine(),
	cssnano()
];


/*----------  Fonctions  ----------*/
	
function css() {
    
    return src( ['css/style.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(dest( './' ));

}

function classic_css() {
    
    return src( ['css/v-classic.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(dest( './' ));

}

function fullscreen_css() {
    
    return src( ['css/v-fullscreen.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(dest( './' ));

}


/*=====  FIN Tâche CSS  ======*/

/*================================
=            Tâche JS            =
================================*/

jshint_src = [
	'scripts/jquery-gallery.js',
	'scripts/scripts.js'
],

js_global_src = [
	'scripts/vendor/jquery-3.4.1.min.js'
].concat(jshint_src);


/*----------  Fonctions  ----------*/

function js_hint() {

	return src( jshint_src )
        .pipe(jshint())
        .pipe(jshint.reporter( 'default' ));

}

function js() {

    return src( js_global_src )
        .pipe(concat( 'scripts.min.js' ))
        .pipe(terser())
        .pipe(dest( 'scripts/' ));

}


/*=====  FIN Tâche JS  =====*/

/*==================================
=            Monitoring            =
==================================*/

exports.watch = function() {
	watch( 'css/**/*.scss', series(css,classic_css,fullscreen_css) )
	watch( ['scripts/**/*.js', '!scripts/scripts.min.js'], series(js_hint,js) )
};


/*=====  FIN Monitoring  ======*/