<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/21/2016
 * Time: 2:42 PM
 */



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

        if(Session::get("loggedIn") == true){
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
                $controller->index($isnoinclude);
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