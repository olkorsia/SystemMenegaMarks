<?php
require_once "ConnectDB.php";

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

    public function elementAddPredmet() {
        $sql = "SELECT id, name FROM predmet";
        $result = $this->_db->query($sql);

        echo <<<HTML
        <form method="POST" class="form-inline">
            <div class="form-group">
                <p class="form-control-static">Добавить из списка новый предмет: </p>
            </div>
            <div class="form-group">
                <select class="form-control" name="select_add_predmet">
HTML;
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            echo '<option>Нет добавленых предметов</option>';
        }
        echo <<<HTML
                </select>
            </div>
            <button type="submit" class="btn btn-default" name="submit_select_add_predmet">Добавить</button>
        </form>
        <br />
        <form method="POST" class="form-inline">
            <div class="form-group">
                <p class="form-control-static">Добавить новый предмет: </p>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="input_add_predmet">
            </div>
            <button type="submit" name="submit_input_add_predmet" class="btn btn-default">Добавить</button>
        </form>
HTML;

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