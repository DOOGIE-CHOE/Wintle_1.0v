<?php

class LogIn_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function logIn(){
        $data = array();

        try{
            if($this->checkId($_POST['user_email'])){
                if($this->checkPassword($_POST['user_email'],$_POST['password'])){
                    Session::set("user_email",$_POST['user_email']);
                    Session::set("loggedIn",true);
                    Session::set("user_id",$this->getUserIdByEmail($_POST['user_email']));
                    Session::set("user_name",$this->getUsernameByEmail($_POST['user_email']));
                    Session::set("my_profile",$this->getProfileUrl($_POST['user_email']));
                    $data['success'] = true;
                }
            }

            /*$sql = $this->db->conn->prepare("CALL Win_User_LogIn(?,?,@return)");

            $password = $this->GetHashCode($_POST['password']);

            //Put arguments
            $sql->bind_param('ss',$_POST['user_email'],$password);
            $sql->execute();

            //Get output from Stored Procedure
            $select = $this->db->conn->query('select @return');
            $result = $select->fetch_assoc();

            if($result['@return'] == 0){
                Session::set("loggedIn",true);
                Session::set("user_id",$this->getUserIdByEmail($_POST['user_email']));
                Session::set("user_email",$_POST['user_email']);
                Session::set("user_name",$this->getUsernameByEmail($_POST['user_email']));
                Session::set("my_profile",$this->getProfileUrl(Session::get("user_id")));
                $data['success'] = true;
            }else if($result['@return'] == -1){
                throw new Exception("Your account does not exist");
            }else if($result['@return'] == -2){
                throw new Exception("User email or password is wrong. Please, check it again");
            }else {
                throw new Exception("System error occur :( please try it later");
            }*/

            return $data['success'];
        }catch(Exception $e) {
            $data['error'] = $e->getMessage();
        }finally {
            echo json_encode($data);
        }
    }

    function checkId($_user_email){
        $sql = "SELECT count(user_email) as emailnumber from user where user_email = '$_user_email'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['emailnumber'] == 1) {
            return true;
        } else {
            throw new Exception("Username or password is wrong. Please, check it again");
        }
    }

    function checkPassword($_user_email,$_password) {
        $sql = "SELECT password from user where user_email = '$_user_email'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['password'] != null) {
            $tmp = $this->getHashCode($_password, $data['password']);
            if ($tmp == $data['password']) {
                return true;
            }
        }
        throw new Exception("Username or password is wrong. Please, check it again");
    }

    function getUsernameByEmail($user_email) {
        $sql = "SELECT user_name from user where user_email = '$user_email'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['user_name'] != null) {
            return $data['user_name'];
        }
    }


    function getUserIdByEmail($user_email){
        $sql = "SELECT user_id from user where user_email = '$user_email'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['user_id'] != null) {
            return $data['user_id'];
        }
    }

    function getProfileUrl($user_id){
        $sql = "SELECT profile_url from user_profile where user_id = '$user_id'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        return $data['profile_url'];
    }

}