<?php
// Entête
get_header();
// Boucle WP (1/2)
if ( have_posts() ) : while ( have_posts() ) : the_post();

	// métas
	$postMetas = get_post_meta($post->ID);

	// Main (1/2)
	pc_get_main_start();

		// Titre de la page (H1)
		pc_get_main_title( get_the_title() );


		/*===============================
		=            Contenu            =
		===============================*/ ?>

		<div class="editor"><?php the_content(); ?></div>
		

		<?php /*=====  FIN Contenu  =====*/

		/*==============================================
		=            Contenu supplémentaire            =
		==============================================*/
		
		/*----------  Contenu spécifique  ----------*/
				
		if ( isset($postMetas['content-from']) ) {
			
			foreach ($pageContentFrom as $slug => $datas) {
				if ($slug == $postMetas['content-from'][0]) {
					include $datas[1];
				}
			}


		/*----------  Sous-pages  ----------*/		

		} else if ( isset($postMetas['content-subpages']) ) {

			$subpagesId = explode(',',$postMetas['content-subpages'][0]);

			echo '<div class="st-list">';
			foreach ($subpagesId as $postId) {
				pc_get_post_resum( $postId, '', 2 );
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
			
			include 'include/templates/template_share.php'; ?>

		</footer>
		
		
		<?php /*=====  FIN Pied de page  =====*/


	// Main (2/2)
	pc_get_main_end();

// Boucle WP (2/2)
endwhile; endif;
// Pied de page
get_footer();