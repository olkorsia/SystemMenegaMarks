<?php
session_start();
require_once "ConnectDB.php";

class AdminStudent
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function outputTableStudent() {
        $sql = "SELECT students.id, students.name, surname, patronic, groups.name AS gname FROM students INNER JOIN groups ON students.group_id=groups.id";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td width="20%" class="surnameStudent" data-id-surname='.$row["id"].' contenteditable>'.$row["surname"].'</td>';
                echo '<td width="20%" class="nameStudent" data-id-name='.$row["id"].' contenteditable>'.$row["name"].'</td>';
                echo '<td width="20%" class="patronicStudent" data-id-patronic='.$row["id"].' contenteditable>'.$row["patronic"].'</td>';
                echo '<td width="20%" class="groupStudent" data-id-group='.$row["id"].' contenteditable>'.$row["gname"].'</td>';
                echo '<td align="center" width="15%"><span class="glyphicon glyphicon-cog" data-id-conf="'.$row["id"].'"></span></td>';
                echo '<td align="center" width="5%"><span class="glyphicon glyphicon-trash deleteStudent" data-id-del="'.$row["id"].'"></span></td>';
                echo '</tr>';
            }
        }
    }

    public function addNewStudentToDB($name_new_group) {
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

    public function changeStudent($student_id, $text, $column_name) {
        $sql = "UPDATE students SET ".$column_name."='$text' WHERE id='$student_id'";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Данные успешно изменены";
        }
    }

    public function deleteStudentFromDB($student_id) {
        $sql = "DELETE FROM students WHERE id='$student_id'";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Группа успешно удален";
        }
    }

}

?>