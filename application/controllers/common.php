<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/13/2016
 * Time: 10:51 AM
 */

class Common extends Controller{

    function index(){}

    public function getProfilePhoto($type,$userid){
        $data = $this->model->getProfilePhoto($type,$userid);
        echo json_encode($data);
    }

    public function checkProfileUrl($profileurl) {
        $data = $this->model->checkProfileUrl($profileurl);
        return $data;
    }

    public function getUsernameById($userid){
        $data = $this->model->getUsernameById($userid);
        echo json_encode($data);
    }

    public function checkUsername($username){
        $data = $this->model->getUsernameById($username);
        echo json_encode($data);
    }

    public function getUserIdByName($username){
        $data = $this->model->getUserIdByName($username);
        echo json_encode($data);
    }

    public function likeContent($contentname, $username){
        $data = $this->model->likeContent($contentname, $username);
        echo json_encode($data);
    }
}