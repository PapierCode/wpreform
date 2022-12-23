<?php
/**
 * 
 * Communs templates : réseaux sociaux
 * 
 ** Liens
 ** Partage
 * 
 */


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

			$txt = 'Suivez-nous sur '.$field['label'].' (nouvelle fenêtre)';
			echo '<li class="social-item"><a class="social-link social-link--'.$field['label_for'].'" href="'.$settings_project[$id].'" target="_blank" rel="noreferrer"><span class="visually-hidden">'.$txt.'</span><span class="ico">'.pc_svg($field['label_for']).'</span></a></li>';		
			
		}

	}

	if ( $ul ) { echo '</ul>'; };	

}
 
 
/*=====  FIN Liens  =====*/

/*===============================
=            Partage            =
===============================*/

function pc_display_share_links() {

	// données page courante
	if ( is_home() ) {
		global $pc_home;
		$metas = $pc_home->get_seo_metas();

	} else if ( is_singular() ) {
		global $pc_post;
		$metas = $pc_post->get_seo_metas();

	} else if ( is_tax() ) {
		global $pc_term;		
		$metas = $pc_term->get_seo_metas();

	} else {
		global $settings_project;		
		$metas = array(
			'title' => $settings_project['coord-name'],
			'description' => $settings_project['seo-desc'],
			'image' => pc_get_default_image_to_share(),
			'permalink' => 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]
		);
	}

	// titre avant les liens
	$share_title = apply_filters( 'pc_filter_share_links_title', 'Partage&nbsp;:' );
	// données liens
	$share_links = apply_filters( 'pc_filter_share_links', array(
		'Facebook' => 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($metas['permalink']),
		'Twitter' => 'https://twitter.com/intent/tweet?url='.urlencode($metas['permalink']),
		'LinkedIn' => 'https://www.linkedin.com/shareArticle?mini=true&url='.urlencode($metas['permalink']).'&title='.str_replace(' ', '%20', $metas['title']).'&summary='.str_replace(' ', '%20', $metas['description'])
	) );


	/*----------  Affichage  ----------*/
	
	echo '<div class="social-share no-print">';

		do_action( 'pc_social_share_after_start' );

		if ( '' != $share_title ) {	echo '<p class="social-share-title">'.$share_title.'</p>'; }
		
		echo '<ul class="social-list social-list--share reset-list">';
			foreach ( $share_links as $name => $href ) {
				echo '<li class="social-item">';
					$txt = 'Partager sur '.$name.' (nouvelle fenêtre)';
					echo '<a href="'.$href.'" target="_blank" class="social-link social-link--'.strtolower($name).'" rel="nofollow noreferrer" title="'.$txt.'">';
						echo '<span class="visually-hidden">'.$txt.'</span>';
						echo '<span class="ico">'.pc_svg( strtolower($name) ).'</span>';
					echo '</a>';
				echo '</li>';
			}
		echo '</ul>';
		
		do_action( 'pc_social_share_before_end' );

	echo '</div>';

}


/*=====  FIN Partage  =====*/