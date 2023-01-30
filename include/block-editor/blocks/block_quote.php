<?php
$quote = trim( get_field('_bloc_quote_txt') );

if ( $quote ) {

	$block_css = array( 'quote', 'bloc-quote', 'bloc-space--'.get_field('_bloc_space_v') );
	if ( isset( $block['className'] ) && '' != trim( $block['className'] ) ) { $block_css[] = $block['className']; }
	
	$block_attrs = array( 'class="'.implode( ' ', $block_css ).'"' );
	if ( isset( $block['anchor'] ) && '' != trim( $block['anchor'] ) ) { $block_attrs[] = 'id="'.$block['anchor'].'"'; }
	
	echo '<blockquote '.implode(' ',$block_attrs).'>';
		echo '<p class="has-text-align-'.get_field('_bloc_quote_txt_align').'">'.$quote.'</p>';
		if ( $cite = trim( get_field('_bloc_quote_src') ) ) {
			echo '<cite class="has-text-align-'.get_field('_bloc_quote_src_align').'">'.$cite.'</cite>';
		}
	echo '</blockquote>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Citation</em> : saissez au moins la citation.</p>';

}