<?php
session_start();
require_once "ConnectDB.php";

class PrepodGroup
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function selectGroupForPredmet($predmet_id, $semestr)
    {
        $id_prepod = $_SESSION['prepod_id'];

        $sql = "SELECT main.id, groups.name FROM main inner join groups ON main.group_id=groups.id WHERE main.prepod_id='$id_prepod' AND main.predmet_id='$predmet_id' AND main.semestr = '$semestr'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            echo '<option>Нет групп</option>';
        }
    }
}

?>