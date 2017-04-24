<?php
require "../controller/ConnectDB.php"
?>
<!DOCTYPE html>
<html>
<head>
	<title>Guest</title>
</head>
<body>
	<h2>Гость</h2> <br /> 

	<form method="POST">
		Введите фамилию студента: <input type="text" name="surname" required>
		<input type="submit" name="search_student">
	</form>
<?php
	class Guest {
		private $_db = null;

		public function __construct() {
			$this->_db = connectDB::getInstance();
		}

		public function query_pdo($patronic) {
			$this->query = "SELECT name, surname, patronic FROM students WHERE surname='$patronic'";
			$result = $this->_db->query($this->query);
			
			if ($result->rowCount() == 1) {
				session_start();
				$_SESSION['auth'] = 'student';
				while ($row = $result->fetch())
				{
					$_SESSION['name'] = $row['name'];
					$_SESSION['surname'] = $row['surname'];
					$_SESSION['patronic'] = $row['patronic'];
				}
			} else {
				echo "Нет такого студента";
				$_SESSION['auth'] = 0;
			}

		}
	}

	if (isset($_POST['search_student'])) {
		$patronic = trim($_POST['surname']);
		$guest = new Guest;
		$guest->query_pdo($patronic);
	}

	if ($_SESSION['auth'] == 'student') {
		echo "Имя: " . $_SESSION['name'] . '<br />';
		echo "Фамилия: " . $_SESSION['surname'] . '<br />';
		echo "Отчество: " . $_SESSION['patronic'] . '<br />';

		echo '<form method="GET"><input type="submit" name="exit" value="Выход"></form>';
	}
?>
</body>
</html>