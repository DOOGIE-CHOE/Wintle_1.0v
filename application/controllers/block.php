<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2/15/17
 * Time: 1:15 PM
 */


class Block extends Controller {
    function __construct() {
        parent::__construct();
    }

    function index($id = null, $limit = 3){
        if(is_null($id)){
            error("index");
        }else{
            $comment = null;
            $count = 0;
            $data = $this->model->getContentInfo($id);
            //content
            if(count($data) == 1){

                //콘텐츠 생성자 갖고오기. 콘텐츠 삭제 버튼 디스플레이 및 삭제 절차에 있어서 콘텐츠가 사용자 본인의 것이 맞는지 확인 용도
                $this->view->contentCreator = $data[0]['user_id'];
                //타입에 따라 콘텐츠 삭제인지 프로젝트 삭제인지 판단
                $this->view->type = _CONTENT;
                $comment = $this->model->getContentComment($data[0]['content_id'],$limit,_CONTENT);
               // $count = $this->model->getCommentCount($data[0]['content_id'],_CONTENT);
            }else{ //project

                //콘텐츠 생성자 갖고오기. 콘텐츠 삭제 버튼 디스플레이 및 삭제 절차에 있어서 콘텐츠가 사용자 본인의 것이 맞는지 확인 용도
                $this->view->contentCreator = $this->model->getProjectCreator($data[0]['project_id']);
                //타입에 따라 콘텐츠 삭제인지 프로젝트 삭제인지 판단
                $this->view->type = _PROJECT;
                $comment = $this->model->getContentComment($data[0]['project_id'],$limit,_PROJECT);
              //  $count = $this->model->getCommentCount($data[0]['project_id'],_PROJECT);
            }
            $this->view->count = $count;
            $this->view->data = $data;
            $this->view->comment = $comment;

            $list = $this->setViewComponents("block/index");
            $this->view->render($list);
        }
    }

    public function getContentComment($content_id, $offset, $type){
        $data = $this->model->getContentComment($content_id, $offset, $type);
        return $data;
    }

    public function uploadComment($comment_id, $user_id, $content_id, $content_type){
        $data = $this->model->uploadComment($comment_id, $user_id, $content_id, $content_type);
        echo json_encode($data);
    }

    public function editComment(){

    }

    public function test(){
        $list = $this->setViewComponents("block/test");
        $this->view->render($list);
    }

    public function deleteContent($id){
        $data = $this->model->deleteContent($id);
        echo json_encode($data);
    }


}