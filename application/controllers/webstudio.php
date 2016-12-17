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

    function index(){
        $list = array();
        array_push($list,
            "header",
            "errorMessage"
        );
        if(!Session::isSessionSet("loggedIn")){
            array_push($list,"loginpopup");
        }
        array_push($list,
            "webstudio/index",
            "footer"
        );
        $this->view->render($list);
    }

    public function sample(){
        $list = array();
        array_push($list,
            "header",
            "errorMessage"
        );
        if(!Session::isSessionSet("loggedIn")){
            array_push($list,"loginpopup");
        }
        array_push($list,
            "webstudio/sample",
            "footer"
        );
        $this->view->render($list);
    }

    public function uploadAudio(){
        $this->model->uploadAudio();
    }


}