<?php

class PC_Post {

	public $wp_post;		// objet

	public $id;				// int
	public $type;			// string
	public $author;			// int
	public $parent;			// int
	public $title;			// string
	public $content;		// string

	public $permalink;		// string
	public $metas;			// array
	
	public $has_image;		// bool
	public $is_fullscreen;	// bool


	/*=================================
	=            Construct            =
	=================================*/
	
	public function __construct ( $post ) {

		// WP_post
		$this->wp_post 		= $post;
		$this->id 			= $post->ID;
		$this->type 		= $post->post_type;
		$this->author 		= $post->post_author;
		$this->parent 		= $post->post_parent;
		$this->title 		= $post->post_title;
		$this->content 		= $post->post_content;

		// url
		$this->permalink = get_the_permalink( $post->ID );

		// métas
		$this->metas = get_post_meta( $post->ID );
		// simplification tableau métas
		foreach ( $this->metas as $key => $value) {
			$this->metas[$key] = implode('', $this->metas[$key] );
		}

		// test image associée
		$this->use_woo_product_image(); // si le post est un produit WooCommerce
		$this->has_image = ( isset( $this->metas['visual-id'] ) && is_object( get_post( $this->metas['visual-id'] ) ) ) ? true : false;
		
		// test fullscreen
		$this->is_fullscreen = ( $this->has_image && isset( $this->metas['visual-fullscreen'] ) ) ? true : false;

	}

	
	/*=====  FIN Construct  =====*/

	/*=================================
	=            Canonical            =
	=================================*/
	
	/**
	 * 
	 * [CANONICAL] Méta link canonical
	 * 
	 * @return string string url
	 * 
	 */
	public function get_canonical() {

		$canonical = $this->permalink;

		if ( 'page' == $this->type && get_query_var( 'paged' ) && get_query_var( 'paged' ) > 1 ) {

			$canonical = $this->permalink.'page/'.get_query_var( 'paged' ).'/';

		}

		return apply_filters( 'pc_filter_post_canonical', $canonical, $this );

	}
	
	
	/*=====  FIN Canonical  =====*/

	/*============================
	=            Date            =
	============================*/
	
	/**
	 * 
	 * [DATE] De création ou modification
	 * 
	 * @param	string	$format		Cf. php date	
	 * @param	bool	$modified	Date de modification ?
	 * 
	 * @return	string 	Date traduite
	 * 
	 */
	public function get_date( $format = 'j F Y', $modified = false ) {

		$date = ( !$modified ) ? $this->wp_post->post_date : $this->wp_post->post_modified;
		return date_i18n( $format, strtotime( $date ) );

	}
	
	
	/*=====  FIN Date  =====*/

	/*==============================
	=            Résumé            =
	==============================*/
	
	/**
	 * 
	 * [RESUMÉ] Titre
	 * 
	 * @return string Méta resum-title | titre du post | '(sans titre)'
	 * 
	 */
	public function get_card_title() {

		$metas = $this->metas;
		$title = ( isset( $metas['resum-title'] ) ) ? $metas['resum-title'] : $this->title;
		$title = apply_filters( 'pc_filter_card_title', $title, $this );

		global $texts_lengths;
		return pc_words_limit( $title, $texts_lengths['resum-title'] );

	}

	/**
	 * 
	 * [RESUMÉ] Description
	 * 
	 * @return string Méta resum-desc | wp_excerpt | empty
	 * 
	 */
	public function get_card_description() {

		$metas = $this->metas;
		$description = ( isset( $metas['resum-desc'] ) ) ? $metas['resum-desc'] : get_the_excerpt( $this->id );
		$description = apply_filters( 'pc_filter_card_description', $description, $this );
	
		global $texts_lengths;
		return pc_words_limit( $description, $texts_lengths['resum-desc'] );
	
	}

