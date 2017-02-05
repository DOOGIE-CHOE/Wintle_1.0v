<?php

class Controller {

	function __construct() {
        $this->view = new View();
	}

	public function loadModel($name) {
		
		$path = ROOT.DS. 'application'. DS. 'models'. DS . strtolower($name).'_model.php';
		
		if (file_exists($path)) {
			$modelName = $name . '_Model';
			$this->model = new $modelName();
		}		
	}

	public function setViewComponents($view){
        $list = array();
        array_push($list,
            "header",
            "errorMessage"
        );
        if(!Session::isSessionSet("loggedIn")){
            array_push($list,"loginpopup");
        }

        array_push($list, $view);
        array_push($list,
            "musicplayer",
            "footer"
        );

        return $list;
    }

}