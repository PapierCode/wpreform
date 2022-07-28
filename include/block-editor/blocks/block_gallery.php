<?php

$gallery = get_field('_bloc_gallery_ids');

if ( $gallery ) {

	$block_css = array( 'gallery', 'bloc-gallery', 'bloc-space--'.get_field('_bloc_space_v') );

	if ( isset( $block['className'] ) && '' != trim( $block['className'] ) ) { $block_css[] = $block['className']; }
	
	$block_size = get_field('_bloc_size');
	if ( 'wide' == $block_size ) { $block_css[] = 'bloc-wide'; }
	
	$block_attrs = array( 'class="'.implode( ' ', $block_css ).'"' );
	if ( isset( $block['anchor'] ) && '' != trim( $block['anchor'] ) ) { $block_attrs[] = 'id="'.$block['anchor'].'"'; }

	echo '<div '.implode(' ',$block_attrs).'><ul class="gallery-list reset-list">';

	foreach ( $gallery as $image ) {

		echo '<li class="gallery-item">';
			echo '<a class="gallery-link" href="'.$image['sizes']['gl-l'].'" data-gl-caption="'.$image['caption'].'" data-gl-responsive="'.$image['sizes']['gl-m'].'" title="Afficher l\'image">';
				echo '<img class="gallery-img" src="'.$image['sizes']['gl-th'].'" width="'.$image['sizes']['gl-th-width'].'" height="'.$image['sizes']['gl-th-height'].'" alt="'.$image['alt'].'" loading="lazy"/>';
				echo '<span class="gallery-ico">'.pc_svg('zoom').'</span>';
			echo '</a>';
		echo '</li>';

	}

	echo '</ul></div>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Galerie</em> : sélectionnez au moins une image.</p>';

}
