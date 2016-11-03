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

    function playlists(){
        $this->profileRender("playlists");
    }

    function projects(){
        $this->profileRender("projects");
    }

    function friends(){
        $this->profileRender("friends");
    }

    function following(){
        $this->profileRender("following");
    }

    function followers(){
        $this->profileRender("followers");
    }

    public function uploadProfilePhoto($type){
        $this->model->uploadProfilePhoto($type);
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
        array_push($list,"musicplayer","footer");
        $this->view->render($list);
    }

}