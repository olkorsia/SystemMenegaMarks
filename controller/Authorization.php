<?php
    require_once "ConnectDB.php";

    class Authorization
    {
        private $_db = null;

        public function __construct()
        {
            $this->_db = connectDB::getInstance();
        }

        public function enter($login, $password)
        {
            try {
                $sql = "SELECT id, name, surname, patronic, email, number_phone FROM prepod WHERE prepod_login='$login' AND prepod_password='$password'";
                $result = $this->_db->query($sql);

                if ($result->rowCount() == 1) {
                    session_start();
                    $_SESSION['auth'] = 'prepod';
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $_SESSION['prepod_id'] = $row['id'];
                        $_SESSION['name'] = $row['name'];
                        $_SESSION['surname'] = $row['surname'];
                        $_SESSION['patronic'] = $row['patronic'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['number_phone'] = $row['number_phone'];
                    }
                    header("Location: /prepod");
                } elseif ($login === "admin") {
                    if ($password === "padmin") {
                        session_start();
                        $_SESSION['auth'] = 'admin';
                        $_SESSION['name'] = "Administrator";
                        header("Location: /admin");
                    }
                } else {
                    echo '<div class="container"><div class="row"><div class="col-md-6 col-md-offset-3">
		                    <div class="alert alert-danger" role="alert" style="text-align: center">Не удается войти. Проверьте правильность написания логина и пароля.</div>
                        </div></div></div>';
                }
            } catch (PDOException $e) {
                echo 'Database error: ' . $e->getMessage();
            }
        }
    }
?>