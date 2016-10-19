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
        if($loggedIn == false){
            return false;
        }
        $this->view->render("profile/index", $noInclude, $loggedIn);
    }

    function projects($noInclude = false, $loggedIn = false){
        if($loggedIn == false){
            return false;
        }
        $noInclude = true;
        $this->view->render("profile/projects", $noInclude, $loggedIn);
    }

    public function uploadProfilePhoto($type){
        $this->model->uploadProfilePhoto($type);
    }


}