<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';

class Model {
    public $conn;

    function __construct() {
        // Create connection
        $this->conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);
        // Check connection
        if ($this->conn->connect_error) {
            // die("Connection failed: " . $conn->connect_error);
            throw new Exception ("Something went wrong.. :( Please, try it later");
        }
    }

    function __destruct() {
        if (!empty($this->conn)) {
            $this->conn->close();
        }
    }


    function GetHashCode($password, $salt = false) {
        //set cost (higher number, higher security but slow processing time
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
}
?>