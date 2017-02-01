<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 1/27/17
 * Time: 3:50 PM
 */


class Search_Model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function searchRandom(){


    }

    function searchBlocks(){
        try {
            $contents = array();
            $sql = null;
            $tags = explode(' ', $_GET['tags']);
            $search = new SearchEngine();
          //  $ex = iconv("utf8", "euckr", $tags[0]);
            //check the first keyword
            if(isset($tags)){
                if(substr($tags[0], 0, 1) == '#'){
                    $sql = $search->createQueryStringHash($tags);
                }else{
                    $sql = $search->createQueryStringComments($tags);
                }
            }
            $result = $this->db->conn->query($sql);
            while ($data = $result->fetch_assoc()) {
                array_push($contents, $data);
            }
        } catch (Exception $e) {
            $contents = $e->getMessage();
        } finally {
            return $contents;
        }
    }

    function searchBoxes(){


    }

    function searchPeople(){


    }


}