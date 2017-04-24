<?php
session_start();
require_once "ConnectDB.php";

class PrepodSemestr
{
    private $_db = null;
    private $id_prepod;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
        $this->id_prepod = $_SESSION['prepod_id'];
    }

    public function selectSemestrForPredmet($predmet_id)
    {
        $sql = "SELECT DISTINCT semestr FROM main WHERE prepod_id='$this->id_prepod' AND predmet_id='$predmet_id'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['semestr'] . '">' . $row['semestr'] . '</option>';
            }
        } else {
            echo '<option>Нет добавленых семестров</option>';
        }
    }

    public function elementAddSemestr() {
        $sql = "SELECT distinct predmet.id, predmet.name FROM `main` inner join `predmet` ON main.predmet_id=predmet.id WHERE main.prepod_id='$this->id_prepod'";
        $result = $this->_db->query($sql);

        echo <<<HTML
        <form method="POST">
        <div class="col-md-4">
        
        <div class="form-group">
            <label class="control-label">Выберите предмет:</label>
        </div>
        <div class="form-group">
            <select multiple class="form-control" id="listAddPredmet" required>
HTML;

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
            }
        } else {
            echo '<option>Нет добавленых предметов</option>';
        }

        echo <<<HTML
            </select>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label class="control-label">Введите номер семестра:</label>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Номер семестра" required>
        </div>
        <button type="submit" class="btn btn-default">Добавить</button>
        
    </div>
    </form>
HTML;
    }
}

?>