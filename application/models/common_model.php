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

    function getProfilePhoto($type,$userid){
            if($type == 'profile'){
                $attr = "profile_photo_path";
            }else if($type == "cover"){
                $attr = "cover_photo_path";
            }

            $sql = "SELECT $attr from user_profile where user_id = '$userid'";
            $result = $this->db->conn->query($sql);
            $data = $result->fetch_assoc();
            return $data;
    }

    function checkProfileUrl($profileurl){
        $sql = "SELECT user_id from user_profile where profile_url = '$profileurl'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
       // echo    $data['user_id'];
        return $data['user_id'];
    }


    function getUsernameById($userid) {
        $sql = "SELECT user_name from user where user_id = '$userid'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['user_name'] != null) {
            return $data['user_name'];
        }
    }

    function getUserIdByName($username){
        $sql = "SELECT user_id from user where user_name = '$username'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['user_id'] != null) {
            return $data['user_id'];
        }
    }

    function likeContent($contentname, $username){


    }

}