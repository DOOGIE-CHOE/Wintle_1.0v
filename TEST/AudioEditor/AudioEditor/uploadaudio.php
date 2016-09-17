<?php
/**
 * Created by Daniel on 8/31/2016.
 */

require_once 'JustWave.class.php';


$data = array(array());
$error = false;
$directory = "waves/";
$audiopath = 'audio/';
$keys = array();
$i = 0;

$length = count($_FILES['audio']['name']);

if($length == 0 && $_FILES['audio']['name'][0] == null){
    $error = true;
}else{
    for ($i = 0; $i < $length; $i++) {
        $justwave = new JustWave('GET');

        if(move_uploaded_file($_FILES['audio']['tmp_name'][$i], $audiopath.basename($_FILES['audio']['name'][$i]))){
            $data[$i]['audiopath'] = $audiopath. $_FILES['audio']['name'][$i];
            $justwave->create($data[$i]['audiopath']);
            // array_push($keys, $justwave->getKey());
            $data[$i]['key'] = $justwave->getKey();
            $data[$i]['imgpath'] = $directory. $data[$i]['key'].".png";
            $data[$i]['width'] = $justwave->getwidth()."px";
        }
        else{
            echo "Fail to upload";
        }



        /*
                    echo "
                            <div id=\"tile\">
                                <div id=\"draggable-$i\" class=\"raw-audio\" style=\"
                                     background-image: url('$fullpath');
                                     width:$width;
                                      \" >
                                </div>
                            </div>
                            ";*/
    }
    echo json_encode(array($data,$error));
}

