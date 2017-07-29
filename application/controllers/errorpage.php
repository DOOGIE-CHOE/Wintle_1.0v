<?php

class ErrorPage extends Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index($msg = "Something went wrong..") {
		$this->view->msg = $msg;
        $list = $this->setViewComponents("error/index");
        $this->view->render($list);
	}

}