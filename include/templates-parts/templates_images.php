<?php
/**
 * 
 * Fonctions pour les templates : images & galeries
 * 
 ** Tailles
 ** Galerie d'images (wysiwyg)
 ** Image avec légende (wysiwyg)
 * 
 */


/*===============================
=            Tailles            =
===============================*/

/*----------  Suppression  ----------*/

remove_image_size('1536x1536');
remove_image_size('2048x2048');


/*----------  Ajouts  ----------*/
    
$images_project_sizes = array(
	
	'st-400'	=> array( 'width'=>400, 'height'=>250, 'crop'=>true ),
	'st-500'	=> array( 'width'=>500, 'height'=>320, 'crop'=>true ),
	'st-700'	=> array( 'width'=>700, 'height'=>440, 'crop'=>true ),
	
	'share'		=> array( 'width'=>300, 'height'=>300, 'crop'=>true ),
	
    'gl-th'		=> array( 'width'=>200, 'height'=>200, 'crop'=>true ),
    'gl-m'		=> array( 'width'=>800, 'height'=>800, 'crop'=>false ),
	'gl-l'		=> array( 'width'=>1200, 'height'=>1200, 'crop'=>false )
	
);

if ( isset( $settings_pc['wpreform-fullscreen'] ) ) {

	$images_project_sizes = array_merge(
		$images_project_sizes,
		array(
			'fs-s' => array( 'width'=>600, 'height'=>1000, 'crop'=>true ),
			'fs-m' => array( 'width'=>1000, 'height'=>900, 'crop'=>true ),
			'fs-l' => array( 'width'=>1600, 'height'=>880, 'crop'=>true )
		)
	);

}

$images_project_sizes = apply_filters( 'pc_filter_add_img_sizes', $images_project_sizes );

foreach ( $images_project_sizes as $size => $datas ) {
    add_image_size( $size, $datas['width'], $datas['height'], $datas['crop'] );
}


/*----------  Recadrage forcé  ----------*/

add_filter( 'image_resize_dimensions', 'pc_image_resize_crop_upscale', 10, 6 );

    function pc_image_resize_crop_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ){

        if ( !$crop ) return null; // si l'image ne doit pas être taillée pour correspondre à la taille demandée
    
        $aspect_ratio = $orig_w / $orig_h;
        $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
    
        $crop_w = round($new_w / $size_ratio);
        $crop_h = round($new_h / $size_ratio);
    
        $s_x = floor( ($orig_w - $crop_w) / 2 );
        $s_y = floor( ($orig_h - $crop_h) / 2 );
    
		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
		
    }

/*=====  FIN Tailles  =====*/

/*===============================
=            Galerie            =
===============================*/
 
add_filter( 'post_gallery', 'pc_gallery_custom', 10, 3 );

	function pc_gallery_custom( $output, $atts, $instance ) {

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