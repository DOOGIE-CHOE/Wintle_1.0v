<?php

//** IMPORTANT **/
/*
 * you should set isServer variable true if you want to use this file at server
  */
$isServer = false;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once (ROOT . DS . 'library' . DS . 'bootstrap.php');

if(isset($_GET['url'])){
    $url = $_GET['url'];
}else{
    $url = null;
}