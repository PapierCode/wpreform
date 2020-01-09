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

const gulp          = require( 'gulp' ); // base

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



/*----------  Sources  ----------*/

    // css
    var css_src = ['css/style.scss'],

    // jshint sources
    jshint_src = [
        'scripts/scripts.js'
    ],

    // js sources globales + jshint sources
    js_global_src = [
        'scripts/vendor/jquery-3.4.1.min.js'
    ].concat(jshint_src);


/*----------  Destinations  ----------*/

    // css
    var css_dir_final = './',

    // js
    js_file_final = 'scripts.min.js',
    js_dir_final = 'scripts/';


/*----------  Monitoring  ----------*/
    
    // css
    var watch_css = 'css/**/*.scss',

    // js
    watch_js = ['scripts/**/*.js', '!scripts/scripts.min.js'];




/*----------  Post CSS plugins  ----------*/

    var plugins = [
        inlinesvg(),
        autoprefixer({ grid: 'autoplace' }),
        mqpacker({ sort: true }),
        cssnano()
    ];


/*----------  Commentaire pour le thème Wordpress  ----------*/
    
    var theme_name 	    = 'Preform Papier Code',
        theme_author 	= 'www.papier-code.fr'
        theme_desc 		= 'Base de projet',
        wp_comment 		= '/* \nTheme Name: '+theme_name+' \nAuthor: '+theme_author+' \nDescription: '+theme_desc+' \n*/\n\n';

    
/*=====  FIN Initialisation  ======*/

/*=================================
=            Tâche CSS            =
=================================*/

// exécuter avec "gulp css"

function css() {
    
    return gulp
        .src( css_src )
        .pipe(sass({ precision: 3 }))
        .pipe(postcss( plugins ))
        .pipe(banner( wp_comment ))
        .pipe(gulp.dest( css_dir_final ));

}

exports.css = css;



/*=====  FIN Tâche CSS  ======*/

/*================================
=            Tâche JS            =
================================*/

function js() {

	gulp.src( jshint_src )
        .pipe(jshint())
        .pipe(jshint.reporter( 'default' ));

    return gulp
        .src( js_global_src )
        .pipe(concat( js_file_final ))
        .pipe(terser())
        .pipe(gulp.dest( js_dir_final ));

}

exports.js = js;

/*=====  FIN Tâche JS  =====*/

/*==================================
=            Monitoring            =
==================================*/

function watchFiles() {
    gulp.watch( watch_css, css );
    gulp.watch( watch_js, js );
}

const watch = gulp.series(watchFiles);
exports.watch = watch;


/*=====  FIN Monitoring  ======*/