<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2/15/17
 * Time: 1:17 PM
 */

class Block_Model extends Model{
    function __construct(){
        parent::__construct();
    }

    function getContentInfo($id)
    {
        $data = null;
        try{
            /* id for all content */
            if($id >= 200000000 && $id <= 499999999){
                $sql = "SELECT * from view_all_content_info where content_id = $id";
                $result = $this->db->conn->query($sql);
                $data = $result->fetch_assoc();
                if (is_null($data)) {
                    throw new Exception("Something went wrong. please refresh the page");
                }

            }
        } catch (Exception $e) {
            $data = $e->getMessage();
        } finally {
            return $data;
        }
    }
}