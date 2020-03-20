<?php
/**
 * 
 * Fonctions pour les templates : article résumé (st)
 * 
 ** Description auto (excerpt)
 ** Affichage
 ** Fake version
 * 
 */

/*========================================
=            Description auto            =
========================================*/

add_filter( 'excerpt_length', function() { return 20; }, 999 );
add_filter( 'excerpt_more', function() { return ''; }, 999 );


/*=====  FIN Description auto  =====*/

/*=================================
=            Affichage            =
=================================*/

function pc_display_post_resum( $post_id, $css = '', $hn = 2 ) {

    $metas = get_post_meta($post_id);
	$title = (isset($metas['resum-title'])) ? $metas['resum-title'][0] : get_the_title($post_id);

    echo '<article class="st fs-bloc '.$css.'"><div class="st-inner">';
    
	do_action( 'pc_action_post_resum_after_start', $post_id );
	

	/*----------  Visuel  ----------*/
	
	echo '<figure class="st-figure">';
	
		if ( isset($metas['thumbnail-img']) ) {
			$st_img_urls = array(
				wp_get_attachment_image_src($metas['thumbnail-img'][0],'st-400')[0],
				wp_get_attachment_image_src($metas['thumbnail-img'][0],'st-500')[0],
				wp_get_attachment_image_src($metas['thumbnail-img'][0],'st-700')[0]
			);
			$st_img_alt	= get_post_meta($metas['thumbnail-img'][0], '_wp_attachment_image_alt', true);			
		} else {
			$st_img_urls = array(
				get_bloginfo('template_directory').'/images/st-default-400.jpg',
				get_bloginfo('template_directory').'/images/st-default-500.jpg',
				get_bloginfo('template_directory').'/images/st-default-700.jpg'
			);
			$st_img_urls = apply_filters( 'pc_filter_st_img_default_urls', $st_img_urls );
			$st_img_alt	= '';
		}

		$st_img_srcset = $st_img_urls[0].' 400w, '.$st_img_urls[1].' 500w, '.$st_img_urls[2].' 700w';
		$st_img_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 700px, (min-width:761px) 500px';

		$st_img = '<img src="'.$st_img_urls[2].'" alt="'.$st_img_alt.'" srcset="'.$st_img_srcset.'" sizes="'.$st_img_sizes.'" />';
		$st_img = apply_filters( 'pc_filter_st_img', $st_img, $post_id );
		echo $st_img;

	echo '</figure>';
	

    /*----------  Titre  ----------*/

    echo '<h'.$hn.' class="st-title"><a href="'.get_the_permalink($post_id).'">'.$title.'</a></h'.$hn.'>';
	
	do_action( 'pc_action_post_resum_after_title', $post_id );
	

	/*----------  Description + lire la suite  ----------*/
	
	$ico_more = pc_svg('more-16',false,'svg-block');
	$ico_more = apply_filters( 'pc_filter_post_resum_ico_more', $ico_more );
    
    $resum = (isset($metas['resum-desc'])) ? wp_trim_words($metas['resum-desc'][0],20,'') : get_the_excerpt($post_id) ;
	echo '<p class="st-desc">'.$resum.'... <span>'.$ico_more.'</span></p>';
	
    do_action( 'pc_action_post_resum_before_end', $post_id );

	echo '</div></article>';
	
};


/*=====  FIN Affichage  =====*/

/*====================================
=            Fake version            =
====================================*/

function pc_add_fake_st( $nb, $css = '' ) {

	global $settings_project;
	$nb_fake_st = 0;

	if ( $settings_project['theme'] == 'fullscreen' ) {

		switch ( $nb ) {
			case 1:
			case 4:
				$nb_fake_st = 2;
				break;
			case 2:
			case 3:
			case 5:
				$nb_fake_st = 1;
				break;
		}

	}
	
	for ($i=0; $i < $nb_fake_st; $i++) { 
		echo '<div class="st st--fake '.$css.'" aria-hidden="true"></div>';
	}

}


/*=====  FIN Fake version  =====*/