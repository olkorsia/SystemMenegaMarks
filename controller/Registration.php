<?php
    require_once "ConnectDB.php";

    class Registration
    {
        private $_db = null;

        public function __construct()
        {
            $this->_db = connectDB::getInstance();
        }

        public function registration($name, $surname, $patronic, $number_phone, $login, $password)
        {

            try {
                $sql = "SELECT id FROM prepod WHERE prepod_login='$login'";
                $result = $this->_db->query($sql);

                if ($result->rowCount() > 0) {
                    echo '<div class="alert alert-warning" role="alert" style="text-align: center">Такой пользователь существует!</div>';
                } else {
                    $sql = "INSERT INTO prepod (name, surname, patronic, number_phone, prepod_login, prepod_password) VALUES ('$name', '$surname', '$patronic', '$number_phone', '$login', '$password')";
                    $result = $this->_db->query($sql);

                    if ($result == true) {
                        echo '<div class="alert alert-success" role="alert" style="text-align: center">Вы успешно зарегистрированны!</div>';
                    }
                }
            } catch (PDOException $e) {
                echo 'Database error: ' . $e->getMessage();
            }
        }
    }
?>