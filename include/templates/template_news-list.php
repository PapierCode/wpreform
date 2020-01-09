<?php
/**
 * 
 * Liste des actualités
 * 
 */  

// page en cours (pager)
$currentPage = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

/*=============================
=            Query            =
=============================*/

$queryNewsArgs = array(
    'post_type' => NEWS_POST_SLUG,
    'posts_per_page' => get_option( 'posts_per_page' ),
    'paged' => $currentPage
);

if ( get_query_var( NEWS_TAX_QUERY_VAR ) ) {
    $queryNewsArgs['tax_query'] = array(
        array (
            'taxonomy' => NEWS_TAX_SLUG,
            'field' => 'slug',
            'terms' => get_query_var( NEWS_TAX_QUERY_VAR )
        )
    );
}

$queryNews = new WP_Query( $queryNewsArgs );


/*=====  FIN Query  =====*/

/*=================================
=            Affichage            =
=================================*/

if ( $queryNews->have_posts() ) { ?>

    <div class="st-list">

    <?php while ( $queryNews->have_posts() ) { $queryNews->the_post();

        pc_get_post_resum( $post->ID, '', 2, true, true );

    } ?>

    </div>

    <?php pc_get_pager( $queryNews, $currentPage );
    
}
 
 
 /*=====  FIN Affichage  =====*/
 
 // reset query
 wp_reset_postdata();