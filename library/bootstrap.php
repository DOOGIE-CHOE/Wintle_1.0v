<?php

if($isServer){
    $protocol = "https://";
    $path = null;
    if (substr($_SERVER['HTTP_HOST'], 0, 4) !== 'www.') {
        $path = $protocol.'www.'.$_SERVER['HTTP_HOST'];
        header('Location: '.$path);
        exit;
    }else if(substr($_SERVER['HTTP_HOST'], 0, 4) == 'www.' && ($_SERVER["HTTPS"] == "off" || !isset($_SERVER["HTTPS"]))){
        $path = $protocol.$_SERVER['HTTP_HOST'];
        header('Location: '.$path);
        exit;
    }
}

require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'library' . DS . 'shared.php');
//require_once (ROOT . DS . 'library' . DS . 'analyticstracking.php');