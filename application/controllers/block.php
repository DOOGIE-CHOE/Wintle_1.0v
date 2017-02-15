<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2/15/17
 * Time: 1:15 PM
 */


class Block extends Controller {
    function __construct() {
        parent::__construct();
    }

    function index($id = null){
        if(is_null($id)){
            error("index");
        }else{
            $data = $this->model->getContentInfo($id);
            $this->view->data = $data;
            $list = $this->setViewComponents("block/index");
            $this->view->render($list);
        }
    }
}