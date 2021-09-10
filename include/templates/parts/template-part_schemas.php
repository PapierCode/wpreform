<?php
/**
 * 
 * Communs templates : données structurée (schema.org)
 * 
 */

/*===================================
=            Client type            =
===================================*/

function pc_get_schema_client_type() {

	$type = apply_filters( 'pc_filter_schema_client_type', 'Organization' );

	return $type;

}


/*=====  FIN Client type  =====*/

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

	$same_as = apply_filters( 'pc_filter_schema_same_as', $same_as );

	return $same_as;

}


/*=====  FIN Same As  =====*/

/*=================================
=            Publisher            =
=================================*/

/**
 *  
 * @return array Données de la propriété Publisher
 * 
 */

function pc_get_schema_publisher() {

	global $settings_project;
	$img = pc_get_default_image_to_share();

	$publisher = array(
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
	if ( !empty( $same_as ) ) { $publisher['sameAs'] = $same_as; };

	$publisher = apply_filters( 'pc_filter_schema_publisher', $publisher );

	return $publisher;

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

	$website = array(
		'@type' => 'WebSite',
		'url' => get_site_url(),
		'name' => $settings_project['coord-name'],
		'description' => $settings_project['seo-desc'],
		'publisher'	=> pc_get_schema_publisher()
	);
	$website = apply_filters( 'pc_filter_schema_website', $website );

	return $website;

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
		$img = pc_get_default_image_to_share();

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
			'description' => $settings_project['seo-desc'],
			'name' => $settings_project['coord-name'],
			'image' => array(
				'@type' => 'ImageObject',
				'url' => $img['0'],
				"width" => $img['1'],
				"height" => $img['2']
			)		
		);

		if ( isset( $settings_project['coord-phone-1'] ) && '' != $settings_project['coord-phone-1'] ) {
			$local_business['telephone'] = pc_phone($settings_project['coord-phone-1']);
		}

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