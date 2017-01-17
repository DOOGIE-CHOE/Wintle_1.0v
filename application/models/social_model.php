<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 1/16/17
 * Time: 3:12 PM
 */


class Social_Model extends Model{
    function __construct(){
        parent::__construct();
    }

    function google_login(){
        require_once 'vendor/autoload.php';
    }

}