<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/library/Model.class.php');

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/14/2016
 * Time: 9:56 PM
 */

$data = array();
$data['success'] = false;
$data['error'] = null;


try{
    $response = $_POST['g-recaptcha-response'];


    $db = new SignUp();

    $cap = new Verification();
    //$verified = $cap->VerifyCaptcha($response);
    //if reCAPTCHA is verified
    //if ($verified) {

    if ($db->VerifyUsername($_POST['username'])) {
        if ($db->VerifyEmail($_POST['email_address'])) {
            if($db->RegisterUser($_POST['username'],$_POST['email_address'],$_POST['password'])){
                $data['success'] = true;
            }
        }
    }
    //} else {
    //    throw new Exception("Our system recognized you as a robot.");
    //}
    //}
}catch(Exception $e){
    $data['error'] = $e->getMessage();
}finally{
    echo json_encode($data);
}



Class SignUp{
    private $model;
    /*
     * It's better to inherit Model class at here.
     * But it doesn't work by that and It works if you create Model object in constructor.
     * Need to figure it out and modify it later;
     * */
    function __construct() {
        $this->model = new Model();
    }


    function VerifyUsername($_username) {
        $sql = "SELECT count(username) as usernumber from users where username = '$_username'";
        $result = $this->model->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['usernumber'] == 0) {
            return true;
        } else {
            throw new Exception("username already exists. Please use other username");
        }
    }

    function VerifyEmail($_email_address) {
        $sql = "SELECT count(email_address) as emailnumber from users where email_address = '$_email_address'";
        $result = $this->model->conn->query($sql);
        $data = $result->fetch_assoc();
        if ($data['emailnumber'] == 0) {
            return true;
        } else {
            throw new Exception("Email address already exists. Please use another Email");
        }
    }

    function RegisterUser($_username, $_email_address, $_password) {
        $hash = $this->model->GetHashCode($_password);
        $sql = "INSERT INTO users (username, email_address, password)
                VALUES ('$_username', '$_email_address', '$hash')";
        if ($this->model->conn->query($sql) === TRUE) {
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