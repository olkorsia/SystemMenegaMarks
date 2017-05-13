<?php
require_once "../controller/PrepodSemestr.php";
$semestr = new PrepodSemestr();

$semestr->selectSemestrOfPredmetForModal($_POST['id_predmet']);
?>