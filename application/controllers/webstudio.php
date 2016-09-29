<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/28/2016
 * Time: 3:23 PM
 */


class WebStudio extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index($noInclude = false, $loggedIn = false){
        $this->view->render("webstudio/index", $noInclude, $loggedIn);
    }

    public function sample(){
        $this->view->render("webstudio/sample", true, false);
    }

    public function uploadAudio(){
        $this->model->uploadAudio();
    }


}