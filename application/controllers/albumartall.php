<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/20/2016
 * Time: 1:33 PM
 */

class AlbumArtAll extends Controller {
    function __construct() {
        parent::__construct();
    }

    function index($noInclude = false, $loggedIn = false){
        $this->view->render("albumart/index", $noInclude, $loggedIn);
    }

}