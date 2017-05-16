<?php
    require_once "../controller/PrepodManageStudent.php";
    $cpprepstudent = new PrepodManageStudent();

    $cpprepstudent->addNewStudentToDB($_POST["surname_student"], $_POST["name_student"], $_POST["patronic_student"]);
?>