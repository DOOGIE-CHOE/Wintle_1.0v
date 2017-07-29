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

    public function likeContent($content_id){
        $data = $this->model->likeContent($content_id);
        echo json_encode($data);
    }

    public function getLikeNum($content_id,$type){
        $data = $this->model->getLikeNum($content_id,$type);
        echo json_encode($data);
    }

    public function isLikedContent($content_id){
        $data = $this->model->isLikedContent($content_id);
        echo json_encode($data);
    }

    public function getFollowNumber($profile_id){
        $data = $this->model->getFollowNumber($profile_id);
        echo json_encode($data);
    }

    public function checkFileExistence($filename){
        $data = $this->model->checkFileExistence($filename);
        echo json_encode($data);
    }
    public function checkUserEmail(){
        $data = $this->model->checkUserEmail();
        echo json_encode($data);
    }
}