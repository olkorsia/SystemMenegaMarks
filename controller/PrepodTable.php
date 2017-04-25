<?php
require_once "ConnectDB.php";

class PrepodTable
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function outputTableMarks($main_id)
    {
        echo '<script>alert('.$main_id.');</script>';

        $view_sql = "CREATE VIEW view_table_mark AS SELECT students.id student_id, subject.id subject_id, marks.mark marks_mark FROM students INNER JOIN marks ON students.id=marks.student_id INNER JOIN subject ON marks.subject_id=subject.id";
        $this->_db->query($view_sql);

        $sql = "SELECT * FROM view_table_mark";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<p>'.$row['student_id'].' '.$row['subject_id'].' '.$row['marks_mark'].'</p>';
            }
        }


        /*echo '<table class="table table-bordered">';
        $sql = "select number, name from marks inner join subject on marks.subject_id=subject.id where main_id='$main_id'";
        $result = $this->_db->query($sql);
        if ($result->rowCount() > 0) {
            echo '<tr><td></td>';
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<td>T'.$row['number'].'</td>';
            }
            echo '</tr>';
        } else {
            echo 'Темы не найдены!';
        }

        $sql = "select name, surname, patronic, mark from marks inner join students on marks.student_id=students.id where main_id='$main_id'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() > 0) {
            echo '<tr>';
            //$dataSNP = $result->fetch(PDO::FETCH_ASSOC);
            //echo '<td>'.$dataSNP['surname'].' '.$dataSNP['name'].' '.$dataSNP['patronic'].'</td>';
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<td>'.$row['mark'].'</td>';
            }
            echo '</tr>';
        } else {
            echo 'Темы не найдены!';
        }

        echo '</table>';*/
    }
}
?>