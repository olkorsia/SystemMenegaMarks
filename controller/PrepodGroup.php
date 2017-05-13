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

    public function elementAddGroup() {

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
                                    <label for="forSelectPredmet">Выберите предмет</label>
                                    <select multiple class="form-control" id="forSelectPredmet">
                                    
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
                                    <label for="forSelectPredmet">Выберите семестр</label>
                                    <select multiple class="form-control" id="forSelectPredmet">
HTML;



        echo <<<HTML
                                    </select>
                                </div>

                                <div class="row"><hr/></div>

                                <div class="form-group">
                                    <label for="forSelectPredmet">Выбрать из существующих групп</label>
                                    <select multiple class="form-control" id="forSelectPredmet">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="forInputPredmet">Добавить новую группу</label>
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
}

?>