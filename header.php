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
		<header class="header">
			<div class="header-inner">
				<div class="h-logo">
					<a href="<?php bloginfo('url'); ?>" class="h-logo-link" title="Accueil <?php bloginfo('name'); ?>">
						<?php
						$logoDatas = array(
							'url' => get_bloginfo('template_directory').'/images/logo.svg',
							'width' => 140,
							'height' => 120,
							'alt' => 'Logo'
						);
						$logoDatas = apply_filters( 'pc_filter_header_logo', $logoDatas );
						?>
						<img class="h-logo" src="<?= $logoDatas['url']; ?>" alt="<?= $logoDatas['alt']; ?>" width="<?= $logoDatas['width']; ?>" height="<?= $logoDatas['height']; ?>" />
					</a>
					<div class="btn-h-nav-box"><button type="button" title="Ouvrir/fermer le menu" class="btn-h-nav reset-btn ico-menu js-menu" aria-hidden="true" tabindex="-1"><span class="btn-menu-inner ico-menu"><span class="">Menu</span></span></button></div>
				</div>
				<nav id="header-nav" class="h-nav">
					<?php
						$hNavConfig = array(
							'theme_location'  	=> 'header_primary',
							'nav_prefix'		=> array('h-nav', 'h-p-nav'), // custom
							'menu_class'      	=> 'h-nav-list h-nav-list--l1 h-p-nav-list h-p-nav-list--l1 reset-list',
							'items_wrap'      	=> '<ul class="%2$s">%3$s</ul>',
							'depth'           	=> 1,
							'container'       	=> '',
							'item_spacing'		=> 'discard',
							'fallback_cb'     	=> false,
							'walker'          	=> new Pc_Walker_Nav_Menu()
						);
						wp_nav_menu( $hNavConfig );
						// + include/navigation.php
					?>
				</nav>
			</div>
		</header>