	/**
	 * 
	 * [RESUMÉ] Urls & attribut alt de la vignette
	 * 
	 * @return 	array 	array 	urls st-400/st-500/st-700	Méta visual-id | default
	 * 					string	attribut alt				Méta _wp_attachment_image_alt | get_card_title()
	 * 
	 */
	public function get_card_image_datas() {

		$metas = $this->metas;

		if ( $this->has_image ) {
			
			$image_datas['sizes'] = apply_filters( 'pc_filter_card_image_sizes', array(
				'400' => wp_get_attachment_image_src( $metas['visual-id'], 'st-400' ),
				'500' => wp_get_attachment_image_src( $metas['visual-id'], 'st-500' ),
				'700' => wp_get_attachment_image_src( $metas['visual-id'], 'st-700' )
			), $metas['visual-id'], $this );
			
			$image_alt = get_post_meta( $metas['visual-id'], '_wp_attachment_image_alt', true );
			$image_datas['alt'] = ( '' != $image_alt ) ? $image_alt : $this->get_card_title();
		
		} else {

			$image_datas['sizes'] = pc_get_default_card_image();
			$image_datas['alt'] = $this->get_card_title();

		}
		
		return $image_datas;
	
	}
	
	/**
	 * 
	 * [RESUMÉ] Affichage vignette
	 * 
	 * @return string HTML
	 * 
	 */
	public function display_card_image() {

		$image_datas = $this->get_card_image_datas();
		$sizes_count = count( $image_datas['sizes'] );
		$last_size_key = array_key_last($image_datas['sizes']);

		$image_attrs = array(
			'src="'.$image_datas['sizes'][$last_size_key][0].'"',
			'alt="'.$image_datas['alt'].'"',
			'width="'.$image_datas['sizes'][$last_size_key][1].'"',
			'height="'.$image_datas['sizes'][$last_size_key][2].'"',
			'loading="lazy"'
		);
	
		if ( $sizes_count > 1 ) {
			
			$attr_srcset = array();
			foreach ( $image_datas['sizes'] as $size => $attachment ) {
				$attr_srcset[] = $attachment[0].' '.$size.'w';
			}
			$image_attrs[] = 'srcset="'.implode(', ',$attr_srcset).'"';

			$attr_sizes = apply_filters( 'pc_filter_card_image_sizes_attribut', '(max-width:400px) 400px, (min-width:401px) and (max-width:700px) 700px, (min-width:701px) 500px', $image_datas, $this );
			$image_attrs[] = 'sizes="'.$attr_sizes.'"';

		}
		
		$tag = apply_filters( 'pc_filter_card_image', '<img '.implode( ' ', $image_attrs ).' />', $image_datas, $this );
		
		echo $tag;
	
	}
	
	/**
	 * 
	 * [RESUMÉ] Affichage résumé complet
	 * 
	 * @param	int		$title_level	Niveau du titre
	 * @param	string	$classes_css	Classes css
	 * 
	 * @return	string	HTML
	 * 
	 */

