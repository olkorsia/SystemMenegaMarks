<?php
session_start();
require "controller/Authorization.php";
require "controller/Registration.php";
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

    header('Location: /admin_index.php');

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
										<input type="text" name="login" id="login" class="form-control" placeholder="Логин" required>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" class="form-control" placeholder="Пароль" required>
									</div>
									<div class="form-group">
										<div class="row col-sm-offset-1">
											<div class="col-sm-5">
												<input type="submit" name="login-submit" id="login-submit" class="form-control btn btn-login" value="Войти">
											</div>
											<div class="col-sm-5">
												<a href="guest/search_student.php" class="form-control btn btn-login">Войти как студент</a>
											</div>
										</div>
									</div>
								</form>
								<form id="register-form" method="POST" role="form" style="display: none;">
									<div class="form-group">
										<input type="text" name="name" id="name" class="form-control" placeholder="Имя" required>
									</div>
									<div class="form-group">
										<input type="text" name="surname" id="surname" class="form-control" placeholder="Фамилия" required>
									</div>
									<div class="form-group">
										<input type="text" name="patronic" id="password" class="form-control" placeholder="Отчество" required>
									</div>
									<div class="form-group">
										<input type="text" name="login" id="login" class="form-control" placeholder="Логин" required>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" class="form-control" placeholder="Пароль" required>
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="confirm-password" class="form-control" placeholder="Подтверждение пароля" required>
									</div>
									<div class="form-group">
										<input type="password" name="enter_key" id="enter_key" class="form-control" placeholder="Ключ регистрации" required>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" class="form-control btn btn-register" value="Зарегистрировать">
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
HTML;
}

if (isset($_POST['login-submit'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $auth = new Authorization;
    $auth->enter($login, $password);
}

if (isset($_POST['register-submit'])) {
    if ($_POST['password'] != $_POST['confirm-password']) {
        echo "Пароли не совподают";
    } else {
        $name = trim($_POST['name']);
        $surname = trim($_POST['surname']);
        $patronic = trim($_POST['patronic']);
        $login = trim($_POST['login']);
        $password_shifr = $_POST['password'];
        $key = trim($_POST['enter_key']);

        $reg = new Registration;
        $reg->registration($name, $surname, $patronic, $login, $password_shifr, $key);
    }
}
?>

<script src="js/bootstrap.min.js"></script>
<script src="js/login_registration_form.js"></script>
</body>
</html>