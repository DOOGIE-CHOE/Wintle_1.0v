<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/14/2016
 * Time: 2:50 AM
 */


class Database{
    function __construct() {
        // Create connection
        $this->conn = new mysqli(DBSERVERNAME, DBUSERNAME, DBPASSWORD, DBNAME);
        // Check connection
        if ($this->conn->connect_error) {
            // die("Connection failed: " . $conn->connect_error);
            throw new Exception($this->conn->connect_error);
            //  throw new Exception ("Something went wrong.. :( Please, try it later");
        }
    }

    function __destruct() {
        if (!empty($this->conn)) {
            $this->conn->close();
        }
    }
}