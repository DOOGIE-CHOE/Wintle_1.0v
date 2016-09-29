<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 9/28/2016
 * Time: 4:29 PM
 */

class WebStudio_Model extends Model{

    function __construct() {
        parent::__construct();
    }

    public function uploadAudio(){

        $data = array(array());
        $error = false;
        $directory = "waves/";
        $audiopath = "audio/";
        $length = count($_FILES['audio']['name']);

        if($length == 0 && $_FILES['audio']['name'][0] == null){
            $error = "No files selected. Please Try it again";
        }else{
            try{
                if(move_uploaded_file($_FILES['audio']['tmp_name'], $audiopath.basename($_FILES['audio']['name']))) {
                        $justwave = new JustWave('GET');
                        $data[0]['audiopath'] = $audiopath . $_FILES['audio']['name'];
                        $justwave->create($data[0]['audiopath']);
                        // array_push($keys, $justwave->getKey());
                        $data[0]['key'] = $justwave->getKey();
                        $data[0]['imgpath'] = $directory . $data[0]['key'] . ".png";
                        $data[0]['width'] = $justwave->getwidth() . "px";
                }
                else{
                    $error = "Couldn't upload the file. Please try it again";
                }
            }catch(Exception $e){
                $error = $e->getMessage();
            }
        }

        echo json_encode(array($data,$error));
    }

}