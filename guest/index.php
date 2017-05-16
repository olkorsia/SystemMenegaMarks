<?php
session_start();
require_once "../controller/GuestMainTable.php";

if (!isset($_SESSION['auth']) || $_SESSION['auth'] != 'student') {
    header("Location: /guest/search_student.php");
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
</head>
<body style="background-image: url('../images/background.jpg');">

<!--MENU NAVBAR-->
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
                    <span class="navbar-brand">Вы вошли как студент</span>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Оценки</a></li>
                        <li><a href="predmet.php">Предметы</a></li>
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
    <div id="idMarks">

        <?php
            if (isset($_SESSION["auth"]) && $_SESSION["auth"] === "student") {
                $gmt = new GuestMainTable();

                $gmt->getMainTable();
            }
        ?>

    </div>
</div>

<script src="../js/bootstrap.min.js"></script>
</body>
</html>
