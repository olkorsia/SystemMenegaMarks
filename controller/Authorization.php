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
                if ($login === "admin") {
                    if ($password === "padmin") {
                        session_start();
                        $_SESSION['auth'] = 'admin';
                        $_SESSION['name'] = "Administrator";
                        header("Location: /admin");
                    }
                } else {
                    $confirm_sql = "SELECT confirm FROM prepod WHERE prepod_login='$login' AND prepod_password='$password'";
                    $confirm_result = $this->_db->query($confirm_sql);

                    if ($confirm_result->rowCount() === 1) {
                        if ($confirm_result->fetch()["confirm"] == 1) {
                            session_start();
                            $_SESSION['auth'] = 'prepod';

                            $prepod_sql = "SELECT id, name, surname, patronic, number_phone FROM prepod WHERE prepod_login='$login' AND prepod_password='$password'";
                            $prepod_result = $this->_db->query($prepod_sql);
                            while ($row = $prepod_result->fetch(PDO::FETCH_ASSOC)) {
                                $_SESSION['prepod_id'] = $row['id'];
                                $_SESSION['name'] = $row['name'];
                                $_SESSION['surname'] = $row['surname'];
                                $_SESSION['patronic'] = $row['patronic'];
                                $_SESSION['numberPhone'] = $row['number_phone'];
                                //$_SESSION['prepod_group'] = $row['group_id'];
                            }
                            header("Location: /prepod");
                        } else {
                            echo '<script>alert("Вы не подтверждены как преподаватель. Попробуйте войти позднее");</script>';
                        }

                        /*$sql_group = "SELECT name FROM groups WHERE id='".$_SESSION['prepod_group']."'";
                        $result_group = $this->_db->query($sql_group);
                        $_SESSION['group_name'] = $result_group->fetch(PDO::FETCH_ASSOC)["name"];*/


                    } else {
                        echo '<div class="container"><div class="row"><div class="col-md-6 col-md-offset-3">
		                    <div class="alert alert-danger" role="alert" style="text-align: center">Не удается войти. Проверьте правильность написания логина и пароля.</div>
                        </div></div></div>';
                    }
                }

            } catch (PDOException $e) {
                echo 'Database error: ' . $e->getMessage();
            }
        }
    }
?>