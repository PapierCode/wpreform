<!doctype html>

<html class="<?= pc_html_css_class();  ?>" lang="fr">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />

	<?php wp_head(); ?>

</head>

<body>

	<ul class="skip-nav no-print"><?php if(!is_home()) { ?><li><a href="<?php bloginfo('url'); ?>" title="Retour à la page d'accueil">Accueil</a></li><?php } ?><li><a href="#header-nav" title="Accès à la navigation">Navigation principale</a></li><li><a href="#main" title="Accès direct au contenu">Contenu</a></li><li><a href="#footer-nav" title="Accès à la navigation du pied de page">Navigation pied de page</a></li>
	</ul>

	<div class="body-inner">

		<?php

		do_action( 'pc_header_start' );

			do_action( 'pc_header_logo' );
			do_action( 'pc_header_nav' );

		do_action( 'pc_header_end' );