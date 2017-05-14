<?php
session_start();
require_once "ConnectDB.php";

class PrepodGroup
{
    private $_db = null;
    private $prepod_id;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
        $this->prepod_id = $_SESSION['prepod_id'];
    }

    public function selectGroupForPredmet($predmet_id, $semestr)
    {
        $id_prepod = $_SESSION['prepod_id'];

        $sql = "SELECT groups.id, groups.name FROM main inner join groups ON main.group_id=groups.id WHERE main.prepod_id='$id_prepod' AND main.predmet_id='$predmet_id' AND main.semestr = '$semestr'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            echo '<option selected disabled>Выберите группу</option>';
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            echo '<option selected disabled>Нет групп</option>';
        }
    }

    public function modalWindowAddGroup() {

        echo <<<HTML
            <!-- Modal Semestr-->
                <div class="modal fade" id="buttonAddGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Добавить группу</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="selectorPredmetForAddGroup">Выберите предмет</label>
                                    <select multiple class="form-control" id="selectorPredmetForAddGroup" name="selectorPredmetForAddGroup" required>
                                    
HTML;

        $sql = "SELECT distinct predmet.id, predmet.name FROM `main` inner join `predmet` ON main.predmet_id=predmet.id WHERE main.prepod_id='$this->prepod_id'";
        $result = $this->_db->query($sql);

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
                                <div class="form-group">
                                    <label for="selectorSemestrForAddGroup">Выберите семестр</label>
                                    <select multiple class="form-control" id="selectorSemestrForAddGroup" name="selectorSemestrForAddGroup" required>
                                        <option disabled>Выберите предмет</option>
                                    </select>
                                </div>

                                <div class="row"><hr/></div>

                                <div class="form-group">
                                    <label for="selectorOfExistingGroup">Выбрать из существующих групп</label>
                                    <select multiple class="form-control" id="selectorOfExistingGroup" name="selectorOfExistingGroup">
HTML;

        $sql = "SELECT id, name FROM groups";
        $result = $this->_db->query($sql);

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
                                <div class="form-group">
                                    <label for="inputNewGroup">Добавить новую группу</label>
                                    <input type="text" class="form-control" id="inputNewGroup" name="inputNewGroup">
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

    public function addGroupOfInputText($predmet_id, $semestr, $group_id)
    {
        $sql = "SELECT id FROM main WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id' AND semestr='$semestr' AND group_id='$group_id'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() == 0 && $result == true) {
            $sql = "SELECT id FROM main WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id' AND semestr='$semestr' AND group_id='0'";
            $result = $this->_db->query($sql);

            if ($result->rowCount() == 1 && $result == true) {
                $sql = "UPDATE main SET main.group='$group_id' WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id' AND semestr='$semestr'";
                $result = $this->_db->query($sql);

                if ($result == true) {
                    echo '<script type="text/javascript">alert("Группа успешно добавлен");</script>';
                    header("Location: /prepod/");
                }
            } else {
                $sql = "INSERT INTO main (prepod_id, predmet_id, semestr, group_id) VALUES ('$this->prepod_id', '$predmet_id', '$semestr', '$group_id')";
                $result = $this->_db->query($sql);

                if ($result == true) {
                    echo '<script type="text/javascript">alert("Группа успешно добавлен");</script>';
                    header("Location: /prepod/");
                }
            }
        } else {
            echo '<script type="text/javascript">alert("Группа существует в БД");</script>';
        }

    }
}

?>