<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/13/2016
 * Time: 10:53 AM
 */

class Common_Model extends Model{

    function __construct(){
        parent::__construct();
    }

    function getProfilePhoto(){
        if(Session::isSessionSet("user_email")){
            $user_email = Session::get("user_email");
            $sql = "SELECT profile_photo_path from user_profile where user_email = '$user_email'";
            $result = $this->db->conn->query($sql);
            $data = $result->fetch_assoc();
            return $data;
        }else{
            return null;
        }
    }

    function uploadProfilePhoto(){
        $success = false;
        $error = null;
        $permitted = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $folder = "profileimages/";

        $count = 0;
        //get extension
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        foreach($permitted as $extension){
            if($extension == $ext)
                $count++;
        }

        if($count == 0){
            $error = "You can upload only image file";
            echo json_encode(array($success,$error));
            exit;
        }

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
            if($this->deleteProfilePhoto(Session::get("user_email"))){
                //file upload
                move_uploaded_file($file_tmp, $filepath);
                if($this->uploadProfilePhotoQuery(Session::get("user_email"), $filepath)){
                    $success = true;
                }
            }else{
                throw new Exception("Error occurs during deleting existing profile photo");
            }
        }catch(Exception $e){
            $error = $e->getMessage();
        }finally{
            echo json_encode(array($success,$error));
        }
    }

    function deleteProfilePhoto($user_email) {
        $sql = "SELECT profile_photo_path  from user_profile where user_email = '$user_email'";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();
        $tmp = $data['profile_photo_path'];
        if (file_exists($tmp)) {
            if (unlink($tmp)) {
                $sql = "UPDATE user_profile set profile_photo_path = null where user_email = '$user_email'";
                if ($this->db->conn->query($sql)) {
                    return true;
                } else
                    throw new Exception("Error occurs during deleting existing profile photo");
            }
        }
        return false;
    }

    function uploadProfilePhotoQuery($user_email, $imagepath) {
        $date = date('Y/m/d H:i:s', time());

        $sql = "UPDATE user_profile set profile_photo_path = '$imagepath', profile_upload_date = '$date'  where user_email = '$user_email'";

        if ($this->db->conn->query($sql) === TRUE) {
            return true;
        } else {
            throw new Exception("Failed to upload profile photo.. :( Please, try it later");
        }
    }


}