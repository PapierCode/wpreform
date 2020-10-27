<?php 



/*==============================
=            Résumé            =
==============================*/

function pc_get_page_excerpt( $post_id, $post_metas, $seo_for = false ) {

	if ( $seo_for && isset( $post_metas['seo-desc'] ) && $post_metas['seo-desc'][0] != '' ) {

		$excerpt = $post_metas['seo-desc'][0];

	} else if ( isset( $post_metas['resum-desc'] ) && $post_metas['resum-desc'][0] != '' ) {

		$excerpt = $post_metas['resum-desc'][0];

	} else {

		$excerpt = get_the_excerpt( $post_id );
	}
	
	return $excerpt;

}


/*=====  FIN Résumé  =====*/

/*==============================================
=            Sous-page, lien retour            =
==============================================*/

function pc_display_subpage_backlink( $post ) {

    if ( $post->post_type == 'page' && $post->post_parent > 0 ) {

        echo '<nav class="main-footer-nav"><a href="'.get_the_permalink($post->post_parent).'" class="btn" title="Page précédente">'.pc_svg('arrow').'<span>Retour</span></a></nav>';

    }

}


/*=====  FIN Sous-page, lien retour  =====*/

