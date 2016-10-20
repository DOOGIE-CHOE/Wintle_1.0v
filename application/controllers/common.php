<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/13/2016
 * Time: 10:51 AM
 */

class Common extends Controller{

    function index($noInclude = false, $loggedIn = false){}

    public function getProfilePhoto($type,$useremail){
        $data = $this->model->getProfilePhoto($type,$useremail);
        echo json_encode($data);
    }

    public function checkProfileUrl($profileurl) {
        $data = $this->model->checkProfileUrl($profileurl);
        return $data;
    }
}