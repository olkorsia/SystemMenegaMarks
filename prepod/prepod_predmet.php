<?php
session_start();
//require "../controller/prepod.php";
$pred = new Predmet;

if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 'prepod') {
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
    <script type="text/javascript">

    </script>
</head>
<body>
<!--MENU-->
<div class="container">
    <div class="row">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
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
                        <li><p class="navbar-text"><?php echo ' '.$_SESSION['surname'].' '.$_SESSION['name'].' '.$_SESSION['patronic']; ?></p></li>
                        <li><a href="#">Настройки</a></li>
                        <li><a href="?exit">Выход</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="container">

    <!--Вывод всех предметов-->
    <div class="col-sm-4 col-md-4">
        <div class="form-group">
            <select multiple class="form-control" id="listPredmet">
                <?php
                $pred->outputAllPredmetPrepod();
                ?>
            </select>
        </div>

        <div class="form-group">
            <button id="add_predmet" class="btn btn-default">Добавить предмет</button>
        </div>
    </div>



    <!--Блок семестра-->
    <div class="col-sm-4 col-md-4">
        <div id="select_semestr">

        </div>
    </div>

    <!--Блок выбора группы-->
    <div class="col-sm-4 col-md-4">
        <div id="select_group">

        </div>
    </div>
</div>

<?php
if (isset($_GET['predmet_id'])) {
    echo $_GET['predmet_id'];
}
if (isset($_POST['submit_input_add_predmet'])) {
    $pred->addPredmetInputText($_POST['input_add_predmet']);
}
?>

<script src="../js/bootstrap.min.js"></script>
</body>
</html>