<?php
    require_once "../controller/AdminStudent.php";
    $castudent = new AdminStudent();

    $castudent->changeStudent($_POST["id"], $_POST["text"], $_POST["column_name"]);
?>