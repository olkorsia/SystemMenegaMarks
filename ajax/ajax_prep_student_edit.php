<?php
    require_once "../controller/PrepodManageStudent.php";
    $cpprepstudent = new PrepodManageStudent();

    $cpprepstudent->changeStudent($_POST["id"], $_POST["text"], $_POST["column_name"]);
?>