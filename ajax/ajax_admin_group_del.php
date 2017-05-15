<?php
    require_once "../controller/AdminGroup.php";
    $cagroup = new AdminGroup();

    $cagroup->deleteGroupFromDB($_POST["id"]);
?>