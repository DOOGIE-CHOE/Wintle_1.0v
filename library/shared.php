<?php

/** Check if environment is development and display errors **/

function setReporting()
{
    if ('DEVELOPMENT_ENVIRONMENT' == true) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
    }
}

/** Check for Magic Quotes and remove them **/

function stripSlashesDeep($value)
{
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function removeMagicQuotes()
{
    if (get_magic_quotes_gpc()) {
        $_GET = stripSlashesDeep($_GET);
        $_POST = stripSlashesDeep($_POST);
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

/** Check register globals and remove them **/

function unregisterGlobals()
{
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

function callHook()
{
    //Session initiate
    Session::init();
    try {
        //all error will be paased to this method

        $url = isset($_GET['url']) ? $_GET['url'] : "index";
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if (isReservedName($url[0])) {
            //본인 profile을 찾아가기 위한 조건문
            if ($url[0] == "profile") {
                Session::set("profile_id", Session::get("user_id"));
            }
            if ($url[0] == "block") {
                //정수인지 확인. 만약 정수라면 block페이지의 콘텐츠를 보기위한 URL이라 판단.
                if(is_numeric($url[1])){
                    $controller = new $url[0];
                    $controller->loadModel($url[0]);
                    if(isset($url[2])){
                        if(isset($url[1])){
                            $controller->index($url[1],$url[2]);
                        }
                    }else if(isset($url[1])) {
                        $controller->index($url[1]);
                    }
                }else{ //그게 아니라면 함수 접근으로 판단
                    $controller = new $url[0];
                    $controller->loadModel($url[0]);
                    methodHandler($controller, $url);
                }

            } else if($url[0] == "index"){
                // 인덱스로 접근 했을 때 로그인이 안되어 있다면 랜딩페이지 출력
                // 로그인을 하지 않았을 때 무조건 랜딩페이지를 띄워준다면, 아는 사람과 콘텐츠를 공유 할 시 문제가 발생함.
                if(Session::isSessionSet("loggedIn") == false){
//                    Session::set("landing_page",true);
                    $url[0] = "greetings";
                    $controller = new $url[0];
                    $controller->loadModel($url[0]);
                    methodHandler($controller, $url);
                }else{
                    //일반적인 index페이지 출력
                    $controller = new $url[0];
                    $controller->loadModel($url[0]);
                    methodHandler($controller, $url);
                }

            } else {
                $controller = new $url[0];
                $controller->loadModel($url[0]);
                methodHandler($controller, $url);
            }
        } else {
            if (isExistingProfile($url[0])) {
                $controller = new Profile();
                $controller->loadModel("Profile");
                methodHandler($controller, $url);

            } else {
                error("index", "cannot find the profile");
            }
        }


    } catch (Exception $e) {
        error("index", $e->getMessage());
    }
}

// calling methods
function methodHandler($controller, $url)
{
    if(isset($url[6])){
        if (isset($url[5])){
            if (isset($url[4])) {
                if (isset($url[3])) {
                    if(isset($url[2])){
                        if (method_exists($controller, $url[1])) {
                            $controller->{$url[1]}($url[2], $url[3], $url[4], $url[5],$url[6]);
                        } else {
                            error("index");
                        }
                    }
                }
            }
        }
    }else if (isset($url[5])){
        if (isset($url[4])) {
            if (isset($url[3])) {
                if(isset($url[2])){
                    if (method_exists($controller, $url[1])) {
                        $controller->{$url[1]}($url[2], $url[3], $url[4], $url[5]);
                    } else {
                        error("index");
                    }
                }
            }
        }
    } else if (isset($url[4])) {
        if (isset($url[3])) {
            if(isset($url[2])){
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}($url[2], $url[3], $url[4]);
                } else {
                    error("index");
                }
            }
        }
    } else if (isset($url[3])) {
        if (isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2], $url[3]);
            } else {
                error("index");
            }
        }
    } else if (isset($url[2])) {
        if (method_exists($controller, $url[1])) {
            $controller->{$url[1]}($url[2]);
        } else {
            error("index");
        }
    } else {
        if (isset($url[1])) {
            if ($url[1] != 'index') {
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

function isExistingProfile($profileurl)
{
    $controller = new Common();
    $controller->loadModel("Common");
    $data = $controller->checkProfileUrl($profileurl);
    if ($data == null) {
        return false;
    } else {
        Session::set("profile_id", $data);
        Session::set("profile_url", $profileurl);
        return true;
    }
}


function isReservedName($name)
{
    if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($name) . '.php')) {
        return true;
    }
    return false;
}

/** Autoload any classes that are required **/

function __my_autoload($className)
{
    if (file_exists(ROOT . DS . 'library' . DS . $className . '.class.php')) {
        require_once(ROOT . DS . 'library' . DS . $className . '.class.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
    } else {
        /* Error Generation Code Here */
    }
}

function error($view, $msg = "Something went wrong..")
{
    //시스템 애러 발생 시 애러페이지로 리다이렉션
    $url = "http://localhost/errorpage";
    if (headers_sent()){
        die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    }else{
        header('Location: ' . $url);
        die();
    }
}


setReporting();
removeMagicQuotes();
unregisterGlobals();
spl_autoload_register('__my_autoload');
callHook();