<?php
session_start();
require_once "../controller/PrepodPredmet.php";

$pred = new PrepodPredmet();

if (!isset($_SESSION['auth']) && !$_SESSION['auth'] == 'prepod') {
    header("Location: /");
}
if (isset($_GET['exit'])) {
    session_unset();
    session_destroy();
    header("Location: /");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/shadows.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#changeAddElement").change(function () {
                var numSelect = $("#changeAddElement option:selected").val();
                if (numSelect == 1) {
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "../ajax/ajax_add_predmet.php"
                    }).done(function (data) {
                        $("#selectedAddElement").html(data);
                    });
                } else if (numSelect == 2) {
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "../ajax/ajax_add_semestr.php"
                    }).done(function (data) {
                        $("#selectedAddElement").html(data);
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "../ajax/ajax_add_group.php"
                    }).done(function (data) {
                        $("#selectedAddElement").html(data);
                    });
                }
            });

            $(document).on("click", "#newGroup", function () {
                $("#writeGroup").show();
            });
        });
    </script>
</head>
<body style="background-image: url('../images/background.jpg');">

<!--MENU NAVBAR-->
<div class="container">
    <div class="row">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand">Вы вошли как преподаватель</span>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Главная</a></li>
                        <li class="active"><a href="#">Добавить</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false"><?php echo ' ' . $_SESSION['surname'] . ' ' . $_SESSION['name'] . ' ' . $_SESSION['patronic']; ?>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="settings.php">Настройки</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="?exit">Выход <span class="glyphicon glyphicon-log-out"
                                                                aria-hidden="true"></span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<!--//MENU NAVBAR-->

<div class="container shadow-left-right-bottom" style="height:800px; margin-top:-20px; padding-top: 20px; background-color: #fff">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <p style="text-align: center; font-size: medium">Добавить</p>
            <hr/>
            <select class="form-control" id="changeAddElement">
                <option disabled selected>Выберите действие</option>
                <option value="1">Предмет</option>
                <option value="2">Семестр</option>
                <option value="3">Группу</option>
            </select>
        </div>
    </div>

    <hr/>

    <div id="selectedAddElement">

    </div>
</div>

<script src="../js/bootstrap.min.js"></script>
</body>
</html>