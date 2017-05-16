<?php
    require_once "../controller/GuestTablePredmet.php";
    $cgptable = new GuestTablePredmet();

    $cgptable->tableOnThePredmet($_POST["id_predmet"]);
?>