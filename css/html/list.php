<?php
$html_class = 'list';
include '_head.php';
?>

<div class="fs-bloc fs-bloc--editor"><div class="editor">
	<p>Quam ob rem circumspecta cautela observatum est deinceps et cum edita montium petere coeperint grassatores, loci iniquitati milites cedunt. ubi autem in planitie potuerint reperiri, quod contingit adsidue, nec exsertare lacertos nec crispare permissi tela, quae vehunt bina vel terna, pecudum ritu inertium trucidantur.</p></p>
</div></div>

<?php for ($i=1; $i <= 6; $i++) {
include '_cpt-st.php';
} ?>
					
<footer class="main-footer fs-bloc">

	<?php
	include '_cpt-pager.php';
	include '_cpt-share.php';
	?>

</footer>
			
<?php include '_footer.php'; ?>