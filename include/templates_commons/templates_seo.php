<?php
/**
 * 
 */

/*==================================================
=            Post : title & description            =
==================================================*/

function pc_get_post_seo_title( $post_id, $post_metas ) {

	// titre
	if ( isset( $post_metas['seo-title'] ) ) {
		
		$post_seo_title = $post_metas['seo-title'][0];

	} else if ( isset( $post_metas['resum-title'] ) ) {

		$post_seo_title = $post_metas['resum-title'][0];

	} else {

		$post_seo_title = get_the_title($post_id);

	}
	
	return $post_seo_title;

}

function pc_get_post_seo_description( $post_id, $post_metas ) {

	global $texts_lengths;
	$post_seo_description = false;

	if ( isset( $post_metas['seo-desc'] ) ) {

		$post_seo_description = pc_words_limit( $post_metas['seo-desc'][0], $texts_lengths['seo-desc'] );

	} else if ( isset( $post_metas['resum-desc'] ) ) {

		$post_seo_description = pc_words_limit( $post_metas['resum-desc'][0], $texts_lengths['seo-desc'] );

	} else {

		$post_seo_description = get_the_excerpt( $post_id ).'...';
		
	}
	
	return $post_seo_description;

}


/*=====  FIN Post : title & description  =====*/

/*======================================================
=            Taxonomy : title & description            =
======================================================*/

function pc_get_tax_seo_title( $tax_id, $tax_name, $tax_metas ) {

	// titre
	if ( isset( $tax_metas['seo-title'] ) ) {
		
		$tax_seo_title = $tax_metas['seo-title'][0];

	} else if ( isset( $tax_metas['resum-title'] ) ) {

		$tax_seo_title = $tax_metas['resum-title'][0];

	} else {

		$tax_seo_title = $tax_name;

	}
	
	return $tax_seo_title;

}

function pc_get_tax_seo_description( $tax_id, $tax_metas ) {

	global $texts_lengths;
	$tax_seo_description = false;

	if ( isset( $tax_metas['seo-desc'] ) ) {

		$tax_seo_description = pc_words_limit( $tax_metas['seo-desc'][0], $texts_lengths['seo-desc'] );

	} else if ( isset( $tax_metas['resum-desc'] ) ) {

		$tax_seo_description = pc_words_limit( $tax_metas['resum-desc'][0], $texts_lengths['seo-desc'] );

	} else if ( isset( $tax_metas['content-desc'] ) ) {

		$tax_seo_description = pc_words_limit( $tax_metas['content-desc'][0], $texts_lengths['seo-desc'] );
		
	}
	
	return $tax_seo_description;

}


/*=====  FIN Taxonomy : title & description  =====*/

/*=================================
=            Métas SEO            =
=================================*/

/*----------  Post  ----------*/

function pc_get_post_seo_metas( $seo_metas, $post_id, $post_metas ) {

	// title
	$seo_metas['title'] = pc_get_post_seo_title( $post_id, $post_metas );

	// description
	$seo_description = pc_get_post_seo_description( $post_id, $post_metas );
	if ( $seo_description ) {
		$seo_metas['description'] = $seo_description;
	}

	// visuel
	if ( isset( $post_metas['visual-id'] ) && is_object( get_post( $post_metas['visual-id'][0] ) ) ) {
		$seo_metas['img'] = wp_get_attachment_image_src($post_metas['visual-id'][0],'share')[0];
	}

	return $seo_metas;

}

/*----------  Taxonomy  ----------*/

function pc_get_tax_seo_metas( $seo_metas, $tax_id, $tax_name, $tax_metas ) {

	// title
	$seo_metas['title'] = pc_get_tax_seo_title( $tax_id, $tax_name, $tax_metas );

	// description
	$seo_description = pc_get_tax_seo_description( $tax_id, $tax_metas );
	if ( $seo_description ) {
		$seo_metas['description'] = $seo_description;
	}

	// visuel
	if ( isset( $tax_metas['visual-id'] ) && is_object( get_post( $tax_metas['visual-id'][0] ) ) ) {
		$seo_metas['img'] = wp_get_attachment_image_src($tax_metas['visual-id'][0],'share')[0];
	}

	return $seo_metas;

}


/*=====  FIN Métas SEO  =====*/