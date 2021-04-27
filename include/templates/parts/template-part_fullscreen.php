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

		if ( is_home() || is_singular() ) {

			global $settings_pc, $pc_fullscreen;
			$pc_fullscreen = false;

			// si autorisé
			if ( isset( $settings_pc['wpreform-fullscreen'] ) ) {

				if ( is_home() ) {

					global $pc_home;
					$pc_fullscreen = $pc_home;

				} else if ( is_singular() ) {

					global $pc_post;
					$pc_fullscreen = $pc_post;

				}

				if ( $pc_fullscreen->is_fullscreen ) { 

					add_filter( 'pc_filter_html_css_class', 'pc_edit_fullscreen_html_css_class' );

					function pc_edit_fullscreen_html_css_class( $css_classes ) {

						global $pc_fullscreen;
						$metas = $pc_fullscreen->metas;
						$css_prefix = 'h1-pos-';
				
						$css_classes[] = 'is-fullscreen';
						$css_classes[] = ( isset( $metas['visual-title-h'] ) ) ? $css_prefix.'h-'.$metas['visual-title-h'] : $css_prefix.'h-center';
						$css_classes[] = ( isset( $metas['visual-title-v'] ) ) ? $css_prefix.'v-'.$metas['visual-title-v'] : $css_prefix.'v-center';

						return $css_classes;

					}

				}

			}

		}

	}

	
/*=====  FIN Init  =====*/

/*=======================================
=            Ajout container            =
=======================================*/

add_action( 'pc_header', 'pc_display_fullscreen_image_container', 25 );

	function pc_display_fullscreen_image_container() {

		global $pc_fullscreen;

		if ( is_object( $pc_fullscreen ) && $pc_fullscreen->is_fullscreen ) { 

			echo '<div class="fs-img"></div>';

		}

	}


/*=====  FIN Ajout container  =====*/

/*=================================================
=            Bouton d'accès au contenu            =
=================================================*/

add_action( 'pc_action_home_main_header', 'pc_display_fullscreen_btn_scroll_to_content', 40 );
add_action( 'pc_action_page_main_header', 'pc_display_fullscreen_btn_scroll_to_content', 40 ); 

	function pc_display_fullscreen_btn_scroll_to_content() {

		global $pc_fullscreen;

		if ( is_object( $pc_fullscreen ) && $pc_fullscreen->is_fullscreen ) { 

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

		global $pc_fullscreen;

		if ( is_object( $pc_fullscreen ) && $pc_fullscreen->is_fullscreen ) { 
			
			$metas = $pc_fullscreen->metas;

			if ( isset( $metas['visual-id'] ) && '' != $metas['visual-id'] ) {

				$em = 16; // medias queries en em
				$sizes = array( 
					array( '', 'fs-s'), 
					array( 600/$em, 'fs-m'), 
					array( 1000/$em, 'fs-l')
				);

				foreach ($sizes as $size) {

					if ( $size[0] != '' ) { $css_inline .= '@media(min-width:'.$size[0].'em){'; }
					$css_inline .= '.fs-img{background-image:url("'.wp_get_attachment_image_src( $metas['visual-id'], $size[1] )[0].'")}';
					if ( $size[0] != '' ) { $css_inline .= '}'; }

				}
				
			}

		}

		return $css_inline;

	}


/*=====  FIN CSS inline  =====*/