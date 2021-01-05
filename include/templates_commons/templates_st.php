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

add_filter( 'excerpt_length', function() use ( $texts_lengths ) { return $texts_lengths['excerpt']; }, 999 );
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

/*==============================
=            Visuel            =
==============================*/

function pc_get_post_resum_visual_datas( $post_id, $post_metas ) {

	$img_post = ( isset($post_metas['visual-id']) ) ? get_post( $post_metas['visual-id'][0] ) : null;
	$img_datas = array();

	if ( is_object( $img_post ) ) {

		$img_datas['urls'] = array(
			wp_get_attachment_image_src( $img_post->ID,'st-400' )[0],
			wp_get_attachment_image_src( $img_post->ID,'st-500' )[0],
			wp_get_attachment_image_src( $img_post->ID,'st-700' )[0]
		);
		$img_datas['alt'] = get_post_meta( $img_post->ID, '_wp_attachment_image_alt', true );	

	} else {

		$dir = get_bloginfo('template_directory');
		$img_datas['urls'] = array(
			$dir.'/images/st-default-400.jpg',
			$dir.'/images/st-default-500.jpg',
			$dir.'/images/st-default-700.jpg'
		);
		$img_datas['alt'] = '';

	}

	apply_filters( 'pc_filter_post_resum_img_datas', $img_datas, $post_id );
	return $img_datas;

}

function pc_display_post_resum_img( $post_id, $img_datas ) {

	$img_tag_srcset = $img_datas['urls'][0].' 400w, '.$img_datas['urls'][1].' 500w, '.$img_datas['urls'][2].' 700w';
	$img_tag_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 700px, (min-width:760px) 500px';

	$img_tag = '<img src="'.$img_datas['urls'][2].'" alt="'.$img_datas['alt'].'" srcset="'.$img_tag_srcset.'" sizes="'.$img_tag_sizes.'" loading="lazy" />';

	$img_tag = apply_filters( 'pc_filter_post_resum_img_tag', $img_tag, $post_id );
	echo $img_tag;

}


/*=====  FIN Visuel  =====*/

/*=================================
=            Affichage            =
=================================*/

function pc_display_post_resum( $post_id, $css = '', $hn = 2 ) {

	// métas
    $post_metas = get_post_meta($post_id);

	// titre
	$title = (isset($post_metas['resum-title'])) ? $post_metas['resum-title'][0] : get_the_title($post_id);
	// lien
	$url = get_the_permalink($post_id);
	// visuel
	$img_datas = pc_get_post_resum_visual_datas( $post_id, $post_metas );
	// icône +	
	$ico_more = apply_filters( 'pc_filter_post_resum_ico_more', pc_svg('more-16') );
	// description
	$desc = pc_get_page_excerpt( $post_id, $post_metas );
	

	/*----------  Données structurées  ----------*/
	
	global $post_resum_schema, $images_project_sizes;

	$post_resum_schema = array(
		'@type' => 'ListItem',
		'name' => $title,
		'description' => $desc,
		'url' => $url,
		'image' => array(
			'@type'		=>'ImageObject',
			'url' 		=> $img_datas['urls'][2],
			'width' 	=> $images_project_sizes['st-700']['width'],
			'height' 	=> $images_project_sizes['st-700']['height']
		)
	);


	/*----------  Affichage  ----------*/
	
	echo '<article class="st '.$css.'"><div class="st-inner">';

		// filtre
		do_action( 'pc_action_post_resum_after_start', $post_id );
	
		echo '<figure class="st-figure">';
			pc_display_post_resum_img( $post_id, $img_datas );
		echo '</figure>';

		echo '<h'.$hn.' class="st-title"><a href="'.$url.'">'.$title.'</a></h'.$hn.'>';	

		// filtre	
		do_action( 'pc_action_post_resum_after_title', $post_id );
		
		echo '<p class="st-desc">'.$desc.'... <span>'.$ico_more.'</span></p>';
	
		// filtre
		do_action( 'pc_action_post_resum_before_end', $post_id );
	
	echo '</div></article>';
	
};


/*=====  FIN Affichage  =====*/
