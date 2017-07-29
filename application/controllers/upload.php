<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/20/2016
 * Time: 3:13 PM
 */

class Upload extends Controller {
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
            "upload/index",
            "musicplayer",
            "footer"
        );
        $this->view->render($list);
    }


    public function uploadContent(){
        $data = $this->model->uploadContent();
        echo json_encode($data);
    }


    public function uploadProject(){
        $data = $this->model->uploadProject();
        echo json_encode($data);
    }
}