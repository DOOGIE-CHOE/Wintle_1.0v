<?php
class Template {

	protected $variables = array();
	protected $_filepath;
	protected $_filename;

	function __construct($filepath,$filename) {
		$this->variables['filepath'] = $filepath;
		$this->variables['filename'] = $filename;
	}

	/** Set Variables **/

	function set($name,$value) {
		$this->variables[$name] = $value;
	}

	/** Display Template **/

    function render() {

		include (ROOT . DS . 'application' . DS . 'views' .DS . 'header.php');

        include (ROOT . DS . 'application' . DS . 'views' .DS . $this->variables['filepath'] . DS . $this->variables['filename'] . '.php');

		include (ROOT . DS . 'application' . DS . 'views' .DS  . 'footer.php');

    }

}
