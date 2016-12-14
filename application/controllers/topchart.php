<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 11/7/2016
 * Time: 9:12 PM
 */


class TopChart extends Controller {
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
            "album/topchart",
            "musicplayer",
            "footer"
        );
        $this->view->render($list);
    }
}