<?php
$quote = trim( get_field('_bloc_quote_txt') );

if ( $quote ) {

	$block_css = array( 'quote', 'bloc-quote', 'bloc-space--'.get_field('_bloc_space_v') );
	
	echo '<blockquote class="'.implode(' ',$block_css).'">';
		echo '<p class="txt-align--'.get_field('_bloc_quote_txt_align').'">'.$quote.'</p>';
		if ( $cite = trim( get_field('_bloc_quote_src') ) ) {
			echo '<cite class="txt-align--'.get_field('_bloc_quote_src_align').'">'.$cite.'</cite>';
		}
		echo '<span class="ico" aria-hidden="true">'.pc_svg('quote').'</span>';
	echo '</blockquote>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Citation</em> : saissez au moins la citation.</p>';

}