<?php
/*session_start();
require_once ($_SERVER['DOCUMENT_ROOT'].'/library/model.class.php');*/

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/15/2016
 * Time: 3:01 PM
 */

$data = array();
$data['success'] = false;
$data['error'] = "test";
echo json_encode($data);/*
try{
    throw new Exception("LogInForm");
    $db = new LogIn();

    if($db->CheckId($_POST['email_address'])){
        if($db->CheckPassword($_POST['email_address'],$_POST['password'])){
            $_SESSION['email_address'] = $_POST['email_address'];
            $_SESSION['loggedIn'] = true;
            $_SESSION['valid_user'] = $db->GetUsernameByEmail($_POST['email_address']);
            $data['success']=true;
        }
    }
}catch(Exception $e){
    $data['error'] = $e->getMessage();
}finally{
    echo json_encode($data);
}

class LogIn {
    private $model;

    function __construct() {
        $this->model = new Model();
    }

    function CheckId($_email_address){
        $sql = "SELECT count(email_address) as emailnumber from users where email_address = '$_email_address'";
        $result = $this->model->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['emailnumber'] == 1) {
            return true;
        } else {
            throw new Exception("Username or password is wrong. Please, check it again");
        }
    }

    function CheckPassword($_email_address,$_password) {
        $sql = "SELECT password from users where email_address = '$_email_address'";
        $result = $this->model->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['password'] != null) {
            $tmp = $this->model->GetHashCode($_password, $data['password']);
            if ($tmp == $data['password']) {
                return true;
            }
        }
        throw new Exception("Username or password is wrong. Please, check it again");
    }



    function GetUsernameByEmail($email_address) {
        $sql = "SELECT username from users where email_address = '$email_address'";
        $result = $this->model->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['username'] != null) {
            return $data['username'];
        }
    }
}*/