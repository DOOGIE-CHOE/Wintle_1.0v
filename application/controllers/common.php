<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/13/2016
 * Time: 10:51 AM
 */

class Common extends Controller{

    function index($noInclude = false, $loggedIn = false){}

    public function getProfilePhoto($type){
        $data = $this->model->getProfilePhoto($type);
        echo json_encode($data);
    }

}