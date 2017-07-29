<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2/15/17
 * Time: 1:18 PM
 */

?>
<div id="all" class="bg_deepgray">

    <style>
        button.btn.play::before {
            content: "\25B6";
        }

        button.btn.play {
            background: #e3e3e3;
            /*border: 0;*/
            border-color:transparent;
        }

        button.btn.play:hover {
            /*background: #cccccc;*/
        }

        .adddata_write_input .tag-editor-tag {
            background: none;
            color: #888888;
        }

        .adddata_write_input .tag-editor-delete {
            display: none;
        }

        .adddata_write_input .tag-editor {
            background: white;
        }

        .adddata_write_input .tag-editor input {
            color: black;
        }
        .delete-modal-wrapper{
            top: 300px;
            position: absolute;
            left: 0;
            right: 0;
            margin: auto;
            width: 500px;
            height:200px;
        }
        .delete_bodyAR{
            height: 100%;
            overflow: auto;
            width: 100%;
            position: fixed;
            top: 0;
        }

    </style>
    <script>
        var limit = 8;
        var project_audio_context = null;
        var project_recorder = null;
        var visualizer = null;
        var readyMicroPhoneEvent = null;
        var readyAudioEvent = null;

        function backward() {
            window.history.back();
        }

        function toggledata() {
            $(".upload-project").toggle();
            $(".buttons").toggle();
        }


        $(function () {
            $("#deleteContent").on('click', function(){

                <?php if(isset($this->data[0]['project_id'])){ ?>
                var contentid = <?php echo $this->data[0]['project_id'];?>;
                <?php }else if(isset($this->data[0]['content_id'])){ ?>
                var contentid = <?php echo $this->data[0]['content_id'];?>;
                <?php }
                ?>
                $.ajax({
                    url: "<?php echo URL ?>block/deletecontent/"+contentid,
                    type: 'POST',
                    async: false,
                    success: function (data) {
                        var value = jQuery.parseJSON(data);
                        if (value.success == true) {
                            errorDisplay("게시글 삭제 완료");

                            var tmp = setInterval(function(){
                                clearInterval(tmp);
                                window.location= _URL;
                            },500);
                        } else if (value.error != false) {
                            errorDisplay(value.error);
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            $('#deleteModal').on('click', function (e) {
                if ($(e.target).attr('class') == "delete_bodyAR") {
                    var opened = $('#deleteModal').hasClass('modal in');
                    if (opened === true) {
                        $('#deleteModal').modal('hide');
                    }
                }
            });


            $("#upload-comment-form").submit(function (event) {
                <?php
                if(!Session::isSessionSet('user_id')){?>
                errorDisplay("로그인이 필요한 서비스 입니다");
                return false;
                <?php }?>

                var formData = new FormData($(this)[0]);
                var userid = '<?php echo Session::get('user_id')?>';
                <?php if(isset($this->data[0]['project_id'])){ ?>
                var contentid = <?php echo $this->data[0]['project_id'];?>;
                var type = '<?php echo "project"?>';
                    <?php }else if(isset($this->data[0]['content_id'])){ ?>
                var contentid = <?php echo $this->data[0]['content_id'];?>;
                var type = '<?php echo "content"?>';
                    <?php }
                ?>

                var url = _URL+"block/uploadcomment/0/"+userid+"/"+contentid+"/"+type;
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        var value = jQuery.parseJSON(data);
                        if(value.success == true){
                            $("#comment_input")[0].value = "";
                            $.pagehandler.loadContent(window.location.href,'comment');
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });



            $('#hashtags').tagEditor({
                delimiter: ' ,', /* space and comma */
                placeholder: "#",
                //테그의 상태에 변화가 있을떄
                onChange: function (field, editor, tags) {
                    var tmp = $(".tag-editor-tag");
                    var all = $('li', editor).find(tmp);

                    // 이전에 입력되었던 테그인지 확인
                    for (var j = 0; j < tags.length; j++) {
                        if (tags[j] == "#" + tags[tags.length - 1]) {
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
                    for (var i = 0; i < all.length; i++) {
                        if (all[i].innerHTML != "" && (all[i].innerHTML).substring(0, 1) != "<" && (all[i].innerHTML).substring(0, 1) != "#") {
                            // 영어 숫자 한글 특수문자 _ 를 제외한 나머지 문자는 제거
                            all[i].innerHTML = all[i].innerHTML.replace(/[^a-z\d_ㄱ-ㅎ|ㅏ-ㅣ|가-힣]+/gi, "");

                            //마지막으로 추가된 해쉬테그의 앞쪽에 # 삽입
                            all[i].innerHTML = "#" + all[i].innerHTML;
                        }
                    }
                }
            });


            $(".userinfo").sortable({
                handle: '#handled',
                cancel: '',
                axis: 'y',
                start: function (e, o) {
                    var object = o.item;
                    object[0].style.boxShadow = "0 0 8px 0 black";
                },

                stop: function (e, o) {
                    var object = o.item;
                    object[0].style.boxShadow = "";
                }
            }).disableSelection();


            //리믹싱 클릭 시 제목에 바로 커서가 올라감 -> 모바일에서 볼때 키보드 자판이 화면을 가림
            //그렇게 되면 사진이나 동영상을 바로 올리고 싶은 사람은 불편하기때문에 주석처리
//            $("#addTalent").click(function () {
//                var childPos = $("#upload-project").offset().top;
//                var parentPos = $(".view_bodyAR").offset().top;
//                $('.view_bodyAR').animate({
//                    scrollTop: childPos - parentPos - 80
//                }, 1000, function () {
//                    $("#project_content_title").focus();
//                });
//            });


            //upload ajax
            $("#upload-project-form").submit(function (event) {
                <?php
                if(!Session::isSessionSet('user_id')){?>
                errorDisplay("Please log in for uploading content");
                return false;
                <?php }?>

                var formData = new FormData($(this)[0]);

                <?php
                $c_ids = null;
                foreach ($this->data as $data) {
                    $c_ids .= $data['content_id'] . ",";
                }
                ?>
                formData.append("content_ids", '<?php echo $c_ids?>');

                var audioBlob = document.getElementById('audioBlob-project');
                console.log(audioBlob);
                if (typeof audioBlob.src !== "undefined") {
                    formData.append("microphone_blob", audioBlob.src,"blob");
                }





                $.ajax({
                    url: "<?php echo URL ?>upload/uploadproject",
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        var value = jQuery.parseJSON(data);
                        if (value.success == true) {
                            errorDisplay("업로드 완료");
//                            $('#playDetailModal').modal('hide');

                            // Submit 후 콘텐츠 업로드를 위해 한번더 Submit 을 하면 콘텐츠 업로드가 안되고 페이지가 새로 고쳐짐
                            // 따라서 콘텐츠 업로드 후 페이지 새로고침을 수행
                            var tmp = setInterval(function(){
                                clearInterval(tmp);
                                window.location= _URL;
                            },500);
                        } else if (value.error != false) {
                            errorDisplay(value.error);
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
                return false;
            });


            $("#file-project-image").change(function () {
                $("#previewprojectdiv").css("display", "block");
                $("#preview-project-audio").css("display", "none");
                $("#preview-project-microphone").css("display", "none");
                $('#file-project-audio').val("");
                $("#preview-project-image").css("display", "block");
                readProjectImage(this);
            });

            //on audio selected
            $("#file-project-audio").change(function () {
                $("#previewprojectdiv").css("display", "block");
                $("#preview-project-image").css("display", "none");
                $("#preview-project-microphone").css("display", "none");
                $('#file-project-image').val("");
                $("#preview-project-audio").css("display", "block");
                readProjectAudio(this);
            });


            $("#preview-project-microphone")[0].addEventListener("onMicrophoneAudioUploadProject", function () {
                $("#previewprojectdiv").css("display", "block");
                $("#preview-project-image").css("display", "none");
                $("#preview-project-audio").css("display", "none");
                $("#preview-project-microphone").css("display", "block");
                $('#file-project-image').val("");
                $('#file-project-audio').val("");
            });
        });


        //image preview
        function readProjectImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview-project-image').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        //audio preview
        function readProjectAudio(input) {
            var pvAudio = document.getElementById('preview-project-audio');
            var pvMP = document.getElementById('preview-project-microphone');
            pvAudio.innerHTML = "";
            pvMP.innerHTML = "";
            pvAudio.src = URL.createObjectURL(input.files[0]);
            createWaveform(pvAudio.src, "#preview-project-audio");
        }



        function startMultiSyncRecording(content, title, hash) {
            readyForMultiSyncRecording(content, title, hash);
        }

        function readyForMultiSyncRecording(content, title, hash) {
            var isAudioContaining = true;
            //만약 clipping하는 콘텐츠에 음원파일이 존재하지 않는다면
            var audioformat = ["mp3", "wav"];
            var count = 0;
            for (var i = 0; i < content.length; i++) {
                var tmp = content[i].split('.');
                for (var j = 0; j < audioformat.length; j++) {
                    if (tmp[tmp.length - 1] == audioformat[j]) count++;
                }
            }
            if (count == 0) {
                isAudioContaining = false;
            }

            if (readyMicroPhoneEvent == null) {
                readyMicroPhoneEvent = new Event('MSR');
                document.addEventListener('MSR', function (e) {
                    if (isAudioContaining) {
                        playAudioFiles(content, title, hash, readyAudioEvent);
                    } else {
                        project_recorder && project_recorder.record();
                        document.dispatchEvent(readyAudioEvent);
                    }
                }, false);
            }


            if (readyAudioEvent == null) {
                readyAudioEvent = new Event('AudioReady');
                document.addEventListener('AudioReady', function (e) {
                    if (isAudioContaining) {
                        countDown();
                    } else {
                        countDown(false);
                    }
                }, false);
            }

            initMicrophoneProject();
        }


        function stopRecordingProject() {
            $("#sign-background").css("display", "none");
            $("#microphone-label-project-stop").css("display", "none");
            $("#microphone-label-project-start").css("display", "inline-block");

            project_recorder && project_recorder.stop();

            var myEvent = new CustomEvent("onMicrophoneAudioUploadProject");
            $("#preview-project-microphone")[0].dispatchEvent(myEvent);

            // create WAV download link using audio data blob
            createDownloadLinkProject();
            project_recorder.clear();
            stopPlaying();

            //비주얼라이저 초기화화
           visualizer = null;
            $('.cssload-overlay').css("visibility", "visible");
        }

        function createDownloadLinkProject() {
            project_recorder && project_recorder.exportWAV(function (blob, url ) {

                //call back으로 받은 blob을 zip 파일로 생성
                var zip = new JSZip();
                zip.file("HiThere.wav", blob, {base64: true});
                zip.generateAsync({type:"blob",
                    compression: "DEFLATE"
                }).then(function(content) {
                    var tmp = document.getElementById('audioBlob-project');
                    tmp.src = content;
                });
                //웨이브폼을 생성해야 하므로 base64 형식에 url 도 함께 가져옴
                var au = document.getElementById('preview-project-microphone');
                au.controls = true;
                au.src = url;
                au.innerHTML = "";
                createWaveform(au.src, "#preview-project-microphone");
                $('.cssload-overlay').css("visibility", "hidden");
            });
        }

        function initMicrophoneProject() {
            if (project_audio_context == null) project_audio_context = new( window.AudioContext || window.webkitAudioContext) ;
            // webkit shim
            navigator.getUserMedia = ( navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia);
            window.URL = window.URL || window.webkitURL;
            navigator.getUserMedia({audio: true}, startUserMediaProject, failToGetUserMedia);
        }



        function startUserMediaProject(stream) {
            //사운드 비주얼라이져 부분
            if(visualizer == null){
                visualizer = new SoundVisualizer;
                visualizer.App.init();
                visualizer.context = project_audio_context;
                visualizer.source = project_audio_context.createMediaStreamSource(stream);
                visualizer.analyser = visualizer.context.createAnalyser();
                visualizer.source.connect(visualizer.analyser);
            }
            //마이크 녹음 시작
            if (project_recorder == null) {
                project_recorder = new Recorder(visualizer.source, {
                    numChannels: 1
                }, "project");
            }

            $("#microphone-label-project-stop").css("display", "inline-block");
            $("#microphone-label-project-start").css("display", "none");

            document.dispatchEvent(readyMicroPhoneEvent);
        }

        function failToGetUserMedia() {
            errorDisplay("Please allow to use microphone in order to record");
        }

        function countDown(play = true) {
            //CSS 설정 초기화
            $("#sign-background").css("display", "block");
            $("#sign-board").css("display", "block");
            $("#count-to-ready-2").css("background", "#f00");
            $("#count-to-ready-1").css("background", "#f00");
            $("#count-to-ready-0").css("background", "#f00");
            $("#stop-button").css("display", "none");

            var i = 3;
            var countInterval = setInterval(function () {
                i--;
                if (i == -1) {
                    if (play) {
                        startPlaying();
                    }
                    var interval = setInterval(function () {
                        project_recorder && project_recorder.record();
                        clearInterval(interval);
                    }, 130);
                    $("#sign-board").css("display", "none");
                    $("#stop-button").css("display", "block");
                    clearInterval(countInterval);
                } else {
                    $("#count-to-ready-" + i).css("background", "black");
                }
            }, 800);
        }


    </script>

    <div class="modal" id="deleteModal" role="dialog">
        <div class="delete_bodyAR" style="background:none;">
        <div class="delete-modal-wrapper grid-item">
            <div class="container" style="margin:0;">
                <ul>
                    <li>
                        <div style="padding:50px 10px 10px; border-bottom:1px solid #eeeeee">
                             <span>
                                 게시물이 삭제되면 더이상 찾을 수 없으며 복구가 불가능 합니다.
                             </span>
                            <span>
                                 정말로 삭제 하시겠습니까 ?
                            </span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <div id="deleteContent" class="btn win-red-button" style="float:right; margin:10px;" >
                                <span>Delete</span>
                            </div>

                            <div class="btn win-red-button-filled" style="float:right; margin:10px;" onclick="$('#deleteModal').modal('hide');">
                                <span>Cancel</span>
                            </div>
                        </div>

                    </li>

                </ul>

            </div>
        </div>
        </div>
    </div>

    <div>
        <!--        <div class="view_header_fix" style="text-align:center">-->
        <!--            <div class="modal_close" data-dismiss="modal"><a href="#">&times;</a></div>-->

        <!--        </div>-->
        <!--view_header_fix-->


        <!--1앨범상세 header-->
        <div class="view_bodyAR">
            <div class="view_header_fix_top-back">
                <span onclick="backward()"><img style="height:35px;" src="<?php echo URL?>icon/Music_pop_up/pagebackward.svg"></span>
            </div>
            <div class="modal-content">

                <div class="view_header_fix_top">
                    <ul>
                        <li class="bg_white" style="border-bottom:1px solid #eeeeee">
                            <div class="container-fluid">

                                <?php
                                $audiolist = array();

                                foreach ($this->data as $data) {
                                    if ($data['content_type_name'] == 'audio') {
                                        array_push($audiolist, URL . $data['content_path']);
                                    }
                                }
                                $title = $this->data[count($this->data) - 1]['content_title'];
                                $hash = htmlentities($this->data[count($this->data) - 1]['hashtags']);

                                ?>

                                <span class="icon" style="float:right;">
                                      <button type="button" id="addTalent" class="f_white btn f_bred"
                                              style="font-size:12px; border-radius:3px;"
                                              onclick="toggledata();" data-langNum="1207">Remixing</button>
                                </span>
                                <?php
                                if ($audiolist) {
                                    ?>
                                    <span class="icon">
                                        <button class="btn play" style="font-size:12px; border-radius:3px;" data-langNum="1206"
                                                onclick='playAudioFiles(<?php echo json_encode($audiolist) ?>,"<?php echo $title ?>","<?php echo $hash ?>")'
                                        > Play</button>
                                    </span>

                                    <!--                                추후 박스에 추가하기 버튼으로 사용 할 예정 -->
                                    <!--                                <span class="icon"-->
                                    <!--                                      onclick='playAudioFiles(--><?php //echo json_encode($audiolist) ?><!--,"--><?php //echo $title ?><!--","--><?php //echo $hash ?><!--")'>-->
                                    <!--                                        <button class="btn play btn-default"> Play</button>-->
                                    <!--                                    </span>-->


                                    <?php
                                }
                                ?>

                                <div class="dropdown">
<!--                                    <span style="float:left; padding:10px">-->
                                      <button type="button" id="addTalent" class="btn dropdown-toggle" data-toggle="dropdown"
                                              style="font-size:12px; border-radius:3px; background:#e3e3e3; float:left; margin:10px">
                                          <img src="<?php echo URL?>icon/Music_pop_up/WI_more.svg" style="width:32px;">
                                      </button>
<!--                                     </span>-->

                                    <ul class="dropdown-menu" style="top:45px;">
                                        <?php
                                            if($this->contentCreator == Session::get("user_id")){ ?>
                                                <li><a data-toggle='modal' data-target='#deleteModal'>Delete this content</a></li>
                                            <?php }else{

                                            }
                                        ?>

                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="bg_white ofh"
                            style="border-bottom:1px solid #eeeeee; text-align: center; height:45px;">
                            <span class='music_name'
                                  style="position:relative; top:10px;">

                                <?php echo htmlentities($title) //htmlentities = html 코드를 html name 으로 변환하는 함수?>
                                </span>
                        </li>
                    </ul>
                </div><!--view_header_fix_top-->
                <!--2앨범관련 커뮤니티area-->
                <div class="view_body_fix">
                    <!--앨범사진외 -->
                    <div>
                        <ul class="userinfo">
                            <?php
                            $waveSequence = 0;
                            foreach ($this->data as $data) { ?>
                                <?php if ($data['content_type_name'] == 'audio') { ?>

                                <li class='albumA' id="block">
                                    <ul>
                                        <li class="buttons">
                                            <div class="remove">
                                                <img src="<?php echo URL ?>icon/upload/delete.svg" style="height:18px;">
                                            </div>
                                            <div class="sort" id="handled">
                                                <img src="<?php echo URL ?>icon/upload/menu.svg" style="height:18px;">
                                            </div>
                                        </li>
                                        <li class="audioHeight">
                                            <span class="user" style="position:absolute"
                                                  onclick="$.pagehandler.loadContent('<?php echo URL . $data['profile_url'] ?>' ,'all');">
                                                 <div class="userN">
                                                        <?php echo "by " . $data['user_name'] ?>
                                                 </div>
                                            </span>

                                            <div onclick="playSingleAudio(this)"
                                                 id="waveform-<?php echo $waveSequence; ?>"></div>
                                        </li>
                                        <?php if ($data['comments'] != "") { ?>
                                            <li class="lyricsPadding lyricsFontSize">
                                                <span class='music_name'> <?php echo preg_replace("/\r\n|\r|\n/", '<br/>', $data['comments']) ?></span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } else if ($data['content_type_name'] == 'image') { ?>
                                <li class='albumP' id="block">
                                    <ul>
                                        <li class="buttons">
                                            <div class="remove">
                                                <img src="<?php echo URL ?>icon/upload/delete.svg" style="height:18px;">
                                            </div>
                                            <div class="sort" id="handled">
                                                <img src="<?php echo URL ?>icon/upload/menu.svg" style="height:18px;">
                                            </div>
                                        </li>
                                        <li>
                                            <span class="user" style="position:absolute"
                                                  onclick="$.pagehandler.loadContent('<?php echo URL . $data['profile_url'] ?>' ,'all');">
                                                    <div class="userN">
                                                        <?php echo "by " . $data['user_name'] ?>
                                                    </div>
                                            </span>
                                            <img src='<?php echo URL . $data['content_path'] ?>' alt=''/>
                                        </li>
                                        <?php if ($data['comments'] != "") { ?>
                                            <li class="lyricsPadding lyricsFontSize">
                                                <span class='music_name'> <?php echo preg_replace("/\r\n|\r|\n/", '<br/>', $data['comments']) ?></span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } else if ($data['content_type_name'] == 'lyrics') { ?>
                                <li class="albumT" id="block">
                                    <ul>
                                        <li class="buttons">
                                            <div class="remove">
                                                <img src="<?php echo URL ?>icon/upload/delete.svg" style="height:18px;">
                                            </div>
                                            <div class="sort" id="handled">
                                                <img src="<?php echo URL ?>icon/upload/menu.svg" style="height:18px; ">
                                            </div>
                                        </li>
                                        <li>
                                            <span class="user" style="position:absolute"
                                                  onclick="$.pagehandler.loadContent('<?php echo URL . $data['profile_url'] ?>' ,'all');">
                                                    <div class="userN">
                                                        <?php echo "by " . $data['user_name'] ?>
                                                    </div>
                                            </span>
                                            <div class="lyricsPadding">
                                                <span class='lyrics'> <?php
                                                    $allLines = explode("\r\n", $data['comments']);
                                                    foreach ($allLines as $line) {
                                                        //htmlentities = html 코드를 html name 으로 변환하는 함수
                                                        echo "<p>" . htmlentities($line) . "</p>";
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php } else if($data['content_type_name'] == null){ ?>
                            <li class="album-Deleted" id="block">
                                <ul>
                                    <li class="buttons">
                                        <div class="remove">
                                            <img src="<?php echo URL ?>icon/upload/delete.svg" style="height:18px;">
                                        </div>
                                        <div class="sort" id="handled">
                                            <img src="<?php echo URL ?>icon/upload/menu.svg" style="height:18px; ">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="deleted-content">
                                             <span>
                                               삭제된 게시글 입니다.
                                             </span>
                                        </div>
                                    </li>
                                </ul>

                            </li>
                            <?php }?>

                                <!--                            --><?php //if ($data['hashtags'] != "") { ?>
                                <!--                                <li>-->
                                <!--                                    --><?php
                            //                                    $hashs = explode(",", $data['hashtags']);
                            //                                    foreach ($hashs as $tag) {
                            //                                        echo "<span class='f_dwhite' style='margin:2px; font-size:1em; padding:0 5px 0 5px;'>$tag</span>";
                            //                                    }
                            //                                    ?>
                                <!--                                </li>-->
                                <!--                            --><?php //}
                            if ($data['content_type_name'] == 'audio') {
                            ?>
                                <script>
                                    //2017-04-14 인코딩 문제로 소스 수정
                                    createWaveform(unescape('<?php echo URL.urlencode($data['content_path'])?>'), '<?php echo "#waveform-".$waveSequence++?>');
                                </script>
                            <?php }
                            } ?>
                            <li style="margin-bottom:-1px; position:relative; overflow:auto;">
                                <div id="sign-background"
                                     style="position:absolute; width:100%; height:100%; background:rgba(0,0,0,0.2); display:none;">
                                    <ul id='sign-board' style="height:100%; padding:0 50px 0 50px;">
                                        <li style="height:33%;"></li>
                                        <li style="height:33%;">
                                            <ul class="count-board"
                                                style="display:flex; justify-content: center; align-items: center; height:100%;">
                                                <li style="margin:auto;">
                                                    <div id="count-to-ready-2"
                                                         style="background: #f00; width: 30px; height: 30px;border-radius: 50%;"></div>
                                                </li>
                                                <li style="margin:auto;">
                                                    <div id="count-to-ready-1"
                                                         style="background: #f00; width: 30px; height: 30px;border-radius: 50%;"></div>
                                                </li>
                                                <li style="margin:auto;">
                                                    <div id="count-to-ready-0"
                                                         style="background: #f00; width: 30px; height: 30px;border-radius: 50%;"></div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li style="height:33%;"></li>
                                    </ul>
                                    <div id="stop-button" style="width:100%; height:100%;">
                                        <img    src="<?php echo URL ?>icon/upload/cancel-button.svg"
                                                style="width:50px; height:50px;position:absolute; /*it can be fixed too*/
                                                left:0; right:0; top:0; bottom:0; margin:auto; z-index:10001"
                                                onclick="stopRecordingProject()">
                                    </div>
                                    <!--                                      <div id="stop-button" style=""><span class='pulse-button'>ㅁ</span></div>-->
                                </div>
                                <div>
                                    <form id="upload-project-form" action="" method="post"
                                          enctype="multipart/form-data">
                                        <div class="adddata_write_input upload-project" id="upload-project"
                                             style="display:none; padding : 0; border-top:1px solid #eeeeee">
                                            <ul>
                                                <li>
                                                    <input type="text" class="form-control" name="content_title"
                                                           id="project_content_title"
                                                           placeholder="Please enter title" autocomplete="off">

                                                    <div style="width:100%; height:auto; display:none;"
                                                         id="previewprojectdiv">
                                                        <img id="preview-project-image" src="#"
                                                             style="height:100%;width:100%;"/>
                                                        <div id="preview-project-audio" class="audioHeight"
                                                             onclick="playSingleAudio(this)"
                                                             style="width:100%; background: #eff3f9;"></div>
                                                        <div id="preview-project-microphone" class="audioHeight"
                                                             onclick="playSingleAudio(this)"
                                                             style="width:100%; background: #eff3f9;"></div>
                                                        <div id="audioBlob-project">
                                                        </div>
                                                    </div>

                                                    <textarea id="textcontent" rows="5" onkeydown="resize(this)"
                                                              onkeyup="resize(this)"
                                                              class="form-control lyricsFontSize"
                                                              placeholder="Show us your inspiration"
                                                              style="resize:none;" name="content_comments"
                                                              autocomplete="off"></textarea>
                                                    <!--                                                <input type="text" class="form-control" name="hashtags" id="hashtags[]"-->
                                                    <!--                                                       placeholder="#" autocomplete="off">-->
                                                    <textarea id="hashtags" name="hashtags"
                                                              style="display:none"></textarea>

                                                    <input id="file-5-microphone-project-start"
                                                           onclick='startMultiSyncRecording(<?php echo json_encode($audiolist) ?>,"<?php echo $title ?>","<?php echo $hash ?>")'
                                                           style='display:none;'
                                                           class="inputfile">
                                                    <label id='microphone-label-project-start'
                                                           for="file-5-microphone-project-start">
                                                        <img src="
                                            <?php echo URL ?>icon/upload/voice.svg">
                                                    </label>

                                                    <input id="file-5-microphone-project-stop"
                                                           onclick="stopRecordingProject()" style="display:none;"
                                                           class="inputfile">
                                                    <label id='microphone-label-project-stop'
                                                           for="file-5-microphone-project-stop" style="display:none">
                                                        <img src="<?php echo URL ?>icon/upload/microphone-recording.svg">
                                                    </label>


                                                    <input type="file" name="content_path_audio" id="file-project-audio"
                                                           class="inputfile inputfile-4 f_bred"
                                                           accept=".mp3,audio/*" style="display:none;"/>
                                                    <label for="file-project-audio">
                                                        <img src="<?php echo URL ?>icon/upload/audio.svg">
                                                    </label>

                                                    <input type="file" name="content_path_image" id="file-project-image"
                                                           class="inputfile inputfile-4 f_bred"
                                                           accept="image/*" style="display:none;"/>
                                                    <label for="file-project-image">
                                                        <img src="<?php echo URL ?>icon/upload/image.svg">
                                                    </label>
                                                    <input type="submit" id="upload-content" class="btn f_right submit"
                                                           value="Upload" style="margin:10px 20px 0 0;">
<!--                                                    <div class='menu-controls'>-->
                                                        <!--<i class="i icon-backward2"></i> -->
                                                        <!--<i class="i icon-pause"></i> -->
                                                        <!--<i class="i icon-forward2"></i> -->
                                                        <!--<i class="i icon-soundcloud schover" data-hovertext='Play music from a SoundCloud URL.'></i> -->
<!--                                                        <i class="i icon-microphone" data-hovertext='Connect to the microphone on your computer.' data-hovertext-no-ssl='Please switch to a secure https:// connection and try again'></i>-->
<!--                                                    </div>-->
                                                </li>
                                            </ul>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="comment-part">
                        <ul class="media-list" >
                            <p class="comment_title">
                                <!--                                <img src="../icon/Music_pop_up/Comment.svg">-->
                                <span class="comment_text_total"><span><?php echo $this->count ?></span><span data-langNum="1208"></span></span>
                                <span class="comment_more"><a data-langNum="1217">More</a></span>
                            </p>
                    <?php if (!is_null($this->comment)) { ?>
                            <p style="height: 28px;  width: 100%;">
                                <span class="load-more" onclick="
                                var loadurl = window.location.href +'/'+ limit;
                                limit += 5;
                                $.pagehandler.loadContent(loadurl,'comment');
                                " data-langNum="1209">댓글 더 보기</span>
                            </p>
                            <?php
                            for($i = count($this->comment)-1; $i >= 0; $i--)  {
                                if(0 == $i){ ?>
                                    <li class="media pdb_10">
                               <?php }else{ ?>
                                    <li class="media">
                               <?php }

                                if($this->comment[$i]['profile_photo_path'] == null){
                                   $this->comment[$i]['profile_photo_path'] = "img/defaultprofile.png";
                               }


                               ?>
                                    <div class="wrt_mem"
                                         style="background-image:url(<?php echo URL.$this->comment[$i]['profile_photo_path']?>)"
                                         onclick="$.pagehandler.loadContent('<?php echo URL.$this->comment[$i]['profile_url'] ?>','all')">
                                    </div>
                                    <?php if($this->comment[$i]['user_id'] == Session::get('user_id')){?>
                                    <div class="wrt_day">
                                            <span><a>Edit</a></span>
                                    </div>
                                    <?php }?>
                                    <div class="wrt_con">
                                        <span class="name" onclick="$.pagehandler.loadContent('<?php echo URL.$this->comment[$i]['profile_url'] ?>','all')" ><?php echo $this->comment[$i]['user_name']?></span>
                                        <span class="date">
                                            <?php
                                            $current_time = new DateTime('now');
                                            $since_start = $current_time->diff(new DateTime($this->comment[$i]['upload_date']));
                                            if($since_start->y != 0 ){
                                                echo $since_start->y."년 전";
                                            }else if($since_start->m != 0 ){
                                                echo $since_start->m."개월 전";
                                            }else if($since_start->d != 0 ) {
                                                echo $since_start->d."일 전";
                                            }else if($since_start->h != 0 ) {
                                                echo $since_start->h."시간 전";
                                            }else if($since_start->i != 0 ){
                                                echo $since_start->i."분 전";
                                            }else if($since_start->s != 0 ) {
                                                echo $since_start->s."초 전";
                                            }else {
                                                echo "방금";
                                            }
                                            ?>
                                        </span>
                                        <span class="dpb pdl_15">
                                            <?php
                                                    $allLines = explode("\r\n", $this->comment[$i]['comment']);
                                                    foreach ($allLines as $line) {
                                                        //htmlentities = html 코드를 html name 으로 변환하는 함수
                                                        echo "<p>" . htmlentities($line) . "</p>";
                                                    }
                                            ?>
                                        </span>
                                    </div>
                                </li>
                            <?php } ?>



                    <?php } ?>
                        </ul>
                    </div>
                    <!--3댓글쓰기-->
                    <div class="view_footer">
                        <?php if(Session::isSessionSet('loggedIn') == true){ ?>
                            <script>
                                $.get("<?php echo URL?>common/getProfilePhoto/profile/<?php echo Session::get('user_id')?>", function (o) {
                                    if (o != null) {
                                        var value = jQuery.parseJSON(o);
                                        var photo = $("#wrt_mem_profile");
                                        if (value.profile_photo_path != null) {
                                            //display default image
                                            // photo.append("<img src = '"+value.profile_photo_path+"' style='width: 187px; height: 187px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'>");
                                            photo.css("background-image", 'url(<?php echo URL?>' + value.profile_photo_path + ')');
                                        }
                                    }
                                });
                            </script>
                        <?php } ?>
                        <div class="wrt_mem" id="wrt_mem_profile" style="background-image:url('<?php echo URL?>img/defaultprofile.png'); top:7px;"></div>
                        <form id="upload-comment-form" action="" method="post" enctype="multipart/form-data">
                            <input class="wrt_input" type="text" name="comment_input" id="comment_input" placeholder="댓글을 달아주세요..." autocomplete="off" data-langNum="1218">
                        </form>
                    </div>
                </div><!--view_body_fix-->
            </div><!--modal-content-->


            <br/><br/><br/><br/><br/><br/><br/><br/><br/>
            <br/><br/><br/><br/><br/><br/><br/><br/><br/>
            <!--            <div class="container mgb_100">-->
            <!---->
            <!--                <div class="playgroupAR">-->
            <!--                    <div class="playlistAR">-->
            <!--                        <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img-->
            <!--                                    src="../image/album_p2.jpg" class="album2"> <img-->
            <!--                                    src="../image/album_p3.jpg" class="album3"> <img-->
            <!--                                    src="../image/album_p4.jpg" class="album4"></div>-->
            <!--                        <div class="playgroupTitle"><span class="left f500 f_1-3">Funky</span> <span><font-->
            <!--                                        class="f_left f_09">8</font><font-->
            <!--                                        class="label label-danger f_right"><a-->
            <!--                                            href="#">edit</a></font></span></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <!--playgroupAR-->
            <!--                <div class="playgroupAR">-->
            <!--                    <div class="playlistAR">-->
            <!--                        <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album2"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album3"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album4"></div>-->
            <!--                        <div class="playgroupTitle"><span class="left f500 f_1-3">Funky</span> <span><font-->
            <!--                                        class="f_left">8</font><font-->
            <!--                                        class="label label-danger f_right">edit</font></span></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <!--playgroupAR-->
            <!--                <div class="playgroupAR">-->
            <!--                    <div class="playlistAR">-->
            <!--                        <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album2"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album3"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album4"></div>-->
            <!--                        <div class="playgroupTitle"><span class="left f500 f_1-3">재미있는노래</span> <span><font-->
            <!--                                        class="f_left">8</font><font-->
            <!--                                        class="label label-danger f_right">edit</font></span></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <!--playgroupAR-->
            <!--                <div class="playgroupAR">-->
            <!--                    <div class="playlistAR">-->
            <!--                        <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album2"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album3"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album4"></div>-->
            <!--                        <div class="playgroupTitle"><span class="left f500 f_1-3">피아노가좋은곡</span> <span><font-->
            <!--                                        class="f_left">8</font><font-->
            <!--                                        class="label label-danger f_right">edit</font></span></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <!--playgroupAR-->
            <!--                <div class="playgroupAR">-->
            <!--                    <div class="playlistAR">-->
            <!--                        <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album2"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album3"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album4"></div>-->
            <!--                        <div class="playgroupTitle"><span class="left f500 f_1-3">피아노가좋은곡</span> <span><font-->
            <!--                                        class="f_left">8</font><font-->
            <!--                                        class="label label-danger f_right">edit</font></span></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <!--playgroupAR-->
            <!--                <div class="playgroupAR">-->
            <!--                    <div class="playlistAR">-->
            <!--                        <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album2"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album3"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album4"></div>-->
            <!--                        <div class="playgroupTitle"><span class="left f500 f_1-3">피아노가좋은곡</span> <span><font-->
            <!--                                        class="f_left">8</font><font-->
            <!--                                        class="label label-danger f_right">edit</font></span></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <!--playgroupAR-->
            <!--                <div class="playgroupAR">-->
            <!--                    <div class="playlistAR">-->
            <!--                        <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album2"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album3"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album4"></div>-->
            <!--                        <div class="playgroupTitle"><span class="left f500 f_1-3">피아노가좋은곡</span> <span><font-->
            <!--                                        class="f_left">8</font><font-->
            <!--                                        class="label label-danger f_right">edit</font></span></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <!--playgroupAR-->
            <!--                <div class="playgroupAR">-->
            <!--                    <div class="playlistAR">-->
            <!--                        <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album2"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album3"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album4"></div>-->
            <!--                        <div class="playgroupTitle"><span class="left f500 f_1-3">피아노가좋은곡</span> <span><font-->
            <!--                                        class="f_left">8</font><font-->
            <!--                                        class="label label-danger f_right">edit</font></span></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <!--playgroupAR-->
            <!--                <div class="playgroupAR">-->
            <!--                    <div class="playlistAR">-->
            <!--                        <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album2"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album3"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album4"></div>-->
            <!--                        <div class="playgroupTitle"><span class="left f500 f_1-3">피아노가좋은곡</span> <span><font-->
            <!--                                        class="f_left">8</font><font-->
            <!--                                        class="label label-danger f_right">edit</font></span></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <!--playgroupAR-->
            <!--                <div class="playgroupAR">-->
            <!--                    <div class="playlistAR">-->
            <!--                        <div class="playPhoto"><img src="../image/album_p1.jpg" class="album1"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album2"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album3"> <img-->
            <!--                                    src="../image/album_p1.jpg" class="album4"></div>-->
            <!--                        <div class="playgroupTitle"><span class="left f500 f_1-3">피아노가좋은곡</span> <span><font-->
            <!--                                        class="f_left">8</font><font-->
            <!--                                        class="label label-danger f_right">edit</font></span></div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <!--playgroupAR-->
            <!---->
            <!---->
            <!--            </div><!--view_bodyAR-->
        </div><!--modal-->
    </div>
</div>
