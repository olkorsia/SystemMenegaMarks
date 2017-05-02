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

        <!-- Modal Semestr-->
                <div class="modal fade" id="myModalSemestr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Добавить семестр</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="forSelectPredmet">Выберите предмет</label>
                                    <select multiple class="form-control" id="forSelectPredmet" required>
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
                                <div class="row"><hr/></div>
                                <div class="form-group">
                                    <label for="forInputPredmet">Добавить новый семестр</label>
                                    <input type="text" id="forInputPredmet" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </div>
                        </div>
                    </div>
                </div>

HTML;
    }
}

?>