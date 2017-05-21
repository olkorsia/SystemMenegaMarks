<?php
session_start();
require_once "ConnectDB.php";

class GuestMainTable
{
    private $_db = null;
    private $student_id;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
        $this->student_id = $_SESSION["id"];
    }

    public function getMainTable() {
        //$subject_number_sql = "SELECT max(number) AS maxnum FROM subject INNER JOIN marks ON subject.id=marks.subject_id WHERE student_id='$this->student_id'";
        //$subject_number_result = $this->_db->query($subject_number_sql)->fetch()["maxnum"];

        $main_sql = "SELECT DISTINCT main.id, name FROM main INNER JOIN marks ON main.id=marks.main_id INNER JOIN predmet ON main.predmet_id=predmet.id WHERE student_id='$this->student_id'";
        $main_result = $this->_db->query($main_sql);

        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered">';
        echo '<thead><tr><td></td><td>T1</td><td>T2</td><td>T3</td><td>T4</td><td>T5</td><td>T6</td><td>T7</td><td>T8</td><td>T9</td><td>T10</td><td>T11</td><td>T12</td></tr></thead>';

        echo '<tbody>';


        while ($main_row = $main_result->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>'.$main_row["name"].'</td>';

            $mark_sql = "SELECT mark FROM marks WHERE student_id='$this->student_id' AND main_id='".$main_row["id"]."'";
            $mark_result = $this->_db->query($mark_sql);

            while ($mark_row = $mark_result->fetch(PDO::FETCH_ASSOC)) {
                echo '<td>'.$mark_row["mark"].'</td>';
            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }
}
?>