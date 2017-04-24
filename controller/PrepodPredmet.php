<?php

class PrepodPredmet
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function outputAllPredmetPrepod()
    {
        $id_prepod = $_SESSION['prepod_id'];

        $sql = "SELECT distinct predmet.id, predmet.name FROM `main` inner join `predmet` ON main.predmet_id=predmet.id WHERE main.prepod_id='$id_prepod'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
            }
        } else {
            echo '<tr><td style="color: red;">Добавьте предмет</td></tr>';
        }
    }

    public function outputPredmetSelector()
    {
        $sql = "SELECT id, name FROM predmet";
        $result = $this->_db->query($sql);

        if ($result == true) {  //////////////////////////////////////////TESTING THIS CODE, HE ALL TIME OUT DATA TRUE. CHANGE TRUE ON ROWCOUNT
            while ($row = $result->fetch()) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            echo '<option>Нет добавленых предметов</option>';
        }
    }

    public function addPredmetSelector()
    {

    }

    public function addPredmetInputText($name_new_predmet)
    {
        $sql = "SELECT name FROM predmet WHERE '$name_new_predmet' LIKE name";
        $result = $this->_db->query($sql);

        if ($result->rowCount() == 0 && $result == true) {
            $sql = "INSERT INTO predmet (name) VALUES ('$name_new_predmet')";
            $result = $this->_db->query($sql);
            if ($result == true) {
                echo '<script type="text/javascript">alert("Предмет успешно добавлен");</script>';
            }
        } else {
            echo '<script type="text/javascript">alert("Предмет существует в БД");</script>';
        }

    }

}

?>