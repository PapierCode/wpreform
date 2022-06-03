<?php
$img = get_field('_bloc_img_id');

if ( $img ) {

	$caption = trim($img['caption']);
	$tag = ( $caption ) ? 'figure' : 'div';

	$block_css = array( 'bloc-image', 'bloc-space--'.get_field('_bloc_space_v') );
	
	$block_size = get_field('_bloc_size');
	if ( 'wide' == $block_size ) { $block_css[] = 'bloc-wide'; }
	
	$img_size = get_field('_bloc_img_size');

	$src = $img['sizes']['thumbnail'];
	$width = $img['sizes']['thumbnail-width'];
	$height = $img['sizes']['thumbnail-height'];

	if ( 'wide' == $block_size || ( 'default' == $block_size && in_array( $img_size, array('600','800') ) ) ) {

		$srcset = array(
			$img['sizes']['thumbnail'].' 400w',
			$img['sizes']['medium'].' 600w'
		);

		if ( 'wide' == $block_size || ( 'default' == $block_size && '800' == $img_size ) ) {

			$srcset[] = $img['sizes']['medium_large'].' 800w';

			if ( 'wide' == $block_size ) {
				$srcset[] = $img['sizes']['large'].' 1200w';
			}

		}

		$sizes = array(
			'(max-width:'.(400/16).'em) 400px'
		);

		if ( 'default' == $block_size && '600' == $img_size ) {
			$sizes[] = '(min-width:'.(401/16).'em) 600px';			
			$src = $img['sizes']['medium'];
			$width = $img['sizes']['medium-width'];
			$height = $img['sizes']['medium-height'];
		}
		if ( 'wide' == $block_size || ( 'default' == $block_size && '800' == $img_size ) ) {
			$sizes[] = '(min-width:'.(401/16).'em) and (max-width:'.(600/16).'em) 600px';
		}
		if ( 'default' == $block_size && '800' == $img_size ) {
			$sizes[] = '(min-width:'.(601/16).'em) 800px';		
			$src = $img['sizes']['medium_large'];
			$width = $img['sizes']['medium_large-width'];
			$height = $img['sizes']['medium_large-height'];
		}
		if ( 'wide' == $block_size ) {
			$sizes = array_merge(
				$sizes,
				array(
					'(min-width:'.(601/16).'em) and (max-width:'.(800/16).'em) 800px',
					'(min-width:'.(801/16).'em) 1200px'
				)
			);		
			$src = $img['sizes']['large'];
			$width = $img['sizes']['large-width'];
			$height = $img['sizes']['large-height'];
		}

	}

	$attrs = array(
		'alt' => trim($img['alt']),
		'loading' => 'lazy',
		'src' => $src,
		'width' => $width,
		'height' => $height,
	);
	if ( isset( $srcset ) ) { $attrs['srcset'] = implode( ', ', $srcset ); }
	if ( isset( $sizes ) ) { $attrs['sizes'] = implode( ', ', $sizes ); }

	echo '<div class="'.implode(' ',$block_css).'"><'.$tag.'>';

		echo '<img';
			foreach ( $attrs as $key => $value ) {
				echo ' '.$key.'="'.$value.'"';
			}
		echo '/>';

		if ( $caption ) { echo '<figcaption class="txt-align--'.get_field('_bloc_img_caption_align').'">'.$caption.'</figcaption>'; }

	echo '</'.$tag.'></div>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Image</em> : sélectionnez une image.</p>';

}