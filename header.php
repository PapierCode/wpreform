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
		<header class="header layout">
			<div class="header-inner">
				<div class="h-logo">
					<a href="<?php bloginfo('url'); ?>" class="h-logo-link" title="Accueil <?php bloginfo('name'); ?>">
						<?php
						$logo_datas = array(
							'url' => get_bloginfo('template_directory').'/images/logo.svg',
							'width' => 150,
							'height' => 150,
							'alt' => 'Logo'
						);
						$logo_datas = apply_filters( 'pc_filter_header_logo', $logo_datas );
						?>
						<img class="h-logo" src="<?= $logo_datas['url']; ?>" alt="<?= $logo_datas['alt']; ?>" width="<?= $logo_datas['width']; ?>" height="<?= $logo_datas['height']; ?>" />
					</a>
					<div class="h-nav-btn-box">
						<button type="button" title="Ouvrir/fermer le menu" class="h-nav-btn js-h-nav reset-btn" aria-hidden="true" tabindex="-1">
							<span class="h-nav-btn-ico"><span class="h-nav-btn-ico h-nav-btn-ico--inner"></span></span>
							<span class="h-nav-btn-txt">Menu</span>
						</button>
					</div>
				</div>
				<nav id="header-nav" class="h-nav"><div class="h-nav-inner">
					<?php
						$nav_header_config = array(
							'theme_location'  	=> 'nav-header',
							'nav_prefix'		=> array('h-nav', 'h-p-nav'), // custom
							'menu_class'      	=> 'h-nav-list h-nav-list--l1 h-p-nav-list h-p-nav-list--l1 reset-list',
							'items_wrap'      	=> '<ul class="%2$s">%3$s</ul>',
							'depth'           	=> 1,
							'container'       	=> '',
							'item_spacing'		=> 'discard',
							'fallback_cb'     	=> false,
							'walker'          	=> new Pc_Walker_Nav_Menu()
						);
						wp_nav_menu( $nav_header_config ); // + include/navigation.php
						pc_nav_social_links();
					?>
				</div></nav>
			</div>
		</header>

		<button type="button" title="Fermer le menu" class="btn-overlay reset-btn js-h-nav" aria-hidden="true" tabindex="-1"><span class="visually-hidden">Fermer le menu</span></button>