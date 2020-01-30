<?php

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post(); // Boucle WP (1/2)

$page_metas = get_post_meta($post->ID);

do_action( 'pc_content_before', $post, $page_metas );

	/*=======================================
	=            Contenu WYSIWYG            =
	=======================================*/

	the_content();
	

	/*=====  FIN Contenu WYSIWYG  =====*/

	/*==============================================
	=            Contenu supplémentaire            =
	==============================================*/
	
	/*----------  Contenu spécifique  ----------*/
			
	if ( isset($page_metas['content-from']) ) {
		
		foreach ($page_content_from as $slug => $datas) {
			if ($slug == $page_metas['content-from'][0]) {
				include $datas[1];
			}
		}


	/*----------  Sous-pages  ----------*/		

	} else if ( isset($page_metas['content-subpages']) ) {

		$sub_pages_id = explode(',',$page_metas['content-subpages'][0]);

		echo '<div class="st-list">';
		foreach ($sub_pages_id as $postId) {
			pc_display_post_resum( $postId, '', 2 );
		}
		echo '</div>';

	}
	
	
	/*=====  FIN Contenu supplémentaire  =====*/
	

do_action( 'pc_content_footer', $post, $page_metas );

do_action( 'pc_content_after', $post, $page_metas );

endwhile; endif; // Boucle WP (2/2)

get_footer();