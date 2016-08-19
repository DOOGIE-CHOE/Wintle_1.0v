<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 8/18/2016
 * Time: 6:37 PM
 */


if($_POST['type']=="login"){
    require_once ("../application/models/login-signup/login.php");
}else if($_POST['type'] == "signup"){
    require_once ("../application/models/login-signup/signup.php");
}
