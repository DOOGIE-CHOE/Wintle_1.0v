<?php
//
//$protocol = (@$_SERVER["HTTPS"] == "on") ? "https://" : "https://";

//if (substr($_SERVER['HTTP_HOST'], 0, 4) !== 'www.') {
  //  header('Location: '.$protocol.'www.'.$_SERVER['HTTP_HOST']);
    //exit;
//}

require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'shared.php');
//require_once (ROOT . DS . 'library' . DS . 'analyticstracking.php');