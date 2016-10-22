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
        set_error_handler(function($errno, $errstr, $errfile, $errline ){
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        });

        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        $isloggedin = false;
        $isnoinclude = false;


        if($url[0] == "favicon.ico"){
            return false;
        }

        if (empty($url[0])) {
            $controller = new Index();
        }

        if(Session::isSessionSet("loggedIn") == true){
            $isloggedin = true;
        }else{
            $isloggedin = false;
        }

        if(isReservedName($url[0])){
            if($url[0] == "profile"){
                Session::set("profile_id",Session::get("user_email"));
            }

            if($url[0] == "webstudio"){
                $isnoinclude = true;
            }

            $controller = new $url[0];
            $controller->loadModel($url[0]);
            methodHandler($controller,$url,$isnoinclude,$isloggedin);

        }else {
            if(isExistingProfile($url[0])){
                $controller = new Profile();
                $controller->loadModel("Profle");
                methodHandler($controller,$url,$isnoinclude,$isloggedin);

            }else{
                error("index");
            }
        }

    }catch(Exception $e){
        if($e->getCode() == 8){
            echo "Undefined Index";
        }
    }
}

// calling methods
function methodHandler($controller,$url,$isnoinclude = false,$isloggedin = false){
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
            $controller->index($isnoinclude,$isloggedin);
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

function __autoload($className) {
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

function error($view) {
    $controller = new ErrorPage();
    $controller->{$view}();
    return false;
}


setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();
