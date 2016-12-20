<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/20/2016
 * Time: 3:14 PM
 */

class Upload_Model extends Model {

    function __construct(){
        parent::__construct();
    }

    function uploadContent($type){
        $data = array();
        try{
            $this->db->conn->begin_transaction();
            $sql = $this->db->conn->prepare("CALL Win_Upload_Content(?,?,?,?,?,@result)");
            $user_id = Session::get('user_id');

            //Put arguments
            $sql->bind_param('sssss',$_POST['content_title'],$_POST['content_path'],$_POST['content_comments'],$user_id,$type);
            $sql->execute();

            //Get output from Stored Procedure
            $select = $this->db->conn->query('select @result');
            $result = $select->fetch_assoc();

            if($result['@result'] > 0){
                $tmp = rtrim($_POST['hashtags'], ',');
                $hashtags = explode(',', $tmp);
                foreach($hashtags as $hash){
                    $sql = $this->db->conn->prepare("CALL Win_Upload_Hashtag(?,?,@result)");
                    $sql->bind_param('ss',$result['@result'],$hash);
                    $sql->execute();
                    $select = $this->db->conn->query('select @result');
                    $hash_result = $select->fetch_assoc();
                    if($hash_result['@result'] != 1){
                        throw new Exception("System error occur :( please try it later");
                    }
                }
                $data['success'] = true;
                $this->db->conn->commit();
            }else{
                throw new Exception("System error occur :( please try it later");
            }
        }
        catch(Exception $e){
            $this->db->conn->rollback();
            $data['error'] = $e->getMessage();
        }finally{
            return $data;
        }

    }

}