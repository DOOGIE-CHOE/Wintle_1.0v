<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 11/30/2016
 * Time: 7:03 PM
 */


class Message extends Controller {
    function __construct() {
        parent::__construct();
    }


    function index(){
        $list = array();
        array_push($list,
            "header",
            "errorMessage",
            "message/index",
            "musicplayer",
            "footer"
        );

        $this->view->render($list);
    }

}