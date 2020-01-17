<?php
// Entête
get_header();
// Boucle WP (1/2)
if ( have_posts() ) : while ( have_posts() ) : the_post();

	// métas
	$page_metas = get_post_meta($post->ID);

	// Main (1/2)
	pc_display_main_start();

		// Titre de la page (H1)
		pc_display_main_title( get_the_title() );


		/*===============================
		=            Contenu            =
		===============================*/ ?>

		<div class="editor"><?php the_content(); ?></div>
		

		<?php /*=====  FIN Contenu  =====*/

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

		/*====================================
		=            Pied de page            =
		====================================*/ ?>
		
		<footer>

			<?php /*----------  Retour page parent  ----------*/		
			
			if ( $post->post_parent > 0 ) {
				echo '<a href="'.get_the_permalink($post->post_parent).'" class="" title="">< page parent</a>';
			}

			/*----------  Partage  ----------*/			
			
			pc_display_share_links(); ?>

		</footer>
		
		
		<?php /*=====  FIN Pied de page  =====*/


	// Main (2/2)
	pc_display_main_end();

// Boucle WP (2/2)
endwhile; endif;
// Pied de page
get_footer();