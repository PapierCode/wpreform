<?php
// Entête
get_header();
// Main (1/2)
pc_get_main_start();


	/*===============================
	=            Contenu            =
	===============================*/ 
	
	$homeSettings = get_option('home-settings-option');
	$homeNews = get_posts(array(
		'post_type' => NEWS_POST_SLUG,
		'posts_per_page' => $homeSettings['content-nbnews']

	));

	// Titre de la page (H1)
	pc_get_main_title( $homeSettings['content-title'] );
	
	// Introduction
	echo pc_wp_wysiwyg($homeSettings['content-intro']);

	// actualités
	if ( count($homeSettings) > 0 ) { ?>

		<aside class="">
			<h2 class="h1-like"><?= $homeSettings['content-newstitle']; ?></h2>
			<div class="st-list" data-nb="<?= $homeSettings['content-nbnews']; ?>">
				<?php foreach ($homeNews as $post) { pc_get_post_resum( $post->ID, '', 3, true ); } ?>
			</div>
		</aside>

	<?php } ?>


	<?php /*=====  FIN Contenu  =====*/

	// partage
	include 'include/templates/template_share.php';


// Main (2/2)
pc_get_main_end();
// Pied de page
get_footer();