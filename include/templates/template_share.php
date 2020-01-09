<?php

/**
*
* Partage sur les réseaux sociaux
*
**/


$currentUrlToShare = 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
global $title, $description;

?>

<div class="share no-print">
	<p class="share-title">Partage&nbsp;: </p>
	<ul class="share-list reset-list">
		<li class="share-item">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($currentUrlToShare); ?>" target="_blank" class="share-link share-link--fb" rel="nofollow" title="Partager sur Facebook (nouvelle fenêtre)">
				<span class="visually-hidden">Facebook</span>
				<?php echo pc_svg('facebook', false, 'svg-block'); ?>
			</a>
		</li>
		<li class="share-item">
			<a href="http://twitter.com/intent/tweet?url=<?= urlencode($currentUrlToShare); ?>" target="_blank" class="share-link share-link--tw" rel="nofollow" title="Partager sur Twitter (nouvelle fenêtre)">
				<span class="visually-hidden">Twitter</span>
				<?php echo pc_svg('twitter', false, 'svg-block'); ?>
			</a>
		</li>
		<li class="share-item">
			<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($currentUrlToShare); ?>&title=<?= str_replace(' ', '%20', $title); ?>&summary=<?= str_replace(' ', '%20', $description); ?>" target="_blank" class="share-link share-link--in" rel="nofollow" title="Partager sur LinkedIn (nouvelle fenêtre)">
			<span class="visually-hidden">LinkedIn</span>
			<?php echo pc_svg('linkedin', '#fff', 'svg-block'); ?>
			</a>
		</li>
	</ul>
</div>
