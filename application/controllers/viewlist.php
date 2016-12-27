<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 12/27/16
 * Time: 2:03 PM
 */


class ViewList extends controller{

    function index(){}


    function loadNewContents($offset){
        $data =  $this->model->loadNewContents($offset);
        echo json_encode($data);
    }


}
