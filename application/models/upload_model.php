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
        $data = null;
        $data['error'] = false;
        try {
            $content_title = $_POST['content_title'];
            $content_comments = $_POST['content_comments'];
            $content_hashs = $_POST['hashtags'];

            if (!Session::isSessionSet('user_id')) {
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
            } else if (isset($_FILES['microphone_blob']['name']) && $_FILES['microphone_blob']['name'] != "") {
                $file_name = $_FILES['microphone_blob']['name'];
                $file_size = 0; // to check file size if it's too big
                $file_tmp = $_FILES['microphone_blob']['tmp_name'];
                $type = "audio";
                $format = "zip";
                $path = $this->uploadAudio($file_name, $file_size, $file_tmp, $format);
            } else if ($_POST['content_comments'] != "") {
                $type = "lyrics";
                $path = "";
            } else {
                $data['error'] = true;
                throw new Exception("이미지, 오디오 또는 텍스트 등 최소 1개 이상의 콘텐츠를 입력하세요.");
            }
            $data = $this->uploadContentProcedure($user_id, $content_title, $path, $content_comments, $content_hashs, $type);
        } catch (Exception $e) {
            if ($e->getCode() == 0)
                $data['error'] = $e->getMessage();
            else
                $data['error'] = "System error occurs. Try it later or contact to system manager";
        } finally {
            return $data;
        }

    }


    function uploadProject()
    {
        $data = null;
        try {
            $content_title = $_POST['content_title'];
            $content_comments = $_POST['content_comments'];
            $content_hashs = $_POST['hashtags'];
            if (!Session::isSessionSet('user_id')) {
                return $data['error'] = "Invalid input";
            }
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
            } else if (isset($_FILES['microphone_blob']['name']) && $_FILES['microphone_blob']['name'] != "") {
                $file_name = $_FILES['microphone_blob']['name'];
                $file_size = 0; // to check file size if it's too big
                $file_tmp = $_FILES['microphone_blob']['tmp_name'];
                $type = "audio";
                $format = "zip";
                $path = $this->uploadAudio($file_name, $file_size, $file_tmp, $format);
            } else if ($_POST['content_comments'] != "") {
                $type = "lyrics";
                $path = "";
            } else {
                $data['error'] = true;
                throw new Exception("이미지, 오디오 또는 텍스트 등 최소 1개 이상의 콘텐츠를 입력하세요.");
            }
            $data = $this->uploadContentProcedure($user_id, $content_title, $path, $content_comments, $content_hashs, $type);
            if ($data['success'] == true) {
                $content_ids .= $data['content_id'];
                $data = $this->uploadProjectProcedure($user_id, $content_ids);
            } else {
                throw new Exception("파일 업로드 애러");
            }
        } catch (Exception $e) {
            if ($e->getCode() == 0)
                $data['error'] = $e->getMessage();
            else
//                $data['error'] = "System error occurs. Try it later or contact to system manager";
                $data['error'] = $e->getMessage();

        } finally {
            return $data;
        }
    }


    function uploadProjectProcedure($user_id, $content_ids, $start_point = 0, $volume = 70)
    {
        $data = array();
        $data['error'] = false;
        try {
            $this->db->conn->begin_transaction();
            $sql = $this->db->conn->prepare("CALL Win_Upload_ProjectId(?,@result)");
            $sql->bind_param('s', $user_id);
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
            if ($e->getCode() == 0)
                $data['error'] = $e->getMessage();
            else
                $data['error'] = "System error occurs. Try it later or contact to system manager";
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
            if ($e->getCode() == 0)
                $data['error'] = $e->getMessage();
            else
                $data['error'] = "System error occurs. Try it later or contact to system manager";
        } finally {
            return $data;
        }
    }


    function getScalingRatio($width)
    {
        $MAXWIDTH = 600;
        $ratio = null;
        if ($width < $MAXWIDTH) {
            $ratio = 1;
        } else if ($width >= $MAXWIDTH) {
            $ratio = ($MAXWIDTH / $width); //get percentage
        }
        return $ratio;
    }

    function resizeImage($filename, $savepath, $savextension)
    {
        header('Content-Type: image/jpeg');
        // Get new sizes
        list($width, $height) = getimagesize($filename);
        $percent = $this->getScalingRatio($width);
        $newwidth = $width * $percent;
        $newheight = $height * $percent;

        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = null;

//        $source = imagecreatefrompng($filename);

        if ($savextension == "png") {
            try {
                $source = imagecreatefrompng($filename);
            } catch (Exception $e) {
                $source = imagecreatefromjpeg($filename);
            }
        } else if ($savextension == "jpg" || $savextension == "jpeg") {
            try {
                $source = imagecreatefromjpeg($filename);
            } catch (Exception $e) {
                $source = imagecreatefrompng($filename);
            }
        }
        $savepath = $savepath . "." . $savextension;

        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        $this->saveImage($thumb, $savepath);
        return $savepath;
    }

    function saveImage($thumb, $savepath)
    {
        imagejpeg($thumb, $savepath);
        imagedestroy($thumb);
        return true;
    }

    public function uploadimage($file_name, $file_size, $file_tmp)
    {
        $permitted = array('jpeg', 'jpg', 'png');
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
        $file_name = $this->createFileName($time);

        //make directory it not exists
        if (!is_dir("image")) {
            mkdir("image", 0755);
        }

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
            $path = $this->resizeImage($file_tmp, $imgpath . DS . $file_name, $ext);
            return $path;
        } else {
            throw new Exception("more than one file is selected");
        }
    }

    public function uploadAudio($file_name, $file_size, $file_tmp, $format = 'file')
    {
        $permitted = array('mp3', 'wav');
        $time = getdate();
        $length = count($file_name);
        //  $wavepath = "wave" . DS . $time['year'] . DS . $time['mon'];
        $audiopath = "audio" . DS . $time['year'] . DS . $time['mon'];
        $count = 0;

        //get extension
        if ($format == "zip") {
            $ext = "wav";
        } else {
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        }

        foreach ($permitted as $extension) {
            if ($extension == $ext)
                $count++;
        }
        if ($count != 1) {
            throw new Exception("MP3 and WAV extensions are supportive");
        }

        $key = $this->createFileName($time);
        $file_name = $key . "." . $ext;

        //make directory it not exists
//        if (!is_dir("wave" . DS . $time['year'])) {
//            mkdir("wave" . DS . $time['year'], 0755, true);
//        }
        if (!is_dir("audio")) {
            mkdir("audio", 0755);
        }
        if (!is_dir("audio" . DS . $time['year'])) {
            mkdir("audio" . DS . $time['year'], 0755, true);
        }
//        if (!is_dir($wavepath)) {
//            mkdir($wavepath, 0755, true);
//        }
        if (!is_dir($audiopath)) {
            mkdir($audiopath, 0755, true);
        }

        if ($length == 0) {
            throw new Exception("No file selected");
        } else if ($length == 1) {
            //move file to server

            $result = false;
            if ($format == "zip") {
                $result = move_uploaded_file($file_tmp, $audiopath . DS . $key . ".zip");
                $zip = new ZipArchive;

                if ($result) {
                    if ($zip->open($audiopath . DS . $key . ".zip") === TRUE) {
                        $zip->extractTo($audiopath . DS . $key);
                        $zip->close();

                        // 압축 해제 후 안에 있는 음원 파일을 기존 오디오 경로로 이동
                        rename($audiopath . DS . $key . DS . "HiThere.wav", $audiopath . DS . $key . ".wav");

                        //임시 zip 파일 및 폴더 권한 변경(삭제목적)
                        @chmod($audiopath . DS . $key, 755);
                        @chmod($audiopath . DS . $key . ".zip", 755);
                        //폴더 및 zip파일 삭제
                        @rmdir($audiopath . DS . $key);
                        @unlink($audiopath . DS . $key . ".zip");
                        $result = true;
                    } else {
                        throw new Exception("System error occur during uploading file");
                        //zip error 처리
                    }
                }
            } else { //파일 생성
                $result = move_uploaded_file($file_tmp, $audiopath . DS . basename($file_name));
                //get waveform file
            }
            if ($result) {
                //wav파일 mp3파일로 변환.
                if ($ext == "wav") {
                    $wavtomp3 = "../library/ffmpeg_server/ffmpeg -i " . $audiopath . DS . $file_name . " -acodec libmp3lame -ac 2 -ab 192k -ar 44100 " . $audiopath . DS . $key . ".mp3";
                    @exec($wavtomp3, $out);
                    $ext = "mp3";
                    $file_name = $key . "." . $ext;
                }

                //mp3파일 용량 줄이기
                $downsize_command = "../library/ffmpeg_server/ffmpeg -i " . $audiopath . DS . $file_name . " -acodec libmp3lame -ac 2 -ab 32k -ar 44100 " . $audiopath . DS . $key . "_scaled." . $ext;
                @exec($downsize_command, $out);
                return $audiopath . DS . $file_name;
//                $justwave = new JustWave('GET');
//                $justwave->setAudioDir($audiopath);
//                $justwave->setWaveDir($wavepath);
//                if ($justwave->create($key, $ext) == false) {
//                    throw new Exception("convert error");
//                } else {
//                    return $audiopath . DS . $file_name;
//                }
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
        $tmp = str_replace(',', ' ', $tmp);
        $hashtags = explode(' ', $tmp);
        foreach ($hashtags as $hash) {
            if ($hash != '' && $hash != '#' && substr($hash, 0, 1) == "#") {
                $sql = $this->db->conn->prepare("CALL Win_Upload_Hashtag(?,?,@result)");
                $sql->bind_param('ss', $contentid, $hash);
                $sql->execute();
                $select = $this->db->conn->query('select @result');
                $hash_result = $select->fetch_assoc();
                if ($hash_result['@result'] != 1) {
                    return $hash_result['@result'];
                }
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