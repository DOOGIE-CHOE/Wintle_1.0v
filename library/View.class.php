<?php

class View {

	function __construct() {
	}

	public function render($name, $noInclude = false, $loggedIn = false) {
		if ($noInclude == true) {
			require_once ROOT.DS.'application'.DS.'views'.DS. $name . '.php';
		} else{
            if($loggedIn == true){
                require_once ROOT.DS.'application'.DS.'views'.DS.'header_loggedin.php';
            }else {
                require_once ROOT . DS . 'application' . DS . 'views' . DS . 'header.php';
            }
            require_once ROOT.DS.'application'.DS.'views'.DS.'errorMessage.php';
            require_once ROOT.DS.'application'.DS.'views'.DS.  $name . '.php';
            require_once ROOT.DS.'application'.DS.'views'.DS.'footer.php';
        }
	}

}