<?php
session_start();
require_once "ConnectDB.php";

class AdminPrep
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function outputTablePrep() {
        $sql = "SELECT id, name, surname, patronic, prepod_login AS login, number_phone, confirm FROM prepod";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row["confirm"] != 1) {
                    echo '<tr style="background-color: lemonchiffon;">';
                    echo '<td width="20%" class="surnamePrep" data-id-surname="'.$row["id"].'" contenteditable>'.$row["surname"].'</td>';
                    echo '<td width="20%" class="namePrep" data-id-name="'.$row["id"].'" contenteditable>'.$row["name"].'</td>';
                    echo '<td width="20%" class="patronicPrep" data-id-patronic="'.$row["id"].'" contenteditable>'.$row["patronic"].'</td>';
                    echo '<td width="15%" class="loginPrep" data-id-login="'.$row["id"].'" contenteditable>'.$row["login"].'</td>';
                    echo '<td width="15%" class="numberPhonePrep" data-id-number-phone="'.$row["id"].'">'.$row["number_phone"].'</td>';
                    echo '<td width="15%" class="confirmUser" data-id-confirm="'.$row["id"].'" style="cursor: default;">Подтвердить</td>';
                    echo '<td align="center" width="5%"><span class="glyphicon glyphicon-trash deleteStudent" data-id-del="'.$row["id"].'"></span></td>';
                    echo '</tr>';
                } else {
                    echo '<tr>';
                    echo '<td width="20%" class="surnamePrep" data-id-surname="'.$row["id"].'" contenteditable>'.$row["surname"].'</td>';
                    echo '<td width="20%" class="namePrep" data-id-name="'.$row["id"].'" contenteditable>'.$row["name"].'</td>';
                    echo '<td width="20%" class="patronicPrep" data-id-patronic="'.$row["id"].'" contenteditable>'.$row["patronic"].'</td>';
                    echo '<td width="15%" class="loginPrep" data-id-login="'.$row["id"].'" contenteditable>'.$row["login"].'</td>';
                    echo '<td width="15%" class="numberPhonePrep" data-id-number-phone="'.$row["id"].'">'.$row["number_phone"].'</td>';
                    echo '<td width="15%" class="deconfirmUser" data-id-deconfirm="'.$row["id"].'" style="cursor: default;">Деактивировать</td>';
                    echo '<td align="center" width="5%"><span class="glyphicon glyphicon-trash deleteStudent" data-id-del="'.$row["id"].'"></span></td>';
                    echo '</tr>';
                }
            }
        }
    }

    public function changePrep($prepod_id, $text, $column_name) {
        $sql = "UPDATE prepod SET ".$column_name."='$text' WHERE id='$prepod_id'";
        $result = $this->_db->query($sql);
    }

    public function deletePrepFromDB($prepod_id) {
        $sql = "DELETE FROM prepod WHERE id='$prepod_id'";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Преподаватель успешно удален";
        }
    }
}

?>