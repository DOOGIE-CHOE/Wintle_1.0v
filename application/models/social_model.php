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

    function google_login($id_token){
        require_once (ROOT. DS. 'library'.DS.'vendor'.DS.'autoload.php');

        $CLIENT_ID = "611141018688-vjcv2sqjcf133cgi453ogfi3lnj4c1bk.apps.googleusercontent.com";

        $client = new Google_Client(['client_id' => $CLIENT_ID]);
        $payload = $client->verifyIdToken($id_token);

        if ($payload) {

            $sql = "SELECT user_id, user_name, token_id from user where token_id='$id_token'";
            $result = $this->db->conn->query($sql);
            $data = $result->fetch_assoc();
            if (!isset($data)) {




                return 111;
            }
                return 222;
                //login procedure


        } else {
            return 0;
            // Invalid ID token
        }
    }

}