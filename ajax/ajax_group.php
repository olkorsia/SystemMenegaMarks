<?php
    require "../controller/PrepodGroup.php";
    $group = new PrepodGroup();

    $group->selectGroupForPredmet($_POST['id_predmet'], $_POST['semestr']);
?>