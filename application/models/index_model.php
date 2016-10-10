<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/10/2016
 * Time: 5:56 PM
 */

class Index_Model extends Model{
    function __construct(){
        parent::__construct();
    }

    function getProfilePhoto(){
        if(Session::isSessionSet("user_email")){
            $user_email = Session::get("user_email");
            $sql = "SELECT profile_photo_path from user_profile where user_email = '$user_email'";
            $result = $this->db->conn->query($sql);
            $data = $result->fetch_assoc();
            return $data;
        }else{
            return null;
        }

    }


}