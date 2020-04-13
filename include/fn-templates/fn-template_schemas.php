<?php
/**
 * 
 * Fonctions données structurée (schema.org)
 * 
 */

/*===================================
=            Client type            =
===================================*/

function pc_get_schema_client_type() {

	$type = 'Organization';
	$type = apply_filters( 'pc_filter_schema_client_type', $type );
	return $type;

}


/*=====  FIN Client type  =====*/


/*==============================
=            Author            =
==============================*/

function pc_get_schema_author( $author_id ) {
	
	$author_first_name = get_the_author_meta( 'first_name', $author_id );
	$author_last_name = get_the_author_meta( 'last_name', $author_id );

	return array(
		'@type' => 'Person',
		'name' => $author_first_name.' '.$author_last_name
	);

}


/*=====  FIN Author  =====*/

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

function pc_get_schema_publisher() {

	global $settings_project;
	$img = pc_get_img_default_to_share();

	$schema_publisher = array(
		'@type' => pc_get_schema_client_type(),
		'name' => $settings_project['coord-name'],
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
=            Website            =
===============================*/

/**
 * 
 * @return array Données structurées Website
 * 
 */

function pc_get_schema_website( ) {

	global $settings_project;

	return array(
		'@type' => 'WebSite',
		'url' => get_site_url(),
		'name' => $settings_project['coord-name'],
		'description' => $settings_project['micro-desc'],
		'publisher'	=> pc_get_schema_publisher()
	);

}


/*=====  FIN Website  =====*/

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

		global $settings_project;
		$img = pc_get_img_default_to_share();

		// données structurées
		$type = pc_get_schema_client_type();
		$local_business = array(
			'@context' => 'http://schema.org',
			'@type' => $type,
			'@id' => get_site_url(),
			'url' => get_site_url(),
			'address' => array(
				'@type' => 'PostalAddress',
				'streetAddress' => $settings_project['coord-address'],
				'postalCode' => $settings_project['coord-postal-code'],
				'addressLocality' => $settings_project['coord-city'],
				'addressRegion' => 'FR'
			),
			'description' => $settings_project['micro-desc'],
			'name' => $settings_project['coord-name'],
			'image' => array(
				'@type' => 'ImageObject',
				'url' => $img['0'],
				"width" => $img['1'],
				"height" => $img['2']
			),
			'telephone' => pc_phone($settings_project['coord-phone-1'])			
		);

		// price range & geo
		if ( $type == 'LocalBusiness' ) {
			$local_business['pricerange'] = '€€';
			$local_business['geo'] = array(
				'@type' => 'GeoCoordinates',
				'latitude' => $settings_project['coord-lat'],
				'longitude' => $settings_project['coord-long']
			);
		}
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

/*===============================
=            Article            =
===============================*/

/**
 * 
 * @param object	$post			Propriétés de l'article
 * @param array		$post_metas		Métadonnées de l'article
 * 
 * @return 			Affiche les données structurées de l'article
 * 
 */

function pc_display_schema_post( $post, $post_metas ) {

	global $settings_project;
	
	// post
	$post_id = $post->ID;
	$post_url = get_the_permalink($post_id);	
	$post_img = ( isset( $post_metas['thumbnail-img'] ) ) ? pc_get_img( $post_metas['thumbnail-img'][0], 'share', 'datas' ) : pc_get_img_default_to_share();

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
		'author' => pc_get_schema_author( $post->post_author ),
		'publisher' => pc_get_schema_publisher(),
		'isPartOf' => pc_get_schema_website()
	);

	// filtre
	$schema_post = apply_filters( 'pc_filter_schema_post', $schema_post, $post, $post_metas );

	// affichage
	if ( !empty( $schema_post ) ) {
		echo '<script type="application/ld+json">'.json_encode($schema_post,JSON_UNESCAPED_SLASHES).'</script>';
	}

}


/*=====  FIN Article  =====*/