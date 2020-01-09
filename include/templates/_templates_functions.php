<?php
/**
 * 
 * Templates : fonctions utiles
 * 
 * * article résumé (html) par id
 * * calendrier
 * 
 */


/*======================================
=            Article résumé            =
======================================*/

add_filter( 'excerpt_length', function() { return 30; }, 999 );
add_filter( 'excerpt_more', function() { return ''; }, 999 );

function pc_get_post_resum( $postId, $classCss = '', $hn = 2, $date = false, $tax = false ) {

	// datas
    $postResumMetas = get_post_meta($postId);
    
	$postResumTitle = (isset($postResumMetas['resum-title'])) ? $postResumMetas['resum-title'][0] : get_the_title($postId);

    echo '<article class="st '.$classCss.'">';

    /*----------  Titre  ----------*/

    echo '<h'.$hn.' class="st-title"><a href="'.get_the_permalink($postId).'">'.$postResumTitle.'</a></h'.$hn.'>';

    /*----------  Visuel  ----------*/

    echo '<figure class="st-figure">';
    if ( isset($postResumMetas['thumbnail-img']) ) {
        echo pc_get_img($postResumMetas['thumbnail-img'][0],'st','img','st-img');
    } else {
        echo pc_get_default_st('st-img');
    }
    echo '</figure>';

    /*----------  Date  ----------*/

    if ( $date ) {
        echo '<time class="st-date" datetime="'.get_the_date('c',$postId).'">Publié le '.get_the_date('',$postId).'</time>';
    }

    /*----------  Taxonomy  ----------*/

    if ( $tax && taxonomy_exists( NEWS_TAX_SLUG ) ) {

        // (array of objets) toutes les taxonomies 'newscategories' attachées au post
        $postResumTax = wp_get_post_terms( $postId, NEWS_TAX_SLUG, array( "fields" => "all" ) );

        // si il y a au moins une tax
        if ( count( $postResumTax ) > 0 ) {

            echo '<ul class="st-tax-list">';
            foreach ( $postResumTax as $postResumTaxKey => $postResumTaxValue ) {
                echo '<li class="reset-list st-tax-list-item"><a class="st-tax-list-link" href="'.pc_get_page_by_custom_content(NEWS_POST_SLUG).'?'.NEWS_TAX_QUERY_VAR.'='.$postResumTaxValue->slug.'" title="Tous les actualités publiées dans '.$postResumTaxValue->name.'" rel="nofollow">'.$postResumTaxValue->name.'</a></li>';
            }
            echo '</ul>';

        }

    }

    /*----------  Description + lire la suite  ----------*/		
    
    $postResumDesc = (isset($postResumMetas['resum-desc'])) ? wp_trim_words($postResumMetas['resum-desc'][0],30,'') : get_the_excerpt($postId) ;
    echo '<p>'.$postResumDesc.'... <a class="st-more" href="'.get_the_permalink($postId).'" title="Lire la suite de '.$postResumTitle.'">Lire la suite</a></p>';

	echo '</article>';
	
};


/*=====  FIN Article résumé  =====*/

/*==================================
=            Calendrier            =
==================================*/

$monthsList             = array('janvvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre');
$monthsListShort        = array('janv.','févr.','mars','avr.','mai','juin','juill.','août','sept.','oct.','nov.','déc.');
$daysList               = array('dimanche','lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
$daysListShort          = array('Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.', 'Dim.');
$DaysListFirstLetter    = array('L','M','M','J','V','S','D');

function pc_build_calendar( $month, $year, $dates, $url ) {

    // données en FR
    global $daysListShort;
    global $monthsList;

    $currentDay = 1; // compteur des jours
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year); // timestamp du 1er jour du mois
    $numberDays = date('t',$firstDayOfMonth); // nombre de jour dans le mois
    $dateComponents = getdate($firstDayOfMonth); // détails sur le 1er jour du mois
    $monthName = ucfirst($monthsList[$month-1]); // nom du mois
    $month = str_pad($month, 2, "0", STR_PAD_LEFT); // complete le chiffre du mois, exemple : 2 devient 02

    // variable qui limite le tableau à 7 colonnes
    // en php la semaine commence un dimanche, mais là on veut lundi
    // -1 pour  tout décaler
    $dayOfWeek = $dateComponents['wday'] - 1;
    // si négatif, on prend le samedi
    if ($dayOfWeek < 0) { $dayOfWeek = 6; }

    // entête du tableau
    $calendar = '<table class="cal">';
    $calendar .= '<tr>';
    foreach($daysListShort as $day) { $calendar .= '<th class="cal-cell cal-cell--day">'.$day.'</th>'; }
    $calendar .= '</tr>';

    // corps du tableau, début de la 1re ligne
    $calendar .= '<tr>';
    // si le 1er n'est pas un lundi
    // fusionne autant de cellule que de jours sépare le lundu du 1er
    if ($dayOfWeek > 0) { $calendar .= '<td colspan="'.$dayOfWeek.'">&nbsp;</td>'; }

    // c'est parti, tant que le compteur des jours est inférieur ou égale au nombre de jour du mois
    while ($currentDay <= $numberDays) {

        // fin de semaine, nouvelle ligne
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT); //complete le chiffre du jour, exemple : 2 devient 02
        $date = "$year-$month-$currentDayRel"; // date courante YYYY-MM-DD

        // si la date courante existe dans le tableau passé en paramètre
        if ( in_array($date, $dates)) {
            $calendar .= '<td class="cal-cell cal-cell--number cal-cell--link"><a href="'.$url.'&date='.$date.'" title="Afficher les événements de cette date" class="cal-link" rel="nofollow">'.$currentDay.'</a></td>';
        } else {
            $calendar .= '<td class="cal-cell cal-cell--number">'.$currentDay.'</td>';
        }

        // MAJ compteur
        $currentDay++;
        $dayOfWeek++;

    }

    // compléte le tableau si le mois ne s'arrête pas un dimanche
    if ($dayOfWeek != 7) {
        $remainingDays = 7 - $dayOfWeek; // jours restant
        $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
    }

    $calendar .= "</tr>";
    $calendar .= "</table>";

    return $calendar;

}


/*=====  FIN Calendrier  ======*/