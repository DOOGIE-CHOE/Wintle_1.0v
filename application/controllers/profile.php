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
        $this->view->render("profile/index", $noInclude, $loggedIn,"profile/home");
    }

    function home($noInclude = false, $loggedIn = false){
        $this->view->render("profile/index", $noInclude, $loggedIn,"profile/home");
    }

    function playlists($noInclude = false, $loggedIn = false){
        $this->view->render("profile/index", $noInclude, $loggedIn,"profile/playlists");
    }

    function projects($noInclude = false, $loggedIn = false){
        $this->view->render("profile/index", $noInclude, $loggedIn,"profile/projects");
    }

    function friends($noInclude = false, $loggedIn = false){
        $this->view->render("profile/index", $noInclude, $loggedIn,"profile/friends");
    }

    function following($noInclude = false, $loggedIn = false){
        $this->view->render("profile/index", $noInclude, $loggedIn,"profile/following");
    }

    function followers($noInclude = false, $loggedIn = false){
        $this->view->render("profile/index", $noInclude, $loggedIn,"profile/followers");
    }

    public function uploadProfilePhoto($type){
        $this->model->uploadProfilePhoto($type);
    }


}