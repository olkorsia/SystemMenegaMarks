<?php
    require_once "../controller/AdminPredmet.php";
    $capred = new AdminPredmet();

    $capred->changePredmet($_POST["id"], $_POST["text"]);
?>