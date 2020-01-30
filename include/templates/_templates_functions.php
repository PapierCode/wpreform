<?php
/**
 * 
 * Templates : fonctions utiles
 * 
 ** article résumé 
 ** Partage 
 * 
 */


/*======================================
=            Article résumé            =
======================================*/

add_filter( 'excerpt_length', function() { return 30; }, 999 );
add_filter( 'excerpt_more', function() { return ''; }, 999 );

function pc_display_post_resum( $post_id, $css = '', $hn = 2 ) {

    $metas = get_post_meta($post_id);
	$title = (isset($metas['resum-title'])) ? $metas['resum-title'][0] : get_the_title($post_id);

    echo '<article class="st '.$css.'">';

    /*----------  Titre  ----------*/

    echo '<h'.$hn.' class="st-title"><a href="'.get_the_permalink($post_id).'">'.$title.'</a></h'.$hn.'>';

    /*----------  Visuel  ----------*/

    echo '<figure class="st-figure">';
    if ( isset($metas['thumbnail-img']) ) {
        echo pc_get_img($metas['thumbnail-img'][0],'st','img','st-img');
    } else {
        echo pc_get_default_st('st-img');
    }
    echo '</figure>';

    /*----------  Ajout par plugin ou thème enfant  ----------*/
    
    do_action( 'pc_display_post_resum_more', $post_id );


    /*----------  Description + lire la suite  ----------*/		
    
    $resum = (isset($metas['resum-desc'])) ? wp_trim_words($metas['resum-desc'][0],30,'') : get_the_excerpt($post_id) ;
    echo '<p>'.$resum.'... <a class="st-more" href="'.get_the_permalink($post_id).'" title="Lire la suite de '.$title.'">Lire la suite</a></p>';

	echo '</article>';
	
};


/*=====  FIN Article résumé  =====*/

/*===============================
=            Partage            =
===============================*/

function pc_display_share_links() {

    $share_url = 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    global $meta_title, $meta_description; // cf. pc_metas_seo_and_social()

    ?>

    <div class="share no-print">
        <p class="share-title">Partage&nbsp;: </p>
        <ul class="share-list reset-list">
            <li class="share-item">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($share_url); ?>" target="_blank" class="share-link share-link--fb" rel="nofollow" title="Partager sur Facebook (nouvelle fenêtre)">
                    <span class="visually-hidden">Facebook</span>
                    <?php echo pc_svg('facebook', false, 'svg-block'); ?>
                </a>
            </li>
            <li class="share-item">
                <a href="http://twitter.com/intent/tweet?url=<?= urlencode($share_url); ?>" target="_blank" class="share-link share-link--tw" rel="nofollow" title="Partager sur Twitter (nouvelle fenêtre)">
                    <span class="visually-hidden">Twitter</span>
                    <?php echo pc_svg('twitter', false, 'svg-block'); ?>
                </a>
            </li>
            <li class="share-item">
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($share_url); ?>&title=<?= str_replace(' ', '%20', $meta_title); ?>&summary=<?= str_replace(' ', '%20', $meta_description); ?>" target="_blank" class="share-link share-link--in" rel="nofollow" title="Partager sur LinkedIn (nouvelle fenêtre)">
                <span class="visually-hidden">LinkedIn</span>
                <?php echo pc_svg('linkedin', '#fff', 'svg-block'); ?>
                </a>
            </li>
        </ul>
    </div>

<?php }


/*=====  FIN Partage  =====*/