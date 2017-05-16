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

            echo '<div><h3 align="center">Темы</h3></div>';
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
                echo '<td width="87%" class="nameSubject" data-id-subject="'.$row_subject["id"].'" contenteditable>'.$row_subject["name"].'</td>';
                echo '<td width="5%" align="center"><span class="glyphicon glyphicon-trash deleteSubject" data-id-del="'.$row_subject["id"].'"></span></td>';
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

        $subject_sql = "SELECT DISTINCT number FROM subject INNER JOIN marks ON subject.id=marks.subject_id WHERE marks.main_id='$main_id'";
        $subject_result = $this->_db->query($subject_sql);
        if ($subject_result->rowCount() == 0) {
            $sql = "INSERT INTO subject (name, number) VALUES ('$name', '1')";
            $result = $this->_db->query($sql);
            if ($result == true) {
                echo "Тема успешно добавлен в БД";
            }
        } else {
            $subject_number_sql = "SELECT max(number) + 1 AS numplus FROM subject INNER JOIN marks ON subject.id=marks.subject_id WHERE marks.main_id='$main_id'";
            $subject_number_result = $this->_db->query($subject_number_sql);
            $number = $subject_number_result->fetch()["numplus"];

            $sql = "INSERT INTO subject (name, number) VALUES ('$name', '$number')";
            $result = $this->_db->query($sql);
            if ($result == true) {
                echo "Тема успешно добавлен в БД";
            }
        }

        $group_student_sql = "SELECT id FROM students WHERE group_id='$group_id'";
        $group_student_result = $this->_db->query($group_student_sql);

        while ($row = $group_student_result->fetch(PDO::FETCH_ASSOC)) {
            $marks_sql = "INSERT INTO marks (main_id, student_id, subject_id) VALUES ('$main_id', '".$row["id"]."', (SELECT id FROM subject WHERE name LIKE '$name'))";
            $marks_result = $this->_db->query($marks_sql);
        }
    }

    public function changeSubject($subject_id, $text) {
        $sql = "UPDATE subject SET name='$text' WHERE id='$subject_id'";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Данные успешно изменены";
        }
    }

    public function deleteSubjectFromDB($subject_id) {
        $sql = "DELETE FROM marks WHERE subject_id='$subject_id'";
        $result = $this->_db->query($sql);

        $sql = "DELETE FROM subject WHERE id='$subject_id'";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Тема успешно удалена";
        }
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
                $output .= '<div><h3 align="center">Оценки</h3></div>';
                $output .= '<div class="table-responsive">';
                $output .= '<table class="table table-bordered">';
                $output .= '<thead>';
                $output .= '<tr>';
                $output .= '<td width="30%"></td>';

                while ($row = $subject_result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<td width="4%">Т'.$row["number"].'</td>';
                }

                $output .= '</tr>';
                $output .= '</thead>';
                $output .= '<tbody>';

                $student_sql = "SELECT id, name, surname FROM students WHERE group_id='$group_id'";
                $student_result = $this->_db->query($student_sql);

                while ($row = $student_result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<tr>';
                    $output .= '<td width="30%">'.$row["surname"].' '.$row["name"].'</td>';

                    $mark_sql = "SELECT id, mark FROM marks WHERE marks.main_id='$main_id' AND marks.student_id='".$row["id"]."'";
                    $mark_result = $this->_db->query($mark_sql);

                    while ($row_mark = $mark_result->fetch(PDO::FETCH_ASSOC)) {
                        $output .= '<td width="4%" data-id-mark="'.$row_mark["id"].'" class="changeMark" contenteditable>'.$row_mark["mark"].'</td>';
                    }

                    $output .= '</tr>';
                }

                $output .= '</tbody>';
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

                $output .= '<hr/>';
                $output .= '<div><h3 align="center">Оценки</h3></div>';
                $output .= '<div class="table-responsive">';
                $output .= '<table class="table table-bordered">';

                $output .= '<tr>';
                $output .= '<td></td>';
                $output .= '</tr>';

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<tr>';
                    $output .= '<td>'.$row['surname'].' '.$row['name'].'</td>';
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

    public function changeMark($mark_id, $text) {
        $sql = "UPDATE marks SET mark='$text' WHERE id='$mark_id'";
        $result = $this->_db->query($sql);

        if ($result == true) {
            echo "Данные успешно изменены";
        }
    }
}
?>