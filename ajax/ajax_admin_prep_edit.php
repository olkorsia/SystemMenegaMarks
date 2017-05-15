<?php
    require_once "../controller/AdminPrep.php";
    $caprep = new AdminPrep();

    $caprep->changePrep($_POST["id"], $_POST["text"], $_POST["column_name"]);
?>