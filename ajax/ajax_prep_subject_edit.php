<?php
    require_once "../controller/PrepodTable.php";
    $cptable = new PrepodTable();

    $cptable->changeSubject($_POST["id"], $_POST["text"]);
?>