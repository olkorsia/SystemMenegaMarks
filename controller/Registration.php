<?php
    class Registration
    {
        private $_db = null;

        public function __construct()
        {
            $this->_db = connectDB::getInstance();
        }

        public function registration($name, $surname, $patronic, $login, $password, $reg_key)
        {
            try {
                $primary_key = "123qwerty123";
                if ($reg_key == $primary_key) {
                    $sql = "SELECT id FROM prepod WHERE prepod_login='$login'";
                    $result = $this->_db->query($sql);

                    if ($result->rowCount() > 0) {
                        echo '<div class="container"><div class="row"><div class="col-md-6 col-md-offset-3">
		                    <div class="alert alert-warning" role="alert" style="text-align: center">Такой пользователь существует!</div>
                        </div></div></div>';
                    } else {
                        $sql = "INSERT INTO prepod (name, surname, patronic, prepod_login, prepod_password) VALUES ('$name', '$surname', '$patronic', '$login', '$password')";
                        $result = $this->_db->query($sql);

                        if ($result == true) {
                            echo '<div class="container"><div class="row"><div class="col-md-6 col-md-offset-3">
		                    <div class="alert alert-success" role="alert" style="text-align: center">Вы успешно зарегистрированны!</div>
                        </div></div></div>';
                        }
                    }
                } else {
                    echo '<div class="container"><div class="row"><div class="col-md-6 col-md-offset-3">
		                    <div class="alert alert-warning" role="alert" style="text-align: center">Не правильный ключ!</div>
                        </div></div></div>';
                }
            } catch (PDOException $e) {
                echo 'Database error: ' . $e->getMessage();
            }
        }
    }
?>