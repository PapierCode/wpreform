<?php
$embed = get_field( '_bloc_embed' );

if ( filter_var( $embed, FILTER_VALIDATE_URL ) ) {

	$providers = array(
		'YouTube' => 'https://policies.google.com/',
		'Dailymotion' => 'https://legal.dailymotion.com',
		'Vimeo' => 'https://vimeo.com/privacy',
	);

	$wp_oembed = null;
	if ( is_null( $wp_oembed ) ) { $wp_oembed = new WP_oEmbed(); }
	$datas = $wp_oembed->get_data($embed);

	if ( $datas && array_key_exists( $datas->provider_name, $providers ) ) {

		$block_css = array( 'bloc-embed', 'bloc-space--'.get_field('_bloc_space_v') );
		if ( isset( $block['className'] ) && '' != trim( $block['className'] ) ) { $block_css[] = $block['className']; }
		if ( 'wide' == get_field('_bloc_size') ) { $block_css[] = 'bloc-wide'; }
		
		$block_attrs = array( 'class="'.implode( ' ', $block_css ).'"' );
		if ( isset( $block['anchor'] ) && '' != trim( $block['anchor'] ) ) { $block_attrs[] = 'id="'.$block['anchor'].'"'; }

		echo '<div '.implode( ' ', $block_attrs ).'>';
			$iframe_padding = ( $datas->height / $datas->width ) * 100;
			echo '<div class="iframe" style="padding-bottom:'.$iframe_padding.'%;background-image:url('.$datas->thumbnail_url.')">';

				if ( !$is_preview ) {

					echo str_replace('src','data-src',$datas->html);
					echo '<div class="iframe-accept">';
						printf( __('<p class="">En lisant cette vidéo, vous acceptez les <a href="%1s" target="blank" rel="noreferrer">conditions générales d\'utilisation</a> de <strong>%2s</strong>.</p>'), $providers[$datas->provider_name], $datas->provider_name );
						echo '<button type="button" class="button button--arrow"><span class="ico">'.pc_svg('arrow').'</span><span class="txt">Lire la vidéo</span></button>';
					echo '</div>';

				} else {
					echo $datas->html;
				}
			echo '</div>';
		echo '</div>';

	} else { echo '<p class="editor-error">Erreur bloc <em>Vidéo</em> : la vidéo n\'a pas été trouvé, vérifiez l\'adresse de la page.</p>'; }

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Vidéo</em> : saisissez l\'adresse d\'une vidéo Youtube, Vimeo ou Dailymotion.</p>';

}