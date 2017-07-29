

<div id="all">

    <style>
        @media all and (min-width: 700px) {
            .grid-item{
                margin:25px auto;
            }
        }

        .adddata_write_input .tag-editor-tag{
            background: none;
            color:#888888;
        }

        .adddata_write_input .tag-editor-delete{
            display:none;
        }

        .adddata_write_input .tag-editor{
            background :white;
        }
        .adddata_write_input .tag-editor input{
            color:black;
        }
    </style>
    <script>
        var limit = 2;
        var offset_main = 0;
        var flag_main = true;   //job flag

        $(function () {

            //파일 업로드 시 해쉬테그 입력란 관련 스크립트
            $('#hashtags').tagEditor({
                placeholder : "#",
                delimiter: ' ,', /* space and comma */

                //테그의 상태에 변화가 있을떄
                onChange: function(field, editor, tags) {
                    var tmp = $(".tag-editor-tag");
                    var all = $('li', editor).find(tmp);

                    // 이전에 입력되었던 테그인지 확인
                    for(var j = 0; j< tags.length ; j++ ){
                        if(tags[j] == "#"+ tags[tags.length-1] ) {
                            //입력되었던 테그가 있다면 마지막으로 추가된 테그 삭제 후 종료
                            $('li', editor).last().remove();
                            /*
                             * 기존에 존재하는 해쉬테그가 있어서 함수 실행이 종료 될 경우, 종료 된 후에도 중복이 되는 해쉬테그를 입력하게 되면
                             * 이곳 함수 전체 (onChange)가 실행되지 않고 바로 웹상에서 헤쉬테그를 입력하는 부분에 해당 해쉬테그가 삽입됨.
                             * 해당 버그를 찾아내는것이 최선이지만, 현재 상황으로써는 php에서 해쉬테그를 업로드 할 때, 첫번째 문자가 #으로 시작하지 않는경우
                             * 데이터베이스 입력을 생략하고 넘어감.
                             *
                             *
                             * 가끔가다가 onchange가 연속 두번으로 실행되는 버그도 존재함
                             * */

                         return false;
                        }
                    }
                    for(var i = 0; i < all.length ; i++){
                        if(all[i].innerHTML != "" && (all[i].innerHTML).substring(0,1) != "<" && (all[i].innerHTML).substring(0,1) != "#"){
                            // 영어 숫자 한글 특수문자 _ 를 제외한 나머지 문자는 제거
                            all[i].innerHTML = all[i].innerHTML.replace(/[^a-z\d_ㄱ-ㅎ|ㅏ-ㅣ|가-힣]+/gi, "");

                            //마지막으로 추가된 해쉬테그의 앞쪽에 # 삽입
                            all[i].innerHTML = "#" + all[i].innerHTML;
                        }
                    }
                }
            });


            if (flag_main) {
                flag_main = false;
                loadNewContent();
            }
            //스크롤 높이에 따른 추가 콘텐츠 로드
            $(window).bind('scroll', function () {
                // 페이지 전체 높이 - 페이지 첫 시작부분 부터 현재화면 상단부 < 현재 스크린 높이
                if (document.body.scrollHeight - $(window).scrollTop() < $(window).height() + 300 && flag_main == true) {
                    flag_main = false;    // wait until the job is done
                    loadNewContent(); // call loading card function
                }
            });

            //팝업창 바깥부분 클릭 시 페이지 뒤로 돌아가기 수행
            $('#playDetailModal').on('click', function (e) {
                if ($(e.target).attr('class') == "view_bodyAR") {
                    var opened = $('#playDetailModal').hasClass('modal in');
                    if (opened === true) {
                        $(this).html('');
                        window.history.back();
                    }
                }
            });


            //on image selected
            $("#file-5-image").change(function(){
                $("#previewdiv").css("display","block");
                $("#preview-audio").css("display","none");
                $("#preview-microphone").css("display","none");
                $('#file-5-audio').val("");
                $("#preview-image").css("display","block");
                readImage(this);
            });

            //on audio selected
            $("#file-5-audio").change(function(){
                $("#previewdiv").css("display","block");
                $("#preview-image").css("display","none");
                $("#preview-microphone").css("display","none");
                $('#file-5-image').val("");
                $("#preview-audio").css("display","block");
                readAudio(this);
            });

            $("#preview-microphone")[0].addEventListener("onMicrophoneAudioUpload",function(){
                $("#previewdiv").css("display","block");
                $("#preview-image").css("display","none");
                $("#preview-audio").css("display","none");
                $("#preview-microphone").css("display","block");
                $('#file-5-image').val("");
                $('#file-5-audio').val("");

            });

        });

        function loadNewContent() {
            //put this instead of on load function;
            $.get("<?php echo URL?>viewlist/loadNewContents/" + limit + "/" + offset_main, function (o) {
                    limit = 2;
                offset_main += 2;
                    var value = jQuery.parseJSON(o);
                    if (value == null) {
                        //display default image
                    } else {
                        for (var i = 0; i < value.length; i++) {
                            if (value[i].constructor === Array) {
                                if(value[i][value[i].length - 1].content_id == null){
                                    var param = {
                                        container:".grid-main",
                                        project_id : value[i][value[i].length - 1].project_id
                                    };
                                    //삭제된 컨텐츠 보여줄 필요가 없어짐
                                    //DisplayDeletedContent.init(param);
                                    //DisplayDeletedContent.display();
                                }else{
                                    displayProject(value[i][value[i].length - 1], value[i].length,".grid-main", "grid");
                                }
                            } else {
                                displayContent(value[i],".grid-main", "grid");
                            }
                        }
                    }
                $(".grid").css("height",$(".container").css("height"));
                }
            ).done(function () {
                    var interval = setInterval(function () {
                    flag_main = true; // the job is done
                    clearInterval(interval);
                },1000);
            });
        }



