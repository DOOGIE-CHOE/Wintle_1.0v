<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/14/2016
 * Time: 9:56 PM
 */

Class SignUp_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function signUp() {
        $data = array();

        try {
            $sql = $this->db->conn->prepare("CALL Win_User_SignUp(?,?,?,?,@_return)");
            $password = $this->GetHashCode($_POST['password_signup']);

            //소셜 로그인시 필요. 수동 로그인임으로 0 처리
            $token = 0;
            //Put arguments
            $sql->bind_param('ssss',$_POST['user_name_signup'],$_POST['user_email_signup'],$password, $token);
            $sql->execute();

            //Get output from Stored Procedure
            $select = $this->db->conn->query('select @_return');
            $result = $select->fetch_assoc();

            if($result['@_return'] == 0){
                $data['success'] = true;


                Session::set("user_email",$_POST['user_email_signup']);
                Session::set("loggedIn",true);
                Session::set("user_id",$this->getUserIdByEmail($_POST['user_email_signup']));
                Session::set("user_name",$this->getUsernameByEmail($_POST['user_email_signup']));
                Session::set("my_profile",$this->getProfileUrl(Session::get("user_id")));
                $this->logInCount(Session::get("user_id"));

            }else {
                throw new Exception("Email address is already existing");
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
}

class Verification
{
    //Google recaptcha API url
    private $google_url = "https://www.google.com/recaptcha/api/siteverify";
    private $secret = '6LcZwyATAAAAAFzPeCoBRL-ptF9gnGs-tP5-Bdik';

    public function verifyCaptcha($response)
    {
        $url = $this->google_url . "?secret=" . $this->secret . "&response=" . $response;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $curlData = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($curlData, TRUE);
        if ($res['success'] == 'true')
            return TRUE;
        else
            return FALSE;
    }
}

?>