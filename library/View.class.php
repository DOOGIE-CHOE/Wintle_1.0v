<?php

class View {

	function __construct() {
	}

	public function render($name, $noInclude = false, $loggedIn = false) {
        require ROOT.DS.'application'.DS.'views'.DS.'errorMessage.php';
		if ($noInclude == true) {
			require ROOT.DS.'application'.DS.'views'.DS. $name . '.php';
		} else if($loggedIn == true){
            require ROOT.DS.'application'.DS.'views'.DS.'header_loggedin.php';
            require ROOT.DS.'application'.DS.'views'.DS.  $name . '.php';
            require ROOT.DS.'application'.DS.'views'.DS.'footer.php';
        }else {
            require ROOT.DS.'application'.DS.'views'.DS.'header.php';
			require ROOT.DS.'application'.DS.'views'.DS.  $name . '.php';
			require ROOT.DS.'application'.DS.'views'.DS.'footer.php';
		}
	}

}