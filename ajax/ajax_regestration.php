<?php
    require_once "../controller/Registration.php";
    $reg = new Registration();

    $reg->registration($_POST["name"], $_POST["surname"], $_POST["patronic"], $_POST["numberPhone"], $_POST["login"], $_POST["password"]);
?>