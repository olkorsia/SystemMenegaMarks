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
        
        <!-- Modal Predmet -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Добавить предмет</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="forSelectPredmet">Выбрать из существующих предметов</label>
                                <select multiple class="form-control" id="forSelectPredmet">
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
                            <div class="form-group">
                                <label for="forInputPredmet">Добавить новый предмет</label>
                                <input type="text" id="forInputPredmet" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Добавить</button>
                        </div>
                    </div>
                </div>
            </div>
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