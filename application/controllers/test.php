<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/5/2016
 * Time: 3:29 PM
 */



class Test extends Controller{
    function __construct() {
        parent::__construct();
    }

    function index(){
    }

    function testtest(){
        $list = $this->setViewComponents("index/test");
        $this->view->render($list);
    }

}