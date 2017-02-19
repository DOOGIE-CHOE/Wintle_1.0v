<?php

/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 12/20/2016
 * Time: 3:14 PM
 */
class Upload_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }


    function uploadContent()
    {
        $content_title = $_POST['content_title'];
        $content_comments = $_POST['content_comments'];
        $content_hashs = $_POST['hashtags'];
        if(!Session::isSessionSet('user_id')){
            return $data['error'] = "Invalid input";
        }
        $user_id = Session::get('user_id');


        if ($_FILES['content_path_audio']['name'] != "") {
            $file_name = $_FILES['content_path_audio']['name'];
            $file_size = $_FILES['content_path_audio']['size']; // to check file size if it's too big
            $file_tmp = $_FILES['content_path_audio']['tmp_name'];
            $type = "audio";
            $path = $this->uploadAudio($file_name, $file_size, $file_tmp);
        } else if ($_FILES['content_path_image']['name'] != "") {
            $file_name = $_FILES['content_path_image']['name'];
            $file_size = $_FILES['content_path_image']['size']; // to check file size if it's too big
            $file_tmp = $_FILES['content_path_image']['tmp_name'];
            $path = $this->uploadimage($file_name, $file_size, $file_tmp);
            $type = "image";
        } else {
            $type = "lyrics";
            $path = "";
        }
        return $this->uploadContentProcedure($user_id, $content_title, $path, $content_comments, $content_hashs, $type);
    }


    function uploadProject()
    {
        $content_title = $_POST['content_title'];
        $content_comments = $_POST['content_comments'];
        $content_hashs = $_POST['hashtags'];
        $user_id = Session::get('user_id');
        $content_ids = $_POST['content_ids'];

        if ($_FILES['content_path_audio']['name'] != "") {
            $file_name = $_FILES['content_path_audio']['name'];
            $file_size = $_FILES['content_path_audio']['size']; // to check file size if it's too big
            $file_tmp = $_FILES['content_path_audio']['tmp_name'];
            $type = "audio";
            $path = $this->uploadAudio($file_name, $file_size, $file_tmp);
        } else if ($_FILES['content_path_image']['name'] != "") {
            $file_name = $_FILES['content_path_image']['name'];
            $file_size = $_FILES['content_path_image']['size']; // to check file size if it's too big
            $file_tmp = $_FILES['content_path_image']['tmp_name'];
            $path = $this->uploadimage($file_name, $file_size, $file_tmp);
            $type = "image";
        } else {
            $type = "lyrics";
            $path = "";
        }

        $data = $this->uploadContentProcedure($user_id, $content_title, $path, $content_comments, $content_hashs, $type);
        if ($data['success'] == true) {
            $content_ids.=$data['content_id'];
            return $this->uploadProjectProcedure($content_ids);
        }
    }


    function uploadProjectProcedure($content_ids, $start_point = 0, $volume = 70)
    {
        $data = array();
        try {
            $this->db->conn->begin_transaction();
            $sql = $this->db->conn->prepare("CALL Win_Upload_ProjectId(@result)");
            //Put arguments
            $sql->execute();
            //Get output from Stored Procedure
            $select = $this->db->conn->query('select @result');
            $result = $select->fetch_assoc();
            if ($result['@result'] == -100) {
                throw new Exception("Creating project error");
            }
            $project_id = $result['@result'];

            $tmp = rtrim($content_ids, ',');
            $ids = explode(',', $tmp);
            $sequence = 0;

            foreach ($ids as $id) {
                $sql = $this->db->conn->prepare("CALL Win_Upload_Projectlist(?,?,?,?,?,@result)");
                $sql->bind_param('sssss', $project_id, $id, $start_point, $volume, $sequence);
                $sql->execute();
                $select = $this->db->conn->query('select @result');
                $result = $select->fetch_assoc();
                if ($result['@result'] != 1) {
                    throw new Exception("Creating project error");
                }
                $sequence++;
            }
            $data['success'] = true;
            $this->db->conn->commit();
        } catch (Exception $e) {
            $this->db->conn->rollback();
            $data['error'] = $e->getMessage();
        } finally {
            return $data;
        }
    }


    function uploadContentProcedure($user_id, $content_title, $path, $content_comments, $content_hashs, $type)
    {
        $data = array();
        try {
            /* DB Stored Procedure part ! */
            $this->db->conn->begin_transaction();
            $sql = $this->db->conn->prepare("CALL Win_Upload_Content(?,?,?,?,?,@result)");

            //Put arguments
            $sql->bind_param('sssss', $content_title, $path, $content_comments, $user_id, $type);
            $sql->execute();

            //Get output from Stored Procedure
            $select = $this->db->conn->query('select @result');
            $result = $select->fetch_assoc();
            $data['content_id'] = $result['@result'];

            if ($result['@result'] > 0) {
                if ($this->uploadHashtag($result['@result'], $content_hashs)) {
                    $data['success'] = true;
                    $this->db->conn->commit();
                } else {
                    throw new Exception("System error occur :( please try it later");
                }
            } else {
                throw new Exception("System error occur :( please try it later");
            }
        } catch (Exception $e) {
            $this->db->conn->rollback();
            $data['error'] = $e->getMessage();
        } finally {
            return $data;
        }
    }

    public function uploadimage($file_name, $file_size, $file_tmp)
    {
        $permitted = array('jpeg', 'jpg', 'gif', 'png');
        $time = getdate();
        $length = count($file_name);
        $imgpath = "image" . DS . $time['year'] . DS . $time['mon'];
        $count = 0;

        //get extension
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        foreach ($permitted as $extension) {
            if ($extension == $ext)
                $count++;
        }
        if ($count != 1) {
            throw new Exception("jpeg, png and gif extensions are supportive");
        }
        $file_name = $this->createFileName($time) . '.' . $ext;

        //make directory it not exists
        if (!is_dir("image" . DS . $time['year'])) {
            mkdir("image" . DS . $time['year'], 0755);
        }
        if (!is_dir($imgpath)) {
            mkdir($imgpath, 0755);
        }

        if ($length == 0) {
            throw new Exception("No file selected");
        } else if ($length == 1) {
            //move file to server
            if (move_uploaded_file($file_tmp, $imgpath . DS . basename($file_name))) {
                return $imgpath . DS . $file_name;
            } else {
                throw new Exception("System error occur during uploading file");
            }
        } else {
            throw new Exception("more than one file is selected");
        }
    }

    public function uploadAudio($file_name, $file_size, $file_tmp)
    {
        $permitted = array('mp3', 'wav');
        $time = getdate();
        $length = count($file_name);
        $wavepath = "wave" . DS . $time['year'] . DS . $time['mon'];
        $audiopath = "audio" . DS . $time['year'] . DS . $time['mon'];
        $count = 0;

        //get extension
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        foreach ($permitted as $extension) {
            if ($extension == $ext)
                $count++;
        }
        if ($count != 1) {
            throw new Exception("MP3 and WAV extensions are supportive");
        }

        $key = $this->createFileName($time);

        $file_name = $key . '.' . $ext;

        //make directory it not exists
        if (!is_dir("wave" . DS . $time['year'])) {
            mkdir("wave" . DS . $time['year'], 0755, true);
        }
        if (!is_dir("audio" . DS . $time['year'])) {
            mkdir("audio" . DS . $time['year'], 0755, true);
        }
        if (!is_dir($wavepath)) {
            mkdir($wavepath, 0755, true);
        }
        if (!is_dir($audiopath)) {
            mkdir($audiopath, 0755, true);
        }

        if ($length == 0) {
            throw new Exception("No file selected");
        } else if ($length == 1) {
            //move file to server
            if (move_uploaded_file($file_tmp, $audiopath . DS . basename($file_name))) {
                //get waveform file
                $justwave = new JustWave('GET');
                $justwave->setAudioDir($audiopath);
                $justwave->setWaveDir($wavepath);
                if ($justwave->create($key, $ext) == false) {
                    throw new Exception("convert error");
                } else {
                    return $audiopath . DS . $file_name;
                }
            } else {
                throw new Exception("System error occur during uploading file");
            }
        } else {
            throw new Exception("more than one file is selected");
        }
    }


    function uploadHashtag($contentid, $hashs)
    {
        $tmp = rtrim($hashs, ' ');
        $hashtags = explode(' ', $tmp);
        foreach ($hashtags as $hash) {
            $sql = $this->db->conn->prepare("CALL Win_Upload_Hashtag(?,?,@result)");
            $sql->bind_param('ss', $contentid, $hash);
            $sql->execute();
            $select = $this->db->conn->query('select @result');
            $hash_result = $select->fetch_assoc();
            if ($hash_result['@result'] != 1) {
                return $hash_result['@result'];
            }
        }
        return true;
    }


    function createFileName($time)
    {
        $ran = rand(1000, 9999);
        $id = $time['year'] . $time['mon'] . $time['mday'] . $time['hours'] . $time['minutes'] . $time['seconds'] . $ran;
        return $id;
    }
}