<?php
/**
 * 
 * Customisation de la recherche
 * 
 */


 /* !!! Modifier le nom de la table !!! */

/*=======================================================================
=            Indexation des customs fields pour la recherche            =
=======================================================================*/

// Extend WordPress search to include custom fields
// https://adambalee.com

// Join posts and postmeta tables
// http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join

function pc_search_join( $join ) {
    global $wpdb;

    if ( !is_admin() && is_search() ) {
        //$join .= ' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
        $join .= ' LEFT JOIN '.$wpdb->postmeta. ' biometa ON '. $wpdb->posts . '.ID = biometa.post_id ';
    }

    return $join;
}
add_filter('posts_join', 'pc_search_join' );


// Modify the search query with posts_where
// http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where

function pc_search_where( $where ) {
    global $pagenow, $wpdb;

    if ( !is_admin() && is_search() ) {
        // $where = preg_replace(
        //     "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
        //     "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (biometa.meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'pc_search_where' );


// Prevent duplicates
// http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct

function pc_search_distinct( $where ) {
    global $wpdb;

    if ( !is_admin() && is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'pc_search_distinct' );


/*=====  FIN Indexation des customs fields pour la recherche  ======*/