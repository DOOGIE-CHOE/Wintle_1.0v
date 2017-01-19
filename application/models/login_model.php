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
                    Session::set("my_profile",$this->getProfileUrl(Session::get("user_id")));

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
        }catch(Exception $e) {
            $data['error'] = $e->getMessage();
        }finally {
            return $data;
            //echo json_encode($data);
        }
    }



}