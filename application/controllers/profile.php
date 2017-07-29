<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/11/2016
 * Time: 4:27 PM
 */

class Profile extends Controller{

    function __construct() {
        parent::__construct();
    }

    function index(){
        $this->profileRender("home");
    }

    function home(){
        $this->profileRender("home");
    }

    function about(){
        $this->profileRender("about");
    }

    function box(){
        $this->profileRender("box");
    }

    function follow(){
        $this->followRender("follow", "followers");
    }

    function followers(){
        $this->followRender("follow", "followers");
    }

    function following(){
        $this->followRender("follow", "following");
    }

    /*
    function playlists(){
        $this->profileRender("playlists");
    }

    function projects(){
        $this->profileRender("projects");
    }

    function friends(){
        $this->profileRender("friends");
    }
    */

    function loadMyContents($limist, $offset_home, $profile_id){
        $data = $this->model->loadMyContents($limist, $offset_home, $profile_id);
        echo json_encode($data);
    }

    function loadMyFollow($limist, $offset_home, $profile_id, $follow){
        $data = $this->model->loadMyFollow($limist, $offset_home, $profile_id, $follow);
        echo json_encode($data);
    }

    function setUserFollow($user_id_2){
        $this->model->setUserFollow($user_id_2);
    }

    public function uploadProfilePhoto($type){
        $this->model->uploadProfilePhoto($type);
    }

    public function userCoverPhotoPosition($profile_id, $top_position){
        $this->model->userCoverPhotoPosition($profile_id, $top_position);
    }

    public function getUserFollow($profile_id){
        $data = $this->model->getUserFollow($profile_id);
        echo json_encode($data);
    }

    public function getCoverPhotoPosition($profile_id){
        $data = $this->model->getCoverPhotoPosition($profile_id);
        echo json_encode($data);
    }

    public function getUserLike($profile_id){
        $data = $this->model->getUserLike($profile_id);
        echo json_encode($data);
    }

    public function getContentsNumber($profile_id){
        $data = $this->model->getContentsNumber($profile_id);
        echo json_encode($data);
    }

    public function getRemixingNumber($profile_id){
        $data = $this->model->getRemixingNumber($profile_id);
        echo json_encode($data);
    }

    function profileRender($contents){
        $list = array();
        array_push($list,
            "header",
            "errorMessage"
        );
        if(!Session::isSessionSet("loggedIn")){
            array_push($list,"loginpopup");
        }
        array_push($list,"profile/index");
        array_push($list,"profile/".$contents);
        array_push($list,
            "musicplayer",
            "footer");
        $this->view->render($list);
    }

    function followRender($contents, $follow_menu){
        $list = array();
        array_push($list,
            "header",
            "errorMessage"
        );
        if(!Session::isSessionSet("loggedIn")){
            array_push($list,"loginpopup");
        }
        array_push($list,"profile/index");
        array_push($list, "profile/".$contents);
        array_push($list, "profile/".$contents."/".$follow_menu);
        array_push($list,
            "musicplayer",
            "footer");
        $this->view->render($list);
    }

}