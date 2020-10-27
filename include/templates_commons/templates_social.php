<?php
/**
 * 
 * Fonctions réseaux sociaux
 * 
 ** Partage
 * 
 */


/*==================================
=            Partage RS            =
==================================*/

function pc_display_share_links() {

    $share_url = 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    global $meta_title, $meta_description; // cf. pc_metas_seo_and_social()

    ?>

    <div class="social-share no-print">
        <p class="social-share-title">Partage&nbsp;: </p>
        <ul class="social-list social-list--share reset-list">
            <li class="social-item">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($share_url); ?>" target="_blank" class="social-link social-link--facebook" rel="nofollow" title="Partager sur Facebook (nouvelle fenêtre)">
                    <span class="visually-hidden">Facebook</span>
                    <?php echo pc_svg('facebook'); ?>
                </a>
            </li>
            <li class="social-item">
                <a href="http://twitter.com/intent/tweet?url=<?= urlencode($share_url); ?>" target="_blank" class="social-link social-link--twitter" rel="nofollow" title="Partager sur Twitter (nouvelle fenêtre)">
                    <span class="visually-hidden">Twitter</span>
                    <?php echo pc_svg('twitter'); ?>
                </a>
            </li>
            <li class="social-item">
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($share_url); ?>&title=<?= str_replace(' ', '%20', $meta_title); ?>&summary=<?= str_replace(' ', '%20', $meta_description); ?>" target="_blank" class="social-link social-link--linkedin" rel="nofollow" title="Partager sur LinkedIn (nouvelle fenêtre)">
                <span class="visually-hidden">LinkedIn</span>
                <?php echo pc_svg('linkedin'); ?>
                </a>
            </li>
        </ul>
    </div>

<?php }


/*=====  FIN Partage RS  =====*/