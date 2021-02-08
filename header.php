<!doctype html>
<html class="<?= pc_get_html_css_class();  ?>" lang="fr">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0" />
	<?php wp_head(); ?>
</head>
<body>
	<ul class="skip-nav no-print"><?php

		if( !is_home() ) { 
			echo '<li><a href="'.get_bloginfo('url').'" title="Retour à la page d\'accueil">Accueil</a></li>';
		}

		$skip_nav_list = array(
			'#header-nav' => array( 'Navigation principale', 'Accès direct à la navigation principale' ),
			'#main' => array( 'Contenu de la page', 'Accès direct au contenu' ),
			'#footer-nav' => array( 'Navigation du pied de page', 'Accès direct à la navigation du pied de page' )
		);
		$skip_nav_list = apply_filters( 'pc_filter_skip_nav', $skip_nav_list );
		
		foreach ( $skip_nav_list as $anchor => $texts ) {
			echo '<li><a href="'.$anchor.'" title="'.$texts[1].'">'.$texts[0].'</a></li>';
		}
		
	?></ul>
	<?php

	do_action( 'pc_body_start' );

		do_action( 'pc_header_start' );

			do_action( 'pc_header_logo' );
			do_action( 'pc_header_nav' );

		do_action( 'pc_header_end' );