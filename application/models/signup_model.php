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
            //$response = $_POST['g-recaptcha-response'];
            //$cap = new Verification();
            //$verified = $cap->VerifyCaptcha($response);
            //if reCAPTCHA is verified
            //if ($verified) {

            if ($this->VerifyUsername($_POST['name'])) {
                if ($this->VerifyEmail($_POST['user_email'])) {
                    if ($this->RegisterUser($_POST['name'], $_POST['user_email'], $_POST['password'])) {
                        $data['success'] = true;
                    }
                }
            }
            //else {
            //    throw new Exception("Our system recognized you as a robot.");
           // }
        }catch(Exception $e){
            $data['error'] = $e->getMessage();
        }finally{
            echo json_encode($data);
        }
    }

    function VerifyUsername($_name) {
        $sql = "SELECT count(name) as usernumber from user where name = '$_name'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['usernumber'] == 0) {
            return true;
        } else {
            throw new Exception("username already exists. Please use other username");
        }
    }

    function VerifyEmail($_user_email) {
        $sql = "SELECT count(user_email) as emailnumber from user where user_email = '$_user_email'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['emailnumber'] == 0) {
            return true;
        } else {
            throw new Exception("Email address already exists. Please use another Email");
        }
    }

    function RegisterUser($_name, $_user_email, $_password) {
        $hash = $this->GetHashCode($_password);
        $sql = "INSERT INTO user (name, user_email, password)
                VALUES ('$_name', '$_user_email', '$hash')";
        if ($this->db->conn->query($sql) === TRUE) {
            return true;
        } else {
            //echo "Error: " . $sql . "<br>" . $conn->error;
            throw new Exception("Failed to sign up,.. :( Please, try it later");
        }
    }
}

class Verification
{
    //Google recaptcha API url
    private $google_url = "https://www.google.com/recaptcha/api/siteverify";
    private $secret = '6LcZwyATAAAAAFzPeCoBRL-ptF9gnGs-tP5-Bdik';

    public function VerifyCaptcha($response)
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