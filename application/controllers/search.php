<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 1/26/17
 * Time: 4:18 PM
 */

class Search extends Controller{

    function index(){
        $list =$this->setViewComponents("search/index");
        $this->view->render($list);
    }

    function blocks(){
        $list = $this->setViewComponents("search/blocks");
        $this->view->render($list);
    }

    function boxes(){

        $list =$this->setViewComponents("search/boxes");
        $this->view->render($list);
    }

    function people(){

        $list =$this->setViewComponents("search/people");
        $this->view->render($list);
    }

    function searchBlocks($limit, $offset){
        $data = $this->model->searchBlocks($limit, $offset);
        echo json_encode($data);
    }

}
