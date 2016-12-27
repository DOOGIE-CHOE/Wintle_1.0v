<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/14/2016
 * Time: 11:18 AM
 */

class Profile_Model extends Model{
    function __construct() {
        parent::__construct();
    }

    function uploadProfilePhoto($type){
        if($type == "profile"){
            $folder = "profileimage/";
        }else if($type == "cover"){
            $folder = "coverimage/";
        }

        $success = false;
        $error = null;
        $permitted = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $count = 0;

        //get extension
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        foreach($permitted as $extension){
            if($extension == strtolower($ext))
                $count++;
        }

        //check if uploaded file is an image
        if($count == 0){
            $error = "You can upload only image file";
            echo json_encode(array($success,$error));
            exit;
        }

        //check if it is multiple uploaded
        if($count != 1){
            $error = "You can upload only one image file";
            echo json_encode(array($success,$error));
            exit;
        }

        $refilename = $this->createContentName("image");
        $refilename .= '.'.$ext;
        $filepath = $folder.$refilename;

        try{
            //if the photo's existing, delete it
            if($this->deleteProfilePhoto(Session::get("user_id"),$type)){
                //file upload
                move_uploaded_file($file_tmp, $filepath);
                if($this->uploadProfilePhotoQuery(Session::get("user_id"), $filepath, $type)){
                    $success = true;
                }
            }
        }catch(Exception $e){
            $error = $e->getMessage();
        }finally{
            echo json_encode(array($success,$error));
        }
    }

    function deleteProfilePhoto($user_id, $type) {
        if($type == "profile"){
            $attr = "profile_photo_path";
        }else if($type == "cover"){
            $attr = "cover_photo_path";
        }
        $sql = "SELECT $attr from user_profile where user_id = '$user_id'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        $tmp = $data[$attr];
        if (file_exists($tmp)) {
            if (unlink($tmp)) {
            }else{
                throw new Exception("Error occurs during deleting existing profile photo errorcode:1");
            }
        }
        $sql = "UPDATE user_profile set $attr = null where user_id = '$user_id'";
        if ($this->db->conn->query($sql)) {
            return true;
        } else
            throw new Exception("Error occurs during deleting existing profile errorcode:2");
    }

    function uploadProfilePhotoQuery($user_id, $imagepath,$type) {
        if($type == "profile"){
            $attr = "profile_photo_path";
            $uploaddate = "profile_upload_date";
        }else if($type == "cover"){
            $attr = "cover_photo_path";
            $uploaddate = "cover_upload_date";
        }
        //get current time
        $date = date('Y/m/d H:i:s', time());
        $sql = "UPDATE user_profile set $attr = '$imagepath', $uploaddate = '$date'  where user_id = '$user_id'";
        if ($this->db->conn->query($sql) === TRUE) {
            return true;
        } else {
            throw new Exception("Failed to upload profile photo.. :( Please, try it later");
        }
    }

}