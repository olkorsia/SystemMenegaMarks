<?php
session_start();
require_once "ConnectDB.php";

class PrepodSettings
{
    private $_db = null;

    public function __construct()
    {
        $this->_db = connectDB::getInstance();
    }

    public function changePassword($last_password, $new_password) {
        $prepod_id = $_SESSION['prepod_id'];

        $sql = "SELECT id FROM prepod WHERE id='$prepod_id' AND prepod_password='$last_password'";
        $result = $this->_db->query($sql);

        if ($result->rowCount() == 1) {
            $sql = "UPDATE prepod SET prepod_password='$new_password' WHERE id='$prepod_id'";
            $result = $this->_db->query($sql);

            if ($result) {
                echo 'OK Change password';
            } else {
                echo 'DON\'T change password';
            }
        } else {
            echo 'Password enter don\'t right!';
        }
    }
}
?>