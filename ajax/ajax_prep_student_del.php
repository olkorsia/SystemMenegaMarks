<?php
    require_once "../controller/PrepodManageStudent.php";
    $cpprepstudent = new PrepodManageStudent();

    $cpprepstudent->deleteStudentFromDB($_POST["id"]);
?>