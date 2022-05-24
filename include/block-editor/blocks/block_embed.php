<?php
$embed = get_field('_bloc_embed');

if ( $embed ) {

	$block_css = array( 'bloc-embed', 'bloc-space--'.get_field('_bloc_space_v') );
	if ( 'wide' == get_field('_bloc_size') ) { $block_css[] = 'bloc-wide'; }

	echo '<div class="'.implode( ' ', $block_css ).'">';
		echo $embed;
	echo '</div>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Contenu embarqué</em> : saisissez l\'adresse du contenu.</p>';

}