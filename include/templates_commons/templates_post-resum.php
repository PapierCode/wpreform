<?php
/**
 * 
 * Fonctions pour les templates : article résumé (st)
 * 
 ** Excerpt WP
 ** Excerpt Preform
 ** Affichage
 ** Fake version
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

	global $texts_lengths;

	if ( $seo_for && isset( $post_metas['seo-desc'] ) && $post_metas['seo-desc'][0] != '' ) {

		$post_excerpt = pc_words_limit( $post_metas['seo-desc'][0], $texts_lengths['resum-desc'] );

	} else if ( isset( $post_metas['resum-desc'] ) && $post_metas['resum-desc'][0] != '' ) {

		$post_excerpt = pc_words_limit( $post_metas['resum-desc'][0], $texts_lengths['resum-desc'] );

	} else {

		$post_excerpt = get_the_excerpt( $post_id ).'...';
		
	}
	
	return $post_excerpt;

}


/*=====  FIN Excerpt Preform   =====*/

/*=============================
=            Image            =
=============================*/

/*----------  Défaut  ----------*/

function pc_get_post_resum_img_default_datas() {

	$template_directory = get_bloginfo('template_directory');

	$post_img_datas = array(
		$template_directory.'/images/st-default-400.jpg',
		$template_directory.'/images/st-default-500.jpg',
		$template_directory.'/images/st-default-700.jpg'
	);

	$post_img_datas = apply_filters( 'pc_filter_post_resum_img_default_datas', $post_img_datas );
	return $post_img_datas;

}


/*----------  Données brutes  ----------*/

function pc_get_post_resum_img_datas( $post_id, $post_metas ) {

	$img_post = ( isset($post_metas['visual-id']) ) ? get_post( $post_metas['visual-id'][0] ) : null;
	$post_img_datas = array();

	if ( is_object( $img_post ) ) {

		$post_img_datas['urls'] = array(
			wp_get_attachment_image_src( $img_post->ID,'st-400' )[0],
			wp_get_attachment_image_src( $img_post->ID,'st-500' )[0],
			wp_get_attachment_image_src( $img_post->ID,'st-700' )[0]
		);
		$post_img_datas['alt'] = get_post_meta( $img_post->ID, '_wp_attachment_image_alt', true );	

	} else {

		$post_img_datas['urls'] = pc_get_post_resum_img_default_datas();
		$post_img_datas['alt'] = '';

	}

	apply_filters( 'pc_filter_post_resum_img_datas', $post_img_datas, $post_id, $post_metas );
	return $post_img_datas;

}


/*----------  HTML  ----------*/

function pc_display_post_resum_img_tag( $post_id, $post_img_datas ) {

	$post_img_tag_srcset = $post_img_datas['urls'][0].' 400w, '.$post_img_datas['urls'][1].' 500w, '.$post_img_datas['urls'][2].' 700w';
	$post_img_tag_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 700px, (min-width:760px) 500px';

	$post_img_tag = '<img src="'.$post_img_datas['urls'][2].'" alt="'.$post_img_datas['alt'].'" srcset="'.$post_img_tag_srcset.'" sizes="'.$post_img_tag_sizes.'" loading="lazy" />';

	$post_img_tag = apply_filters( 'pc_filter_post_resum_img_tag', $post_img_tag, $post_id );
	echo $post_img_tag;

}


/*=====  FIN Image  =====*/

/*=================================
=            Affichage            =
=================================*/

function pc_get_post_resum_link_tag_start( $class, $href, $title ) {

	return '<a href="'.$href.'" class="'.$class.'" title="Lire la suite de l\'article '.$title.'">';

}

function pc_display_post_resum( $post_id, $post_css = '', $post_title_level = 2 ) {

	// post métas
	$post_metas = get_post_meta($post_id);

	// titre
	$post_title = (isset($post_metas['resum-title'])) ? $post_metas['resum-title'][0] : get_the_title($post_id);
	// lien
	$post_link = get_the_permalink($post_id);
	$post_link_position = apply_filters( 'pc_filter_post_resum_link_postion', 'multiple' ); // multiple || global	
	// image datas
	$post_img_datas = pc_get_post_resum_img_datas( $post_id, $post_metas );
	// description
	$post_desc = pc_get_page_excerpt( $post_id, $post_metas );
	// icône +	
	$post_ico_more = apply_filters( 'pc_filter_post_resum_ico_more', pc_svg('more-16') );
	

	/*----------  Données structurées  ----------*/
	
	global $post_resum_schema, $images_project_sizes;

	$post_resum_schema = array(
		'@type' => 'ListItem',
		'name' => $post_title,
		'description' => $post_desc,
		'url' => $post_link,
		'image' => array(
			'@type'		=>'ImageObject',
			'url' 		=> $post_img_datas['urls'][2],
			'width' 	=> $images_project_sizes['st-700']['width'],
			'height' 	=> $images_project_sizes['st-700']['height']
		)
	);

	/*----------  Affichage  ----------*/
	
	echo '<article class="st '.$post_css.'"><div class="st-inner">';

		if ( 'global' == $post_link_position ) { echo pc_get_post_resum_link_tag_start( 'st-link', $post_link, $post_title ); }

			// filtre
			do_action( 'pc_action_post_resum_after_start', $post_id );
		
			echo '<figure class="st-figure">';
				pc_display_post_resum_img_tag( $post_id, $post_img_datas );				
			echo '</figure>';

			echo '<h'.$post_title_level.' class="st-title">';
				if ( 'multiple' == $post_link_position ) {
					echo pc_get_post_resum_link_tag_start( 'st-title-link', $post_link, $post_title ).$post_title.'</a>';
				} else {
					echo $post_title;
				}
			echo '</h'.$post_title_level.'>';	

			// filtre	
			do_action( 'pc_action_post_resum_after_title', $post_id );
			
			echo '<p class="st-desc">'.$post_desc.' ';
				if ( 'global' == $post_link_position ) { echo '<span class="st-desc-ico">'.$post_ico_more.'</span>';	}	
			echo '</p>';
			
			if ( 'multiple' == $post_link_position ) {
				echo pc_get_post_resum_link_tag_start( 'st-read-more button', $post_link, $post_title ).'<span class="st-read-more-ico">'.$post_ico_more.'</span> <span class="st-read-more-txt">Lire la suite</span><span class="visually-hidden"> de l\'article '.$post_title.'</span></a>';
			} else {
				echo '<span class="st-ico">'.$post_ico_more.'</span>';
			}
		
			// filtre
			do_action( 'pc_action_post_resum_before_end', $post_id );

		if ( 'global' == $post_link_position ) { echo '</a>'; }
	
	echo '</div></article>';
	
};


/*=====  FIN Affichage  =====*/
