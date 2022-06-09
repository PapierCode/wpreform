<?php
$button_txt = trim(get_field('_bloc_cta_button_txt'));
$button_type = get_field('_bloc_cta_button_type');

switch ( $button_type ) {
	case 'page':
		$button_link = get_field('_bloc_cta_button_link');
		break;
	case 'file':
		$button_link = get_field('_bloc_cta_button_file');
		break;
}

if ( $button_txt && is_array($button_link) ) {

	$frame = get_field('_bloc_cta_box');
	$frame_title = get_field('_bloc_cta_title');
	
	$block_css = array( 'bloc-cta', 'bloc-space--'.get_field('_bloc_space_v'), 'cta', 'cta--'.get_field('_bloc_cta_style') );
	if ( $frame ) { $block_css[] = 'cta--frame'; }
	if ( 'wide' == get_field('_bloc_size') ) { $block_css[] = 'bloc-wide'; }

	$link_attrs[] = 'href="'.trim($button_link['url']).'"';	
	$link_css = array( 'cta-button' );
	$link_attrs[] = 'class="'.implode(' ',$link_css).'"';
	if ( (isset($button_link['target']) && '_blank' == $button_link['target']) || 'file' == $button_type ) { $link_attrs[] = 'target="_blank"'; }

	echo '<div class="'.implode( ' ', $block_css ).'">';
		if ( $frame && $frame_title ) { echo '<h2 class="cta-title">'.$frame_title.'</h2>'; }
		echo '<a '.implode( ' ', $link_attrs ).'>'.$button_txt.'</a>';
	echo '</div>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Bouton (CTA)</em> : saisissez au moins le texte et un lien.</p>';

}