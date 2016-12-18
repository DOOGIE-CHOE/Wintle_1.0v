<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 11/11/2016
 * Time: 2:36 PM
 */


class Recommend extends Controller{
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
            "musicplayer",
            "index/recommend",
            "footer"
        );
        $this->view->render($list);
    }

}