<?php
class Template {

	protected $filepath = array();
	protected $filename = array();
	protected $_filepath;
	protected $_filename;

	function __construct($_filepath,$_filename) {
		array_push($this->filepath,$_filepath);
		array_push($this->filename,$_filename);
	}

	/** Set Variables **/

	function set($_filepath,$_filename) {
		array_push($this->filepath,$_filepath);
		array_push($this->filename,$_filename);

		//$this->variables[$name] = $value;
	}

	/** Display Template **/

    function render() {
		
		include (ROOT . DS . 'application' . DS . 'views' .DS . 'header.php');

		for($i = 0 ; $i < count($this->filename) ; $i++)
        include (ROOT . DS . 'application' . DS . 'views' .DS . $this->filepath[$i] . DS . $this->filename[$i] . '.php');

		include (ROOT . DS . 'application' . DS . 'views' .DS  . 'footer.php');

    }

}
