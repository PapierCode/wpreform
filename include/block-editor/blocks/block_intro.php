<?php
$intro = trim(get_field('_bloc_intro_txt'));

if ( $intro ) {

	$block_css = array( 'bloc-intro' );
	if ( isset( $block['className'] ) && '' != trim( $block['className'] ) ) { $block_css[] = $block['className']; }
	
	$block_attrs = array( 'class="'.implode( ' ', $block_css ).'"' );
	if ( isset( $block['anchor'] ) && '' != trim( $block['anchor'] ) ) { $block_attrs[] = 'id="'.$block['anchor'].'"'; }

	echo '<p '.implode(' ',$block_attrs).'>'.$intro.'</p>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Introduction</em> : saisissez le texte de l\'introduction.</p>';

}
