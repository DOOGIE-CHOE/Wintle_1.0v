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

                    $this->logInCount(Session::get("user_id"));
                    $data['success'] = true;
                }
            }
        }catch(Exception $e) {
            if($e->getCode() == 0 )
                $data['error'] = $e->getMessage();
            else
                $data['error'] = "System error occurs. Try it later or contact to system manager";
        }finally {
            return $data;
        }
    }
}