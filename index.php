<?php
session_start();
require_once "controller/Authorization.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Главная</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/login_registration_form.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body style="background-image: url('./images/background.jpg');">
<?php
if ($_SESSION['auth'] == 'prepod') {

    header("Location: /prepod");

} elseif ($_SESSION['auth'] == 'student') {

    header("Location: /guest");

} elseif ($_SESSION['auth'] == 'admin') {

    header('Location: /admin');

} elseif ($_SESSION['auth'] == 0 || empty($_SESSION['auth'])) {
    echo <<<HTML

	<div class="container">
    	<div class="row">
    		<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Вход</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Регистрация</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" method="POST" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="login" class="form-control" placeholder="Логин" required>
									</div>
									<div class="form-group">
										<input type="password" name="password" class="form-control" placeholder="Пароль" required>
									</div>
									<div class="form-group">
										<div class="row col-sm-offset-1">
											<div class="col-sm-5">
												<input type="submit" name="login-submit" class="form-control btn btn-login" value="Войти">
											</div>
											<div class="col-sm-5">
												<a href="guest/search_student.php" class="form-control btn btn-login">Войти как студент</a>
											</div>
										</div>
									</div>
								</form>
								<form id="register-form" method="POST" style="display: none;">
									<div class="form-group">
										<input type="text" id="name" class="form-control" placeholder="Имя" required>
									</div>
									<div class="form-group">
										<input type="text" id="surname" class="form-control" placeholder="Фамилия" required>
									</div>
									<div class="form-group">
										<input type="text" id="patronic" class="form-control" placeholder="Отчество" required>
									</div>
									<div class="form-group">
										<input type="text" id="number-phone" class="form-control" placeholder="Номер телефона" required>
									</div>
									<div class="form-group">
										<input type="text" id="login" class="form-control" placeholder="Логин" required>
									</div>
									<div class="form-group">
										<input type="password" id="password" class="form-control" placeholder="Пароль" required>
									</div>
									<div class="form-group">
										<input type="password" id="confirm-password" class="form-control" placeholder="Подтверждение пароля" required>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="button" id="register-submit" class="form-control btn btn-register" value="Зарегистрировать">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div id="alertContent">
                </div>
            </div>
        </div>
    </div>
HTML;
}

if (isset($_POST['login-submit'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $auth = new Authorization;
    $auth->enter($login, $password);
}
?>

<script type="text/javascript">
    function addPrepod(name, surname, patronic, numberPhone, login, password) {
        $.ajax({
            type: "POST",
            async: false,
            url:"../ajax/ajax_regestration.php",
            data: ({name:name, surname:surname, patronic:patronic, numberPhone:numberPhone, login:login, password:password}),
            dataType: "text"
        }).done(function (data) {
            $("#alertContent").html(data);
        });
    }

    $(document).on("click", "#register-submit", function () {
        var password = $("#password").val();
        var confPassword = $("#confirm-password").val();
        if (password == confPassword) {
            var name = $("#name").val();
            var surname = $("#surname").val();
            var patronic = $("#patronic").val();
            var numberPhone = $("#number-phone").val();
            var login = $("#login").val();
            addPrepod(name, surname, patronic, numberPhone, login, password);
        } else {
            alert("Пароли не совпадают");
        }
    });
</script>

<script src="js/bootstrap.min.js"></script>
<script src="js/login_registration_form.js"></script>
</body>
</html>