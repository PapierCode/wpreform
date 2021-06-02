<?php
/**
 * 
 * Communs templates : images & galeries
 * 
 ** Tailles
 ** Image de partage par défaut
 ** Sprite
 * 
 */


/*===============================
=            Tailles            =
===============================*/

/*----------  Recadrage forcé  ----------*/

add_filter( 'image_resize_dimensions', 'pc_image_resize_crop_upscale', 10, 6 );

    function pc_image_resize_crop_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ){

        if ( !$crop ) return null; // si l'image ne doit pas être recadrée
    
        $aspect_ratio = $orig_w / $orig_h;
        $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);
    
        $crop_w = round($new_w / $size_ratio);
        $crop_h = round($new_h / $size_ratio);
    
        $s_x = floor( ($orig_w - $crop_w) / 2 );
        $s_y = floor( ($orig_h - $crop_h) / 2 );
    
		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
		
    }


/*----------  Suppressions  ----------*/

add_filter( 'intermediate_image_sizes_advanced', 'pc_remove_images_sizes', 10 );

	function pc_remove_images_sizes( $sizes ) {

		$sizes_to_remove = array(
			'1536x1536',
			'2048x2048'
		);

		foreach ($sizes_to_remove as $size) {
			unset( $sizes[$size] );
		}

		return $sizes;

}


/*----------  Ajouts  ----------*/

add_action( 'init', 'pc_add_images_sizes' );

	function pc_add_images_sizes() {
		
		global $settings_pc, $images_sizes;
		$images_sizes = array(
			
			'st-400'	=> array( 'width'=>400, 'height'=>250, 'crop'=>true ),
			'st-500'	=> array( 'width'=>500, 'height'=>320, 'crop'=>true ),
			'st-700'	=> array( 'width'=>700, 'height'=>440, 'crop'=>true ),
			
			'share'		=> array( 'width'=>300, 'height'=>300, 'crop'=>true ),
			
			'gl-th'		=> array( 'width'=>200, 'height'=>200, 'crop'=>true ),
			'gl-m'		=> array( 'width'=>800, 'height'=>800, 'crop'=>false ),
			'gl-l'		=> array( 'width'=>1200, 'height'=>1200, 'crop'=>false )
			
		);

		if ( isset( $settings_pc['wpreform-fullscreen'] ) ) {

			$images_sizes = array_merge(
				$images_sizes,
				array(
					'fs-s' => array( 'width'=>600, 'height'=>1000, 'crop'=>true ),
					'fs-m' => array( 'width'=>1000, 'height'=>900, 'crop'=>true ),
					'fs-l' => array( 'width'=>1600, 'height'=>880, 'crop'=>true )
				)
			);

		}

		$images_sizes = apply_filters( 'pc_filter_images_sizes', $images_sizes );

		foreach ( $images_sizes as $size => $datas ) {
			add_image_size( $size, $datas['width'], $datas['height'], $datas['crop'] );
		}

	}


/*=====  FIN Tailles  =====*/

/*=========================================
=            Images par défaut            =
=========================================*/

function pc_get_default_image_to_share() {

	global $images_sizes;

	return apply_filters( 'pc_filter_default_image_to_share', array(
		get_template_directory_uri().'/images/share-default.jpg',
		$images_sizes['share']['width'],
		$images_sizes['share']['height']
	) );

}

function pc_get_default_card_image() {

	$directory = get_bloginfo('template_directory');

	return apply_filters( 'pc_filter_default_card_image', array(
		$directory.'/images/st-default-400.jpg',
		$directory.'/images/st-default-500.jpg',
		$directory.'/images/st-default-700.jpg'
	) );

}


/*=====  FIN Image par défaut  =====*/

/*==============================
=            SPrite            =
==============================*/

