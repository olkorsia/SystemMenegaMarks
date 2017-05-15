<?php
    require_once "../controller/AdminPrep.php";
    $caprep = new AdminPrep();

    $caprep->deletePrepFromDB($_POST["id"]);
?>