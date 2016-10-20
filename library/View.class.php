<?php

class View {

	function __construct() {
	}

	public function render($name, $noInclude = false, $loggedIn = false) {
		if ($noInclude == true) {
			require_once ROOT.DS.'application'.DS.'views'.DS. $name . '.php';
		} else{
            require_once ROOT . DS . 'application' . DS . 'views' . DS . 'header.php';
            if($loggedIn == false){
                require_once ROOT.DS.'application'.DS.'views'.DS.'loginpopup.php';
            }
            require_once ROOT.DS.'application'.DS.'views'.DS.'errorMessage.php';
            require_once ROOT.DS.'application'.DS.'views'.DS.  $name . '.php';
            require_once ROOT.DS.'application'.DS.'views'.DS.'musicplayer.php';
            require_once ROOT.DS.'application'.DS.'views'.DS.'footer.php';
        }
	}

}