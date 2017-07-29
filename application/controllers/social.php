<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 1/16/17
 * Time: 2:38 PM
 */


class Social extends Controller {
    function index(){}

    function google_login($id_token){
        $data = $this->model->google_login($id_token);
        echo json_encode($data);
    }

}