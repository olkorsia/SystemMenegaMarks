<?php
session_start();
require_once "../controller/PrepodPredmet.php";
require_once "../controller/PrepodSemestr.php";
require_once "../controller/PrepodGroup.php";
require_once "../controller/PrepodTable.php";

if (!isset($_SESSION['auth']) && !$_SESSION['auth'] == 'prepod') {
    header("Location: /");
} else {
    $cpred = new PrepodPredmet();
    $csemestr = new PrepodSemestr();
    $cgroup = new PrepodGroup();
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
                        <li class="active"><a href="index.php">Главная</a></li>
                        <?php
                            if ($_SESSION["prepod_group"] != 0) {
                                echo '<li><a href="managegroupe.php">Управление группой</a></li>';
                            }
                        ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false"><?php echo ' ' . $_SESSION['surname'] . ' ' . $_SESSION['name'] . ' ' . $_SESSION['patronic']; ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="settings.php">Настройки</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="?exit">Выход <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a></li>
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

    <!--Вывод всех предметов-->
    <div class="col-sm-4 col-md-4">
        <div class="form-group">
            <label class="control-label">Предмет:</label>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#buttonAddPredmet">
                Добавить новый
            </button>
            <?php
                $cpred->modalWindowAddPredmet();
            ?>

            <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#buttonDelPredmet">
                Удалить
            </button>
        </div>
        <div class="form-group">
            <select class="form-control" id="selectorPredmets">
                <option selected disabled>Выберите предмет</option>
                <?php
                $cpred->outputAllPredmetPrepod();
                ?>
            </select>
        </div>
    </div>

    <!--Блок семестра-->
    <div class="col-sm-4 col-md-4">
        <div id="select_semestr">
            <div class="form-group">
                <label class="control-label">Семестр:</label>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#buttonAddSemestr">
                    Добавить новый
                </button>

                <?php
                    $csemestr->modalWindowAddSemestr();
                ?>

            </div>
            <div class="form-group">
                <select class="form-control" id="selectorSemestrs">
                    <option selected disabled>Нет данных</option>
                </select>
            </div>
        </div>
    </div>

    <!--Блок выбора группы-->
    <div class="col-sm-4 col-md-4">
        <div id="select_group">
            <div class="form-group">
                <label class="control-label">Группа:</label>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#buttonAddGroup">
                    Добавить новый
                </button>

                <?php
                    $cgroup->modalWindowAddGroup();
                ?>

            </div>
            <div class="form-group">
                <select class="form-control" id="selectorGroups">
                    <option selected disabled>Нет данных</option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-12">
        <div>
            <p align="center">Subject</p>
        </div>
        <div id="mainSubjectTable">

        </div>
    </div>

    <div class="col-sm-12 col-md-12">
        <div>
            <p align="center">Marks</p>
        </div>
        <div id="mainMarksTable">

        </div>
    </div>
</div>

<div class="container" style="margin-bottom: 40px">

</div>

<?php
    if (isset($_POST["selectorOfExistingPredmet"])) {
        $cpred->addPredmetOfSelector($_POST["selectorOfExistingPredmet"]);
    }
    if (isset($_POST["inputNewSemestr"])) {
        $csemestr->addSemestrOfInputText($_POST["selectorPredmetForAddSemestr"], $_POST["inputNewSemestr"]);
    }
    if (isset($_POST["selectorOfExistingGroup"])) {
        $cgroup->addGroupOfSelector($_POST["selectorPredmetForAddGroup"], $_POST["selectorSemestrForAddGroup"], $_POST["selectorOfExistingGroup"]);
    }
?>

<!--script src="../js/prepod_ajax.js"></script-->
<script type="text/javascript">
    var idPredmet, semestr, group;

    $("#selectorPredmets").change(function () {
        idPredmet = $("#selectorPredmets option:selected").val();
        $.ajax({
            type: "POST",
            async: false,
            url: "../ajax/ajax_semestr.php",
            data: ({id_predmet: idPredmet})
        }).done(function (data) {
            $("#selectorSemestrs").html(data);
        });
    });

    $("#selectorSemestrs").change(function () {
        semestr = $("#selectorSemestrs option:selected").val();
        $.ajax({
            type: "POST",
            async: false,
            url: "../ajax/ajax_group.php",
            data: ({id_predmet: idPredmet, semestr: semestr})
        }).done(function (data) {
            $("#selectorGroups").html(data);
        });
    });

    $("#selectorGroups").change(function () {
        group = $("#selectorGroups option:selected").val();
        $.ajax({
            type: "POST",
            url: "../ajax/ajax_mainSubjectTable.php",
            data: ({id_predmet: idPredmet, semestr: semestr, id_group: group}),
            dataType:"text"
        }).done(function (data) {
            $("#mainSubjectTable").html(data);
            output_table();
        });
        function output_table() {
            $.ajax({
                type: "POST",
                url: "../ajax/ajax_mainMarksTable.php",
                data: ({id_predmet: idPredmet, semestr: semestr, id_group: group})
            }).done(function (data) {
                $("#mainMarksTable").html(data);
            });
        }
    });

    $("#selectorPredmetForAddGroup").change(function () {
        var idPredmetAdd = $("#selectorPredmetForAddGroup option:selected").val();
        $.ajax({
            type: "POST",
            async: false,
            url: "../ajax/ajax_semestr_for_modal.php",
            data: ({id_predmet: idPredmetAdd})
        }).done(function (data) {
            $("#selectorSemestrForAddGroup").html(data);
        });
    });

</script>

<script type="text/javascript">
    function fetch_data() {
        $.ajax({
            type: "POST",
            async: false,
            url: "../ajax/ajax_prep_student_output.php"
        }).done(function (data) {
            $("#dataTableStudentPrepod").html(data);
        });
    }

    function add_data(subjectName, mainId) {
        $.ajax({
            url:"../ajax/ajax_prep_subject_add.php",
            type:"POST",
            async: false,
            data: ({subject_name:subjectName, main_id:mainId}),
            dataType:"text"
        }).done(function (data) {
            alert(data);
            //fetch_data();
        });
    }

    function edit_data(id, text, column_name) {
        $.ajax({
            type: "POST",
            async: false,
            url: "../ajax/ajax_prep_student_edit.php",
            data: ({id:id, text:text, column_name:column_name}),
            dataType: "text"
        }).done(function (data) {
            alert(data);
        });
    }

    function delete_data(id) {
        $.ajax({
            type: "POST",
            async: false,
            url:"../ajax/ajax_prep_student_del.php",
            data: ({id:id}),
            dataType: "text"
        }).done(function (data) {
            alert(data);
            fetch_data();
        });
    }

    //fetch_data();

    $(document).on('click', '#btn_add_subject', function(){
        var subjectName = $('#newSubjectForMarks').text();
        var mainId = $('#newSubjectForMarks').data("mainId");
        if(subjectName == '')
        {
            alert("Введите тему");
            return false;
        }
        add_data(subjectName, mainId);
    });

    $(document).on('blur', '.surnameStudent', function(){
        var id = $(this).data("idSurname");
        var changeSurname = $(this).text();
        edit_data(id, changeSurname, "surname");
        fetch_data();
    });
    $(document).on('blur', '.nameStudent', function(){
        var id = $(this).data("idName");
        var changeName = $(this).text();
        edit_data(id, changeName, "name");
        fetch_data();
    });
    $(document).on('blur', '.patronicStudent', function(){
        var id = $(this).data("idPatronic");
        var changePatronic = $(this).text();
        edit_data(id, changePatronic, "patronic");
        fetch_data();
    });

    $(document).on('blur', '.groupStudent', function(){
        var id = $(this).data("idGroup");
        var changeGroup = $(this).text();
        //edit_data(id, changeGroup, "group");
        fetch_data();
    });

    $(document).on('click', '.deleteStudent', function(){
        var id = $(this).data("idDel");
        if(confirm("Вы уверены, что хотите удалить это?")) {
            delete_data(id);
        }
    });
</script>

<script src="../js/bootstrap.min.js"></script>
</body>
</html>