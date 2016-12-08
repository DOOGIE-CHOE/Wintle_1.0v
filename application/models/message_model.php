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

            if($result['@result'] == 0){
                $data['success'] = true;
            }else if($result['@result'] == -1){
                throw new Exception("Some thing went wrong, please try it later");
            }else {
                throw new Exception("System error occur :( please try it later");
            }
        }
        catch(Exception $e){
            $data['error'] = $e->getMessage();
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

        /*if (!empty($data)) {
            return $data;
        } else {
            throw new Exception("Couldn't load message lists..");
        }*/

        $aa = array();
        while ($data = $result->fetch_assoc())
        {
            array_push($aa,$data);
        }
        return $aa;

        /*
        if($result->num_rows <= 0) {
            return null;
        }
        else{

        }*/

/*
        */

    }
}