//        function islikedcontent(content_id, img){
//            var value;
//            $.get("<?php //echo URL?>//common/islikedcontent/" + content_id, function(o){
//                value = jQuery.parseJSON(o);
//            }).done(function () {
//                if(value == 1){
//                    img.src = _URL + "icon/Details_Content/stared.svg";
//                }else{
//                    img.src = _URL + "icon/Details_Content/star.svg";
//                }
//            });
//        }





    </script>
    <body class="body_bg02 popup-background, bg_deepgray">

    <div class="modal" id="playDetailModal" role="dialog">
    </div>

<!--  화면 하단 이용 약관 및 개인정보처리방침 페이지 링크 -->
    <div class="row info-bottom-board">
        <div class="col-md-2 col-lg-2 pull-right">
            <span onclick="$.pagehandler.loadContent('<?php echo URL?>info/terms','all')">Terms</span>
            <span onclick="$.pagehandler.loadContent('<?php echo URL?>info/privacy','all')">Privacy</span>
        </div>
    </div>

    <div id="wrapper">
        <div class="container bg_deepgray">

            <!--앨범전체 AREA-->
            <div class="grid grid-main row" style="max-width:650px;" >



                <div class="grid-item col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                    <form id="upload-content-form" action="" method="post" enctype="multipart/form-data">
                        <div class="adddata_write_input">
                            <ul id="recordingslist"></ul>
                            <ul>
                                <li>
                                    <input type="text" class="form-control" name="content_title" id="content_title"
                                           placeholder="제목이 궁금해요" autocomplete="off" data-langNum="1201">
                                </li>
                                <li>
                                    <div style="width:100%; height:auto; background:white; display:none;" id="previewdiv">
                                        <img id="preview-image" src="#"  style="height:100%;width:100%;"/>
                                        <!--                                    <audio id="preview-audio" style="width:100%; display:none;" controls></audio>-->
                                        <div id="preview-audio" class="audioHeight" style="width:100%; height:300px" onclick="playSingleAudio(this)"></div>
                                        <div id="preview-microphone"  class="audioHeight"  onclick="playSingleAudio(this)" style="width:100%; height:300px;"></div>
                                    </div>
                                    <div id="audioBlob">
                                    </div>
                                </li>
                                <li>
                                    <textarea id="textcontent" rows="2" onkeydown="resize(this)" onkeyup="resize(this)"
                                              class="form-control lyricsFontSize" placeholder="지금 무슨 영감이 떠오르셨나요 ?"
                                              style="resize:none;" name="content_comments" autocomplete="off" data-langNum="1202"></textarea>
                                </li>
                                <li>
<!--                                    <input type="text" class="form-control" name="hashtags" id="hashtags[]"-->
<!--                                           placeholder="#" autocomplete="off">-->
                                    <textarea id="hashtags" name="hashtags" style="display:none" placeholder="#"></textarea>
                                </li>
                                <li>
                                    <input id="file-5-microphone-start" onclick="startRecording()" style="display:none;" class="inputfile">
                                    <label id='microphone-label-start' for="file-5-microphone-start">
                                        <img src="<?php echo URL ?>icon/upload/voice.svg" class="voice-icon">
                                    </label>

                                    <input id="file-5-microphone-stop" onclick="stopRecording()" style="display:none;" class="inputfile">
                                    <label id='microphone-label-stop' for="file-5-microphone-stop" style="display:none">
                                        <img src="<?php echo URL ?>icon/upload/voice_filled.svg" >
                                    </label>


                                    <input type="file" name="content_path_audio" id="file-5-audio" class="inputfile inputfile-4 f_bred"
                                           accept=".mp3,audio/*" style="display:none;"/>
                                    <label for="file-5-audio" >
                                        <img src="<?php echo URL ?>icon/upload/audio.svg" class="audio-icon">
                                    </label>

                                    <input type="file" name="content_path_image" id="file-5-image" class="inputfile inputfile-4 f_bred"
                                           accept="image/*" style="display:none;" />
                                    <label for="file-5-image">
                                        <img src="<?php echo URL ?>icon/upload/image.svg" class="image-icon">
                                    </label>


                                    <input type="submit" id="upload-content" class="btn f_right submit" value="Upload" style="margin-top:12px;" data-langNum="1203">
                                </li>
                        </div>

                    </form>
                </div>
                <!--앨범-->
            </div><!--grid-->




        </div><!--container-->
    </div><!--#wrapper-->
    </body>

</div>


