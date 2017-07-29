<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 5/13/17
 * Time: 3:19 PM
 */

class Info extends Controller {
    function __construct() {
        parent::__construct();
    }
    function index(){
        $this->terms();
    }

    function wintle(){
        $list = $this->setViewComponents("info/wintle");
        $this->view->render($list);
    }

    function companyinfo(){
        $list = $this->setViewComponents("info/companyinfo");
        $this->view->render($list);
    }

    function terms(){
        $list = $this->setViewComponents("info/terms");
        $this->view->render($list);
    }

    function privacy(){
        $list = $this->setViewComponents("info/privacy");
        $this->view->render($list);
    }

    function license(){
        $list = $this->setViewComponents("info/license");
        $this->view->render($list);
    }

}