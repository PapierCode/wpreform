<?php
/**
 * 
 * Blocs ACF
 * 
 */

/*
bloc publié dans une seule page

$posts_with = get_posts(array(
	'post_type' => 'page',
	's' => 'acf/visio-custom-posts',
	'post__not_in' => array($post_id)
));
if ( !empty( $posts_with ) ) {
	foreach ( $posts_with as $post ) {
		$blocs = parse_blocks($post->post_content);
		$bloc = array_filter($blocs, 'pc_find_block');
		$bloc = reset( $bloc );
		if ( $type['value'] == $bloc['attrs']['data']['_bloc_posts_type'] ) {
			$display = false;
			$message = 'le contenu "'.$type['label'].'" est déjà publié dans une autre page';
			break;
		}
	}
}

*/

add_action( 'acf/init', 'pc_acf_init_block_types' );

	function pc_acf_init_block_types() {

		if ( function_exists( 'acf_register_block_type' ) ) {

			/*----------  Image  ----------*/
			
			if ( apply_filters( 'pc_filter_add_acf_image_block', true ) ) {
				acf_register_block_type( 
					apply_filters( 'pc_filter_acf_image_block_args', array(
						'name'              => 'pc-image',
						'title'             => 'Image',
						'icon'              => 'format-image',
						'category'          => 'media',
						'keywords'          => array( 'image' ),
						'mode'				=> 'auto',
						'supports'			=> array(
							'align' => false,
							'anchor' => true
						),
						'render_template'   => 'include/block-editor/blocks/block_image.php',
					) )
				);
			}

			/*----------  Galerie d'images  ----------*/

			if ( apply_filters( 'pc_filter_add_acf_gallery_block', true ) ) {
				acf_register_block_type( 
					apply_filters( 'pc_filter_acf_gallery_block_args', array(
						'name'              => 'pc-gallery',
						'title'             => 'Galerie d\'images',
						'icon'              => 'format-gallery',
						'category'          => 'media',
						'keywords'          => array( 'image', 'galerie' ),
						'mode'				=> 'auto',
						'supports'			=> array(
							'align' => false,
							'anchor' => true
						),
						'render_template'   => 'include/block-editor/blocks/block_gallery.php',
					) )
				);
			}

			/*----------  Colonnes  ----------*/
					
			// if ( apply_filters( 'pc_filter_add_acf_columns_block', true ) ) {
			// 	acf_register_block_type( 
			// 		apply_filters( 'pc_filter_acf_columns_block_args', array(
			// 			'name'              => 'pc-columns',
			// 			'title'             => 'Colonnes',
			// 			'icon'              => 'columns',
			// 			'category'          => 'design',
			// 			'keywords'          => array( 'colonne', 'colonnes' ),
			// 			'mode'				=> 'auto',
			// 			'supports'			=> array(
			// 				'align' => false,
			// 				'anchor' => true
			// 			),
			// 			'render_template'   => 'include/block-editor/blocks/block_columns.php',
			// 		) )
			// 	);
			// }

			/*----------  Bouton (CTA)  ----------*/

			if ( apply_filters( 'pc_filter_add_acf_cta_block', true ) ) {
				acf_register_block_type( 
					apply_filters( 'pc_filter_acf_cta_block_args', array(
						'name'              => 'pc-cta',
						'title'             => 'Bouton (CTA)',
						'icon'              => 'button',
						'category'          => 'design',
						'keywords'          => array( 'bouton', 'cta' ),
						'mode'				=> 'auto',
						'supports'			=> array(
							'align' => false,
							'anchor' => true
						),
						'render_template'   => 'include/block-editor/blocks/block_cta.php',
					) )
				);
			}

			/*----------  Citation  ----------*/

			if ( apply_filters( 'pc_filter_add_acf_quote_block', true ) ) {
				acf_register_block_type( 
					apply_filters( 'pc_filter_acf_quote_block_args', array(
						'name'              => 'pc-quote',
						'title'             => 'Citation',
						'icon'              => 'format-quote',
						'category'          => 'design',
						'keywords'          => array( 'citation' ),
						'mode'				=> 'auto',
						'supports'			=> array(
							'align' => false,
							'anchor' => true
						),
						'render_template'   => 'include/block-editor/blocks/block_quote.php',
					) )
				);
			}

			/*----------  Contenu embarqué  ----------*/

			if ( apply_filters( 'pc_filter_add_acf_embed_block', true ) ) {
				acf_register_block_type( 
					apply_filters( 'pc_filter_acf_embed_block_args', array(
						'name'              => 'pc-embed',
						'title'             => 'Contenu embarqué',
						'icon'              => 'format-video',
						'category'          => 'media',
						'keywords'          => array( 'vidéo', 'embed' ),
						'mode'				=> 'auto',
						'supports'			=> array(
							'align' => false,
							'anchor' => true
						),
						'render_template'   => 'include/block-editor/blocks/block_embed.php',
					) )
				);
			}

			/*----------  Contenu introduction  ----------*/

			if ( apply_filters( 'pc_filter_add_acf_intro_block', true ) ) {
				acf_register_block_type(
					apply_filters( 'pc_filter_acf_intro_block_args', array(
						'name'              => 'pc-intro',
						'title'             => 'Introduction',
						'icon'              => 'info-outline',
						'category'          => 'text',
						'keywords'          => array( 'introduction', 'chapeau' ),
						'mode'				=> 'auto',
						'supports'			=> array(
							'align' => false,
							'anchor' => true
						),
						'render_template'   => 'include/block-editor/blocks/block_intro.php',
					) )
				);
			}

		}

	}