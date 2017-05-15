<?php
session_start();
require_once "ConnectDB.php";

class AdminPredmet
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function outputTablePredmet() {
        $sql = "SELECT id, name FROM predmet";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td width="90%" class="namePredmet" data-id='.$row["id"].' contenteditable="true">'.$row["name"].'</td>';
                echo '<td align="center" width="5%"><span class="glyphicon glyphicon-trash deletePredmet" data-id-del="'.$row["id"].'"></span></td>';
                echo '</tr>';
            }
        }
    }

    public function addNewPredmetToDB($name_new_predmet) {
        $trim_name = trim($name_new_predmet);
        $sql = "SELECT name FROM predmet WHERE trim(name) LIKE '$trim_name'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() == 0 && $result == true) {
            $sql = "INSERT INTO predmet (name) VALUES ('$name_new_predmet')";
            $result_add_predmet = $this->_db->query($sql);

            $sql = "INSERT INTO main (prepod_id, predmet_id) VALUES ('$this->prepod_id', (SELECT id FROM predmet WHERE name LIKE '$name_new_predmet'))";
            $result_add_main = $this->_db->query($sql);

            if ($result_add_main == true) {
                echo '<script type="text/javascript">alert("Предмет успешно добавлен");</script>';
            }
        } else {
            echo '<script type="text/javascript">alert("Предмет существует в БД");</script>';
        }
    }

    public function changePredmet($predmet_id, $text) {
        $sql = "UPDATE predmet SET name='$text' WHERE id='$predmet_id'";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Данные успешно изменены";
        }
    }

    public function deletePredmetFromDB($predmet_id) {
        $sql = "DELETE FROM predmet WHERE id='$predmet_id'";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Предмет успешно удален";
        }
    }

}

?>