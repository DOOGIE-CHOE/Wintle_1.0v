<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/16/2016
 * Time: 2:02 PM
 */



class UploadContents extends Controller {
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
            "index/uploadcontents",
            "musicplayer",
            "footer"
        );
        $this->view->render($list);
    }

    function uploadlyrics(){
        $data = $this->model->uploadlyrics();
        echo json_encode($data);
    }

    function uploadaudio(){
        $data = $this->model->uploadaudio();
        echo json_encode($data);
    }

    function uploadimage(){
        $data = $this->model->uploadaudio();
        echo json_encode($data);
    }
}

?>


