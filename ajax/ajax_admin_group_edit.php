<?php
    require_once "../controller/AdminGroup.php";
    $cagroup = new AdminGroup();

    $cagroup->changeGroup($_POST["id"], $_POST["text"], $_POST["column_name"]);
?>