	public function display_card( $title_level = 2, $classes_css = 'st-inner', $params = array() ) {

		$metas = $this->metas;
	
		// titre
		$title = $this->get_card_title();

		// lien
		$href = $this->permalink;
		$href_params = apply_filters( 'pc_filter_card_link_params', array(), $this );
		if ( !empty( $href_params ) ) {
			$href .= ( false === strpos( $href, '?' ) ) ? '?' : '&';
			$param_index = 0;
			foreach ( $href_params as $param => $value ) {
				if ( $param_index > 0 ) { $href .= '&'; }
				$href .= $param.'='.$value;
				$param_index++;
			}
		}
		$link_tag_start = '<a href="'.$href.'" class="st-link" title="Lire la suite de : '.$title.'">';
		$link_position = apply_filters( 'pc_filter_post_card_link_position', 'title', $this ); // title || st-inner

		// description
		$description = $this->get_card_description();

		// filtres call to action
		$ico_more = apply_filters( 'pc_filter_card_ico_more', pc_svg('arrow'), $this );	
		$ico_more_display = apply_filters( 'pc_filter_card_ico_more_display', true, $this );
		$read_more_display = apply_filters( 'pc_filter_card_read_more_display', false, $this );
		
		
		/*----------  Affichage  ----------*/
		
		echo '<article class="'.$classes_css.'">';
	
			if ( 'st-inner' == $link_position ) { echo $link_tag_start; }
	
				// hook
				do_action( 'pc_post_card_after_start', $this, $params );
			
				echo '<figure class="st-figure">';
					$this->display_card_image();				
				echo '</figure>';

				// hook	
				do_action( 'pc_post_card_after_figure', $this, $params );
	
				echo '<h'.$title_level.' class="st-title">';
					if ( 'title' == $link_position ) {
						echo $link_tag_start.$title.'</a>';
					} else {
						echo $title;
					}
				echo '</h'.$title_level.'>';	
	
				// hook	
				do_action( 'pc_post_card_after_title', $this, $params );
				
				if ( '' != $description ) {
					echo '<p class="st-desc">';
						echo $description;
						if ( $ico_more_display ) { echo ' <span class="st-desc-ico">'.$ico_more.'</span>';	}	
					echo '</p>';
				}

				// hook
				do_action( 'pc_post_card_after_desc', $this, $params );
				
				if ( $read_more_display ) {
					echo '<div class="st-read-more" aria-hidden="true"><span class="st-read-more-ico">'.$ico_more.'</span> <span class="st-read-more-txt">Lire la suite</span></a></div>';
				}
			
				// hook
				do_action( 'pc_post_card_before_end', $this, $params );
	
			if ( 'st-inner' == $link_position ) { echo '</a>'; }
		
		echo '</article>';
		
	}	
	
	
	/*=====  FIN Résumé  =====*/

	/*====================================
	=            SEO & Social            =
	====================================*/

	/**
	 * 
	 * [SEO & SOCIAL] Titre
	 * 
	 * @return string Méta seo-title | get_card_title()
	 * 
	 */
	public function get_seo_meta_title() {

		$metas = $this->metas;

		$title = ( isset( $metas['seo-title'] ) ) ? $metas['seo-title'] : $this->get_card_title();

		if ( 'page' == $this->type && get_query_var( 'paged' ) ) {
			$title .= ' - Page '.get_query_var( 'paged' );	
		}

		global $settings_project;
		$title .= ' - '.$settings_project['coord-name'];
		
		return $title;
	
	}

	/**
	 * 
	 * [SEO & SOCIAL] Description
	 * 
	 * @return string Méta seo-desc | get_card_description()
	 * 
	 */
	public function get_seo_meta_description() {

		$metas = $this->metas;
		
		if ( isset( $metas['seo-desc'] ) ) {
			
			$description = $metas['seo-desc'];
			
		} else if ( '' != $this->get_card_description() ) {

			$description = $this->get_card_description();

		} else {

			global $settings_project;
			$description = $settings_project['seo-desc'];

		}
		
		global $texts_lengths;
		return pc_words_limit( $description, $texts_lengths['seo-desc'] );
	
	}

	/**
	 * 
	 * [SEO & SOCIAL] Url et dimensions de l'image
	 * 
	 * @return array 	méta visual-id | default
	 * 					Url/width/height 
	 * 
	 */
	public function get_seo_meta_image_datas() {

		$metas = $this->metas;
		$image = ( $this->has_image ) ? wp_get_attachment_image_src( $metas['visual-id'], 'share' ) : pc_get_default_image_to_share();
		
		return $image;
	
	}

	/**
	 * 
	 * [SEO & SOCIAL] Titre, Description, Image
	 * 
	 * @param 	array	$seo_metas	Valeurs par défaut
	 * 
	 * @return	array	get_seo_meta_title()
	 * 					get_seo_meta_description()
	 * 					get_seo_meta_image_datas()
	 * 
	 */
	public function get_seo_metas( ) {

		// titre
		$metas['title'] = $this->get_seo_meta_title();
		// description
		$metas['description'] = $this->get_seo_meta_description();
		// image
		$metas['image'] = $this->get_seo_meta_image_datas();
		// url
		$metas['permalink'] = $this->get_canonical();

		return $metas;

	}
	
	
	/*=====  FIN SEO & Social  =====*/

	/*===========================================
	=            Données structurées            =
	===========================================*/
	
