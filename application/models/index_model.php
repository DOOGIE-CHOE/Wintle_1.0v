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
/*
    function loadNewContents($offset){
        $contents = array();
        $sql = "SELECT * from view_all_content_info limit 100 offset $offset";
        $result = $this->db->conn->query($sql);

        while($data = $result->fetch_assoc()){
            array_push($contents,$data);
        }
        if (!is_null($contents)) {
            return $contents;
        } else {
            throw new Exception("Something went wrong. please refresh the page");
        }
    }*/
}