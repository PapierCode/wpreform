<?php

/*----------  Html  ----------*/

echo '<!doctype html><html class="'.pc_get_html_css_class().'" lang="fr">';


/*----------  Head  ----------*/

echo '<head>';

	echo '<meta charset="utf-8" />';
	echo '<meta name="viewport" content="width=device-width,initial-scale=1.0" />';

	wp_head();

echo '</head>';


/*----------  Body start  ----------*/

echo '<body>';


/*----------  Hook header  ----------*/

do_action( 'pc_header' );
