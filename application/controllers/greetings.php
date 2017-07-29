<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 5/24/17
 * Time: 6:48 PM
 */

class Greetings extends Controller {
    function __construct() {
        parent::__construct();
    }

    function index(){
        $list = $this->setViewComponents("greetings/index");
        $this->view->render($list);
    }
}