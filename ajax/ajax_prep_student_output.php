<?php
    require_once "../controller/PrepodManageStudent.php";
    $cpprepstudent = new PrepodManageStudent();

    $cpprepstudent->outputTableStudent($_POST["group_id"]);
?>