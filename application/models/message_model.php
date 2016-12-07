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
}
