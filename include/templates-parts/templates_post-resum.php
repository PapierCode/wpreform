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

function pc_get_post_resum_img_datas( $post_id, $post_title, $post_metas ) {

	$template_directory = get_bloginfo('template_directory');
	$img_datas = apply_filters( 'pc_filter_post_resum_img_default_datas', array( 
		'urls' => array(
			$template_directory.'/images/st-default-400.jpg',
			$template_directory.'/images/st-default-500.jpg',
			$template_directory.'/images/st-default-700.jpg'
		)
	) );

	$img_post = ( isset($post_metas['visual-id']) ) ? get_post( $post_metas['visual-id'][0] ) : null;
	if ( is_object( $img_post ) ) {

		$img_datas = array(
			'urls' => array(
				wp_get_attachment_image_src( $img_post->ID,'st-400' )[0],
				wp_get_attachment_image_src( $img_post->ID,'st-500' )[0],
				wp_get_attachment_image_src( $img_post->ID,'st-700' )[0]
			)
		);	

	}

	$img_datas['alt'] = $post_title;
	if ( isset($post_metas['visual-id']) ) {
		$img_alt = get_post_meta( $post_metas['visual-id'][0], '_wp_attachment_image_alt', true );
		if ( '' != $img_alt ) { $img_datas['alt'] = $img_alt; }
	}

	apply_filters( 'pc_filter_post_resum_img_datas', $img_datas, $post_id, );
	return $img_datas;

}


/*----------  HTML  ----------*/

function pc_display_post_resum_img_tag( $img_datas, $post_id ) {

	global $images_project_sizes;

	$post_img_tag_srcset = $img_datas['urls'][0].' 400w, '.$img_datas['urls'][1].' 500w, '.$img_datas['urls'][2].' 700w';
	$post_img_tag_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 700px, (min-width:760px) 500px';

	$post_img_tag = '<img src="'.$img_datas['urls'][1].'" alt="'.$img_datas['alt'].'" srcset="'.$post_img_tag_srcset.'" sizes="'.$post_img_tag_sizes.'" loading="lazy" width="'.$images_project_sizes['st-500']['width'].'" height="'.$images_project_sizes['st-500']['height'].'" />';

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
	$post_link_tag_start = '<a href="'.$post_link.'" class="st-link" title="Lire la suite de l\'article '.$post_title.'">';
	$post_link_position = apply_filters( 'pc_filter_post_resum_link_position', 'multiple' ); // multiple || global	
	// image datas
	$img_datas = pc_get_post_resum_img_datas( $post_id, $post_title, $post_metas );
	// description
	$post_desc = pc_get_post_resum_excerpt( $post_id, $post_metas );
	// icône
	$st_ico_more = apply_filters( 'pc_filter_st_ico_more', pc_svg('more') );	
	
	

	/*----------  Données structurées  ----------*/
	
	global $post_resum_schema, $images_project_sizes;

	$post_resum_schema = array(
		'@type' => 'ListItem',
		'name' => $post_title,
		'description' => $post_desc,
		'url' => $post_link,
		'image' => array(
			'@type'		=>'ImageObject',
			'url' 		=> $img_datas['urls'][2],
			'width' 	=> $images_project_sizes['st-700']['width'],
			'height' 	=> $images_project_sizes['st-700']['height']
		)
	);

	/*----------  Affichage  ----------*/
	
	echo '<li class="st '.$post_css.'"><article class="st-inner">';

		if ( 'global' == $post_link_position ) { echo $post_link_tag_start; }

			// hook
			do_action( 'pc_post_resum_after_start', $post_id );
		
			echo '<figure class="st-figure">';
				pc_display_post_resum_img_tag( $img_datas, $post_id );				
			echo '</figure>';

			echo '<h'.$post_title_level.' class="st-title">';
				if ( 'multiple' == $post_link_position ) {
					echo $post_link_tag_start.$post_title.'</a>';
				} else {
					echo $post_title;
				}
			echo '</h'.$post_title_level.'>';	

			// hook	
			do_action( 'pc_post_resum_after_title', $post_id );
			
			if ( '' != $post_desc ) {
				echo '<p class="st-desc">';
					echo $post_desc;
					$st_desc_ico_display = apply_filters( 'pc_filter_st_desc_ico_display', true );
					if ( $st_desc_ico_display ) { echo ' <span class="st-desc-ico">'.$st_ico_more.'</span>';	}	
				echo '</p>';
			}
			
			$st_read_more_display = apply_filters( 'pc_filter_st_read_more_display', false );
			if ( $st_read_more_display ) {
				echo '<div class="st-read-more" aria-hidden="true"><span class="st-read-more-ico">'.$st_ico_more.'</span> <span class="st-read-more-txt">Lire la suite</span></a></div>';
			}
		
			// hook
			do_action( 'pc_post_resum_before_end', $post_id );

		if ( 'global' == $post_link_position ) { echo '</a>'; }
	
	echo '</article></li>';
	
};


/*=====  FIN Affichage  =====*/
