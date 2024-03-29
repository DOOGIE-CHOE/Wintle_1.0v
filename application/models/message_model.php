<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 11/30/2016
 * Time: 7:04 PM
 */
class Message_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function sendMessage(){
        $data = array();
        try {
            $sql = $this->db->conn->prepare("CALL Win_Send_Message(?,?,?,@result)");

            $sender_id = Session::get("user_id");
            //Put arguments
            $sql->bind_param('sss',$sender_id,$_POST['receiver_id'],$_POST['message']);
            $sql->execute();

            //Get output from Stored Procedure
            $select = $this->db->conn->query('select @result');
            $result = $select->fetch_assoc();

            if($result['@result'] == 1){
                $data['success'] = true;
            }else if($result['@result'] == -1){
                throw new Exception("Some thing went wrong, please try it later");
            }else {
                throw new Exception("System error occur :( please try it later");
            }
        }
        catch(Exception $e){
            if($e->getCode() == 0 )
                $data['error'] = $e->getMessage();
            else
                $data['error'] = "System error occurs. Try it later or contact to system manager";
        }finally{
            return $data;
        }
    }

    function getMessageOverView(){
        $user_id = Session::get('user_id');
        $sql = "select * from view_newest_message 
                where msg_group_id 
                in(select msg_group_id from message_list where user_id = '$user_id')";
        $result = $this->db->conn->query($sql);
        $msg = array();
        while ($data = $result->fetch_assoc())
        {
            array_push($msg,$data);
        }
        return $msg;
    }

    function getConversationByGroupId($group_id){
        $sql = "select * from user_message where msg_group_id ='$group_id'";
        $result = $this->db->conn->query($sql);
        $msg = array();
        while ($data = $result->fetch_assoc())
        {
            array_push($msg,$data);
        }
        return $msg;
    }

}


















