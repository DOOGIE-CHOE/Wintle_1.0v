<?php
/**
 * Created by Daniel on 8/31/2016.
 */


$data = array();
$data['success'] = true;
$data['error'] = null;




if(isset($_FILES)){
    $data['success'] = true;
    $data['name'] = $_FILES['audio']['name'][0];
}else{
    $data['success'] = false;
}

echo json_encode($data);