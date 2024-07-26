<?php

$gallery = get_field('_bloc_gallery_ids');

if ( $gallery ) {

	$block_css = array( 'gallery', 'bloc-gallery', 'bloc-space--'.get_field('_bloc_space_v') );

	$gallery_no_js = get_field('_bloc_gallery_js');
	if ( $gallery_no_js ) { $block_css[] = 'gallery--nojs'; }

	if ( isset( $block['className'] ) && '' != trim( $block['className'] ) ) { $block_css[] = $block['className']; }
	
	$block_size = get_field('_bloc_size');
	if ( 'wide' == $block_size ) { $block_css[] = 'bloc-wide'; }
	
	$block_attrs = array( 'class="'.implode( ' ', $block_css ).'"' );
	if ( isset( $block['anchor'] ) && '' != trim( $block['anchor'] ) ) { $block_attrs[] = 'id="'.$block['anchor'].'"'; }

	echo '<div '.implode(' ',$block_attrs).'><ul class="gallery-list reset-list">';

	$thumb_size = get_field('_bloc_gallery_nocrop') ? 'thumbnail' : 'gl-th';

	foreach ( $gallery as $image ) {

		echo '<li class="gallery-item">';
			if ( !$gallery_no_js ) { echo '<a class="gallery-link" href="'.$image['sizes']['gl-l'].'" data-gl-caption="'.$image['caption'].'" data-gl-responsive="'.$image['sizes']['gl-m'].'" title="Afficher l\'image">'; }
				echo '<img class="gallery-img" src="'.$image['sizes'][$thumb_size].'" width="'.$image['sizes'][$thumb_size.'-width'].'" height="'.$image['sizes'][$thumb_size.'-height'].'" alt="'.$image['alt'].'" loading="lazy"/>';
				echo '<span class="gallery-ico">'.pc_svg('zoom').'</span>';
			if ( !$gallery_no_js ) { echo '</a>'; }
		echo '</li>';

	}

	echo '</ul></div>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Galerie</em> : sélectionnez au moins une image.</p>';

}
