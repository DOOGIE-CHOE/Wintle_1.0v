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

        //폴더 존재 여부 판단
        if(!is_dir($folder)){
            mkdir($folder);
        }

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
            if($e->getCode() == 0 )
                $error = $e->getMessage();
            else
                $error = "System error occurs. Try it later or contact to system manager";
        }finally{
            echo json_encode(array($success,$error));
        }
    }

    function deleteProfilePhoto($user_id, $type) {
        if($type == "profile"){
            $attr = "profile_photo_path";
        }else if($type == "cover"){
            $attr = "cover_photo_path";
            $position = "cover_photo_position";
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
        if($type == "cover") {
            $sql = "UPDATE user_profile set $attr = null, $position = 0 where user_id = '$user_id'";
        }
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

    /*function uploadProfileintroduction(){
        $success = false;
        $error = null;
        textarea = nl2br($textarea,false);
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
    }*/

    /*function uploadProfileintroductionQuery($user_id, $textarea){
        $
        $sql = "UPDATE user_profile set introduction = '$textarea' where user_id = '$user_id'";
        if ($this->db->conn->query($sql) === TRUE) {
            return true;
        } else {
            throw new Exception("Failed to upload profile introduction.. :( Please, try it later");
        }
    }*/

    function loadMyContents($limit, $offset_home, $profile_id)
    {
        try {
            $contents = array();
            $projects = array();
            $tmp = null;

            //각 프로젝트 마다 포함하는 콘텐츠의 갯수가 다르므로, 프로젝트로 그룹바이를 한 뒤 offset을 줘서 프로젝스 갯수를 만큼 가져옴
            $sql = "select * from view_all_project_info as plist inner join
                    (select project_id from view_all_project_info
                    where project_creator = $profile_id
                    group by project_id
                    order by upload_date desc
                    limit $limit offset $offset_home ) as pid
                    on plist.project_id = pid.project_id
                    order by upload_date desc, sequence asc
                    ";

            $result = $this->db->conn->query($sql);

            $data = $result->fetch_assoc();

            $tmp = $data['project_id'];
            array_push($projects, $data);
            while ($data = $result->fetch_assoc()) {
                //가져온 콘텐츠가 이전 콘텐츠와 같은 프로젝트에 속해있다면
                if ($tmp == $data['project_id']) {
                    array_push($projects, $data);
                } else {
                    //다른 프로젝트라면 꺼내온 같은 프로젝트들을 contents 변수에 집어넣고 프로젝트 변수 재 선언
                    array_push($contents, $projects);
                    $tmp = $data['project_id'];
                    $projects = array();
                    array_push($projects, $data);
                }
            }
            array_push($contents, $projects);

            $sql = "SELECT * from view_all_content_info where user_id = $profile_id order by upload_date desc limit $limit offset $offset_home ";
            $result = $this->db->conn->query($sql);

            while ($data = $result->fetch_assoc()) {
                array_push($contents, $data);
            }

            if (is_null($contents)) {
                throw new Exception("Something went wrong. please refresh the page");
            }

        } catch (Exception $e) {
            if($e->getCode() == 0 )
                $contents = $e->getMessage();
            else
                $contents = "System error occurs. Try it later or contact to system manager";
        } finally {
            return $contents;
        }
    }

    function setUserFollow($user_id_2)
    {
        try {
            $type = null;
            $error = null;

            $user_id_1 = Session::get("user_id");

            //로그인 중인지 판단
            if($user_id_1 == null)
                return -1; // if it's not logged in

            $sql = $this->db->conn->prepare("CALL Win_User_Follow(?,?,@result)");
            $sql->bind_param('ss', $user_id_1, $user_id_2);
            $sql->execute();
            $select = $this->db->conn->query('select @result');
            $result = $select->fetch_assoc();
            if ($result['@result'] == -1) {
                throw new Exception("로그인 후 사용 가능합니다.");
            } else {
                //팔로우면 1 반환, 팔로우 취소면 2 반환, 회원이 아니면 -1 반환, 본인을 팔로우 할경우 -2 반환
                $type = $result['@result'];
            }
        } catch(Exception $e) {
            if($e->getCode() == 0 )
                $error = $e->getMessage();
            else
                $error = "System error occurs. Try it later or contact to system manager";
        } finally {
            echo json_encode(array($type, $error));
        }
    }

    function userCoverPhotoPosition($profile_id, $top_position)
    {
        try {
            $data = array();

            if($top_position == null){
                $top_position = 0;
            }

            $sql = $this->db->conn->prepare("CALL Win_Set_Cover_Position(?,?,@result)");
            $sql->bind_param('ss', $profile_id, $top_position);
            $sql->execute();

            $select = $this->db->conn->query('select @result');
            $result = $select->fetch_assoc();

            if($result['@result'] == 1){
                $data['result'] = true;
            } else {
                $data['result'] = false;
                throw new Exception("커버 사진의 위치를 변경하는 데 실패하였습니다. 잠시 후 다시 시도해 주세요");
            }
        } catch(Exception $e) {
            if($e->getCode() == 0 )
                $data['error'] = $e->getMessage();
            else
                $data['error'] = "System error occurs. Try it later or contact to system manager";
        } finally {
            echo json_encode($data);
        }
    }

    function loadMyFollow($limit, $offset_follow, $profile_id, $follow)
    {
        try {
            $follower = array();
            $data = array();

            if($follow == "followers"){
                $sql = "select * 
                      from view_follow_list_info as flist
                     where flist.user_id_2 = $profile_id
                     order by flist.follow_date
                     limit $limit offset $offset_follow";
            } else if($follow == "following"){
                $sql = "select * 
                      from view_follow_list_info as flist
                     where flist.user_id_1 = $profile_id
                     order by flist.follow_date
                     limit $limit offset $offset_follow";
            }

            $result = $this->db->conn->query($sql);

            while ($data = $result->fetch_assoc()) {
                array_push($follower, $data);
            }

            if (is_null($follower)) {
                throw new Exception("팔로워가 없습니다.");
            }

        } catch (Exception $e) {
            if($e->getCode() == 0 )
                $follower = $e->getMessage();
            else
                $follower = "System error occurs. Try it later or contact to system manager";
        } finally {
            return $follower;
        }
    }


    //프로필 화면에서 로그인유저가 팔로우 하였는지 확인 메소드
    function getUserFollow($profile_id){
        $user_id = Session::get("user_id");
        $following = "following";
        $follow = "follow";

        if($user_id == null)
            return -1; // if it's not logged in

        $sql = "select * from follow_list where user_id_1 = $user_id and user_id_2 = $profile_id";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();

        if($data['user_id_1'] != null){
            return $following;
        } else {
            return $follow;
        }
    }

    function getCoverPhotoPosition($profile_id){
        if($profile_id == null)
            return -1;

        $sql = "select cover_photo_position from user_profile where user_id = $profile_id";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();

        if($data['cover_photo_position'] != null){
            return $data['cover_photo_position'];
        } else {
            return 0;
        }
    }

    function getUserLike($profile_id){
        $sql = "select count(*) like_number
                  from content_list
                 where user_id = $profile_id
                   and content_id IN (select content_id 
                                        from content_like);";
        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();

        return $data;
    }

    function getContentsNumber($profile_id){
        $sql = "select count(*) content_number
                  from content_list
                 where user_id = $profile_id";

        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();

        return $data;
    }

    function getRemixingNumber($profile_id){
        $sql = "select count(*) remixing_number
                  from (
                        select A.project_id
                             , C.user_id
                          from project_list as A
                         inner join content_list as C
                            on C.content_id = A.content_id
                         where A.sequence not in (select max(B.sequence)
                                                    from project_list as B
                                                   where B.project_id = A.project_id
                                                   group by B.project_id)
                         group by A.project_id, C.user_id) remixing_list
                 where user_id = $profile_id";

        $result = $this->db->conn->query($sql);
        $data = $result->fetch_assoc();

        return $data;
    }
}