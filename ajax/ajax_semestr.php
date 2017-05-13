<?php 
	require_once "../controller/PrepodSemestr.php";
	$semestr = new PrepodSemestr();

	$semestr->selectSemestrForPredmet($_POST['id_predmet']);
?>