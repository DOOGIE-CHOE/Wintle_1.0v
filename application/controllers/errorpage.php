<?php

class ErrorPage extends Controller {

	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->view->msg = 'This page doesnt exist';
		$this->view->render('error/index',true);
	}

	function loggedInService(){
        $this->view->msg = 'You need to log in to use this service.';
        $this->view->render('error/loggedinservice',true);
    }

}