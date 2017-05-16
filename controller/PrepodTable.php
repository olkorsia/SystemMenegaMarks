<?php
session_start();
require_once "ConnectDB.php";

class PrepodTable
{
    private $_db = null;
    private $prepod_id;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
        $this->prepod_id = $_SESSION["prepod_id"];
    }

    public function outputMainTableSubject($predmet_id, $semestr, $group_id) {
        try {
            $main_id_sql = "SELECT id FROM main WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id' AND semestr='$semestr' AND group_id='$group_id'";
            $main_id_result = $this->_db->query($main_id_sql);

            if ($main_id_result->rowCount() == 1) {
                $main_id = $main_id_result->fetch(PDO::FETCH_ASSOC)["id"];
            }

            $subject_sql = "SELECT DISTINCT subject.name, subject.id, subject.number FROM subject INNER JOIN marks ON subject.id=marks.subject_id WHERE marks.main_id='$main_id'";
            $subject_result = $this->_db->query($subject_sql);

            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered">';
            echo '<thead>';
            echo '<tr>';
            echo '<td width="8%" align="center">Тема №</td>';
            echo '<td width="87%">Название темы</td>';
            echo '<td width="5%"></td>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row_subject = $subject_result->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td width="8%" align="center">'.$row_subject["number"].'</td>';
                echo '<td width="87%" class="nameStudent" data-id-name="'.$row_subject["id"].'" contenteditable>'.$row_subject["name"].'</td>';
                echo '<td width="5%" align="center"><span class="glyphicon glyphicon-trash deleteStudent" data-id-del="'.$row_subject["id"].'"></span></td>';
                echo '</tr>';
            }

            echo '<tr>';
            echo '<td width="8%"></td>';
            echo '<td width="87%" id="newSubjectForMarks" data-main-id="'.$main_id.'" contenteditable></td>';
            echo '<td width="5%" align="center"><button type="button" id="btn_add_subject" class="btn btn-xs btn-success">+</button></td>';
            echo '</tr> ';

            echo '</tbody>';
            echo '</table>';
            echo '</div>';

        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    }

    public function addNewSubjectToDB($name, $main_id) {
        $main_group_sql = "SELECT group_id FROM main WHERE id='$main_id'";
        $main_group_result = $this->_db->query($main_group_sql);
        $group_id = $main_group_result->fetch()["group_id"];

        $group_student_sql = "SELECT id FROM students WHERE group_id='$group_id'";
        $group_student_result = $this->_db->query($group_student_sql);
        $count_students = $group_student_result->rowCount();


        /*$sql = "INSERT INTO subject (name, number) VALUES ('$name', '')";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Студент успешно добавлен в БД";
        }*/
    }

    public function outputTableMarks($predmet_id, $semestr, $group_id)
    {
        try {
            $main_id_sql = "SELECT id FROM main WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id' AND semestr='$semestr' AND group_id='$group_id'";
            $main_id_result = $this->_db->query($main_id_sql);

            if ($main_id_result->rowCount() == 1) {
                $main_id = $main_id_result->fetch(PDO::FETCH_ASSOC)["id"];
            }

            $output = '';

            $subject_sql = "SELECT DISTINCT subject.number FROM subject INNER JOIN marks ON subject.id=marks.subject_id WHERE marks.main_id='$main_id'";
            $subject_result = $this->_db->query($subject_sql);

            if ($subject_result->rowCount() > 0) {
                $output .= '<hr/>';
                $output .= '<div class="table-responsive">';
                $output .= '<table class="table table-bordered">';
                $output .= '<tr style="background-color: #66afe9;">';
                $output .= '<td width="30%"></td>';

                while ($row = $subject_result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<td width="4%">Т'.$row["number"].'</td>';
                }

                $output .= '<td align="center" width="4%"><button type="button" id="btn_add_marks" class="btn btn-xs btn-success">+</button></td>';
                $output .= '</tr>';


                $student_sql = "SELECT id, name, surname FROM students WHERE group_id='$group_id'";
                //$student_sql = "SELECT DISTINCT students.id, students.name, students.surname FROM students INNER JOIN marks ON students.id=marks.student_id WHERE marks.main_id='$main_id'";
                $student_result = $this->_db->query($student_sql);


                while ($row = $student_result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<tr>';
                    $output .= '<td>'.$row["surname"].' '.$row["name"].'</td>';

                    $mark_sql = "SELECT id, mark FROM marks WHERE marks.main_id='$main_id' AND marks.student_id='".$row["id"]."'";
                    $mark_result = $this->_db->query($mark_sql);

                    while ($row_mark = $mark_result->fetch(PDO::FETCH_ASSOC)) {
                        $output .= '<td data-id='.$row_mark["id"].' contenteditable>'.$row_mark["mark"].'</td>';
                    }

                    $output .= '<td width="4%" id="patronicStudent" contenteditable></td>';
                    $output .= '</tr>';
                }

                $output .= '</table>';
                $output .= '</div>';
            } else {
                $main_id_sql = "SELECT id FROM main WHERE prepod_id='$this->prepod_id' AND predmet_id='$predmet_id' AND semestr='$semestr' AND group_id='$group_id'";
                $main_id_result = $this->_db->query($main_id_sql);

                if ($main_id_result->rowCount() == 1) {
                    $main_id = $main_id_result->fetch(PDO::FETCH_ASSOC)["id"];
                }

                $sql = "SELECT id, name, surname FROM students WHERE group_id='$group_id'";
                $result = $this->_db->query($sql);

                $output .= '<div class="table-responsive">';
                $output .= '<table class="table table-bordered">';

                $output .= '<tr>';
                $output .= '<td></td>';
                $output .= '<td align="center" width="4%"><button type="button" id="btn_add_marks" class="btn btn-xs btn-success">+</button></td>';
                $output .= '</tr>';

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<tr>';
                    $output .= '<td>'.$row['surname'].' '.$row['name'].'</td>';
                    $output .= '<td width="4%" class="newMarks" data-main-id="'.$main_id.'" data-student-id="'.$row['id'].'" contenteditable></td>';
                    $output .= '</tr>';
                }

                $output .= '</table>';
                $output .= '</div>';
            }

            echo $output;

        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    }

    /*public function outputMainTableSubject() {

        $output = '';

        $output .= '<div class="table-responsive">';
        $output .= '<table class="table table-bordered" style="margin-top: 20px">';
        $output .= '<tr>';
        $output .= '<td width="20%" align="center">Номер темы</td>';
        $output .= '<td width="20%" align="center">Название темы</td>';
        $output .= '</tr>';

        while ($row_subject = $two_subject_result->fetch(PDO::FETCH_ASSOC)) {
            $output .= '<tr>';
            $output .= '<td width="3%" align="center">'.$row_subject["number"].'</td>';
            $output .= '<td width="80%" contenteditable>'.$row_subject["name"].'</td>';
            $output .= '</tr>';
        }

        $output .= '</table>';
        $output .= '</div>';

        echo $output;
    }*/
}
?>