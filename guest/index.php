<?php
session_start();
require_once "../controller/GuestMainTable.php";

if (isset($_GET['exit'])) {
    session_unset();
    session_destroy();
    header("Location: /");
}
if (!isset($_SESSION['auth']) && !$_SESSION['auth'] == 'student') {
    header("Location: /guest/search_student.php");
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
        $(document).ready(function() {
            $(document).on("click", "#sendSearchSurname", function () {
                var surname = $("#inputSearch").val();
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "../ajax/ajax_guest_search_user.php",
                    data: ({student_surname: surname})
                }).done(function (data) {
                    $("#done").html(data);
                });
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
    <div id="idMarks">

        <?php
            if (isset($_SESSION["auth"]) && $_SESSION["auth"] === "student") {
                $student_id = $_SESSION["id"];
                $gmt = new GuestMainTable();

                $gmt->getMainTable($student_id);
            }
        ?>

    </div>

</div>

    <?php
        if (isset($_POST['inputSearch'])) {
            $gfs = new GuestFindStudent();
            $gfs->search($_POST['inputSearch']);
        }
    ?>

<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript">
    /*$("#idEnd").hide();
     $("#idPredmet").hide();
     $("#idMarks").show();

     $("#menu_marks").click(function () {
     $("#idEnd").hide();
     $("#idPredmet").hide();
     $("#idMarks").show();
     });
     $("#menu_predmet").click(function () {
     $("#idEnd").hide();
     $("#idMarks").hide();
     $("#idPredmet").show();
     $("#idPredmet").addclass("active");
     });
     $("#menu_end").click(function () {
     $("#idMarks").hide();
     $("#idPredmet").hide();
     $("#idEnd").show();
     });*/
</script>
</body>
</html>
