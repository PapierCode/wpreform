<?php
/**
 * 
 * Afficher une image en pleine page
 * 
 */


/*============================
=            Init            =
============================*/
 
add_action( 'wp', 'pc_fullscreen_init' );

	function pc_fullscreen_init() {

		global $settings_pc;
		
		global $is_fullscreen;
		$is_fullscreen = array();

		if ( isset($settings_pc['wpreform-fullscreen']) ) {

			if ( is_home() ) {

				global $settings_home;
				$is_fullscreen = $settings_home;

			} else if ( is_singular() ) {

				$post_id = get_the_ID();
				$is_fullscreen = get_post_meta( $post_id );
				foreach ($is_fullscreen as $key => $value) {
					$is_fullscreen[$key] = implode('', $is_fullscreen[$key] );
				}

			}

		}

		$img_post = ( isset( $is_fullscreen['visual-id'] ) && '' != $is_fullscreen['visual-id'] ) ? get_post( $is_fullscreen['visual-id'] ) : null;

		if ( !isset( $is_fullscreen['visual-fullscreen'] ) || !is_object( $img_post ) ) { 
			$is_fullscreen = array();
		}

	}

	
/*=====  FIN Init  =====*/

/*======================================================
=            Classes CSS sur la balise HTML            =
======================================================*/

function pc_fullscreen_edit_html_css_class( $css_classes ) {
	
	global $is_fullscreen;

	if ( !empty( $is_fullscreen ) ) {

		$is_fullscreen = apply_filters( 'pc_filter_fullscreen_html_css_class', $is_fullscreen );

		$css_prefix = 'h1-pos-';
		
		$css_classes[] = 'is-fullscreen';
		$css_classes[] = ( isset( $is_fullscreen['visual-title-h'] ) ) ? $css_prefix.'h-'.$is_fullscreen['visual-title-h'] : $css_prefix.'h-center';
		$css_classes[] = ( isset( $is_fullscreen['visual-title-v'] ) ) ? $css_prefix.'v-'.$is_fullscreen['visual-title-v'] : $css_prefix.'v-center';

	}

	return $css_classes;

}
	
	
/*=====  FIN Classes CSS sur la balise HTML  =====*/

/*=======================================
=            Ajout container            =
=======================================*/

add_action( 'pc_header', 'pc_fullscreen_display_img_container', 20 );

	function pc_fullscreen_display_img_container() {

		global $is_fullscreen;

		if ( !empty( $is_fullscreen ) ) {

			echo '<div class="fs-img"></div>';

		}

	}


/*=====  FIN Ajout container  =====*/

/*=================================================
=            Bouton d'accès au contenu            =
=================================================*/

add_action( 'pc_home_content', 'pc_fullscreen_display_btn_scroll_to_content', 25 );
add_action( 'pc_page_content_before', 'pc_fullscreen_display_btn_scroll_to_content', 35 ); 

	function pc_fullscreen_display_btn_scroll_to_content() {

		global $is_fullscreen;
		
		if ( !empty( $is_fullscreen ) ) {

			$ico = apply_filters( 'pc_filter_btn_scroll_to_content_ico', pc_svg('arrow') );

			echo '<div class="fs-more">';
			echo '<button type="button" class="fs-more-btn button" aria-hidden="true">'.$ico.'</button>';
			echo '</div>';

		}

	}


/*=====  FIN Bouton d'accès au contenu  =====*/

/*==================================
=            CSS inline            =
==================================*/

add_filter( 'pc_filter_css_custom', 'pc_fullscreen_display_inline_css', 10 );

	function pc_fullscreen_display_inline_css( $css_custom ) {

		global $is_fullscreen;

		if ( !empty( $is_fullscreen ) ) {

			if ( isset( $is_fullscreen['visual-id'] ) && '' != $is_fullscreen['visual-id'] ) {

				$em = 16; // medias queries en em
				$sizes = array( 
					array( '', 'fs-s'), 
					array( 600/$em, 'fs-m'), 
					array( 1000/$em, 'fs-l')
				);

				foreach ($sizes as $size) {

					if ( $size[0] != '' ) { $css_custom .= '@media(min-width:'.$size[0].'em){'; }
					$css_custom .= '.fs-img{background-image:url("'.wp_get_attachment_image_src( $is_fullscreen['visual-id'], $size[1] )[0].'")}';
					if ( $size[0] != '' ) { $css_custom .= '}'; }

				}
				
			}

		}

		return $css_custom;

	}


/*=====  FIN CSS inline  =====*/