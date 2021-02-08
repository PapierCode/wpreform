<?php

$theme_setup_pages = array(
	array(
		'menu_location' => null, // argument wpreform
		'post_type' 	=> 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_title' 	=> 'Page enfant #1',
		'post_content' 	=> 'Homines enim eruditos et sobrios ut infaustos et inutiles vitant, eo quoque accedente quod et nomenclatores adsueti haec et talia venditare, mercede accepta lucris quosdam et prandiis inserunt subditicios ignobiles et obscuros.'
	),
	array(
		'menu_location' => null, // argument wpreform
		'post_type' 	=> 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_title' 	=> 'Page enfant #2',
		'post_content' 	=> 'Saraceni tamen nec amici nobis umquam nec hostes optandi, ultro citroque discursantes quicquid inveniri poterat momento temporis parvi vastabant milvorum rapacium similes, qui si praedam dispexerint celsius, volatu rapiunt celeri, aut nisi impetraverint, non inmorantur.'
	),
	array(
		'menu_location' => 'nav-footer', // argument wpreform
		'post_type' 	=> 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_title' 	=> 'Mentions légales',
		'post_content' 	=> file_get_contents(get_template_directory_uri().'/include/theme-setup/theme-setup-contents/theme-setup_ml.php')
	),
	array(
		'menu_location' => 'nav-footer', // argument wpreform
		'post_type' 	=> 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_title' 	=> 'Conditions générales d\'utilisation',
		'post_content' 	=> file_get_contents(get_template_directory_uri().'/include/theme-setup/theme-setup-contents/theme-setup_cgu.php')
	),
	array(
		'menu_location' => 'nav-header', // argument wpreform
		'post_type' 	=> 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_title' 	=> 'Wysiwyg',
		'post_content' 	=> file_get_contents(get_template_directory_uri().'/include/theme-setup/theme-setup-contents/theme-setup_wysiwyg.php')
	)
);