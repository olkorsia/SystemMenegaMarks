<?php
session_start();
require_once "ConnectDB.php";

class PrepodTable
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function outputTableMarks($predmet, $semestr, $group)
    {
        try {
            $prepod = $_SESSION['prepod_id'];

            $sql = "SELECT main.id FROM main inner join groups ON main.group_id=groups.id WHERE main.prepod_id='$prepod' AND main.predmet_id='$predmet' AND main.semestr = '$semestr' AND main.group_id='$group'";
            $result = $this->_db->query($sql);

            $main_id = $result->fetch()['id'];

            $output = '';
            //echo '<script>alert('.$main_id.');</script>';

            $subject_sql = "SELECT DISTINCT subject.number FROM subject INNER JOIN marks ON subject.id=marks.subject_id WHERE marks.main_id='$main_id'";
            $subject_result = $this->_db->query($subject_sql);

            if ($subject_result->rowCount() > 0) {
                $output .= '<hr/>';
                $output .= '<div class="table-responsive">';
                $output .= '<table class="table table-bordered">';
                $output .= '<tr style="background-color: #66afe9;">';
                $output .= '<td  width="30%"></td>';

                while ($row = $subject_result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<td width="3%">Т'.$row["number"].'</td>';
                }

                $output .= '<td width="3%"></td>';
                $output .= '</tr>';

                $student_sql = "SELECT DISTINCT students.id, students.name, students.surname FROM students INNER JOIN marks ON students.id=marks.student_id WHERE marks.main_id='$main_id'";
                $student_result = $this->_db->query($student_sql);


                while ($row = $student_result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<tr>';
                    $output .= '<td>'.$row["surname"].' '.$row["name"].'</td>';

                    $mark_sql = "SELECT id, mark FROM marks WHERE marks.main_id='$main_id' AND marks.student_id='".$row["id"]."'";
                    $mark_result = $this->_db->query($mark_sql);

                    while ($row_mark = $mark_result->fetch(PDO::FETCH_ASSOC)) {
                        $output .= '<td data-id='.$row_mark["id"].' contenteditable>'.$row_mark["mark"].'</td>';
                    }

                    $output .= '<td width="3%"></td>';
                    $output .= '</tr>';
                }

                $output .= '</table>';
                $output .= '</div>';

                //////////////////////////////////////////////////////////////

                $two_subject_sql = "SELECT DISTINCT subject.name, subject.number FROM subject INNER JOIN marks ON subject.id=marks.subject_id WHERE marks.main_id='$main_id'";
                $two_subject_result = $this->_db->query($two_subject_sql);

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

            } else {
                $sql = "SELECT name, surname FROM students WHERE group_id='$group'";
                $result = $this->_db->query($sql);

                $output .= '<div class="table-responsive">';
                $output .= '<table class="table table-bordered">';

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<tr>';
                    $output .= '<td>'.$row['surname'].' '.$row['name'].'</td>';
                    $output .= '<td align="center">+</td>';
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
}
?>