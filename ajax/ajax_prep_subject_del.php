<?php
    require_once "../controller/PrepodTable.php";
    $cptable = new PrepodTable();

    $cptable->deleteSubjectFromDB($_POST["id"]);
?>