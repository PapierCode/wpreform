<?php
/**
 * 
 * Templates : fonctions utiles
 * 
 ** Liens réseaux sociaux
 ** article résumé 
 ** Partage 
 * 
 */


/*=============================================
=            Liens réseaux sociaux            =
=============================================*/

function pc_nav_social_links() {

	global $settings_project, $settings_project_fields;

	$prefix = $settings_project_fields[2]['prefix'];
	$ul = false;
	
	foreach( $settings_project_fields[2]['fields'] as $field ) {

		$id = $prefix.'-'.$field['label_for'];
		
		if ( isset($settings_project[$id]) && $settings_project[$id] != '' ) {

			if ( !$ul ) { echo '<ul class="social-list social-list--header reset-list no-print">'; $ul = true; };

			echo '<li class="social-item"><a class="social-link social-link--'.$field['label_for'].'" href="'.$settings_project[$id].'" title="'.$field['label'].' (nouvelle fenêtre)" target="_blank"><span class="visually-hidden">'.$field['label'].'</span>'.pc_svg($field['label_for'],false,'svg-block').'</a></li>';		
			
		}

	}

	if ( $ul ) { echo '</ul>'; };	

}


/*=====  FIN Liens réseaux sociaux  =====*/

/*======================================
=            Article résumé            =
======================================*/

add_filter( 'excerpt_length', function() { return 20; }, 999 );
add_filter( 'excerpt_more', function() { return ''; }, 999 );

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
	
	$ico_more = pc_svg('cross-16',false,'svg-block');
	$ico_more = apply_filters( 'pc_filter_post_resum_ico_more', $ico_more );
    
    $resum = (isset($metas['resum-desc'])) ? wp_trim_words($metas['resum-desc'][0],20,'') : get_the_excerpt($post_id) ;
	echo '<p class="st-desc">'.$resum.'... <span>'.$ico_more.'</span></p>';
	
    do_action( 'pc_action_post_resum_before_end', $post_id );

	echo '</div></article>';
	
};

/*----------  Fake  version  ----------*/

function pc_add_fake_st( $nb, $css = '' ) {

	global $settings_pc;
	$nb_fake_st = 0;

	if ( $settings_pc['preform-theme'] == 'fullscreen' ) {

		switch ( $nb ) {
			case 1:
			case 4:
				$nb_fake_st = 2;
				break;
			case 2:
			case 5:
				$nb_fake_st = 1;
				break;
		}

	} else {

		if ( in_array( $nb, array(1,3,5) ) ) {
			$nb_fake_st = 1;
		}

	}
	for ($i=0; $i < $nb_fake_st; $i++) { 
		echo '<div class="st st--fake '.$css.'" aria-hidden="true"></div>';
	}

}




/*=====  FIN Article résumé  =====*/

/*===============================
=            Partage            =
===============================*/

function pc_display_share_links() {

    $share_url = 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    global $meta_title, $meta_description; // cf. pc_metas_seo_and_social()

    ?>

    <div class="social-share no-print">
        <p class="social-share-title">Partage&nbsp;: </p>
        <ul class="social-list social-list--share reset-list">
            <li class="social-item">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($share_url); ?>" target="_blank" class="social-link social-link--facebook" rel="nofollow" title="Partager sur Facebook (nouvelle fenêtre)">
                    <span class="visually-hidden">Facebook</span>
                    <?php echo pc_svg('facebook', false, 'svg-block'); ?>
                </a>
            </li>
            <li class="social-item">
                <a href="http://twitter.com/intent/tweet?url=<?= urlencode($share_url); ?>" target="_blank" class="social-link social-link--twitter" rel="nofollow" title="Partager sur Twitter (nouvelle fenêtre)">
                    <span class="visually-hidden">Twitter</span>
                    <?php echo pc_svg('twitter', false, 'svg-block'); ?>
                </a>
            </li>
            <li class="social-item">
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($share_url); ?>&title=<?= str_replace(' ', '%20', $meta_title); ?>&summary=<?= str_replace(' ', '%20', $meta_description); ?>" target="_blank" class="social-link social-link--linkedin" rel="nofollow" title="Partager sur LinkedIn (nouvelle fenêtre)">
                <span class="visually-hidden">LinkedIn</span>
                <?php echo pc_svg('linkedin', '#fff', 'svg-block'); ?>
                </a>
            </li>
        </ul>
    </div>

<?php }


/*=====  FIN Partage  =====*/