<?php

/**
*
* Formulaire pour filtrer les actualités
*
**/

?>

<form method="get" class="st-filter" action="<?= get_post_type_archive_link(NEWS_POST_SLUG) ?>">
	
	<?php 
		// toutes les catégories (non vide)
		$allNewsTax = get_terms( array( 'taxonomy' => NEWS_TAX_SLUG, 'hide_empty' => true )	);
	?>

	<label class="st-filter-label" for="newscat">Catégories :</label>
	<select id="newscat" name="newscat" class="st-filter-select">
		<option value="">Toutes les catégories</option>
		<?php foreach ($allNewsTax as $tax) { echo '<option value="'.$tax->slug.'"'.selected(get_query_var('newscat'),$tax->slug, false).'>'.$tax->name.'</option>'; } ?>
	</select>
	<button type="submit" class="st-filter-submit">Filtrer</button>
		
</form>