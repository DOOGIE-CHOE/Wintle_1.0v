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


    function loadNewContents($limit, $offset_main)
    {
        try {
            $contents = array();
            $projects = array();
            $tmp = null;


            $sql = "SELECT * from view_all_content_info limit $limit offset $offset_main";
            $result = $this->db->conn->query($sql);
            while( $data = $result->fetch_assoc()){
                $data['project_id'] = false;
                array_push($contents,$data);
            }

           // $sql = "select * from view_all_project_info order by upload_date desc limit $limist offset $offset";
//              $sql = "select * from view_all_project_info  order by upload_date desc, sequence asc limit $limit offset $offset_main ";

            //각 프로젝트 마다 포함하는 콘텐츠의 갯수가 다르므로, 프로젝트로 그룹바이를 한 뒤 offset을 줘서 프로젝스 갯수를 만큼 가져옴
            $sql = "select * from view_all_project_info as plist inner join
                    (select project_id from view_all_project_info
                    group by project_id
                    order by upload_date desc
                    limit $limit offset $offset_main ) as pid
                    on plist.project_id = pid.project_id
                    order by upload_date desc, sequence asc
                    ";

            $result = $this->db->conn->query($sql);

            $data = $result->fetch_assoc();

            $tmp = $data['project_id'];
            array_push($projects, $data);
            while ($data = $result->fetch_assoc()) {
                //가져온 콘텐츠가 이전 콘텐츠와 같은 프로젝트에 속해있다면
                if ($tmp == $data['project_id']) {
                    array_push($projects, $data);
                } else {
                    //다른 프로젝트라면 꺼내온 같은 프로젝트들을 contents 변수에 집어넣고 프로젝트 변수 재 선언
                    array_push($contents, $projects);
                    $tmp = $data['project_id'];
                    $projects = array();
                    array_push($projects, $data);
                }
            }
            array_push($contents, $projects);


            if (is_null($contents)) {
                throw new Exception("Something went wrong. please refresh the page");
            }

        } catch (Exception $e) {
            if($e->getCode() == 0 )
                $contents = $e->getMessage();
            else
                $contents = "System error occurs. Try it later or contact to system manager";
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
            if($e->getCode() == 0 )
                $contents = $e->getMessage();
            else
                $contents = "System error occurs. Try it later or contact to system manager";
        } finally {
            return $contents;
        }
    }
}