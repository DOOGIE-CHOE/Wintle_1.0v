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

    function getProfilePhoto($type,$useremail){
            if($type == 'profile'){
                $attr = "profile_photo_path";
            }else if($type == "cover"){
                $attr = "cover_photo_path";
            }

            $sql = "SELECT $attr from user_profile where user_email = '$useremail'";
            $result = $this->db->conn->query($sql);
            $data = $result->fetch_assoc();
            return $data;
    }

    function checkProfileUrl($profileurl){
        $sql = "SELECT user_email from user_profile where profile_url = '$profileurl'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        return $data['user_email'];
    }


    function getUsernameByEmail($user_email) {
        $sql = "SELECT name from user where user_email = '$user_email'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['name'] != null) {
            return $data['name'];
        }
    }
}