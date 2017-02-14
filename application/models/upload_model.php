<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/20/2016
 * Time: 3:14 PM
 */

class Upload_Model extends Model {

    function __construct(){
        parent::__construct();
    }


    function uploadContent($type){
        $content_title = $_POST['content_title'];
        $content_comments = $_POST['content_comments'];
        $content_hashs =  $_POST['hashtags'];
        $user_id = Session::get('user_id');
        if($type == "lyrics"){
            $path = $_POST['content_path'];
        }else{
            $file_name = $_FILES['content_path']['name'];
            $file_size = $_FILES['content_path']['size']; // to check file size if it's too big
            $file_tmp = $_FILES['content_path']['tmp_name'];
            if($type == "audio"){
                $path = $this->uploadAudio($file_name, $file_size, $file_tmp);
            }else if($type == "image"){
                $path = $this->uploadimage($file_name, $file_size, $file_tmp);
            }
        }
        return $this->uploadContentProcedure($user_id, $content_title, $path, $content_comments, $content_hashs, $type);
    }

    function uploadContentProcedure($user_id, $content_title, $path, $content_comments, $content_hashs, $type){
        $data = array();
        try{
            /* DB Stored Procedure part ! */
            $this->db->conn->begin_transaction();
            $sql = $this->db->conn->prepare("CALL Win_Upload_Content(?,?,?,?,?,@result)");

            //Put arguments
            $sql->bind_param('sssss',$content_title, $path, $content_comments, $user_id, $type);
            $sql->execute();

            //Get output from Stored Procedure
            $select = $this->db->conn->query('select @result');
            $result = $select->fetch_assoc();

            if($result['@result'] > 0){
                if($this->uploadHashtag($result['@result'], $content_hashs)){
                    $data['success'] = true;
                    $this->db->conn->commit();
                }else{
                    throw new Exception("System error occur :( please try it later");
                }
            }else{
                throw new Exception("System error occur :( please try it later");
            }
        }
        catch(Exception $e){
            $this->db->conn->rollback();
            $data['error'] = $e->getMessage();
        }finally{
            return $data;
        }
    }

    public function uploadimage($file_name, $file_size, $file_tmp){
        $permitted = array('jpeg', 'jpg','gif','png');
        $time = getdate();
        $length = count($_FILES['content_path']['name']);
        $imgpath = "image".DS.$time['year'].DS.$time['mon'];
        $count = 0;

        //get extension
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        foreach($permitted as $extension){
            if($extension == $ext)
                $count++;
        }
        if($count != 1){
            throw new Exception("jpeg, png and gif extensions are supportive");
        }
        $file_name = $this->createFileName($time).'.'.$ext;

        //make directory it not exists
        if(!is_dir("image".DS.$time['year'])){
            mkdir("image".DS.$time['year'],0755);
        }
        if(!is_dir($imgpath)){
            mkdir($imgpath,0755);
        }

        if($length == 0){
            throw new Exception("No file selected");
        }else if($length == 1){
            //move file to server
            if(move_uploaded_file($file_tmp, $imgpath.DS.basename($file_name))) {
                return $imgpath.DS.$file_name;
            }
            else{
                throw new Exception("System error occur during uploading file");
            }
        }else{
            throw new Exception("more than one file is selected");
        }
    }

    public function uploadAudio($file_name, $file_size, $file_tmp){
        $permitted = array('mp3', 'wav');
        $time = getdate();
        $length = count($_FILES['content_path']['name']);
        $wavepath = "wave".DS.$time['year'].DS.$time['mon'];
        $audiopath = "audio".DS.$time['year'].DS.$time['mon'];
        $count = 0;

        //get extension
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        foreach($permitted as $extension){
            if($extension == $ext)
                $count++;
        }
        if($count != 1){
            throw new Exception("MP3 and WAV extensions are supportive");
        }

        $key = $this->createFileName($time);

        $file_name = $key.'.'.$ext;

        //make directory it not exists
        if(!is_dir("wave".DS.$time['year'])){
            mkdir("wave".DS.$time['year'],0755,true);
        }
        if(!is_dir("audio".DS.$time['year'])){
            mkdir("audio".DS.$time['year'],0755,true);
        }
        if(!is_dir($wavepath)){
            mkdir($wavepath,0755,true);
        }
        if(!is_dir($audiopath)){
            mkdir($audiopath,0755,true);
        }

        if($length == 0){
            throw new Exception("No file selected");
        }else if($length == 1){
            //move file to server
            if(move_uploaded_file($file_tmp, $audiopath.DS.basename($file_name))) {
                //get waveform file
                $justwave = new JustWave('GET');
                $justwave->setAudioDir($audiopath);
                $justwave->setWaveDir($wavepath);
                if($justwave->create($key,$ext) == false){
                    throw new Exception("convert error");
                }else{
                    return $audiopath.DS.$file_name;
                }
            }
            else{
                throw new Exception("System error occur during uploading file");
            }
        }else{
            throw new Exception("more than one file is selected");
        }
    }


    function uploadHashtag($contentid, $hashs){
        $tmp = rtrim($hashs, ' ');
        $hashtags = explode(' ', $tmp);
        foreach($hashtags as $hash){
            $sql = $this->db->conn->prepare("CALL Win_Upload_Hashtag(?,?,@result)");
            $sql->bind_param('ss',$contentid,$hash);
            $sql->execute();
            $select = $this->db->conn->query('select @result');
            $hash_result = $select->fetch_assoc();
            if($hash_result['@result'] != 1) {
                return $hash_result['@result'];
            }
        }
        return true;
    }


    function createFileName($time){
        $ran = rand(1000,9999);
        $id = $time['year'].$time['mon'].$time['mday'].$time['hours'].$time['minutes'].$time['seconds'].$ran;
        return $id;
    }
}