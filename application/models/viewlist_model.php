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


    function loadNewContents($limist, $offset)
    {
        try {
            $contents = array();
            $projects = array();
            $tmp = null;

           // $sql = "select * from view_all_project_info order by upload_date desc limit $limist offset $offset";
              $sql = "select * from view_all_project_info  order by upload_date desc, sequence asc limit $limist offset $offset ";
            $result = $this->db->conn->query($sql);

            $data = $result->fetch_assoc();

            $tmp = $data['project_id'];
            array_push($projects, $data);
            while ($data = $result->fetch_assoc()) {
                if ($tmp == $data['project_id']) {
                    array_push($projects, $data);
                } else {
                    array_push($contents, $projects);
                    $tmp = $data['project_id'];
                    $projects = array();
                    array_push($projects, $data);
                }
            }
            array_push($contents, $projects);

            $sql = "SELECT * from view_all_content_info limit $limist offset $offset";
            $result = $this->db->conn->query($sql);
            while( $data = $result->fetch_assoc()){
                $data['project_id'] = false;
                array_push($contents,$data);
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