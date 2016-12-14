<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 11/9/2016
 * Time: 9:42 PM
 */



class NewChart extends Controller {
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
            "album/newchart",
            "musicplayer",
            "footer"
        );
        $this->view->render($list);
    }
}