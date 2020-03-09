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

const { src, dest, watch, series }          = require( 'gulp' ); // base

const sass          = require( 'gulp-sass' ); // scss to css
const postcss 		= require( 'gulp-postcss' ); // package
const cssnano 		= require( 'cssnano' ); // minification css
const autoprefixer 	= require( 'autoprefixer' ); // ajout des préfixes
const mqpacker 		= require( 'css-mqpacker' ); // factorisation des medias queries
const inlinesvg		= require( 'postcss-inline-svg' ); // svg to data:URI
const banner		= require( 'gulp-banner' ); // commentaire css pour wordpress

const jshint		= require( 'gulp-jshint' ); // recherche d'erreurs js
const concat		= require( 'gulp-concat' ); // empile plusieurs fichiers js en un seul
const terser		= require( 'gulp-terser' ); // minification js

    
/*=====  FIN Initialisation  ======*/

/*=================================
=            Tâche CSS            =
=================================*/

// plugins CSS
var plugins = [
	inlinesvg(),
	autoprefixer({ grid: 'false' }),
	mqpacker({ sort: true }),
	cssnano()
];

// commentaire WP
var theme_name 	    = 'WPréformaté',
	theme_author 	= 'www.papier-code.fr'
	theme_desc 		= 'Base de projet',
	wp_comment 		= '/* \nTheme Name: '+theme_name+' \nAuthor: '+theme_author+' \nDescription: '+theme_desc+' \n*/\n\n';


/*----------  Fonctions  ----------*/
	
function css() {
    
    return src( ['css/style.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(banner( wp_comment ))
        .pipe(dest( './' ));

}

function classic_css() {
    
    return src( ['css/v-classic.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(dest( 'css' ));

}

function fullscreen_css() {
    
    return src( ['css/v-fullscreen.scss'] )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(dest( 'css' ));

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