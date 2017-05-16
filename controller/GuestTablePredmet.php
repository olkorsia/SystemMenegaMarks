<?php
session_start();
require_once "ConnectDB.php";

class GuestTablePredmet
{
    private $_db = null;
    private $student_id;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
        $this->student_id = $_SESSION["id"];
    }

    public function selectorOptionPredmet() {
        $sql = "SELECT DISTINCT predmet.id, name FROM predmet INNER JOIN main ON predmet.id=main.predmet_id INNER JOIN marks ON main.id=marks.main_id WHERE student_id='2'";
        $result = $this->_db->query($sql);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
        }
    }

    public function tableOnThePredmet($predmet_id) {
        $sql = "SELECT s.name, m.mark FROM main INNER JOIN marks AS m ON main.id=m.main_id INNER JOIN subject AS s ON m.subject_id=s.id WHERE predmet_id='$predmet_id' AND student_id='$this->student_id'";
        $result = $this->_db->query($sql);

        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered">';

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>'.$row["name"].'</td>';
            echo '<td>'.$row["mark"].'</td>';
            echo '</tr>';
        }

        echo '</div>';
        echo '</table>';
    }
}

?>