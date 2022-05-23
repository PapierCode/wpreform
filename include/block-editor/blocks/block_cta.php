<?php
$button_txt = trim(get_field('_bloc_cta_button_txt'));
$button_link = get_field('_bloc_cta_button_link');

if ( $button_txt && is_array($button_link) ) {

	$frame = get_field('_bloc_cta_box');
	$frame_title = get_field('_bloc_cta_title');
	
	$block_css = array( 'bloc-cta', 'cta', 'bloc-space--'.get_field('_bloc_space_v') );
	if ( $frame ) { $block_css[] = 'cta--frame'; }
	if ( 'wide' == get_field('_bloc_size') ) { $block_css[] = 'bloc-wide'; }

	$link_attrs[] = 'href="'.trim($button_link['url']).'"';	
	$link_css = array( 'cta-button' );
	if ( !$is_preview ) { $link_css[] = 'button'; }
	$link_attrs[] = 'class="'.implode(' ',$link_css).'"';
	if ( $button_link['target'] ) { $link_attrs[] = 'target="'.$button_link['target'].'"'; }

	echo '<div class="'.implode( ' ', $block_css ).'">';
		if ( $frame && $frame_title ) { echo '<h2 class="cta-title">'.$frame_title.'</h2>'; }
		echo '<a '.implode( ' ', $link_attrs ).'>'.trim($button_txt).'</a>';
	echo '</div>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Bouton (CTA)</em> : saisissez au moins le texte et le lien du bouton.</p>';

}