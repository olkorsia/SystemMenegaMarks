<?php
require "ConnectDB.php";

class GuestFindStudent
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function search1($str) {
        $exp = explode(" ", $str);
        $surname = $exp[0];
        $name = $exp[1];

        echo $surname . "<br/>";
        echo $name;
    }


    public function search($surname) {
        try {
            $sql = "SELECT id, name, surname, patronic FROM students WHERE surname='$surname'";
            $result = $this->_db->query($sql);

            if ($result->rowCount() == 1) {
                session_start();
                $_SESSION['auth'] = 'student';
                while ($row = $result->fetch(PDO::FETCH_ASSOC))
                {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['surname'] = $row['surname'];
                    $_SESSION['patronic'] = $row['patronic'];
                }
                header("Location: /guest");
            } elseif ($result->rowCount() > 1) {
                echo '<form method="POST" class="form-inline"><div class="form-group">
                            <p class="form-control-static"><strong>Выберите студента: </strong></p>
                        </div><div class="form-group"><select class="form-control selectorMargin"  name="selectVal">';

                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="'.$row["id"].'">'.$row["surname"].' '.$row["name"].'</option>';
                }

                echo '</select></div><button type="submit" class="btn btn-default">Выбрать</button></form>';
            } else {
                echo "Нет такого студента";
            }
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    }

    public function selectSurnameStudent($student_id) {
        try {
            echo "Start class param: " . $student_id;
            $sql = "SELECT id, name, surname, patronic FROM students WHERE id='$student_id'";
            $result = $this->_db->query($sql);

            echo "SQL work";
            if ($result->rowCount() == 1) {
                echo "IF ok";
                session_start();
                $_SESSION['auth'] = 'student';
                while ($row = $result->fetch(PDO::FETCH_ASSOC))
                {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['surname'] = $row['surname'];
                    $_SESSION['patronic'] = $row['patronic'];
                }
                header("Location: /guest");
            } else {
                echo "Произошла ошибка";
            }
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    }
}
?>