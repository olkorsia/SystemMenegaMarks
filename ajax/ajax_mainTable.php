<?php
    require "../controller/PrepodTable.php";
    $mtable = new PrepodTable();

    $mtable->outputTableMarks($_POST['id_predmet'], $_POST['semestr'], $_POST['id_group']);
?>