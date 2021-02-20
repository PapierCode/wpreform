<?php
/**
 * 
 * Fonctions réseaux sociaux
 * 
 ** Image par défaut
 ** Liens
 ** Partage
 * 
 */



/*========================================
=            Image par défaut            =
========================================*/

function pc_get_img_default_to_share() {

	global $images_project_sizes;

	$img = array(
		get_template_directory_uri().'/images/share-default.jpg',
		$images_project_sizes['share']['width'],
		$images_project_sizes['share']['height']
	);
	$img = apply_filters( 'pc_filter_img_default_to_share', $img );

	return $img;

}


/*=====  FIN Image par défaut  =====*/

/*=============================
=            Liens            =
=============================*/

function pc_display_social_links( $css_class ) {

	global $settings_project, $settings_project_fields;

	$prefix = $settings_project_fields[2]['prefix'];
	$ul = false;
	
	foreach( $settings_project_fields[2]['fields'] as $field ) {

		$id = $prefix.'-'.$field['label_for'];
		
		if ( isset($settings_project[$id]) && $settings_project[$id] != '' ) {

			if ( !$ul ) { echo '<ul class="social-list reset-list no-print '.$css_class.'">'; $ul = true; };

			echo '<li class="social-item"><a class="social-link social-link--'.$field['label_for'].'" href="'.$settings_project[$id].'" title="'.$field['label'].' (nouvelle fenêtre)" target="_blank" rel="noreferrer"><span class="visually-hidden">'.$field['label'].'</span>'.pc_svg($field['label_for']).'</a></li>';		
			
		}

	}

	if ( $ul ) { echo '</ul>'; };	

}
 
 
/*=====  FIN Liens  =====*/

/*===============================
=            Partage            =
===============================*/

function pc_display_share_links() {

    $share_url = 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    global $seo_metas; // cf. pc_metas_seo_and_social()

    ?>

    <div class="social-share no-print">
        <p class="social-share-title">Partage&nbsp;: </p>
        <ul class="social-list social-list--share reset-list">
            <li class="social-item">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($share_url); ?>" target="_blank" class="social-link social-link--facebook" rel="nofollow noreferrer" title="Partager sur Facebook (nouvelle fenêtre)">
                    <span class="visually-hidden">Facebook</span>
                    <?php echo pc_svg('facebook'); ?>
                </a>
            </li>
            <li class="social-item">
                <a href="http://twitter.com/intent/tweet?url=<?= urlencode($share_url); ?>" target="_blank" class="social-link social-link--twitter" rel="nofollow noreferrer" title="Partager sur Twitter (nouvelle fenêtre)">
                    <span class="visually-hidden">Twitter</span>
                    <?php echo pc_svg('twitter'); ?>
                </a>
            </li>
            <li class="social-item">
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($share_url); ?>&title=<?= str_replace(' ', '%20', $seo_metas['title']); ?>&summary=<?= str_replace(' ', '%20', $seo_metas['description']); ?>" target="_blank" class="social-link social-link--linkedin" rel="nofollow noreferrer" title="Partager sur LinkedIn (nouvelle fenêtre)">
                <span class="visually-hidden">LinkedIn</span>
                <?php echo pc_svg('linkedin'); ?>
                </a>
            </li>
        </ul>
    </div>

<?php }


/*=====  FIN Partage  =====*/