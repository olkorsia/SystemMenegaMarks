<?php
session_start();
require_once "ConnectDB.php";

class PrepodManageStudent
{
    private $_db = null;
    private $group_id;
    private $prepod_id;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
        $this->prepod_id = $_SESSION['prepod_id'];
        $this->group_id = $_SESSION["prepod_group"];
    }

    public function outputToSelectorManageGroup() {
        $sql = "SELECT id, name FROM groups WHERE manage_id='$this->prepod_id'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
            }
        }
    }

    public function outputTableStudent($group_id) {

        $sql = "SELECT students.id, students.name, surname, patronic FROM students WHERE students.group_id='$group_id'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td width="20%" class="surnameStudent" data-id-surname='.$row["id"].' contenteditable>'.$row["surname"].'</td>';
                echo '<td width="20%" class="nameStudent" data-id-name='.$row["id"].' contenteditable>'.$row["name"].'</td>';
                echo '<td width="20%" class="patronicStudent" data-id-patronic='.$row["id"].' contenteditable>'.$row["patronic"].'</td>';
                echo '<td align="center" width="5%"><span class="glyphicon glyphicon-trash deleteStudent" data-id-del="'.$row["id"].'"></span></td>';
                echo '</tr>';
            }
            echo '<tr style="border-bottom: 1px solid darkgray;">';
            echo '<td style="border-right: 1px solid darkgray;" width="20%" id="surnameStudent" contenteditable></td>';
            echo '<td style="border-right: 1px solid darkgray;" width="20%" id="nameStudent" contenteditable></td>';
            echo '<td style="border-right: 1px solid darkgray;" width="20%" id="patronicStudent" contenteditable></td>';
            echo '<td align="center" width="5%"><button type="button" id="btn_add" class="btn btn-xs btn-success">+</button></td>';
            echo '</tr>';
        } else {
            echo '<tr style="border-bottom: 1px solid darkgray;">';
            echo '<td style="border-right: 1px solid darkgray;" width="20%" id="surnameStudent" contenteditable></td>';
            echo '<td style="border-right: 1px solid darkgray;" width="20%" id="nameStudent" contenteditable></td>';
            echo '<td style="border-right: 1px solid darkgray;" width="20%" id="patronicStudent" contenteditable></td>';
            echo '<td align="center" width="5%"><button type="button" id="btn_add" class="btn btn-xs btn-success">+</button></td>';
            echo '</tr>';
        }
    }

    public function addNewStudentToDB($surname, $name, $patronic, $group_id) {
        $sql = "INSERT INTO students (surname, name, patronic, group_id) VALUES ('$surname', '$name', '$patronic', '$group_id')";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Студент успешно добавлен в БД";
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
            echo "Студент успешно удален";
        }
    }
}

?>