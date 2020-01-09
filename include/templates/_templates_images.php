<?php
/**
 * 
 * Gestion des images
 * 
 */


/*===============================
=            Tailles            =
===============================*/

add_action( 'after_switch_theme', 'pc_define_default_img_sizes' );

function pc_define_default_img_sizes() {

    // update_option( 'thumbnail_crop', 0 );
    // update_option( 'thumbnail_size_h', 150 );
    // update_option( 'thumbnail_size_w', 150 );
    // update_option( 'medium_size_h', 150 );
    // update_option( 'medium_size_w', 150 );
    // update_option( 'medium_large_size_h', 150 );
    // update_option( 'medium_large_size_w', 150 );
    // update_option( 'large_size_h', 150 );
    // update_option( 'large_size_w', 150 );

}
    
$imgSizes = array(
    'st'    => array( 'width'=>150, 'height'=>150, 'crop'=>true ), // affecte pc_get_default_st()
    'share' => array( 'width'=>300, 'height'=>300, 'crop'=>true ),
    'gl-m'  => array( 'width'=>800, 'height'=>800, 'crop'=>false ),
    'gl-l'  => array( 'width'=>1200, 'height'=>1200, 'crop'=>false )
);

$imgSizes = apply_filters( 'pc_filter_add_img_sizes', $imgSizes );

foreach ( $imgSizes as $imgSize => $datas ) {
    add_image_size( $imgSize, $datas['width'], $datas['height'], $datas['crop'] );
}


/*=====  FIN Tailles  =====*/

/*===============================
=            Galerie            =
===============================*/
 
add_filter( 'post_gallery', 'pc_gallery_custom', 10, 3 );

function pc_gallery_custom( $output = '', $atts, $instance ) {

    // liste des images
    $imgIdList = explode( ',' , $atts['ids'] );

    // html contruction
    $return = '<ul class="wp-gallery reset-list">';

        foreach ( $imgIdList as $imgId ) {

            $imgThumbDatas = wp_get_attachment_image_src($imgId,'st');

            // si la vignette existe
            if ( isset($imgThumbDatas) && $imgThumbDatas[3] == 1 ) {

               $imgMediumDatas = wp_get_attachment_image_url($imgId,'gl-m');
               if ( !isset($imgMediumDatas) ) { $imgMediumDatas = wp_get_attachment_image_src($value,'full'); }
               $imgLargeDatas = wp_get_attachment_image_url($imgId,'gl-l');
               if ( !isset($imgLargeDatas) ) { $imgLargeDatas = wp_get_attachment_image_src($value,'full'); }

                $imgCaption = wp_get_attachment_caption($imgId);
                $imgAlt = get_post_meta( $imgId, '_wp_attachment_image_alt', true);

                // affichage
                $return .= '<li class="wp-gallery-item">';
                $return .= '<a class="wp-gallery-link" href="'.$imgLargeDatas.'" data-gl-caption="'.$imgCaption.'" data-gl-responsive="'.$imgMediumDatas.'" title="Afficher l\'image">';
                $return .= '<img class="wp-gallery-img" src="'.$imgThumbDatas[0].'" width="'.$imgThumbDatas[1].'" height="'.$imgThumbDatas[2].'" alt="'.$imgAlt.'"/>';
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