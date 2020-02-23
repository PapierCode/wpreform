<?php
/**
 * 
 * Templates : structure globale
 * 
 */


/*----------  Accueil  ----------*/

add_action( 'pc_home_content_before', 'pc_display_main_start', 10 );

add_action( 'pc_home_content', 'pc_display_home_content', 10, 1 );

add_action( 'pc_home_content_footer', 'pc_display_main_footer_start', 10 );
add_action( 'pc_home_content_footer', 'pc_display_share_links', 20 );
add_action( 'pc_home_content_footer', 'pc_display_main_footer_end', 30 );

add_action( 'pc_home_content_after', 'pc_display_main_end', 10 );


/*----------  Page & post  ----------*/

add_action( 'pc_content_before', 'pc_display_main_start', 10 );

add_action( 'pc_content_before', 'pc_display_main_title', 20, 1 );

add_action( 'pc_content_footer', 'pc_display_main_footer_start', 10 );
add_action( 'pc_content_footer', 'pc_display_main_footer_subpage_backlink', 20, 1 );
add_action( 'pc_content_footer', 'pc_display_share_links', 30 );
add_action( 'pc_content_footer', 'pc_display_main_footer_end', 40 );

add_action( 'pc_content_after', 'pc_display_main_end', 10 );


/*----------  Fonctions associées  ----------*/

function pc_display_main_start() {

    echo '<main id="main" class="main cl-bloc"><div class="main-inner">';

}

function pc_display_main_end() {

    echo '</div></main>';

}

function pc_display_main_title( $post ) {

    echo '<header class="main-header"><h1>'.get_the_title( $post->ID ).'</h1></header>';

}

function pc_display_main_footer_start() {

    echo '<footer class="main-footer fs-bloc">';

}

function pc_display_main_footer_end() {

    echo '</footer>';

}

function pc_display_main_footer_subpage_backlink( $post ) {

    if ( $post->post_type == 'page' && $post->post_parent > 0 ) {

        echo '<nav class="main-footer-nav"><a href="'.get_the_permalink($post->post_parent).'" class="btn" title="Page précédente">'.pc_svg('arrow',null,'svg_block').'Retour</a></nav>';

    }

}

function pc_display_home_content( $settings_home ) {

    echo '<header class="main-header"><h1>'.$settings_home['content-title'].'</h1></header>';
	echo '<div class="editor fs-bloc fs-editor cl-editor"><div class="editor-inner">'.pc_wp_wysiwyg( $settings_home['content-txt'],false ).'</div></div>';

	// pages à la une
	$home_pages = array();
	for ($i=1; $i <= 4 ; $i++) {
		if ( $settings_home['pages-page-'.$i] != '' ) {
			$home_pages[$settings_home['pages-page-'.$i]] = $settings_home['pages-title-'.$i];
		}
	}

	if ( !empty($home_pages) ) {

		echo '<ul class="home-shortcuts reset-list">';
			foreach ($home_pages as $page_id => $page_new_title) {
				$page_title = ($page_new_title != '') ? $page_new_title : get_the_title($page_id);
				echo '<li class="home-shortcut-item"><a title="'.$page_title.'" href="'.get_the_permalink($page_id).'" class="home-shortcut-link"><span class="home-shortcut-img">';

				$page_img_id = get_post_meta( $page_id, 'thumbnail-img', 'thumbnail-img' );
				if ( $page_img_id != '' ) {
					$page_img_urls = array(
						wp_get_attachment_image_src($page_img_id,'st-400')[0],
						wp_get_attachment_image_src($page_img_id,'st-500')[0]
					);
					$page_img_alt	= get_post_meta($page_img_id, '_wp_attachment_image_alt', true);			
				} else {
					$page_img_urls = array(
						get_bloginfo('template_directory').'/images/st-default-400.jpg',
						get_bloginfo('template_directory').'/images/st-default-500.jpg'
					);
					$page_img_urls = apply_filters( 'pc_filter_home_shortcut_img_default_urls', $page_img_urls );
					$page_img_alt	= '';
				}
		
				$page_img_srcset = $page_img_urls[0].' 400w, '.$page_img_urls[1].' 500w';
				$page_img_sizes = '(max-width:400px) 400px, (min-width:401px) and (max-width:759px) 500px, (min-width:760px) and (max-width:840px) 400px (min-width:841px) 500px';
		
				$page_img = '<img src="'.$page_img_urls[1].'" alt="'.$page_img_alt.'" srcset="'.$page_img_srcset.'" sizes="'.$page_img_sizes.'" />';
				$page_img = apply_filters( 'pc_filter_home_shortcut_img', $page_img, $page_id );
				echo $page_img;

				echo '</span><span class="home-shortcut-txt">'.pc_words_limit($page_title,40).'</span></a></li>';
			}
			if ( count($home_pages) == 1 || count($home_pages) == 3 ) {
				echo '<li class="home-shortcut-item home-shortcut-item--fake" aria-hidden="true"></li>';
			}
		echo '</ul>';

	}

}


/*=========================================
=            Wysiwyg container            =
=========================================*/

add_filter( 'the_content', 'pc_filter_content' );
    
    function pc_filter_content( $content ) {
    
        if ( in_the_loop() && is_main_query() ) {
            return '<div class="editor fs-bloc fs-editor cl-editor"><div class="editor-inner">'.$content.'</div></div>';
        }
    
        return $content;
    }


/*=====  FIN Wysiwyg container  =====*/