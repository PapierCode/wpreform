<?php
$columns = array();
			
if ( have_rows ('_bloc_columns') ) { while ( have_rows('_bloc_columns') ) { the_row();

	$column = array();

	if ( have_rows('_bloc_col') ) { while ( have_rows('_bloc_col') ) { the_row();
		switch ( get_row_layout() ) {
			case '_col_bloc_txt':
				$txt = trim(get_sub_field('_col_bloc_txt_wysi'));
				$button_txt = trim(get_sub_field('_bloc_cta_button_txt'));
				$button_link = get_sub_field('_bloc_cta_button_link');
				if ( $txt || ( $button_txt && is_array($button_link) ) ) {
					$txt_col = array(
						'type' => 'text',
						'fields' => array()
					);
					if ( $txt ) { $txt_col['fields']['text'] = $txt; }
					if ( $button_txt && is_array($button_link) ) { 
						$txt_col['fields']['button_txt'] = $button_txt;
						$txt_col['fields']['button_link'] = $button_link;
						$txt_col['fields']['button_pos'] = get_sub_field('_col_cta_pos');
					}
					$column[] = $txt_col;
				}
				break;
			case '_col_bloc_image':
				$img = get_sub_field('_bloc_img_id');
				if ( $img ) { $column[] = array(
					'type' => 'image',
					'fields' => array(
						'url' => $img['url'],
						'width' => $img['width'],
						'height' => $img['height'],
						'alt' => trim($img['alt']),
						'caption' => trim($img['caption']),
						'caption_align' => get_sub_field('_bloc_img_caption_align'),
						'sizes' => $img['sizes']
					)
				); }
				break;
		}

	} }

	if ( !empty( $column ) ) { $columns[] = $column; }

} }

// pc_var($columns);

// to button css
// height: auto;
// padding:rem($button-space)

if ( !empty($columns) && count($columns) > 1 ) {

	$block_css = array( 'bloc-columns', 'bloc-columns--'.count($columns), 'bloc-space--'.get_field('_bloc_space_v') );	
	$block_size = get_field('_bloc_size');
	if ( 'wide' == $block_size ) { $block_css[] = 'bloc-wide'; }

	echo '<div class="'.implode(' ',$block_css).'">';

		foreach ( $columns as $column ) {
				
			echo '<div>';

			foreach ( $column as $bloc ) { 
			
				switch ( $bloc['type'] ) {

				case 'text':
						echo pc_wp_wysiwyg( $bloc['fields']['text'], false );
						if ( isset( $bloc['fields']['button_txt'] ) && isset( $bloc['fields']['button_link'] ) ) {
							$link_attrs[] = 'href="'.trim($bloc['fields']['button_link']['url']).'"';
							$link_css = array( 'cta-button' );
							if ( !is_preview() ) { $link_css[] = 'button'; }
							$link_attrs[] = 'class="'.implode(' ',$link_css).'"';
							if ( $button_link['target'] ) { $link_attrs[] = 'target="'.$button_link['target'].'"'; }	
							echo '<a '.implode( ' ', $link_attrs ).'>'.$bloc['fields']['button_txt'].'</a>';
						}
					break;

				case 'image':
						$tag = ( '' != $bloc['fields']['caption'] ) ? 'figure' : 'div';
						$img_sizes = $bloc['fields']['sizes'];

						if ( $bloc['width'] > '400' ) {

							$srcset = array(
								$img_sizes['thumbnail'].' 400w'
							);
							$sizes = array(
								'(max-width:'.(400/16).'em) 400px'
							);
							
							if ( $bloc['width'] > '600' ) {
								
							}
							
						}

						echo '<'.$tag.'>';

						if ( '' != $bloc['fields']['caption'] ) {
							echo '<figcaption class="txt-align--'.$bloc['fields']['caption_align'].'">'.$bloc['fields']['caption'].'</figcaption>';
						}
						echo '</'.$tag.'>';
					break;

				}

			}
			
			echo '</div>';

		}
			
	echo '</div>';
	

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Colonnes</em> : 2 colonnes minimum avec des blocs configurés.</p>';

}
