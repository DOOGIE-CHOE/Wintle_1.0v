<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/13/2016
 * Time: 3:12 PM
 */

class SignUp extends Controller {
    function index($noInclude = false, $loggedIn = false){}

    function callSignUp(){
        $data = $this->model->signUp();
        echo json_encode($data);
    }

}