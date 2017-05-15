<?php
session_start();
require_once "ConnectDB.php";

class PrepodPredmet
{
    private $_db = null;
    private $prepod_id;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
        $this->prepod_id = $_SESSION['prepod_id'];
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

    public function modalWindowAddPredmet() {
        $sql = "SELECT id, name FROM predmet";
        $result = $this->_db->query($sql);

        echo <<<HTML
        <!-- Modal Predmet -->
            <div class="modal fade" id="buttonAddPredmet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Добавить предмет</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="forSelectPredmet">Выбрать из существующих предметов</label>
                                    <select multiple class="form-control" id="selectorOfExistingPredmet" name="selectorOfExistingPredmet" required>
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
                                <div class="text-right">
                                    <button type="submit" class="btn btn-default btn-sm">Добавить предмет</button>
                                </div>
                            </form>
                            <div class="row"><hr/></div>
                            <form method="POST">                   
                                <div class="form-group">
                                    <label for="forInputPredmet">Добавить новый предмет</label>
                                    <input type="text" id="inputNewPredmet" class="form-control" name="inputNewPredmet" required>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-default btn-sm">Добавить новый предмет</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Ок</button>
                        </div>
                    </div>
                </div>
            </div>
HTML;
    }

    public function addPredmetOfSelector($predmet_id)
    {
        $sql = "SELECT id FROM main WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() == 0 && $result == true) {
            $sql = "INSERT INTO main (prepod_id, predmet_id) VALUES ('$this->prepod_id', '$predmet_id')";
            $result = $this->_db->query($sql);

            if ($result == true) {
                echo "Predmet added";
            } else {
                echo "Predmeta nety y dannogo prepodovatelya i on ne dobavilsya";
            }
        } else {
            echo "Takoy predmet y dannogo prepodovatelya esty";
        }
    }

    public function addPredmetOfInputText($name_new_predmet)
    {


    }

}

?>