<?php
/**
 * 
 * Communs templates : image en pleine page
 * 
 */


/*============================
=            Init            =
============================*/
 
add_action( 'wp', 'pc_fullscreen_init', 100 );

	function pc_fullscreen_init() {

		global $settings_pc, $is_fullscreen;

		if ( isset($settings_pc['wpreform-fullscreen']) ) {

			if ( is_home() ) {

				global $settings_home;
				$is_fullscreen = $settings_home;

			} else if ( is_singular() ) {

				global $pc_post;
				$is_fullscreen = $pc_post->metas;

			}

		}

		$img_post = ( isset( $is_fullscreen['visual-id'] ) && '' != $is_fullscreen['visual-id'] ) ? get_post( $is_fullscreen['visual-id'] ) : null;

		if ( !isset( $is_fullscreen['visual-fullscreen'] ) || !is_object( $img_post ) ) { 
			
			$is_fullscreen = array();

		} else {

			add_filter( 'pc_filter_html_css_class', 'pc_edit_fullscreen_html_css_class', 10, 2 );

			function pc_edit_fullscreen_html_css_class( $css_classes ) {

				global $is_fullscreen;
				$css_prefix = 'h1-pos-';
		 
				$css_classes[] = 'is-fullscreen';
				$css_classes[] = ( isset( $is_fullscreen['visual-title-h'] ) ) ? $css_prefix.'h-'.$is_fullscreen['visual-title-h'] : $css_prefix.'h-center';
				$css_classes[] = ( isset( $is_fullscreen['visual-title-v'] ) ) ? $css_prefix.'v-'.$is_fullscreen['visual-title-v'] : $css_prefix.'v-center';

				return $css_classes;

			}

		}

	}

	
/*=====  FIN Init  =====*/

/*=======================================
=            Ajout container            =
=======================================*/

add_action( 'pc_header', 'pc_display_fullscreen_image_container', 25 );

	function pc_display_fullscreen_image_container() {

		global $is_fullscreen;

		if ( !empty( $is_fullscreen ) ) {

			echo '<div class="fs-img"></div>';

		}

	}


/*=====  FIN Ajout container  =====*/

/*=================================================
=            Bouton d'accès au contenu            =
=================================================*/

add_action( 'pc_action_home_main_header', 'pc_display_fullscreen_btn_scroll_to_content', 30 );
add_action( 'pc_action_page_main_header', 'pc_display_fullscreen_btn_scroll_to_content', 30 ); 

	function pc_display_fullscreen_btn_scroll_to_content() {

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

add_filter( 'pc_filter_css_inline', 'pc_edit_fullscreen_css_inline', 10 );

	function pc_edit_fullscreen_css_inline( $css_inline ) {

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

					if ( $size[0] != '' ) { $css_inline .= '@media(min-width:'.$size[0].'em){'; }
					$css_inline .= '.fs-img{background-image:url("'.wp_get_attachment_image_src( $is_fullscreen['visual-id'], $size[1] )[0].'")}';
					if ( $size[0] != '' ) { $css_inline .= '}'; }

				}
				
			}

		}

		return $css_inline;

	}


/*=====  FIN CSS inline  =====*/