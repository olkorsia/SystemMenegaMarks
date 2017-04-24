<?php
session_start();

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
<body>

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
                    <span class="navbar-brand">Вы вошли как гость</span>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Оценки</a></li>
                        <li><a href="predmet.php">Предметы</a></li>
                        <li><a href="results.php">Итоги</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <p class="navbar-text"><?php echo ' ' . $_SESSION['surname'] . ' ' . $_SESSION['name'] . ' ' . $_SESSION['patronic']; ?></p>
                        <?php if ($_SESSION['auth'] == 'student') { echo '<li><a href="?exit">Выход</a></li>'; }  ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<!--//MENU NAVBAR-->


<div class="container">
    <div id="idMarks">

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td></td>
                    <td>Тема 1</td>
                    <td>Тема 2</td>
                    <td>Тема 3</td>
                    <td>Тема 4</td>
                    <td>Тема 5</td>
                    <td>Тема 6</td>
                    <td>Тема 7</td>
                    <td>Тема 8</td>
                    <td>Тема 9</td>
                    <td>Тема 10</td>
                </tr>
                <tr>
                    <td>ИЗВП</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>ОПИ</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>ПП</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
            </table>
        </div>
    </div>

</div>

<!--div class="container" id="idPredmet">
    <p>Predmet</p>

    <select class="selectpicker">
        <option>Mustard</option>
          <option>Ketchup</option>
          <option>Relish</option>
      </select>

    <form class="form-inline" method="POST">
        <div class="form-group">
            <div class="dropdown">
                  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Предметы <span class="caret"></span></button>

                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="#">ИЗВП</a></li>
                    <li><a href="#">ОПИ</a></li>
                    <li><a href="#">ПП</a></li>
                </ul>
            </div>
          </div>
        <button type="submit" class="btn btn-default">Выбрать</button>
    </form>
</div-->

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
