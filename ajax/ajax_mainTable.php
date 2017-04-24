<?php
    require "../controller/PrepodTable.php";
    $mtable = new PrepodTable();

    $mtable->outputTableMarks($_POST['main_id']);
?>