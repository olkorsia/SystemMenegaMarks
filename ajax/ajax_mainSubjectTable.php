<?php
    require_once "../controller/PrepodTable.php";
    $mtable = new PrepodTable();

    $mtable->outputMainTableSubject($_POST['id_predmet'], $_POST['semestr'], $_POST['id_group']);
?>