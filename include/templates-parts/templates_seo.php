<?php
/**
 * 
 */

/*============================
=            Post            =
============================*/

function pc_get_post_seo_title( $post, $post_metas ) {

	if ( isset( $post_metas['seo-title'] ) ) {
		
		$post_seo_title = $post_metas['seo-title'][0];

	} else {

		$post_seo_title = pc_get_post_resum_title( $post->ID, $post_metas );

	}
	
	return $post_seo_title;

}

function pc_get_post_seo_description( $post, $post_metas ) {

	if ( isset( $post_metas['seo-desc'] ) ) {

		$post_seo_description = $post_metas['seo-desc'][0];

	} else {

		$post_seo_description = pc_get_post_resum_description( $post->ID, $post_metas );

	}
	
	global $texts_lengths;
	return pc_words_limit( $post_seo_description, $texts_lengths['seo-desc'] );

}

function pc_get_post_seo_metas( $seo_metas, $post, $post_metas ) {

	// title
	$post_seo_title = pc_get_post_seo_title( $post, $post_metas );
	if ( '(sans titre)' != $post_seo_title ) {
		$seo_metas['title'] = $post_seo_title;
	}

	// description
	$post_seo_description = pc_get_post_seo_description( $post, $post_metas );
	if ( '' != $post_seo_description ) {
		$seo_metas['description'] = $post_seo_description;
	}

	// visuel
	if ( isset( $post_metas['visual-id'] ) && is_object( get_post( $post_metas['visual-id'][0] ) ) ) {
		$seo_metas['img'] = wp_get_attachment_image_src($post_metas['visual-id'][0],'share')[0];
	}

	return $seo_metas;

}


/*=====  FIN Post  =====*/

/*================================
=            Taxonomy            =
================================*/

function pc_get_tax_seo_title( $term, $term_metas ) {

	// titre
	if ( isset( $term_metas['seo-title'] ) ) {
		
		$term_seo_title = $term_metas['seo-title'][0];

	} else if ( isset( $term_metas['resum-title'] ) ) {

		$term_seo_title = $term_metas['resum-title'][0];

	} else {

		$term_seo_title = $term->name;

	}
	
	return $term_seo_title;

}

function pc_get_tax_seo_description( $term, $term_metas ) {

	if ( isset( $term_metas['seo-desc'] ) ) {

		$term_seo_description = $term_metas['seo-desc'][0];

	} else if ( isset( $term_metas['resum-desc'] ) ) {

		$term_seo_description = $term_metas['resum-desc'][0];

	} else if ( isset( $term_metas['content-desc'] ) ) {

		$term_seo_description = wp_strip_all_tags( $term_metas['content-desc'][0] );
		
	} else {

		$term_seo_description = '';
		
	}
	
	global $texts_lengths;
	return pc_words_limit( $term_seo_description, $texts_lengths['seo-desc'] );

}

function pc_get_tax_seo_metas( $seo_metas, $term, $term_metas ) {

	// title
	$seo_metas['title'] = pc_get_tax_seo_title( $term, $term_metas );

	// description
	$seo_description = pc_get_tax_seo_description( $term, $term_metas );
	if ( '' != $seo_description ) {
		$seo_metas['description'] = $seo_description;
	}

	// visuel
	if ( isset( $term_metas['visual-id'] ) && is_object( get_post( $term_metas['visual-id'][0] ) ) ) {
		$seo_metas['img'] = wp_get_attachment_image_src($term_metas['visual-id'][0],'share')[0];
	}

	return $seo_metas;

}


/*=====  FIN Taxonomy : title & description  =====*/