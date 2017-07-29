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
                $sql = " select * from view_all_project_info where project_id = $id order by upload_date desc, sequence asc ";
                $result = $this->db->conn->query($sql);

                while ($data = $result->fetch_assoc()) {
                    array_push($contents, $data);
                }

                if (empty($contents)) {
                    throw new Exception("Something went wrong. please refresh the page");
                }
            }
        } catch (Exception $e) {
            $contents['error'] = true;
            if($e->getCode() == 0 )
                $contents['error_message'] = $e->getMessage();
            else
                $contents['error_message'] = "System error occurs. Try it later or contact to system manager";
        } finally {
            return $contents;
        }
    }

    function getContentComment($content_id, $limit, $type){
        try{
            $comments_list = null;
            if($type == _CONTENT){
                $sql = "select * from view_all_content_comment where content_id = $content_id order by upload_date desc LIMIT $limit";
            }else if($type == _PROJECT){
                $sql = "select * from view_all_project_comment where project_id = $content_id order by upload_date desc LIMIT $limit";
            }
            $result = $this->db->conn->query($sql);
            while ($data = $result->fetch_assoc()) {
                if($comments_list == null){
                    $comments_list = array();
                }
                array_push($comments_list, $data);
            }
        }catch(Exception $e){
            $comments_list['error'] = true;
            if($e->getCode() == 0)
                $comments_list['error_message'] = $e->getMessage();
            else{
                $comments_list['error_message'] = "System error occurs. Try it later or contact to system manager";
            }
        }finally{
            return $comments_list;
        }
    }

    function uploadComment($comment_id, $user_id, $content_id, $content_type){
        try{
            //업로드 아이디와 로그인 아이디가 동일해야 함
            if($user_id != Session::get('user_id')){
                throw new Exception("잘못된 접근입니다.");
            }
            $data = null;
            $type = "insert";

            //comment_id, user_id, content_id, comment, content_type, comment_type
            $sql = $this->db->conn->prepare("CALL Win_Upload_Comment(?,?,?,?,?,?,@result)");
            $sql->bind_param('ssssss', $comment_id, $user_id, $content_id, $_POST['comment_input'],  $content_type, $type);
            $sql->execute();
            $select = $this->db->conn->query('select @result');
            $result = $select->fetch_assoc();
            if ($result['@result'] == 1) {
                $data['success'] = true;
            }else{
                throw new Exception("잘못된 접근입니다.");
            }
        } catch(Exception $e){
            $data['error'] = true;
            if($e->getCode() == 0)
                $data['error_message'] = $e->getMessage();
            else{
                $data['error_message'] = "System error occurs. Try it later or contact to system manager";
            }
        }finally{
            return $data;
        }
    }

    function getCommentCount($content_id, $type){
        if($type == _CONTENT){
            $sql = "select count(*) as comment_num from view_content_comment where content_id = $content_id";
        }else if($type == _PROJECT){
            $sql = "select count(*) as comment_num from view_project_comment where project_id = $content_id";
        }
        $select = $this->db->conn->query($sql);
        $result = $select->fetch_assoc();
        return $result['comment_num'];
    }

    function getProjectCreator($project_id){
        $sql = "select project_creator  from project where project_id = $project_id";
        $select = $this->db->conn->query($sql);
        $result = $select->fetch_assoc();
        return $result['project_creator'];
    }

    function getContentCreator($content_id){
        $sql = "select user_id  from view_all_content_info where content_id = $content_id";
        $select = $this->db->conn->query($sql);
        $result = $select->fetch_assoc();
        return $result['user_id'];
    }

    function deleteContent($id){
        try{
            //업로드 아이디와 로그인 아이디가 동일해야 함
            $user_id = null;
            $type = null;
            if($id >= 200000000 && $id <= 499999999) {
                $user_id = $this->getContentCreator($id);
                $type = _CONTENT;
            }else if($id >= 700000000 && $id <= 799999999){
                $user_id = $this->getProjectCreator($id);
                $type = _PROJECT;
            }

            if($user_id != Session::get('user_id')){
                throw new Exception("잘못된 접근입니다.");
            }

            $data = null;
            if($type == _CONTENT){
                $sql = $this->db->conn->prepare("CALL Win_Delete_Content(?,@result)");
                $sql->bind_param('s', $id);
                $sql->execute();
                $select = $this->db->conn->query('select @result');
                $result = $select->fetch_assoc();
                if ($result['@result'] == 1) {
                    $data['success'] = true;
                }else{
                    throw new Exception("잘못된 접근입니다.");
                }
            }else if($type == _PROJECT){
                $sql = $this->db->conn->prepare("CALL Win_Delete_Project(?,@result)");
                $sql->bind_param('s', $id);
                $sql->execute();
                $select = $this->db->conn->query('select @result');
                $result = $select->fetch_assoc();
                if ($result['@result'] == 1) {
                    $data['success'] = true;
                }else{
                    throw new Exception("잘못된 접근입니다.");
                }

            }else{
                throw new Exception("잘못된 접근입니다.");
            }

        } catch(Exception $e){
            $data['error'] = true;
            if($e->getCode() == 0)
                $data['error_message'] = $e->getMessage();
            else{
                $data['error_message'] = "System error occurs. Try it later or contact to system manager";
            }
        }finally{
            return $data;
        }



    }
}