	/**
	 * 
	 * [SCHÉMA] Auteur
	 * 
	 * @param	bool	$is_part_of	Schéma Article (true) | itemListElement (false)
	 * 
	 * @return	array	Pour conversion JSON
	 * 
	 */
	public function get_schema_author() {

		global $settings_project;

		$author_first_name = get_the_author_meta( 'first_name', $this->author );
		$author_last_name = get_the_author_meta( 'last_name', $this->author );
	
		if ( isset( $settings_project['seo-author-default'] ) || '' == $author_first_name ) {
			$author_first_name = $settings_project['seo-author-first-name'];
		}
		if ( isset( $settings_project['seo-author-default'] ) || '' == $author_last_name ) {
			$author_last_name = $settings_project['seo-author-last-name'];
		}
	
		$author = array(
			'@type' => 'Person',
			'name' => $author_first_name.' '.$author_last_name
		);

		// filtre
		$author = apply_filters( 'pc_filter_post_schema_author', $author, $this );
	
		return $author;

	}
	
	/**
	 * 
	 * [SCHÉMA] Article
	 * 
	 * @param	bool	$is_part_of	
	 * 
	 * @return	array	Pour conversion JSON
	 * 
	 */
	public function get_schema_article( $is_part_of = false ) {

		global $settings_project;
			
		$image_to_share = $this->get_seo_meta_image_datas();		

		// données structurées
		$schema = array(
			'@type' => 'Article',
			'url' => $this->get_canonical(),
			'datePublished' => $this->get_date( 'c' ),
			'dateModified' => $this->get_date( 'c', true ),
			'headline' => $this->get_seo_meta_title(),
			'description' => $this->get_seo_meta_description(),
			'mainEntityOfPage'	=> $this->get_canonical(),
			'image' => array(
				'@type'		=>'ImageObject',
				'url' 		=> $image_to_share[0],
				'width' 	=> $image_to_share[1],
				'height' 	=> $image_to_share[2]
			),
			'author' => $this->get_schema_author(),
			'publisher' => pc_get_schema_publisher(),
			'isPartOf' => pc_get_schema_website()
		);

		if( !$is_part_of ) { $schema = array_merge( array('@context' =>'http://schema.org'), $schema ); }
		
		// filtre
		$schema = apply_filters( 'pc_filter_post_schema_article', $schema, $this );

		return $schema;

	}
	
	/**
	 * 
	 * [SCHÉMA] ListItem
	 * 
	 * @param	int		$position	Position dans la liste
	 * 
	 * @return	array	Pour conversion JSON
	 * 
	 */
	public function get_schema_list_item( $position ) {

		$image_to_share = $this->get_seo_meta_image_datas();	

		$schema = array(
			'@type' => 'ListItem',
			'name' => $this->get_seo_meta_title(),
			'description' => $this->get_seo_meta_description(),
			'url' => $this->get_canonical(),
			'position' => $position,
			'image' => array(
				'@type'		=>'ImageObject',
				'url' 		=> $image_to_share[0],
				'width' 	=> $image_to_share[1],
				'height' 	=> $image_to_share[2]
			)
		);

		return $schema;

	}
	
	
	/*=====  FIN Données structurées  =====*/

	/*===================================
	=            WooCommerce            =
	===================================*/
	
	/**
	 * 
	 * [WOO] Image produit
	 * 
	 */
	private function use_woo_product_image() {

		if ( in_array( $this->type, array('product','product_variation') ) ) {
		
			if ( isset( $this->metas['_thumbnail_id'] ) && $this->metas['_thumbnail_id'] > 0 ) {

				$this->metas['visual-id'] = $this->metas['_thumbnail_id'];

			} else if ( 'product_variation' == $this->type ) {

				$parent_image_id = get_post_meta( $this->parent, '_thumbnail_id', true );
				if ( '' != $parent_image_id && $parent_image_id > 0 ) { $this->metas['visual-id'] = $parent_image_id; }

			}

		}

	}
	
	
	/*=====  FIN WooCommerce  =====*/

}

