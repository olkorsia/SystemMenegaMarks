<?php
session_start();
require_once "ConnectDB.php";

class PrepodSemestr
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function selectSemestrForPredmet($predmet_id)
    {

        $id_prepod = $_SESSION['prepod_id'];

        $sql = "SELECT DISTINCT semestr FROM main WHERE prepod_id='$id_prepod' AND predmet_id='$predmet_id'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['semestr'] . '">' . $row['semestr'] . '</option>';
            }
        } else {
            echo '<option>Нет добавленых семестров</option>';
        }
    }
}

?>