<?php
    require_once "../controller/AdminPredmet.php";
    $capred = new AdminPredmet();

    $capred->deletePredmetFromDB($_POST["id"]);
?>