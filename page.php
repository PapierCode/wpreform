<?php

if ( have_posts() ) : while ( have_posts() ) : the_post(); // Boucle WP (1/2)

$page_metas = get_post_meta($post->ID);

// version fullscreen et visuel associé ?
if ( $settings_project['theme'] == 'fullscreen' && isset($page_metas['thumbnail-img'])) { $settings_project['is-fullscreen'] = true; }

get_header();

do_action( 'pc_page_content_before', $post, $page_metas );

	/*=======================================
	=            Contenu WYSIWYG            =
	=======================================*/

	if ( $post->post_content != '' ) { the_content(); }
	

	/*=====  FIN Contenu WYSIWYG  =====*/

	/*==============================================
	=            Contenu supplémentaire            =
	==============================================*/
	
	/*----------  Contenu spécifique  ----------*/
			
	if ( isset($page_metas['content-from']) ) {
		
		foreach ( $settings_project['page-content-from'] as $slug => $datas ) {
			if ($slug == $page_metas['content-from'][0]) {
				include $datas[1];
			}
		}


	/*----------  Sous-pages  ----------*/		

	} else if ( isset($page_metas['content-subpages']) ) {

		$sub_pages_id = explode( ',',$page_metas['content-subpages'][0] );

		foreach ( $sub_pages_id as $postId ) {
			pc_display_post_resum( $postId, '', 2 );
		}
		pc_add_fake_st( count($sub_pages_id) );

	}
	
	
	/*=====  FIN Contenu supplémentaire  =====*/
	

do_action( 'pc_page_content_footer', $post, $page_metas );

do_action( 'pc_page_content_after', $post, $page_metas );

get_footer();

endwhile; endif; // Boucle WP (2/2)