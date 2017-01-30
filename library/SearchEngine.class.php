<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 1/28/17
 * Time: 6:32 PM
 */

class SearchEngine {

    function __construct(){
    }


    function createQueryStringHash($keywords){
        $list = $this->getOnlyHashTags($keywords);

        $querytmp = "hashtags like '%$list[0]%'";


        for ($i = 1; $i < count($list); $i++) {
            $querytmp .= "or hashtags like '%$list[$i]%'";
        }
        $sql = "SELECT * from view_content_with_hashtag where " . $querytmp;

        return $sql;

    }

    function createQueryStringOthers($keywords){

    }

    function removeForbiddenSpecialCharacters($keywords){
        $forbiddencharacters = array('\'','"','\\');
        $list = str_replace($forbiddencharacters, '',$keywords);
        return $list;
    }

    function removeSpecialCharacters($keywords){

    }

    function getOnlyHashTags($keywords){
        $list = array();
        foreach($keywords as $word){
            if(substr($word, 0, 1) == '#'){
                array_push($list, $word);
            }
        }
        return $list;
    }


}