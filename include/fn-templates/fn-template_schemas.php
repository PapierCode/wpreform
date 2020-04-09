<?php
/**
 * 
 * Fonctions données structurée (schema.org)
 * 
 */


/*=================================
=            Publisher            =
=================================*/

/**
 * 
 * @param string	$name	Nom de la structure qui publie le contenu
 * @param array		$img	URL, largeur et hauteur de l'image (logo)
 * 
 * @return array	Données de la propriété Publisher
 * 
 */

function pc_get_schema_publisher( $name, $img ) {

	$schema_publisher = array(
		'@type' => 'Organization',
		'name' => $name,
		'logo'	=> array(
			'@type'		=>'ImageObject',
			'url' 		=> $img[0],
			'width' 	=> $img[1],
			'height'	=> $img[2]
		)
	);

	$same_as = pc_get_schema_same_as();
	if ( !empty( $same_as ) ) { $schema_publisher['sameAs'] = $same_as; };

	return $schema_publisher;

}


/*=====  FIN Publisher  =====*/

/*===============================
=            Same As            =
===============================*/

/**
 * 
 * @return array Données de la propriété Same As
 * 
 */

function pc_get_schema_same_as() {

	global $settings_project, $settings_project_fields;

	$same_as = array();

	foreach( $settings_project_fields[2]['fields'] as $field ) {

		$id = $settings_project_fields[2]['prefix'].'-'.$field['label_for'];
		if ( isset($settings_project[$id]) && $settings_project[$id] != '' ) {	
			$same_as[] = $settings_project[$id];				
		}	

	}

	return $same_as;

}


/*=====  FIN Same As  =====*/

/*======================================
=            Local Business            =
======================================*/

/**
 * 
 * @return affiche les données structurées Local Business sur la page d'accueil
 * 
 */

function pc_display_schema_local_business() {

	if ( is_home() ) {

		global $settings_project, $images_project_sizes;

		// données structurées
		$local_business = array(
			'@context' => 'http://schema.org',
			'@type' => 'LocalBusiness',
			'@id' => get_site_url(),
			'url' => get_site_url(),
			'address' => array(
				'@type' => 'PostalAddress',
				'streetAddress' => $settings_project['coord-address'],
				'postalCode' => $settings_project['coord-postal-code'],
				'addressLocality' => $settings_project['coord-city'],
				'addressRegion' => 'FR'
			),
			'geo' => array(
				'@type' => 'GeoCoordinates',
				'latitude' => $settings_project['coord-lat'],
				'longitude' => $settings_project['coord-long']
			),
			'description' => $settings_project['micro-desc'],
			'name' => $settings_project['coord-name'],
			'image' => array(
				'@type' => 'ImageObject',
				'url' => pc_get_img_default_url_to_share(),
				"width" => $images_project_sizes['share']['width'],
				"height" => $images_project_sizes['share']['height']
			),
			'telephone' => pc_phone($settings_project['coord-phone-1']),
			'pricerange' => '€€'
		);
		
		// same as
		$same_as = pc_get_schema_same_as();
		if ( !empty( $same_as ) ) { $local_business['sameAs'] = $same_as; };
		
		// filtre
		$local_business = apply_filters( 'pc_filter_local_business', $local_business, $settings_project );

		// affichage
		echo '<script type="application/ld+json">'.json_encode($local_business,JSON_UNESCAPED_SLASHES).'</script>';

	}

}


/*=====  FIN Local Business  =====*/

/*==================================================
=            Page (article par défault)            =
==================================================*/

/**
 * 
 * @param object	$post			Propriétés de l'article
 * @param array		$post_metas		Métadonnées de l'article
 * 
 * @return 			Affiche les données structurées de l'article
 * 
 */

function pc_display_schema_post( $post, $post_metas ) {

	global $settings_project, $images_project_sizes;
	$img_default = array( pc_get_img_default_url_to_share(), $images_project_sizes['share']['width'], $images_project_sizes['share']['height'] );

	// auteur
	$author_id = $post->post_author;
	$author_first_name = get_the_author_meta( 'first_name', $author_id );
	$author_last_name = get_the_author_meta( 'last_name', $author_id );
	
	// post
	$post_url = get_the_permalink($post_id);	
	$post_img = ( isset( $post_metas['thumbnail-img'] ) ) ? pc_get_img( $post_metas['thumbnail-img'][0], 'share', 'datas' ) : $img_default;

	// données structurées
	$schema_post = array(
		'@context' => 'http://schema.org',
		'@type' => 'Article',
		'url' => $post_url.'#main',
		'datePublished' => get_the_date( 'c', $post_id ),
		'dateModified' => get_the_modified_date( 'c', $post_id ),
		'headline' => get_the_title( $post_id ),
		'description' => pc_get_page_excerpt( $post->ID, $post_metas ),
		'mainEntityOfPage'	=> $post_url,
		'image' => array(
			'@type'		=>'ImageObject',
			'url' 		=> $post_img[0],
			'width' 	=> $post_img[1],
			'height' 	=> $post_img[2]
		),
		'author' => array(
			'@type' => 'Person',
			'name' => $author_first_name.' '.$author_last_name
		),
		'publisher' => pc_get_schema_publisher( $settings_project['coord-name'], $img_default ),
		'isPartOf' => array(
			'@type' => 'WebSite',
			'url' => get_site_url(),
			'name' => $settings_project['coord-name'],
			'description' => $settings_project['micro-desc'],
			'publisher'	=> pc_get_schema_publisher( $settings_project['coord-name'], $img_default )
		)
	);

	// filtre
	$schema_post = apply_filters( 'pc_filter_schema_post', $schema_post, $post, $post_metas );

	// affichage
	echo '<script type="application/ld+json">'.json_encode($schema_post,JSON_UNESCAPED_SLASHES).'</script>';

}


/*=====  FIN Page (article par défault)  =====*/