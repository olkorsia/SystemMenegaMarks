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
        $sql = "SELECT id, name, surname, patronic, prepod_login AS login, group_id FROM prepod";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row["group_id"] == 0) {
                    $group = "-";
                } else {
                    $sql_group = "SELECT name FROM groups WHERE id='".$row['group_id']."'";
                    $result_group = $this->_db->query($sql_group);
                    $group = $result_group->fetch(PDO::FETCH_ASSOC)["name"];
                }
                echo '<tr>';
                echo '<td width="20%" class="surnamePrep" data-id-surname='.$row["id"].' contenteditable>'.$row["surname"].'</td>';
                echo '<td width="20%" class="namePrep" data-id-name='.$row["id"].' contenteditable>'.$row["name"].'</td>';
                echo '<td width="20%" class="patronicPrep" data-id-patronic='.$row["id"].' contenteditable>'.$row["patronic"].'</td>';
                echo '<td width="20%" class="loginPrep" data-id-login='.$row["id"].' contenteditable>'.$row["login"].'</td>';
                echo '<td width="15%" class="groupPrep" data-id-group='.$row["id"].' data-toggle="modal" data-target="#myModal">'.$group.'</td>';
                echo '<td align="center" width="5%"><span class="glyphicon glyphicon-trash deleteStudent" data-id-del="'.$row["id"].'"></span></td>';
                echo '</tr>';
            }
            echo '<!-- Modal -->
        <div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>';
        }
    }

    public function changePrep($prepod_id, $text, $column_name) {
        $sql = "UPDATE prepod SET ".$column_name."='$text' WHERE id='$prepod_id'";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Данные успешно изменены";
        }
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