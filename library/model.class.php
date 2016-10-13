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
}