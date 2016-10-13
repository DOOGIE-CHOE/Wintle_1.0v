<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/12/2016
 * Time: 4:02 PM
 */

class Index extends Controller {
    function __construct() {
        parent::__construct();
    }

    function index($noInclude = false, $loggedIn = false){
        $this->view->render("index/index", $noInclude, $loggedIn);
    }


    function getTotalCounts(){

    }
}