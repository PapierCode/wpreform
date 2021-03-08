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

	$img_datas = apply_filters( 'pc_filter_img_default_to_share', array(
		get_template_directory_uri().'/images/share-default.jpg',
		$images_project_sizes['share']['width'],
		$images_project_sizes['share']['height']
	) );

	return $img_datas;

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
	$share_title = apply_filters( 'pc_filter_share_links_title', 'Partage&nbsp;:' );

    global $seo_metas; // cf. pc_metas_seo_and_social()

	$share_links = apply_filters( 'pc_filter_share_links', array(
		'Facebook' => 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($share_url),
		'Twitter' => 'http://twitter.com/intent/tweet?url='.urlencode($share_url),
		'LinkedIn' => 'https://www.linkedin.com/shareArticle?mini=true&url='.urlencode($share_url).'&title='.str_replace(' ', '%20', $seo_metas['title']).'&summary='.str_replace(' ', '%20', $seo_metas['description'])
	) );

	echo '<div class="social-share no-print">';
		do_action( 'pc_social_share_after_start' );
		echo '<p class="social-share-title">'.$share_title.'</p>';
		echo '<ul class="social-list social-list--share reset-list">';
			foreach ($share_links as $name => $href) {
				echo '<li class="social-item">';
					echo '<a href="'.$href.'" target="_blank" class="social-link social-link--'.strtolower($name).'" rel="nofollow noreferrer" title="Partager sur '.$name.' (nouvelle fenêtre)">';
						echo '<span class="visually-hidden">'.$name.'</span>';
						echo pc_svg( strtolower($name) );
					echo '</a>';
				echo '</li>';
			}
		echo '</ul>';
		do_action( 'pc_social_share_before_end' );
	echo '</div>';

}


/*=====  FIN Partage  =====*/