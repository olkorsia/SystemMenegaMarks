<?php
session_start();
require "../controller/GuestFindStudent.php";
$gfs = new GuestFindStudent();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <style type="text/css">
        .selectorMargin {
            margin-right: 4px;
            margin-left: 4px;
        }
    </style>
</head>
<body>

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
                    <span class="navbar-brand">Вы вошли как гость</span>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/">Выйти на главную</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<!--MENU NAVBAR-->


<div class="container">
    <div>
        <form method="POST" class="form-inline">
            <div class="form-group">
                <p class="form-control-static"><strong>Введите фамилию студента: </strong></p>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="inputSearch" placeholder="Поиск">
            </div>
            <button type="submit" class="btn btn-default" name="sendSearchSurname">Искать</button>
        </form>
    </div>
    <br/>
    <div>
        <?php
        if (isset($_POST['inputSearch'])) {
            $gfs->search($_POST['inputSearch']);
        }
        ?>
    </div>

    <?php
    if (isset($_POST['selectVal'])) {
        $gfs->selectSurnameStudent($_POST['selectVal']);
    }
    ?>

    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
