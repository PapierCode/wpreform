<?php
/**
 * 
 * Fonctions pour les templates : réseaux sociaux (RS)
 * 
 ** Liens RS
 ** Partage RS 
 * 
 */


/*================================
=            Liens RS            =
================================*/

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


/*=====  FIN Liens RS  =====*/

/*==================================
=            Partage RS            =
==================================*/

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


/*=====  FIN Partage RS  =====*/