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
add_filter( 'excerpt_more', function() { return '&hellip;'; }, 999 );


/*=====  FIN Excerpt WP  =====*/


/*========================================
=            Excerpt Preform             =
========================================*/

function pc_get_post_resum_excerpt( $post_id, $post_metas ) {

	global $texts_lengths;

	$post_excerpt = ( isset( $post_metas['resum-desc'] ) ) ? $post_metas['resum-desc'][0] : get_the_excerpt( $post_id );
	
	return pc_words_limit( $post_excerpt, $texts_lengths['resum-desc'] ) ;

}


/*=====  FIN Excerpt Preform   =====*/

/*=============================
=            Image            =
=============================*/

/*----------  Fichiers  ----------*/

function pc_get_post_resum_img_urls( $post_id, $post_metas ) {

	$template_directory = get_bloginfo('template_directory');
	$post_img_urls = apply_filters( 'pc_filter_post_resum_img_default_datas', array(
		$template_directory.'/images/st-default-400.jpg',
		$template_directory.'/images/st-default-500.jpg',
		$template_directory.'/images/st-default-700.jpg'
	) );

	$img_post = ( isset($post_metas['visual-id']) ) ? get_post( $post_metas['visual-id'][0] ) : null;

	if ( is_object( $img_post ) ) {

		$post_img_urls = array(
			wp_get_attachment_image_src( $img_post->ID,'st-400' )[0],
			wp_get_attachment_image_src( $img_post->ID,'st-500' )[0],
			wp_get_attachment_image_src( $img_post->ID,'st-700' )[0]
		);	

	}

	apply_filters( 'pc_filter_post_resum_img_datas', $post_img_urls, $post_id, $post_metas );
	return $post_img_urls;

}


/*----------  HTML  ----------*/

function pc_display_post_resum_img_tag( $post_id, $post_img_urls ) {

	$post_img_tag_srcset = $post_img_urls[0].' 400w, '.$post_img_urls[1].' 500w, '.$post_img_urls[2].' 700w';
	$post_img_tag_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 700px, (min-width:760px) 500px';

	$post_img_tag = '<img src="'.$post_img_urls[2].'" alt="" srcset="'.$post_img_tag_srcset.'" sizes="'.$post_img_tag_sizes.'" loading="lazy" />';

	$post_img_tag = apply_filters( 'pc_filter_post_resum_img_tag', $post_img_tag, $post_id );
	echo $post_img_tag;

}


/*=====  FIN Image  =====*/

/*=================================
=            Affichage            =
=================================*/

function pc_display_post_resum( $post_id, $post_css = '', $post_title_level = 2 ) {

	// post métas
	$post_metas = get_post_meta($post_id);

	// titre
	$post_title = (isset($post_metas['resum-title'])) ? $post_metas['resum-title'][0] : get_the_title($post_id);
	// lien
	$post_link = get_the_permalink($post_id);
	$link_tag_start = '<a href="'.$post_link.'" class="st-link" title="Lire la suite de l\'article '.$post_title.'">';
	$post_link_position = apply_filters( 'pc_filter_post_resum_link_position', 'multiple' ); // multiple || global	
	// image datas
	$post_img_urls = pc_get_post_resum_img_urls( $post_id, $post_metas );
	// description
	$post_desc = pc_get_post_resum_excerpt( $post_id, $post_metas );	
	
	

	/*----------  Données structurées  ----------*/
	
	global $post_resum_schema, $images_project_sizes;

	$post_resum_schema = array(
		'@type' => 'ListItem',
		'name' => $post_title,
		'description' => $post_desc,
		'url' => $post_link,
		'image' => array(
			'@type'		=>'ImageObject',
			'url' 		=> $post_img_urls[2],
			'width' 	=> $images_project_sizes['st-700']['width'],
			'height' 	=> $images_project_sizes['st-700']['height']
		)
	);

	/*----------  Affichage  ----------*/
	
	echo '<li class="st '.$post_css.'"><article class="st-inner">';

		if ( 'global' == $post_link_position ) { echo $link_tag_start; }

			// filtre
			do_action( 'pc_post_resum_after_start', $post_id );
		
			echo '<div class="st-figure" aria-hidden="true">';
				pc_display_post_resum_img_tag( $post_id, $post_img_urls );				
			echo '</div>';

			echo '<h'.$post_title_level.' class="st-title">';
				if ( 'multiple' == $post_link_position ) {
					echo $link_tag_start.$post_title.'</a>';
				} else {
					echo $post_title;
				}
			echo '</h'.$post_title_level.'>';	

			// filtre	
			do_action( 'pc_post_resum_after_title', $post_id );
			
			if ( '' != $post_desc ) {
				echo '<p class="st-desc">';
					echo $post_desc;
					$post_ico_more = apply_filters( 'pc_filter_post_resum_ico_more', pc_svg('more-16') );
					$st_desc_ico_more_display = apply_filters( 'pc_st_desc_ico_more_display', true );
					if ( $st_desc_ico_more_display ) { echo ' <span class="st-desc-ico">'.$post_ico_more.'</span>';	}	
				echo '</p>';
			}
			
			$st_read_more_display = apply_filters( 'pc_st_read_more_display', false );
			if ( $st_read_more_display ) {
				echo '<div class="st-read-more" aria-hidden="true"><span class="st-read-more-ico">'.$post_ico_more.'</span> <span class="st-read-more-txt">Lire la suite</span></a></div>';
			}
		
			// filtre
			do_action( 'pc_post_resum_before_end', $post_id );

		if ( 'global' == $post_link_position ) { echo '</a>'; }
	
	echo '</article></li>';
	
};


/*=====  FIN Affichage  =====*/
