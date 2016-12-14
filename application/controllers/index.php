<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/12/2016
 * Time: 4:02 PM
 */

class Index extends Controller {
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
            "index/index",
            "footer"
        );
        $this->view->render($list);
    }

}