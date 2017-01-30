<?php

/** Check if environment is development and display errors **/

function setReporting() {
    if ('DEVELOPMENT_ENVIRONMENT' == true) {
        error_reporting(E_ALL);
        ini_set('display_errors','On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors','Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
    }
}

/** Check for Magic Quotes and remove them **/

function stripSlashesDeep($value) {
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function removeMagicQuotes() {
    if ( get_magic_quotes_gpc() ) {
        $_GET    = stripSlashesDeep($_GET   );
        $_POST   = stripSlashesDeep($_POST  );
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

/** Check register globals and remove them **/

function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

function callHook() {
    //Session initiate
    Session::init();

    try{
        //all error will be paased to this method

        $url = isset($_GET['url']) ? $_GET['url'] : "index";
        $url = rtrim($url, '/');
        $url = explode('/', $url);

//        if($url[0] == "favicon.ico"){
//            return false;
//        }
/*
        if (empty($url[0])) {
            $url[0] = "index";
            $controller = new $url[0];
        }*/

        if(isReservedName($url[0])){
            if($url[0] == "profile"){
                Session::set("profile_id",Session::get("user_id"));
            }


            $controller = new $url[0];
            $controller->loadModel($url[0]);
            methodHandler($controller,$url);

        }else {
            if(isExistingProfile($url[0])){
                $controller = new Profile();
                $controller->loadModel("Profle");
                methodHandler($controller,$url);

            }else{
                error("index");
            }
        }


    }catch(Exception $e){
        error("index", $e->getMessage());
    }
}

// calling methods
function methodHandler($controller,$url){
    if(isset($url[3])){
        if(isset($url[2])){
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2],$url[3]);
            } else {
                error("index");
            }
        }
    }else if (isset($url[2])) {
        if (method_exists($controller, $url[1])) {
            $controller->{$url[1]}($url[2]);
        } else {
            error("index");
        }
    } else {
        if (isset($url[1])) {
            if($url[1] != 'index'){
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}();
                } else {
                    error("index");
                }
            }
        } else {
            $controller->index();
        }
    }

}

function isExistingProfile($profileurl){
    $controller = new Common();
    $controller->loadModel("Common");
    $data = $controller->checkProfileUrl($profileurl);
    if($data == null){
        return false;
    }
    else{
        Session::set("profile_id",$data);
        Session::set("profile_url",$profileurl);
        return true;
    }
}


function isReservedName($name){
    if(file_exists(ROOT . DS . 'application' . DS .'controllers' . DS . strtolower($name) . '.php')){
        return true;
    }
    return false;
}

/** Autoload any classes that are required **/

function __my_autoload($className) {
    if (file_exists(ROOT . DS . 'library' . DS . $className . '.class.php')) {
        require_once(ROOT . DS . 'library' . DS . $className . '.class.php');
    } else if (file_exists(ROOT . DS . 'application' . DS .'controllers' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS .'controllers' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'application' . DS .'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS .'models' . DS . strtolower($className) . '.php');
    } else {
        /* Error Generation Code Here */
    }
}

function error($view, $msg = "this page is not existing") {
    $controller = new ErrorPage();
    $controller->{$view}($msg);
    return false;
}


setReporting();
removeMagicQuotes();
unregisterGlobals();
spl_autoload_register('__my_autoload');
callHook();