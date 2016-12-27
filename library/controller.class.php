<?php

class Controller {

	function __construct() {
        $this->view = new View();
	}

	public function loadModel($name) {
		
		$path = ROOT.DS. 'application'. DS. 'models'. DS . $name.'_model.php';
		
		if (file_exists($path)) {
			$modelName = $name . '_Model';
			$this->model = new $modelName();
		}		
	}
}