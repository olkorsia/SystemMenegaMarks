<?php
    require_once "../controller/PrepodTable.php";
    $cptable = new PrepodTable();

    $cptable->addNewSubjectToDB($_POST["subject_name"], $_POST["main_id"]);
?>