<?php

/**
*
* Actualités
*
* * Post
* * Admin
* * Taxonomy
* * Menu item actif
*
**/


if ( isset($pcSettings['news-active']) && class_exists( 'PC_Add_Custom_Post' ) && class_exists( 'PC_Add_Admin_Page' ) ) {

	/*===================================
	=            Custom Post            =
	===================================*/

	/*----------  Labels  ----------*/

	$newsLabels = array (
	    'name'                  => 'Actualités',
	    'singular_name'         => 'Actualité',
	    'menu_name'             => 'Actualités',
	    'add_new'               => 'Ajouter une actualité',
	    'add_new_item'          => 'Ajouter une actualité',
	    'new_item'              => 'Ajouter une actualité',
	    'edit_item'             => 'Modifier l\'actualité',
	    'all_items'             => 'Toutes les actualités',
	    'not_found'             => 'Aucune actualité'
	);


	/*----------  Configuration  ----------*/

	$newsArgs = array(
	    'menu_position'     => 26,
		'menu_icon'         => 'dashicons-megaphone',
		'show_in_nav_menus' => ($currentUserRole === 'administrator') ? true : false,
	    'supports'          => array( 'title', 'editor' ),
	    'rewrite'			=> array( 'slug' => 'news-actualites'),
		'taxonomies'		=> array( NEWS_TAX_SLUG ),
		'has_archive'		=> false
	);


	/*----------  Déclaration  ----------*/

	$news = new PC_Add_Custom_Post( NEWS_POST_SLUG, $newsLabels, $newsArgs );


	/*=====  FIN Custom Post  ======*/

	/*=======================================
	=            Custom Taxonomy            =
	=======================================*/

	if ( isset($pcSettings['news-tax']) ) {

		/*----------  Labels  ----------*/

		$newsCatLabels = array(
		    'name'                          => 'Catégories',
		    'singular_name'                 => 'Catégorie',
		    'menu_name'                     => 'Catégories',
		    'all_items'                     => 'Toutes les catégories',
		    'edit_item'                     => 'Modifier la catégorie',
		    'view_item'                     => 'Voir la catégorie',
		    'update_item'                   => 'Mettre à jour la catégorie',
		    'add_new_item'                  => 'Ajouter une catégorie',
		    'new_item_name'                 => 'Ajouter une catégorie',
		    'search_items'                  => 'Rechercher une catégorie',
		    'popular_items'                 => 'Catégories les plus utilisées',
		    'separate_items_with_commas'    => 'Séparer les catégories avec une virgule',
		    'add_or_remove_items'           => 'Ajout/supprimer une catégorie',
		    'choose_from_most_used'         => 'Choisir parmis les plus utilisées',
		    'not_found'                     => 'Aucune catégorie définie'
		);


		/*----------  Paramètres  ----------*/

		$newsCatArgs = array(
			'show_in_nav_menus' => ($currentUserRole === 'administrator') ? true : false,
		);


		/*----------  Déclaration  ----------*/

		$news->add_custom_tax( NEWS_TAX_SLUG, $newsCatLabels, $newsCatArgs );


		/*----------  Filtre  ----------*/

		// déclaration variable
		add_filter( 'query_vars', 'pc_news_query_vars' );

			function pc_news_query_vars( $vars ){

				$vars[] = NEWS_TAX_QUERY_VAR;
				return $vars;

			}

	} // FIN si taxonomy active


	/*=====  FIN Custom Taxonomy  ======*/

	/*============================================================
	=            Gestion des colonnes dans les listes            =
	============================================================*/
	
	add_filter( 'manage_edit-'.NEWS_TAX_SLUG.'_columns', 'pc_news_tax_columns' );

		function pc_news_tax_columns( $columns ) {
			
			unset( $columns['description'] );
			return $columns;

		}
	
	
	/*=====  FIN Gestion des colonnes dans les listes  =====*/

} // FIN if news-active && class_exists(PC_Add_Custom_Post)
