<?php
/**
 * Created by Daniel on 8/31/2016.
 */

require_once 'JustWave.class.php';


$data = array(array());
$error = false;
$directory = "waves/";
$audiopath = 'audio/';
$i = 0;

$length = count($_FILES['audio']['name']);

if($length == 0 && $_FILES['audio']['name'][0] == null){
    $error = "No files selected. Please Try it again";
}else{
    try{
        if(move_uploaded_file($_FILES['audio']['tmp_name'][$i], $audiopath.basename($_FILES['audio']['name'][$i]))) {
            for ($i = 0; $i < $length; $i++) {
                $justwave = new JustWave('GET');
                $data[$i]['audiopath'] = $audiopath . $_FILES['audio']['name'][$i];
                $justwave->create($data[$i]['audiopath']);
                // array_push($keys, $justwave->getKey());
                $data[$i]['key'] = $justwave->getKey();
                $data[$i]['imgpath'] = $directory . $data[$i]['key'] . ".png";
                $data[$i]['width'] = $justwave->getwidth() . "px";

            }
        }
        else{
            $error = "Couldn't upload the file. Please try it again";
        }
    }catch(Exception $e){
        $error = $e->getMessage();
    }
    echo json_encode(array($data,$error));
}

