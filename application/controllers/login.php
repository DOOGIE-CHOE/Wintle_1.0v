<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/13/2016
 * Time: 3:11 PM
 */

class LogIn extends Controller{

    function index(){}

    function callLogIn(){
        $data =  $this->model->logIn();
        echo json_encode($data);
    }
}
