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

            $output .= '<table class="table table-bordered">';
            if ($subject_result->rowCount() > 0) {
                $output .= '<tr>';
                $output .= '<td  width="40%"></td>';

                while ($row = $subject_result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<td width="5%">Т'.$row["number"].'</td>';
                }

                $output .= '<td width="5%"></td>';
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

                    $output .= '<td width="5%"></td>';
                    $output .= '</tr>';
                }
            } else {
                $sql = "SELECT name, surname FROM students WHERE group_id='$group'";
                $result = $this->_db->query($sql);

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $output .= '<tr>';
                    $output .= '<td>'.$row['surname'].' '.$row['name'].'</td>';
                    $output .= '</tr>';
                }
            }

            $output .= '</table>';
            echo $output;

        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
        }


        /*if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $output .= '  
                <tr>  
                     <td>'.$row["id"].'</td>  
                     <td class="first_name" data-id1="'.$row["id"].'" contenteditable>'.$row["first_name"].'</td>  
                     <td class="last_name" data-id2="'.$row["id"].'" contenteditable>'.$row["last_name"].'</td>  
                     <td><button type="button" name="delete_btn" data-id3="'.$row["id"].'" class="btn btn-xs btn-danger btn_delete">x</button></td>  
                </tr>  
           ';
            }
            $output .= '  
           <tr>  
                <td></td>  
                <td id="first_name" contenteditable></td>  
                <td id="last_name" contenteditable></td>  
                <td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success">+</button></td>  
           </tr>  
      ';
        }
        else
        {

        }*/
    }
}
?>