<?php
session_start();
require "../controller/PrepodPredmet.php";
require "../controller/PrepodSemestr.php";
//require "../controller/PrepodGroup.php";
//require "../controller/PrepodTable.php";

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
                    <span class="navbar-brand">Вы вошли как преподователь</span>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.html">Предметы</a></li>
                        <li><a href="#">Семестры</a></li>
                        <li><a href="#">Группы</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <p class="navbar-text"><?php echo ' ' . $_SESSION['surname'] . ' ' . $_SESSION['name'] . ' ' . $_SESSION['patronic']; ?></p>
                        </li>
                        <li><a href="#">Настройки</a></li>
                        <li><a href="?exit">Выход</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<!--//MENU NAVBAR-->

<div class="container">

    <!--Вывод всех предметов-->
    <div class="col-sm-4 col-md-4">
        <div class="form-group">
            <label class="control-label">Предмет:</label>
        </div>
        <div class="form-group">
            <select multiple class="form-control" id="listPredmet">
                <?php
                $pred->outputAllPredmetPrepod();
                ?>
            </select>
        </div>
    </div>

    <!--Блок семестра-->
    <div class="col-sm-4 col-md-4">
        <div id="select_semestr">
            <div class="form-group">
                <label class="control-label">Семестр:</label>
            </div>
            <div class="form-group" id="divListSemestr">
                <select multiple class="form-control" id="listSemestr">
                    <option>Нет данных</option>
                </select>
            </div>
        </div>
    </div>

    <!--Блок выбора группы-->
    <div class="col-sm-4 col-md-4">
        <div id="select_group">
            <div class="form-group">
                <label class="control-label">Группа:</label>
            </div>
            <div class="form-group">
                <select multiple class="form-control" id="listGroup">
                    <option>Нет данных</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="col-sm-12 col-md-12">
        <div class="table-responsive" id="mainPrepodTable">

        </div>
    </div>
</div>

<script src="../js/prepod_ajax.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>