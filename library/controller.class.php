<?php
class Controller {

	protected $_model;
	protected $_template;


	//The order of arguments must be Controller, Action and Model
	function __construct() {
		$args = func_get_args();

		if(count($args) != 3 and count($args) != 2){
			//error message here
		}
		if(count($args) == 3){
			$this->_model = new $args[2];
		}

		$this->_template = new Template($args[0],$args[1]);
	}

	/*
	function __construct($model, $controllers, $action) {

		$this->_controller = $controllers;
		$this->_action = $action;

		$this->_model = new Model();
		$this->_template = new Template($controllers,$action);
	}

	function __construct($controllers, $acton){

	}*/

	function add($_add){
		
	}

	function set($name,$value) {
		$this->_template->set($name,$value);
	}

	function __destruct() {
			$this->_template->render();
	}

}
