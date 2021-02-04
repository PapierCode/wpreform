<?php

$ml = <<<ML
<h2>1. Éditeur du site</h2>
<strong>Votre nom</strong>, Guillaume Savouré
44 avenue Lafayette
17300 Rochefort

Téléphone : 05 46 88 40 61 / 06 89 90 32 34
<h2>2. Réalisation du site</h2>
<a href="https://www.papier-code.fr" target="_blank" rel="noopener noreferrer"><strong>Papier Codé</strong>, création de site internet à Rochefort</a><strong>
</strong>15 rue de Bretagne
17300 Rochefort

Téléphone : 06 60 83 32 06
Site internet : www.papier-code.fr
<h2>3. Hébergement</h2>
OVH
2 rue Kellermann 59100 Roubaix
Téléphone : 09 72 10 10 07
ML;

$theme_setup_pages = array(
	array(
		'menu_location' => null, // argument wpreform
		'post_type' 	=> 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_title' 	=> 'Page enfant #1',
		'post_content' 	=> file_get_contents( 'https://loripsum.net/api/2/medium/plaintext' )
	),
	array(
		'menu_location' => null, // argument wpreform
		'post_type' 	=> 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_title' 	=> 'Page enfant #2',
		'post_content' 	=> file_get_contents( 'https://loripsum.net/api/2/medium/plaintext' )
	),
	array(
		'menu_location' => 'nav-footer', // argument wpreform
		'post_type' 	=> 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_title' 	=> 'Mentions légales',
		'post_content' 	=> $ml
	),
	array(
		'menu_location' => 'nav-footer', // argument wpreform
		'post_type' 	=> 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_title' 	=> 'Conditions générales d\'utilisation',
		'post_content' 	=> ''
	)
);