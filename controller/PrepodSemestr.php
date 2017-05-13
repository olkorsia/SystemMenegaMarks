<?php
session_start();
require_once "ConnectDB.php";

class PrepodSemestr
{
    private $_db = null;
    private $prepod_id;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
        $this->prepod_id = $_SESSION['prepod_id'];
    }

    public function selectSemestrForPredmet($predmet_id)
    {
        $sql = "SELECT DISTINCT semestr FROM main WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            echo '<option selected disabled>Выберите семестр</option>';
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['semestr'] . '">' . $row['semestr'] . '</option>';
            }
        } else {
            echo '<option selected disabled>Нет добавленых семестров</option>';
        }
    }

    public function selectSemestrOfPredmetForModal($predmet_id)
    {
        $sql = "SELECT DISTINCT semestr FROM main WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['semestr'] . '">' . $row['semestr'] . '</option>';
            }
        } else {
            echo '<option selected disabled>Нет добавленых семестров</option>';
        }
    }

    public function modalWindowAddSemestr() {
        $sql = "SELECT distinct predmet.id, predmet.name FROM `main` inner join `predmet` ON main.predmet_id=predmet.id WHERE main.prepod_id='$this->prepod_id'";
        $result = $this->_db->query($sql);

        echo <<<HTML
            <!-- Modal Semestr-->
                <div class="modal fade" id="buttonAddSemestr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Добавить семестр</h4>
                            </div>
                            <form method="POST">
                                <div class="modal-body">                                    
                                    <div class="form-group">
                                        <label for="selectorPredmetForAddSemestr">Выберите предмет</label>
                                        <select multiple class="form-control" id="selectorPredmetForAddSemestr" name="selectorPredmetForAddSemestr" required>
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
                                        <label for="inputNewSemestr">Добавить новый семестр</label>
                                        <input type="text" class="form-control" id="inputNewSemestr" name="inputNewSemestr" required>
                                    </div>                                   
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Добавить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

HTML;
    }

    public function addSemestrOfInputText($predmet_id, $semestr)
    {
        $sql = "SELECT id FROM main WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id' AND semestr='$semestr'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() == 0 && $result == true) {
            $sql = "UPDATE main SET main.semestr='$semestr' WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id'";
            $result = $this->_db->query($sql);

            if ($result == true) {
                echo '<script type="text/javascript">alert("Предмет успешно добавлен");</script>';
            }
            header("Location: /prepod/");
        } else {
            echo '<script type="text/javascript">alert("Предмет существует в БД");</script>';
        }

    }
}

?>