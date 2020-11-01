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

	// container
    echo '<article class="st '.$css.'"><div class="st-inner">';
    
	do_action( 'pc_action_post_resum_after_start', $post_id );
	

	/*----------  Visuel  ----------*/
	
	echo '<figure class="st-figure">';
	
		if ( isset($post_metas['thumbnail-img']) ) {
			$st_img_urls = array(
				wp_get_attachment_image_src($post_metas['thumbnail-img'][0],'st-400')[0],
				wp_get_attachment_image_src($post_metas['thumbnail-img'][0],'st-500')[0],
				wp_get_attachment_image_src($post_metas['thumbnail-img'][0],'st-700')[0]
			);
			$st_img_alt	= get_post_meta($post_metas['thumbnail-img'][0], '_wp_attachment_image_alt', true);			
		} else {
			$st_img_urls = array(
				get_bloginfo('template_directory').'/images/st-default-400.jpg',
				get_bloginfo('template_directory').'/images/st-default-500.jpg',
				get_bloginfo('template_directory').'/images/st-default-700.jpg'
			);
			$st_img_urls = apply_filters( 'pc_filter_img_default_st', $st_img_urls );
			$st_img_alt	= '';
		}

		$st_img_srcset = $st_img_urls[0].' 400w, '.$st_img_urls[1].' 500w, '.$st_img_urls[2].' 700w';
		$st_img_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 700px, (min-width:760px) 500px';

		$st_img = '<img src="'.$st_img_urls[2].'" alt="'.$st_img_alt.'" srcset="'.$st_img_srcset.'" sizes="'.$st_img_sizes.'" loading="lazy" />';
		$st_img = apply_filters( 'pc_filter_st_img', $st_img, $post_id );
		echo $st_img;

	echo '</figure>';
	

    /*----------  Titre  ----------*/

	echo '<h'.$hn.' class="st-title"><a href="'.$url.'">'.$title.'</a></h'.$hn.'>';
	
	do_action( 'pc_action_post_resum_after_title', $post_id );
	

	/*----------  Description + lire la suite  ----------*/
	
	$ico_more = pc_svg('more-16');
	$ico_more = apply_filters( 'pc_filter_post_resum_ico_more', $ico_more );
	
	$resum = pc_get_page_excerpt( $post_id, $post_metas );
	echo '<p class="st-desc">'.$resum.'... <span>'.$ico_more.'</span></p>';
	
    do_action( 'pc_action_post_resum_before_end', $post_id );
	

	/*----------  Données structurées  ----------*/
	
	global $st_schema, $images_project_sizes;
	$st_schema = array(
		'@type' => 'ListItem',
		'name' => $title,
		'description' => $resum,
		'url' => $url,
		'image' => array(
			'@type'		=>'ImageObject',
			'url' 		=> $st_img_urls[2],
			'width' 	=> $images_project_sizes['st-700']['width'],
			'height' 	=> $images_project_sizes['st-700']['height']
		)
	);

	// container
	echo '</div></article>';
	
	
};


/*=====  FIN Affichage  =====*/
