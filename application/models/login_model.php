<?php

class LogIn_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function logIn(){
        $data = array();

        try{
            if($this->CheckId($_POST['user_email'])){
                if($this->CheckPassword($_POST['user_email'],$_POST['password'])){
                    Session::init();
                    Session::set("user_email",$_POST['user_email']);
                    Session::set("loggedIn",true);
                    Session::set("user_name",$this->GetUsernameByEmail($_POST['user_email']));
                    $data['success']=true;
                }
            }
        }catch(Exception $e) {
            $data['error'] = $e->getMessage();
        }finally {
            echo json_encode($data);
        }
    }

    function CheckId($_user_email){
        $sql = "SELECT count(user_email) as emailnumber from user where user_email = '$_user_email'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['emailnumber'] == 1) {
            return true;
        } else {
            throw new Exception("Username or password is wrong. Please, check it again");
        }
    }

    function CheckPassword($_user_email,$_password) {
        $sql = "SELECT password from user where user_email = '$_user_email'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['password'] != null) {
            $tmp = $this->GetHashCode($_password, $data['password']);
            if ($tmp == $data['password']) {
                return true;
            }
        }
        throw new Exception("Username or password is wrong. Please, check it again");
    }

    function GetUsernameByEmail($user_email) {
        $sql = "SELECT name from user where user_email = '$user_email'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['name'] != null) {
            return $data['name'];
        }
    }
}