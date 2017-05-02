<?php
session_start();

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
                    <span class="navbar-brand">Вы вошли как студент</span>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Оценки</a></li>
                        <li class="active"><a href="predmet.php">Предметы</a></li>
                        <li><a href="results.php">Итоги</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false"><?php echo ' ' . $_SESSION['surname'] . ' ' . $_SESSION['name'] . ' ' . $_SESSION['patronic']; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php if ($_SESSION['auth'] == 'student') { echo '<li><a href="?exit">Выход <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a></li>'; }  ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<!--//MENU NAVBAR-->


<div class="container shadow-left-right-bottom" style="height:800px; margin-top:-20px; padding-top: 20px; background-color: #fff;">

    <div class="form-inline">
        <div class="form-group">
            <p class="form-control-static"><strong>Выберите предмет: </strong></p>
        </div>
        <div class="form-group">
            <select class="form-control" id="selectPredmetStudent">
                <option>ИЗВП</option>
                <option>ОПИ</option>
                <option>ПП</option>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-default" id="btnSelectPredmetStudent">Выбать</button>
        </div>
    </div>

    <br/>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <td>Тема 1</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Тема 2</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Тема 3</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Тема 4</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Тема 5</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Тема 6</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Тема 7</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Тема 8</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Тема 9</td>
                <td>5</td>
            </tr>
            <tr>
                <td>Тема 10</td>
                <td>5</td>
            </tr>
        </table>
    </div>
</div>

<script src="../js/bootstrap.min.js"></script>
</body>
</html>
