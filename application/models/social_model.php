<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 1/16/17
 * Time: 3:12 PM
 */


class Social_Model extends Model{
    function __construct(){
        parent::__construct();
    }

    function google_login($id_token)
    {
        require_once(ROOT . DS . 'library' . DS . 'vendor' . DS . 'autoload.php');

        $CLIENT_ID = "611141018688-vjcv2sqjcf133cgi453ogfi3lnj4c1bk.apps.googleusercontent.com";

        $client = new Google_Client(['client_id' => $CLIENT_ID]);

        $payload = $client->verifyIdToken($id_token);

        if ($payload) {
            $data = array();
            try {
                $sql = $this->db->conn->prepare("CALL Win_User_SignUp(?,?,?,?,@_return)");

                $password = 0;
                $token = $payload['sub'];

                //Put arguments
                $sql->bind_param('ssss', $payload['given_name'], $payload['email'], $password, $token);
                $sql->execute();

                //Get output from Stored Procedure
                $select = $this->db->conn->query('select @_return');
                $result = $select->fetch_assoc();

                if ($result['@_return'] == 0) {
                    Session::set("user_email",$payload['email']);
                    Session::set("loggedIn",true);
                    Session::set("social_loggedIn",true);
                    Session::set("user_id",$this->getUserIdByEmail($payload['email']));
                    Session::set("user_name",$this->getUsernameByEmail($payload['email']));
                    Session::set("my_profile",$this->getProfileUrl(Session::get("user_id")));
                    $this->logInCount(Session::get("user_id"));
                    $data['success'] = true;
                } else {
                    throw new Exception("System error occur :( please try it later");
                }
            } catch (Exception $e) {
                $data['error'] = $e->getMessage();
            } finally {
                return $data;

            }
        }
    }

}