<?php
require_once "ConnectDB.php";

class GuestMainTable
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function getMainTable($student) {


        echo "<div class=\"table-responsive\">
            <table class=\"table table-bordered\">
                <tr>
                    <td></td>
                    <td>Тема 1</td>
                    <td>Тема 2</td>
                    <td>Тема 3</td>
                    <td>Тема 4</td>
                    <td>Тема 5</td>
                    <td>Тема 6</td>
                    <td>Тема 7</td>
                    <td>Тема 8</td>
                    <td>Тема 9</td>
                    <td>Тема 10</td>
                </tr>
                <tr>
                    <td>ИЗВП</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>ОПИ</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>ПП</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                    <td>5</td>
                </tr>
            </table>
        </div>";
    }
}
?>