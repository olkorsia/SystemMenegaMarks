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
        $sql = "SELECT id, name, manage_id FROM groups";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row["manage_id"] == 0) {
                    $style = 'background-color: lemonchiffon;';
                } else {
                    $style = '';
                }
                echo '<tr style="'.$style.'">';
                echo '<td width="55%" class="nameGroup" data-id='.$row["id"].' contenteditable="true">'.$row["name"].'</td>';
                echo '<td width="40%"><select class="form-control input-sm managePrepod" data-id-group="'.$row["id"].'">';

                $prepod_sql = "SELECT id, name, surname, patronic FROM prepod WHERE confirm='1'";
                $prepod_result = $this->_db->query($prepod_sql);

                echo '<option selected disabled>Выберите куратора</option>';
                while ($prepod_row = $prepod_result->fetch(PDO::FETCH_ASSOC)) {
                    if ($row["manage_id"] == $prepod_row["id"]) {
                        $config = "selected disabled";
                    } else {
                        $config = "";
                    }
                    echo '<option value="'.$prepod_row["id"].'" '.$config.'>'.$prepod_row["surname"].' '.$prepod_row["name"].' '.$prepod_row["patronic"].'</option>';
                }

                echo '</select></td>';
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

    public function changeGroup($group_id, $text, $column_name) {
        if ($column_name === 'name') {
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
        } else {
            $sql = "UPDATE groups SET ".$column_name."='$text' WHERE id='$group_id'";
            $result = $this->_db->query($sql);

            if ($result == true) {
                echo "Данные успешно изменены";
            }
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