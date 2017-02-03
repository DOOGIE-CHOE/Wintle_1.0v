<?php

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 12/27/16
 * Time: 2:10 PM
 */
class ViewList_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }


    function loadNewContents($offset)
    {
        try {
            $contents = array();
            $sql = "SELECT * from view_all_content_info";
            $result = $this->db->conn->query($sql);

            while ($data = $result->fetch_assoc()) {
                array_push($contents, $data);
            }
            if (is_null($contents)) {
                throw new Exception("Something went wrong. please refresh the page");
            }

        } catch (Exception $e) {
            $contents = $e->getMessage();
        } finally {
            return $contents;
        }
    }

    function loadContentsByHash()
    {
        try {
            $contents = array();
            $hashtags = rtrim($_GET['hashtags'], '/');
            $hashtags = explode('/', $hashtags);

            $querytmp = "hashtags like '%$hashtags[0]%'";


            for ($i = 1; $i < count($querytmp); $i++) {
                $querytmp .= "or hashtags like '%$querytmp[$i]%'";
            }
            $sql = "SELECT * from view_content_with_hashtag where " . $querytmp;

            $result = $this->db->conn->query($sql);


            while ($data = $result->fetch_assoc()) {
                array_push($contents, $data);
            }

//            if (is_null($contents)) {
//                throw new Exception("Something went wrong. please refresh the page");
//            }
        } catch (Exception $e) {
            $contents = $e->getMessage();
        } finally {
            return $contents;
        }
    }

}