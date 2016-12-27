<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 12/27/16
 * Time: 2:10 PM
 */

class ViewList_Model extends Model{

    function __construct(){
        parent::__construct();
    }


    function loadNewContents($offset){
        $contents = array();
        $sql = "SELECT * from wintle.view_all_content_info";
        $result = $this->db->conn->query($sql);

        while($data = $result->fetch_assoc()){
            array_push($contents,$data);
        }
        if (!is_null($contents)) {
            return $contents;
        } else {
            throw new Exception("Something went wrong. please refresh the page");
        }
    }
}