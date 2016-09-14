<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/14/2016
 * Time: 3:39 AM
 */

class LogOut extends Controller {

    function index($noInclude = false, $loggedIn = false){}

    function callLogOut(){
        Session::destroy();
        header("Location: ".URL."index.php");
        exit();
    }
}