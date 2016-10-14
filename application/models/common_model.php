<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/13/2016
 * Time: 10:53 AM
 */

class Common_Model extends Model{

    function __construct(){
        parent::__construct();
    }

    function getProfilePhoto($type){
        if(Session::isSessionSet("user_email")){
            if($type == 'profile'){
                $attr = "profile_photo_path";
            }else if($type == "cover"){
                $attr = "cover_photo_path";
            }

            $user_email = Session::get("user_email");
            $sql = "SELECT $attr from user_profile where user_email = '$user_email'";
            $result = $this->db->conn->query($sql);
            $data = $result->fetch_assoc();
            return $data;
        }else{
            return null;
        }
    }

}