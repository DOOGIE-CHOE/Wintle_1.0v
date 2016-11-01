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

    function index($noInclude = false, $loggedIn = false){
        //  $this->view->render("profile/index",false,false,"profile/home");

        $list = array();
        array_push($list,
            "header",
            "errorMessage"
        );
        if($loggedIn == false){
            array_push($list,"loginpopup");
        }
        array_push($list,
            "profile/index",
            "profile/home",
            "musicplayer",
            "footer"
        );


        $this->view->test($list);
    }

    function home(){
        $this->view->render("profile/index",false,false,"profile/home");
    }

    function playlists(){
        $this->view->render("profile/index",false,false,"profile/playlists");
    }

    function projects(){
        $this->view->render("profile/index",false,false,"profile/projects");
    }

    function friends(){
        $this->view->render("profile/index",false,false,"profile/friends");
    }

    function following(){
        $this->view->render("profile/index",false,false,"profile/following");
    }

    function followers(){
        $this->view->render("profile/index",false,false,"profile/followers");
    }

    public function uploadProfilePhoto($type){
        $this->model->uploadProfilePhoto($type);
    }


}