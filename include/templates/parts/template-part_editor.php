<?php
/**
 * 
 * Communs templates : Wysiwyg WP
 * 
 ** Container
 ** Excerpt
 ** Galerie
 ** Image avec légende
 * 
 */


/*=====  FIN Container  =====*/

/*===============================
=            Excerpt            =
===============================*/

add_filter( 'excerpt_length', function() use ( $texts_lengths ) { return $texts_lengths['excerpt']; }, 999 );
add_filter( 'excerpt_more', function() { return ''; }, 999 );


/*=====  FIN Excerpt  =====*/

/*===============================
=            Galerie            =
===============================*/
 
add_filter( 'post_gallery', 'pc_post_gallery_custom', 10, 3 );

	function pc_post_gallery_custom( $output, $atts, $instance ) {

		// liste des images
		$img_id_list = explode( ',' , $atts['ids'] );

		// html contruction
		$return = '<ul class="wp-gallery reset-list">';

			foreach ( $img_id_list as $img_id ) {

				$thumbnail_datas = wp_get_attachment_image_src($img_id,'gl-th');

				// si la vignette existe
				if ( isset($thumbnail_datas) && $thumbnail_datas[3] == 1 ) {

				$medium_datas = wp_get_attachment_image_url($img_id,'gl-m');
				if ( !isset($medium_datas) ) { $medium_datas = wp_get_attachment_image_src($value,'full'); }
				$large_datas = wp_get_attachment_image_url($img_id,'gl-l');
				if ( !isset($large_datas) ) { $large_datas = wp_get_attachment_image_src($value,'full'); }

					$caption = wp_get_attachment_caption($img_id);
					$alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true);

					// affichage
					$return .= '<li class="wp-gallery-item">';
					$return .= '<a class="wp-gallery-link" href="'.$large_datas.'" data-gl-caption="'.$caption.'" data-gl-responsive="'.$medium_datas.'" title="Afficher l\'image">';
					$return .= '<img class="wp-gallery-img" src="'.$thumbnail_datas[0].'" width="'.$thumbnail_datas[1].'" height="'.$thumbnail_datas[2].'" alt="'.$alt.'" loading="lazy"/>';
					$return .= '<span class="wp-gallery-ico">'.pc_svg('zoom').'</span>';
					$return .= '</a>';
					$return .= '</li>';

				}

			}

		$return .= '</ul>';

		// affichage
		return $return;

	} 
	
 
/*=====  FIN Galerie  =====*/

/*==========================================
=            Image avec légende            =
==========================================*/

add_filter( 'img_caption_shortcode', function( $empty, $attr, $content ) {

    return '<figure class="wp-caption '.$attr['align'].'">'.$content.'<figcaption style="max-width:'.$attr['width'].'px">'.$attr['caption'].'</figcaption></figure>';

}, 10, 3 );


/*=====  FIN Image avec légende  =====*/