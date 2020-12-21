<?php
/**
 * 
 * Fonctions pour les templates : article résumé (st)
 * 
 ** Excerpt WP
 ** Excerpt Preform
 ** Affichage
 * 
 */

/*==================================
=            Excerpt WP            =
==================================*/

add_filter( 'excerpt_length', function() { return 20; }, 999 );
add_filter( 'excerpt_more', function() { return ''; }, 999 );


/*=====  FIN Excerpt WP  =====*/


/*========================================
=            Excerpt Preform             =
========================================*/

function pc_get_page_excerpt( $post_id, $post_metas, $seo_for = false ) {

	if ( $seo_for && isset( $post_metas['seo-desc'] ) && $post_metas['seo-desc'][0] != '' ) {

		$excerpt = $post_metas['seo-desc'][0];

	} else if ( isset( $post_metas['resum-desc'] ) && $post_metas['resum-desc'][0] != '' ) {

		$excerpt = $post_metas['resum-desc'][0];

	} else {

		$excerpt = get_the_excerpt( $post_id );
	}
	
	return $excerpt;

}


/*=====  FIN Excerpt Preform   =====*/

/*=================================
=            Affichage            =
=================================*/

function pc_display_post_resum( $post_id, $css = '', $hn = 2 ) {

    $post_metas = get_post_meta($post_id);
	$title = (isset($post_metas['resum-title'])) ? $post_metas['resum-title'][0] : get_the_title($post_id);
	$url = get_the_permalink($post_id);


	/*----------  Visuel  ----------*/

	$img_post = get_post( $post_metas['visual-id'][0] );

	if ( isset($post_metas['visual-id']) && is_object( $img_post ) ) {

		$img_urls = array(
			wp_get_attachment_image_src( $post_metas['visual-id'][0],'st-400' )[0],
			wp_get_attachment_image_src( $post_metas['visual-id'][0],'st-500' )[0],
			wp_get_attachment_image_src( $post_metas['visual-id'][0],'st-700' )[0]
		);
		$img_alt = get_post_meta($post_metas['visual-id'][0], '_wp_attachment_image_alt', true);	

	} else {

		$img_urls = array(
			get_bloginfo('template_directory').'/images/st-default-400.jpg',
			get_bloginfo('template_directory').'/images/st-default-500.jpg',
			get_bloginfo('template_directory').'/images/st-default-700.jpg'
		);
		$img_alt = '';

	}

	$img_urls = apply_filters( 'pc_filter_post_resum_img_urls', $img_urls );
	$img_tag_srcset = $img_urls[0].' 400w, '.$img_urls[1].' 500w, '.$img_urls[2].' 700w';
	$img_tag_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 700px, (min-width:760px) 500px';

	$img_tag = '<img src="'.$img_urls[2].'" alt="'.$img_alt.'" srcset="'.$img_tag_srcset.'" sizes="'.$img_tag_sizes.'" loading="lazy" />';
	$img_tag = apply_filters( 'pc_filter_post_resum_img_tag', $img_tag );

		
	/*----------  Description  ----------*/
	
	$ico_more = pc_svg('more-16');
	$ico_more = apply_filters( 'pc_filter_post_resum_ico_more', $ico_more );
	
	$resum = pc_get_page_excerpt( $post_id, $post_metas );
	

	/*----------  Données structurées  ----------*/
	
	global $post_resum_schema, $images_project_sizes;
	$st_schema = array(
		'@type' => 'ListItem',
		'name' => $title,
		'description' => $resum,
		'url' => $url,
		'image' => array(
			'@type'		=>'ImageObject',
			'url' 		=> $img_urls[2],
			'width' 	=> $images_project_sizes['st-700']['width'],
			'height' 	=> $images_project_sizes['st-700']['height']
		)
	);


	/*----------  Affichage  ----------*/
	
	echo '<article class="st '.$css.'"><div class="st-inner">';

		// filtre
		do_action( 'pc_action_post_resum_after_start', $post_id );
	
		echo '<figure class="st-figure">'.$img_tag.'</figure>';

		echo '<h'.$hn.' class="st-title"><a href="'.$url.'">'.$title.'</a></h'.$hn.'>';	

		// filtre	
		do_action( 'pc_action_post_resum_after_title', $post_id );
		
		echo '<p class="st-desc">'.$resum.'... <span>'.$ico_more.'</span></p>';
	
		// filtre
		do_action( 'pc_action_post_resum_before_end', $post_id );
	
	echo '</div></article>';
	
};


/*=====  FIN Affichage  =====*/
