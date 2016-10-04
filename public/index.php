<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once ROOT.DS.'application'.DS.'views'.DS.'musicplayer.php';
require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');

$url = $_GET['url'];