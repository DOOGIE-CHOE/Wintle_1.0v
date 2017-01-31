<?php

/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 1/28/17
 * Time: 6:32 PM
 */
class SearchEngine
{

    function __construct()
    {
    }


    function createQueryStringHash($keywords)
    {
        $list = $this->getOnlyHashTags($keywords);
        $querytmp = "hashtags like '%$list[0]%'";
        for ($i = 1; $i < count($list); $i++) {
            $querytmp .= "or hashtags like '%$list[$i]%'";
        }
        $sql = "SELECT * from view_all_content_info where " . $querytmp;
        return $sql;
    }

    function createQueryStringComments($keywords)
    {
        $list = $this->removeForbiddenSpecialCharacters($keywords);
        $querytmp = "comments like '%$list[0]%'";
        for ($i = 1; $i < count($list); $i++) {
            $querytmp .= "or comments like '%$list[$i]%'";
        }
        $sql = "SELECT * from view_all_content_info where " . $querytmp;
        return $sql;
    }

    function createQueryStringUser($keywords)
    {
        $list = $this->removeSpecialCharacters($keywords);
        $querytmp = "user_name like '%$list[0]%'";
        for ($i = 1; $i < count($list); $i++) {
            $querytmp .= "or user_name like '%$list[$i]%'";
        }
        $sql = "SELECT * from user where " . $querytmp;
        return $sql;
    }


    function removeForbiddenSpecialCharacters($keywords)
    {
        $forbiddencharacters = array('\'', '"', '\\');
        $list = array();
        foreach ($keywords as $word) {
            array_push($list, str_replace($forbiddencharacters, '', $word));
        }
        return $list;
    }

    function removeSpecialCharacters($keywords)
    {
        $list = array();
        foreach ($keywords as $word) {
            $string = str_replace(' ', '-', $word); // Replaces all spaces with hyphens.
            array_push($list, preg_replace('/[^A-Za-z0-9\-]/', '', $string)); // Removes special chars.
        }
        return $list;
    }

    function getOnlyHashTags($keywords)
    {
        $list = array();
        foreach ($keywords as $word) {
            if (substr($word, 0, 1) == '#') {
                array_push($list, $word);
            }
        }
        return $list;
    }


}