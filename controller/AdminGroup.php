<?php
session_start();
require_once "ConnectDB.php";

class AdminGroup
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function outputTableGroup() {
        $sql = "SELECT id, name FROM groups";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td width="90%" class="nameGroup" data-id='.$row["id"].' contenteditable="true">'.$row["name"].'</td>';
                echo '<td align="center" width="5%"><span class="glyphicon glyphicon-trash deleteGroup" data-id-del="'.$row["id"].'"></span></td>';
                echo '</tr>';
            }
        }
    }

    public function addNewGroupToDB($name_new_group) {
        $trim_name = trim($name_new_group);
        $sql = "SELECT name FROM groups WHERE trim(name) LIKE '$trim_name'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() == 0 && $result == true) {
            $sql = "INSERT INTO groups (name) VALUES ('$name_new_group')";
            $result = $this->_db->query($sql);

            if ($result == true) {
                echo '<script type="text/javascript">alert("Группа успешно добавлен");</script>';
            }
        } else {
            echo '<script type="text/javascript">alert("Группа существует в БД");</script>';
        }
    }

    public function changeGroup($group_id, $text) {
        $trim_name = trim($text);
        $sql = "SELECT name FROM groups WHERE trim(name) LIKE '$trim_name'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() == 0 && $result == true) {
            $sql = "UPDATE groups SET name='$text' WHERE id='$group_id'";
            $result = $this->_db->query($sql);

            if ($result == true) {
                echo "Данные успешно изменены";
            }
        } else {
            echo "Такая группа существует";
        }
    }

    public function deleteGroupFromDB($group_id) {
        $sql = "DELETE FROM groups WHERE id='$group_id'";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Группа успешно удален";
        }
    }

}

?>