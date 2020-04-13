<?php
/**
 * 
 * Fonctions pour les templates : accueil
 * 
 */


/*=============================
=            Hooks            =
=============================*/

add_action( 'pc_home_content_before', 'pc_display_main_start', 10 ); // layout commun

add_action( 'pc_home_content', 'pc_display_home_content', 10, 1 ); // contenu

add_action( 'pc_home_content_footer', 'pc_display_main_footer_start', 10 );  // layout commun
add_action( 'pc_home_content_footer', 'pc_display_share_links', 20 );  // layout commun
add_action( 'pc_home_content_footer', 'pc_display_main_footer_end', 30 );  // layout commun

add_action( 'pc_home_content_after', 'pc_display_main_end', 10 );  // layout commun


/*=====  FIN Hooks  =====*/

/*===============================
=            Contenu            =
===============================*/

function pc_display_home_content( $settings_home ) {

	/*----------  Header  ----------*/
	
	echo '<header class="main-header">';
	echo '<h1>'.$settings_home['content-title'].'</h1>';
	pc_fs_btn_scroll_to_content();
	echo '</header>';


	/*----------  Wysiwyg  ----------*/
	
	echo '<div class="editor fs-bloc fs-editor cl-editor"><div class="editor-inner">'.pc_wp_wysiwyg( $settings_home['content-txt'],false ).'</div></div>';
	

	/*----------  Données structurées  ----------*/
	
	$home_schema = array(
		'@context' => 'http://schema.org/',
		'@type'=> 'CollectionPage',
		'name' => $settings_home['content-title'],
		'headline' => $settings_home['content-title'],
		'description' => ( isset( $settings_home['seo-desc'] ) && $settings_home['seo-desc'] != '' ) ? $settings_home['seo-desc'] : wp_trim_words($settings_home['content-txt'],30,'...'),
		'mainEntity' => array(
			'@type' => 'ItemList',
			'itemListElement' => array()
		),
		'isPartOf' => pc_get_schema_website()
	);


	/*----------  Pages à la une  ----------*/
	
	// bdd to array
	$home_pages = ( isset($settings_home['content-pages']) ) ? pc_home_pages_bdd_to_array($settings_home['content-pages']) : '';

	if ( !empty($home_pages) ) {

		// pour les CSS, pair ou impair ?
		$shortcuts_nb = ( count($home_pages)%2 == 1 ) ? 'home-shortcuts--odd' : 'home-shortcuts--even';

		echo '<ul class="home-shortcuts '.$shortcuts_nb.' reset-list">';
			foreach ($home_pages as $page_id => $page_new_title) {

				// titre
				$page_title = ($page_new_title != '') ? $page_new_title : get_the_title($page_id);
				// lien
				$page_url = get_the_permalink($page_id);
				
				// image de la page ou image par défaut
				$page_img_id = get_post_meta( $page_id, 'thumbnail-img', true );
				if ( $page_img_id != '' ) {
					$page_img_urls = array(
						wp_get_attachment_image_src($page_img_id,'st-400')[0],
						wp_get_attachment_image_src($page_img_id,'st-500')[0]
					);
					$page_img_alt = get_post_meta($page_img_id, '_wp_attachment_image_alt', true);			
				} else {
					$page_img_urls = array(
						get_bloginfo('template_directory').'/images/st-default-400.jpg',
						get_bloginfo('template_directory').'/images/st-default-500.jpg'
					);
					$page_img_alt = $page_title;
				}
				$page_img_srcset = $page_img_urls[0].' 400w, '.$page_img_urls[1].' 500w';
				$page_img_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 500px, (min-width:760px) and (max-width:840px) 400px, (min-width:841px) 500px';
				$page_img = '<img src="'.$page_img_urls[1].'" alt="'.$page_img_alt.'" srcset="'.$page_img_srcset.'" sizes="'.$page_img_sizes.'" />';
				$page_img = apply_filters( 'pc_filter_home_shortcut_img', $page_img, $page_id );

				// affichage
				echo '<li class="home-shortcut-item"><a title="'.$page_title.'" href="'.$page_url.'" class="home-shortcut-link">';
				echo '<span class="home-shortcut-img">'.$page_img.'</span>';
				echo '<span class="home-shortcut-txt">'.pc_words_limit(htmlspecialchars_decode($page_title),40).'</span>';
				echo '<span class="home-shortcut-ico">'.pc_svg('link').'</span>';
				echo '</a></li>';

				// ajout données structurées
				global $images_project_sizes;
				$home_schema['mainEntity']['itemListElement'][] = array(
					'@type' => 'ListItem',
					'name' => $page_title,
					'url' => $page_url,
					'image' => array(
						'@type'		=>'ImageObject',
						'url' 		=> $page_img_urls[1],
						'width' 	=> $images_project_sizes['st-500']['width'],
						'height' 	=> $images_project_sizes['st-500']['height']
					)
				);

			} // FIN foreach $home_pages
		echo '</ul>';

	}

	/*----------  Affichage données structurées  ----------*/
	
	$home_schema = apply_filters( 'pc_filter_schema_home', $home_schema );
	echo '<script type="application/ld+json">'.json_encode($home_schema,JSON_UNESCAPED_SLASHES).'</script>';

}


/*=====  FIN Contenu  =====*/

/*==========================================================
=            Classes CSS en fonction du contenu            =
==========================================================*/

add_filter( 'pc_filter_html_css_class', 'pc_home_add_class' );
		
function pc_home_add_class( $class ) {

	global $home_pages;
	if ( is_home() && !empty($home_pages) ) { $class[] = 'is-home-with-shortcuts'; }

	return $class;

}


/*=====  FIN Classes CSS en fonction du contenu  =====*/