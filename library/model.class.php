<?php

class Model {

	function __construct() {
		$this->db = new Database();
	}


    function getHashCode($password, $salt = false) {
        //set cost (hdigher number, higher security but slow processing time
        $cost = 10;
        if ($salt == false) {
            // Create a random salt
            $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
            // Prefix information about the hash so PHP knows how to verify it later.
            // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
            $salt = sprintf("$2a$%02d$", $cost) . $salt;
        }
        // Hash the password with the salt
        $hash = crypt($password, $salt);

        return $hash;
    }

    function createContentName($type){
        $time = getdate();
        $ran = rand(1000,9999);
        $contentid = $time['year'].$time['mon'].$time['mday'].$time['hours'].$time['minutes'].$time['seconds'].$ran;

        if($type == "image"){
            return $contentid;
        }
        else if($type == "lyrics"){
            return "L".$contentid;
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