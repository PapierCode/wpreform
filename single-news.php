<?php
// Entête
get_header();
// Boucle WP (1/2)
if ( have_posts() ) : while ( have_posts() ) : the_post();

	// métas
	$postMetas = get_post_meta( $post->ID );

	// Main (1/2)
	pc_get_main_start();
		

		/*----------  Visuel  ----------*/

		if ( isset( $postMetas['resum-img'] ) ) {
			$img = pc_get_img( $postMetas['resum-img'][0], 'st', 'datas' );
			echo '<figure class=""><img src="'.$img[0].'" alt="'.$img[1].'" width="'.$img[2].'" height="'.$img[3].'" /></figure>';
		} else {
			$img = pc_get_default_st( '', 'datas' );
		}

		// Titre de la page (H1)
		pc_get_main_title( get_the_title() );
		

		/*----------  Dates  ----------*/ ?>

		<time class="" datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>


		<?php /*----------  Taxonomy  ----------*/ ?>

		<?php if ( taxonomy_exists (NEWS_TAX_SLUG ) ) {

			// toutes les termes attachés au post
			$postTax = wp_get_post_terms( $post->ID, NEWS_TAX_SLUG, array("fields" => "all" ) );

			// si il y a au moins une tax
			if ( count($postTax) > 0 ) {

				echo '<ul class="tax-list">';
				foreach ($postTax as $postTaxKey => $postTaxValue) {
					echo '<li class="reset-list tax-list-item"><a class="tax-list-link" href="'.pc_get_page_by_custom_content(NEWS_POST_SLUG).'?'.NEWS_TAX_QUERY_VAR.'='.$postTaxValue->slug.'" title="Tous les actualités publiées dans '.$postTaxValue->name.'" rel="nofollow">'.$postTaxValue->name.'</a></li>';
				}
				echo '</ul>';
				
			}

		} ?>


		<?php /*----------  Contenu  ----------*/ ?>	
		
		<div class="editor"><?php the_content(); ?></div>


		<?php /*----------  Footer  ----------*/ ?>

		<footer>

			<?php 
			// navigation suivant/précédent
			pc_post_navigation();
			// Partage
			include 'include/templates/template_share.php';
			?>

		</footer>	

		<?php
		/*==========================================
		=            Données structurée            =
		==========================================*/ ?>

		<script type="application/ld+json">
			{
				"@context": "http://schema.org",
				"@type": "NewsArticle",
				"url": "<?php the_permalink(); ?>",
				"author": {
					"@type": "Organization",
					"name": "<?= $projectSettings['coord-name']; ?>",
					"logo": {
						"@type":"ImageObject",
						"url" : "<?php bloginfo('template_directory'); ?>/images/logo.jpg",
						"width" : "<?= $imgSizes['share']['width']; ?>",
						"height" : "<?= $imgSizes['share']['height']; ?>"
					}
				},
				"publisher": {
					"@type": "Organization",
					"name": "<?php bloginfo('name'); ?>",
					"logo": {
						"@type":"ImageObject",
						"url" : "<?php bloginfo('template_directory'); ?>/images/logo.jpg",
						"width" : "<?= $imgSizes['share']['width']; ?>",
						"height" : "<?= $imgSizes['share']['height']; ?>"
					}
				},
				"headline": "<?php the_title(); ?>",
				"image": {
					"@type":"ImageObject",
					"url" : "<?= $img[0]; ?>",
					"width" : "<?= $img[1]; ?>",
					"height" : "<?= $img[2]; ?>"
				},
				"datePublished": "<?= get_the_date('c'); ?>",
				"dateModified": "<?php the_modified_date('c'); ?>",
				"description": "<?= (isset($postResumMetas['resum-desc'])) ? $postResumMetas['resum-desc'][0] : get_the_excerpt(); ?>",
				"mainEntityOfPage": "<?php the_permalink(); ?>"
			}
		</script>

		<?php /*=====  FIN Données structurée  ======*/

		// Main (2/2)
	pc_get_main_end();

// Boucle WP (2/2)
endwhile; endif;
// Pied de page
get_footer();