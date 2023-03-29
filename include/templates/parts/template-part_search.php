<?php
/**
 * 
 * Customisation de la recherche
 * 
 */


/*==================================
=            Formulaire            =
==================================*/

function pc_display_form_search( $txts = array(), $css = array(), $icon = 'zoom' ) {

		$txts = array_merge(
			array(
				'label' => 'Mots-clés',
				'btn_title' => 'Rechercher ces mots-clés',
				'btn_txt' => 'Rechercher'
			),
			$txts
		);

		$css = array_merge(
			array( 'form-search' ),
			$css
		);

		echo '<form id="form-search" class="'.implode( ' ', $css ).'" method="get" role="search" aria-label="Formulaire de recherche" action="'.get_bloginfo('url').'">';
			echo '<label class="form-search-label" for="form-search-input">'.$txts['label'].'</label>';
			echo '<input type="text" class="form-search-input" name="s" id="form-search-input" value="'.esc_html( get_search_query() ).'" required>';
			echo '<button type="submit" class="form-search-submit reset-btn button" title="'.$txts['btn_title'].'"></span><span class="txt">'.$txts['btn_txt'].'</span><span class="ico">'.pc_svg($icon).'</button>';
		echo '</form>';

}


/*=====  FIN Formulaire  =====*/

/*=================================
=            Résultats            =
=================================*/

function pc_get_search_count_results( $query ) {

	global $wp_query;
	$posts_count = $wp_query->found_posts;
	$post_per_page = get_option( 'posts_per_page' );

	if ( $posts_count <= $post_per_page ) {

		$txt = ( $posts_count > 1 ) ? 'résultats' : 'résultat';
		return '<strong>'.$posts_count.' '.$txt.'</strong> pour la recherche de &quot;'.$query.'&quot;';

	} else {

		$pages_count = ceil( $posts_count / get_option( 'posts_per_page' ) );
		$page_current = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;					
		return '<strong>Page '.$page_current.' sur '.$pages_count.'</strong> pour <strong>'.$posts_count.' résultats</strong> associés à la recherche de &quot;'.$query.'&quot;';

	}

}


/*=====  FIN Résultats  =====*/

/*=======================================================================
=            Indexation des customs fields pour la recherche            =
=======================================================================*/

add_filter( 'posts_join', 'pc_search_join' );

	function pc_search_join( $join ) {

		global $wpdb;

		if ( is_search() ) {    
			$join .=' LEFT JOIN '.$wpdb->postmeta. ' wpreform_metas ON '. $wpdb->posts . '.ID = wpreform_metas.post_id ';
		}

		return $join;

	}

add_filter( 'posts_where', 'pc_search_where' );

	function pc_search_where( $where ) {

		global $pagenow, $wpdb;

		if ( is_search() ) {
			$where = preg_replace(
				"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
				"(".$wpdb->posts.".post_title LIKE $1) OR (wpreform_metas.meta_value LIKE $1)", $where );
		}

		return $where;

	}

add_filter( 'posts_distinct', 'pc_search_distinct' );

	function pc_search_distinct( $where ) {

		global $wpdb;

		if ( is_search() ) {
			return "DISTINCT";
		}

		return $where;

	}


/*=====  FIN Indexation des customs fields pour la recherche  ======*/