$sprite = array(

	'arrow' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M16.5 2.9L13.6 0 3.5 10l10.1 10 2.9-2.9L9.3 10l7.2-7.1z"/></svg>',

	'cross' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M20 2.9l-2.9-2.9-7.1 7.1-7.1-7.1-2.9 2.9 7.1 7.1-7.1 7.1 2.9 2.9 7.1-7.1 7.1 7.1 2.9-2.9-7.1-7.1z"/></svg>',

	'more' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><polygon points="20 8 12 8 12 0 8 0 8 8 0 8 0 12 8 12 8 20 12 20 12 12 20 12 20 8"/></svg>',

	'less' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><rect y="8" width="20" height="4"/></svg>',

	'account' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><circle cx="10" cy="5.5" r="5.5"/><path d="M10,10A10,10,0,0,0,0,20H20A10,10,0,0,0,10,10Z"/></svg>',

	'msg' => '<svg xmlns="http://www.w3.org/2000/svg" width="4" height="19" viewBox="0 0 4 19"><rect y="15" width="4" height="4"/><rect width="4" height="12"/></svg>',

	'phone' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M15.69,20a8.26,8.26,0,0,1-2.84-.61,21.79,21.79,0,0,1-7.25-5,22,22,0,0,1-5-7.18c-.85-2.19-.84-4,0-4.91L3,0,7.45,4.49,5.1,6.83l.51.78A24.78,24.78,0,0,0,8.7,11.36a24.48,24.48,0,0,0,3.67,3l.78.52,2.36-2.36L20,17l-2.26,2.25A2.79,2.79,0,0,1,15.69,20Z"/></svg>',

	'smartphone' => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="20" viewBox="0 0 14 20"><path d="M0,0V20H14V0ZM7,18.5A1.5,1.5,0,1,1,8.5,17,1.5,1.5,0,0,1,7,18.5ZM3,14V3h8V14Z"/></svg>',

	'mail' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M0,0V17H20V0ZM14.69,3,10,7.35,5.31,3ZM3,14V5l7,6.48,7-6.49V14Z"/></svg>',

	'map' => '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="20" viewBox="0 0 14 20"><path d="M7,0H7A7.24,7.24,0,0,0,0,7.44c0,2.25,1.08,4,2.29,5.74L7,20s4.45-6.41,4.72-6.81C12.92,11.44,14,9.69,14,7.44A7.24,7.24,0,0,0,7,0ZM7,10.32A3.12,3.12,0,1,1,10.12,7.2,3.12,3.12,0,0,1,7,10.32Z"/></svg>',

	'link' => '<svg xmlns="http://www.w3.org/2000/svg" width="27" height="15" viewBox="0 0 27 15"><polygon points="6 15 0 15 0 0 18 0 18 9 15 9 15 3 3 3 3 12 6 12 6 15"/><polygon points="27 15 9 15 9 6 12 6 12 12 24 12 24 3 21 3 21 0 27 0 27 15"/></svg>',

	'facebook' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M7.2 4v2.9H5v3.5h2.2V20h4.4v-9.6h3s.3-1.7.4-3.5h-3.4V4.5c0-.4.5-.8 1-.8H15V.1C13.8 0 12.3 0 11.7 0 7.1 0 7.2 3.5 7.2 4z"/></svg>',

	'twitter' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M20 3.9c-.7.3-1.5.5-2.4.6.8-.5 1.5-1.3 1.8-2.2-.8.5-1.7.8-2.6 1-.7-.8-1.8-1.3-3-1.3-2.3 0-4.1 1.8-4.1 4 0 .3 0 .6.1.9-3.3-.1-6.3-1.7-8.3-4.2-.4.6-.6 1.3-.6 2.1 0 1.4.7 2.6 1.8 3.4-.6-.1-1.2-.3-1.8-.6v.1c0 2 1.4 3.6 3.3 4-.3 0-.7.1-1.1.1-.3 0-.5 0-.8-.1.5 1.6 2 2.8 3.8 2.8-1.4 1.1-3.2 1.7-5.1 1.7-.3 0-.7 0-1-.1C1.9 17.3 4.1 18 6.4 18 13.8 18 18 11.8 18 6.5V6c.8-.6 1.4-1.3 2-2.1z"/></svg>',

	'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M14,2a4,4,0,0,1,4,4v8a4,4,0,0,1-4,4H6a4,4,0,0,1-4-4V6A4,4,0,0,1,6,2h8m0-2H6A6,6,0,0,0,0,6v8a6,6,0,0,0,6,6h8a6,6,0,0,0,6-6V6a6,6,0,0,0-6-6Z"/><path d="M10,7a3,3,0,1,1-3,3,3,3,0,0,1,3-3m0-2a5,5,0,1,0,5,5,5,5,0,0,0-5-5Z"/><path d="M15.34,3.41a1.25,1.25,0,1,0,1.25,1.25,1.25,1.25,0,0,0-1.25-1.25Z"/></svg>',

	'linkedin' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M.34,6.63h4.2V20H.34ZM2.43,0A2.42,2.42,0,0,1,4.86,2.4,2.42,2.42,0,0,1,2.43,4.8,2.42,2.42,0,0,1,0,2.4,2.42,2.42,0,0,1,2.43,0"/><path d="M6.94,6.63h4V8.45H11A4.43,4.43,0,0,1,15,6.3c4.25,0,5,2.76,5,6.35V20H15.81V13.48c0-1.55,0-3.49-2.18-3.49s-2.52,1.69-2.52,3.42V20H6.91Z"/></svg>',

	'zoom' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M20,17.88,14.62,12.5a8,8,0,1,0-2.12,2.12L17.88,20ZM3,8a5,5,0,1,1,5,5A5,5,0,0,1,3,8Z"/></svg>',

	'tag' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M11.42,1.09A4.36,4.36,0,0,0,8.77,0H1.55A1.56,1.56,0,0,0,0,1.55V8.77a4.36,4.36,0,0,0,1.09,2.65l8.14,8.13a1.56,1.56,0,0,0,2.19,0l8.13-8.13a1.56,1.56,0,0,0,0-2.19ZM6.32,8.9A2.58,2.58,0,1,1,8.9,6.32,2.58,2.58,0,0,1,6.32,8.9Z"/></svg>'

);

$sprite = apply_filters( 'pc_filter_sprite', $sprite );


/*=====  FIN SPrite  =====*/