<?php
$intro = trim(get_field('_bloc_intro_txt'));

if ( $intro ) {

	echo '<p class="bloc-intro">'.$intro.'</p>';

} else if ( $is_preview ) {

	echo '<p class="editor-error">Erreur bloc <em>Introduction</em> : saisissez le texte de l\'introduction.</p>';

}
