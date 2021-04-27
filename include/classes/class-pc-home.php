<?php

class PC_Home {

	public $title;			// string
	public $permalink;		// string
	public $metas;			// array

	public $has_image;		// bool
	public $is_fullscreen;	// bool
	

	/*=================================
	=            Construct            =
	=================================*/
	
	public function __construct ( ) {

		$this->metas 		= get_option('home-settings-option');
		$this->title 		= $this->metas['content-title'];
		$this->permalink 	= get_bloginfo('url');

		// test image associée
		$this->has_image = ( isset( $this->metas['visual-id'] ) && '' != $this->metas['visual-id'] && is_object( get_post( $this->metas['visual-id'] ) ) ) ? true : false;

		// test fullscreen
		$this->is_fullscreen = ( $this->has_image && isset( $this->metas['visual-fullscreen'] ) ) ? true : false;

	}
 
	
	/*=====  FIN Construct  =====*/

	/*====================================
	=            SEO & Social            =
	====================================*/
	
	/**
	 * 
	 * [SEO & SOCIAL] Titre
	 * 
	 * @return string Méta seo-title | $this->title
	 * 
	 */
	public function get_seo_meta_title() {

		$metas = $this->metas;
		global $settings_project;

		$title = ( isset( $metas['seo-title'] ) && '' != $metas['seo-title'] ) ? $metas['seo-title'] : $this->title.' - '.$settings_project['coord-name'];
		
		return $title;
	
	}

	/**
	 * 
	 * [SEO & SOCIAL] Description
	 * 
	 * @return string Méta seo-desc | Métas content-txt | Paramétre Projet seo-desc
	 * 
	 */
	public function get_seo_meta_description() {

		$metas = $this->metas;
		global $texts_lengths;

		if ( isset( $metas['seo-desc'] ) && '' != $metas['seo-desc'] ) {

			$description = $metas['seo-desc'];
			
		} else if ( isset( $metas['content-txt'] ) && '' != $metas['content-txt'] ) {
			
			$description = $metas['content-txt'];

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
	 * @return	array	get_seo_title()
	 * 					get_seo_description()
	 * 					get_image_to_share()
	 * 
	 */
	public function get_seo_metas() {

		// titre
		$metas['title'] = $this->get_seo_meta_title();
		// description
		$metas['description'] = $this->get_seo_meta_description();
		// image
		$metas['image'] = $this->get_seo_meta_image_datas();
		// url
		$metas['permalink'] = $this->permalink;

		return $metas;

	}

	
	/*=====  FIN SEO & Social  =====*/

}

