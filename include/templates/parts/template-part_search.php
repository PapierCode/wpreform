<?php
/**
 * 
 * Customisation de la recherche
 * 
 */


/*==================================
=            Formulaire            =
==================================*/

function pc_display_form_search() {

		echo '<form id="form-search" class="form-search mw" method="get" role="search" action="'.get_bloginfo('url').'">';
			echo '<label class="form-search-label" for="form-search-input">Mots-clés</label>';
			echo '<input type="text" class="form-search-input" name="s" id="form-search-input" value="'.esc_html( get_search_query() ).'" placeholder="Mots-clés" required>';
			echo '<button type="submit" class="form-search-submit reset-btn button" title="Rechercher ces mots-clés"><span class="ico">'.pc_svg('zoom').'</span><span class="visually-hidden">Rechercher</span>'.'</button>';
		echo '</form>';

}


/*=====  FIN Formulaire  =====*/

/*=======================================================================
=            Indexation des customs fields pour la recherche            =
=======================================================================*/

/**
 * 
 * Extend WordPress search to include custom fields
 *
 * https://adambalee.com
 * 
 */

/**
 *
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 * 
 */

function pc_search_join( $join ) {

    global $wpdb;

    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' wpreform_metas ON '. $wpdb->posts . '.ID = wpreform_metas.post_id ';
    }

    return $join;

}

add_filter( 'posts_join', 'pc_search_join' );

/**
 * 
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 * 
 */

function pc_search_where( $where ) {

    global $pagenow, $wpdb;

    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (wpreform_metas.meta_value LIKE $1)", $where );
    }

    return $where;

}

add_filter( 'posts_where', 'pc_search_where' );

/**
 * 
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 * 
 */

function pc_search_distinct( $where ) {

    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;

}

add_filter( 'posts_distinct', 'pc_search_distinct' );


/*=====  FIN Indexation des customs fields pour la recherche  ======*/