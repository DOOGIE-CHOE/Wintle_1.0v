<?php

class View {

	function __construct() {
	}

	public function render($name, $noInclude = false, $loggedIn = false) {
		if ($noInclude == true) {
			require ROOT.DS.'application'.DS.'views'.DS. $name . '.php';
		} else{
            if($loggedIn == true){
                require ROOT.DS.'application'.DS.'views'.DS.'header_loggedin.php';
            }else {
                require ROOT . DS . 'application' . DS . 'views' . DS . 'header.php';
            }
            require ROOT.DS.'application'.DS.'views'.DS.'errorMessage.php';
            require ROOT.DS.'application'.DS.'views'.DS.  $name . '.php';
            require ROOT.DS.'application'.DS.'views'.DS.'footer.php';
        }
	}

}