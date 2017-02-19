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
        $contents = array();
        $projects = array();
        $tmp = null;
        try{
            /* id for all content */
            if($id >= 200000000 && $id <= 499999999){
                $sql = "SELECT * from view_all_content_info where content_id = $id";
                $result = $this->db->conn->query($sql);

                while ($data = $result->fetch_assoc()) {
                    array_push($contents, $data);
                }

                if (empty($contents)) {
                    throw new Exception("Something went wrong. please refresh the page");
                }

            }
            else if($id >= 700000000 && $id <= 799999999){
                $sql = "SELECT * from view_all_project_list_info where project_id = $id";
                $result = $this->db->conn->query($sql);

                while ($data = $result->fetch_assoc()) {
                    array_push($contents, $data);
                }

                if (empty($contents)) {
                    throw new Exception("Something went wrong. please refresh the page");
                }
            }
        } catch (Exception $e) {
            $contents = $e->getMessage();
        } finally {
            return $contents;
        }
    }
}