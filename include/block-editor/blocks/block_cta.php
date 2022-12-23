<?php
$errors = array();
$btn_attrs = array( 'class="cta-button"' );

$btn_txt = trim( get_field( '_bloc_cta_button_txt' ) );
if ( !$btn_txt ) { $errors[] = 'saississez le texte du boutton'; }

$btn_type = get_field( '_bloc_cta_button_type' );
switch ( $btn_type ) {
	case 'page':
		$page_id = get_field( '_bloc_cta_button_page' );
		if ( !$page_id ) { $errors[] = 'sélectionnez une page'; }
		else if ( !get_post_status( $page_id ) ) { $errors[] = 'la page n\'existe pas'; }
		else { 
			$btn_attrs[] = 'href="'.get_the_permalink( $page_id ).'"';
		}
		break;
	case 'file':
		$media_id = get_field( '_bloc_cta_button_file' );		
		if ( !$media_id ) { $errors[] = 'sélectionnez un fichier'; }
		else if ( !get_post_status( $media_id ) ) { $errors[] = 'le fichier n\'existe pas'; }
		else {
			$btn_attrs[] = 'href="'.wp_get_attachment_url( $media_id ).'"';			
			$btn_attrs[] = 'download';
		}
		break;
	case 'url':
		$url = get_field( '_bloc_cta_button_url' );
		if ( !$url ) { $errors[] = 'saisissez une URL'; }
		else if ( !filter_var( $url, FILTER_VALIDATE_URL ) ) { $errors[] = 'l\'url n\'est pas valide'; }
		else {
			$btn_attrs[] = 'href="'.$url.'"';
			$btn_attrs[] = 'target="_blank"';
		}
		break;
}

if ( !empty( $errors ) ) {
	
	echo '<p class="editor-error">Erreur bloc <em>Bouton (CTA)</em> : '.implode(', ',$errors).'.</p>';

} else {

	$frame = get_field('_bloc_cta_box');
	$frame_title = get_field('_bloc_cta_title');
	$frame_desc = get_field('_bloc_cta_desc');
	
	/*----------  Bloc attributs  ----------*/
	
	$block_css = array(
		'bloc-cta', 
		'bloc-space--'.get_field('_bloc_space_v'), 
		'cta', 
		'cta--'.get_field('_bloc_cta_style')
	);
	if ( isset( $block['className'] ) && '' != trim( $block['className'] ) ) { $block_css[] = $block['className']; }
	if ( $frame ) { $block_css[] = 'cta--frame'; }
	if ( 'wide' == get_field('_bloc_size') ) { $block_css[] = 'bloc-wide'; }
	
	$block_attrs = array( 'class="'.implode( ' ', $block_css ).'"' );
	if ( isset( $block['anchor'] ) && '' != trim( $block['anchor'] ) ) { $block_attrs[] = 'id="'.$block['anchor'].'"'; }

	/*----------  Affichage  ----------*/
	
	echo '<div '.implode(' ',$block_attrs).'>';
		if ( $frame ) { 
			if ( $frame_title ) { echo '<h2 class="cta-title">'.$frame_title.'</h2>'; }
			if ( $frame_desc ) { echo '<p class="cta-desc">'.$frame_desc.'</p>'; }
		}
		echo '<a '.implode( ' ', $btn_attrs ).'><span class="txt">'.$btn_txt.'</span></a>';
	echo '</div>';

}