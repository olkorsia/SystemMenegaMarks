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
        $prepod_id = $_SESSION['prepod_id'];
    }

    public function selectGroupForPredmet($predmet_id, $semestr)
    {
        $id_prepod = $_SESSION['prepod_id'];

        $sql = "SELECT groups.id, groups.name FROM main inner join groups ON main.group_id=groups.id WHERE main.prepod_id='$id_prepod' AND main.predmet_id='$predmet_id' AND main.semestr = '$semestr'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
        } else {
            echo '<option>Нет групп</option>';
        }
    }

    public function elementAddGroup() {
        echo <<<HTML
        <div>
        <form method="POST">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Выберите предмет:</label>
                </div>
                <div class="form-group">
                    <select multiple class="form-control" id="listAddPredmet" required>
HTML;
        $sql = "SELECT distinct predmet.id, predmet.name FROM `main` inner join `predmet` ON main.predmet_id=predmet.id WHERE main.prepod_id='$this->id_prepod'";
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
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Выберите семестр:</label>
                </div>
                <div class="form-group">
                    <select multiple class="form-control" id="listAddPredmet" required>
HTML;

        echo <<<HTML
                        <option>qwweg</option>
                        <option>qw12eh</option>
                        <option>htjy</option>
                        <option>mbcgydfgi45</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Выберите группу:</label>
                </div>
                <div class="form-group">
                    <select class="form-control" id="listAddPredmet" required>
HTML;
        echo <<<HTML
                        <option>qwweg</option>
                        <option>qw12eh</option>
                        <option>htjy</option>
                        <option>mbcgydfgi45</option>
                    </select>
                </div>
                <button type="button" class="btn btn-default" id="newGroup">Новая группа</button>
                <button type="submit" class="btn btn-default">Добавить</button>
            </div>
            <div class="col-md-12 form-horizontal" id="writeGroup" style="margin-top: 25px; display: none">
                <div class="form-group">
                    <label class="control-label col-md-2" for="valueNewGroup">Выберите группу:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="valueNewGroup" placeholder="Введите группу"
                               required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-default" id="sendValueNewGroup">Добавить</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
HTML;

    }
}

?>