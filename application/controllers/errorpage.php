<?php

class ErrorPage extends Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index($msg) {
		$this->view->msg = $msg;

        $list = array();
        array_push($list,
            "header",
            "errorMessage"
        );
        if(!Session::isSessionSet("loggedIn")){
            array_push($list,"loginpopup");
        }
        array_push($list,
            "error/index",
            "musicplayer",
            "footer"
        );
        $this->view->render($list);
	}

}