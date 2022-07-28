<?php
$embed = get_field('_bloc_embed');

if ( $embed ) {

	$block_css = array( 'bloc-embed', 'bloc-space--'.get_field('_bloc_space_v') );
	if ( isset( $block['className'] ) && '' != trim( $block['className'] ) ) { $block_css[] = $block['className']; }
	if ( 'wide' == get_field('_bloc_size') ) { $block_css[] = 'bloc-wide'; }
	
	$block_attrs = array( 'class="'.implode( ' ', $block_css ).'"' );
	if ( isset( $block['anchor'] ) && '' != trim( $block['anchor'] ) ) { $block_attrs[] = 'id="'.$block['anchor'].'"'; }

	echo '<div '.implode(' ',$block_attrs).'>';
		echo $embed;
	echo '</div>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Contenu embarqué</em> : saisissez l\'adresse du contenu.</p>';

}