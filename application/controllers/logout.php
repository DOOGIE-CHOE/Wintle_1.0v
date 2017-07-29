<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/14/2016
 * Time: 3:39 AM
 */

class LogOut extends Controller {

    function index(){}

    function callLogOut(){
        Session::destroy();
        header("Location: ".URL);
        exit();
    }
}