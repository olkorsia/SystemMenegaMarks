<?php
    require_once "../controller/PrepodTable.php";
    $cptable = new PrepodTable();

    $cptable->changeMark($_POST["id"], $_POST["text"]);
?>