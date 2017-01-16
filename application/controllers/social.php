<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 1/16/17
 * Time: 2:38 PM
 */


class Social extends Controller {
    function index(){}

    function callSignUp(){
        $data = $this->model->signUp();
        echo json_encode($data);
    }

}