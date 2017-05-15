<?php
    require_once "../controller/AdminStudent.php";
    $castudent = new AdminStudent();

    $castudent->deleteStudentFromDB($_POST["id"]);
?>