<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');

if(isset($_GET['url'])){
    $url = $_GET['url'];
}else{
    $url = null;
}