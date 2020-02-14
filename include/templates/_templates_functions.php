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

    echo '<article class="st '.$css.'"><div class="st-inner">';
    
	do_action( 'pc_action_post_resum_after_start', $post_id );
	

	/*----------  Visuel  ----------*/
	
	echo '<figure class="st-figure">';
	
    if ( isset($metas['thumbnail-img']) ) {

		$st_img_s = pc_get_img($metas['thumbnail-img'][0],'st-s','datas');
		$st_img_l = pc_get_img($metas['thumbnail-img'][0],'st-l','datas');
	
		$st_img = array(
			'src'		=> $st_img_l[0],
			'alt'		=> $st_img_l[3],
			'srcset'	=> $st_img_s[0].' 400w, '.$st_img_l[0].' 700w',
			'sizes'		=> '(max-width:400px) 400px, (min-width:401px) and (max-width:760px) 700px, (min-width:761px) 400px'
		);
		$st_img = apply_filters( 'pc_filter_st_img', $st_img );

		echo '<img src="'.$st_img['src'].'" alt="'.$st_img['alt'].'" srcset="'.$st_img['srcset'].'" sizes="'.$st_img['sizes'].'" />';
		
    } else {
        echo pc_get_default_st('st-img');
    }
	echo '</figure>';
	

    /*----------  Titre  ----------*/

    echo '<h'.$hn.' class="st-title"><a href="'.get_the_permalink($post_id).'">'.$title.'</a></h'.$hn.'>';
	
	do_action( 'pc_action_post_resum_after_title', $post_id );
	

	/*----------  Description + lire la suite  ----------*/
	
	$ico_more = pc_svg('cross-16',false,'svg-block');
	$ico_more = apply_filters( 'pc_filter_post_resum_ico_more', $ico_more );
    
    $resum = (isset($metas['resum-desc'])) ? wp_trim_words($metas['resum-desc'][0],20,'') : get_the_excerpt($post_id) ;
	echo '<p class="st-desc">'.$resum.'...<span>'.$ico_more.'</span></p>';
	
    do_action( 'pc_action_post_resum_before_end', $post_id );

	echo '</div></article>';
	
};


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