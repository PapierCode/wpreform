<?php
// Entête
get_header();
// Main (1/2)
pc_display_main_start();


	/*===============================
	=            Contenu            =
	===============================*/ 
	
	$settings_home = get_option('home-settings-option');
	$home_news = get_posts(array(
		'post_type' => NEWS_POST_SLUG,
		'posts_per_page' => $settings_home['content-nbnews']

	));

	// Titre de la page (H1)
	pc_display_main_title( $settings_home['content-title'] );
	
	// Introduction
	echo pc_wp_wysiwyg($settings_home['content-intro']);

	// actualités
	if ( count($settings_home) > 0 ) { ?>

		<aside class="">
			<h2 class="h1-like"><?= $settings_home['content-newstitle']; ?></h2>
			<div class="st-list" data-nb="<?= $settings_home['content-nbnews']; ?>">
				<?php foreach ($home_news as $post) { pc_display_post_resum( $post->ID, '', 3, true ); } ?>
			</div>
		</aside>

	<?php } ?>


	<?php /*=====  FIN Contenu  =====*/

	// partage
	pc_display_share_links();


// Main (2/2)
pc_display_main_end();
// Pied de page
get_footer();