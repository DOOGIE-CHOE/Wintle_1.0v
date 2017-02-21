<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2/15/17
 * Time: 1:18 PM
 */

?>
<div id="all" class="bg_deepgray">

    <script>
        function toggledata() {
            $(".upload-project").toggle();
        }

        $(function () {
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


                var fp = document.getElementById('preview-project-microphone');
                var head = 'data:image/png;base64,';
                var fileSize = Math.round((fp.src.length - head.length)*3/4) ;
                formData.append("microphone_name","");
                formData.append("microphone_tmp_name",fp.src);
                formData.append("microphone_size",fileSize);



                $.ajax({
                    url: "<?php echo URL ?>upload/uploadproject",
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        var value = jQuery.parseJSON(data);
                        if (value.success == true) {
                            errorDisplay("File's uploaded");
                            $('#writeContentModal').modal('hide');
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
                if (projectsound != null) projectsound.pause();
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
        var projectsound = null;
        function readProjectAudio(input) {
            projectsound = document.getElementById('preview-project-audio');
            projectsound.src = URL.createObjectURL(input.files[0]);
            // not really needed in this exact case, but since it is really important in other cases,
            // don't forget to revoke the blobURI when you don't need it
            projectsound.onend = function (e) {
                URL.revokeObjectURL(input.src);
            };
        }


                var project_audio_context;
                var project_recorder;
                function startUserMediaProject(stream) {
                    var input = project_audio_context.createMediaStreamSource(stream);
                    project_recorder = new Recorder(input, {
                        numChannels: 1
                    },"project");
                }

                function startRecordingProject(button) {
                    init();
                    console.log(11111);
                    $("#microphone-label-project-stop").css("display","inline-block");
                    $("#microphone-label-project-start").css("display","none");

                    project_recorder && project_recorder.record();
                }

                function stopRecordingProject(button) {
                    console.log(22222);
                    $("#microphone-label-project-stop").css("display","none");
                    $("#microphone-label-project-start").css("display","inline-block");

                    project_recorder && project_recorder.stop();

                    var myEvent = new CustomEvent("onMicrophoneAudioUploadProject");
                    $("#preview-project-microphone")[0].dispatchEvent(myEvent);

                    // create WAV download link using audio data blob
                    createDownloadLinkProject();

                    project_recorder.clear();
                }

                function createDownloadLinkProject() {
                    project_recorder && project_recorder.exportWAV(function (blob) {
                    });
                }

                function init(){

                    window.onload = function init() {
                        // webkit shim
                        window.AudioContext = window.AudioContext || window.webkitAudioContext;
                        navigator.getUserMedia = ( navigator.getUserMedia ||
                        navigator.webkitGetUserMedia ||
                        navigator.mozGetUserMedia ||
                        navigator.msGetUserMedia);
                        window.URL = window.URL || window.webkitURL;

                        project_audio_context = new AudioContext;

                        navigator.getUserMedia({audio: true}, startUserMediaProject, function (e) {

                        });

                    };

                }


    </script>
    <div>
        <!--        <div class="view_header_fix" style="text-align:center">-->
        <!--            <div class="modal_close" data-dismiss="modal"><a href="#">&times;</a></div>-->

        <!--        </div>-->
        <!--view_header_fix-->


        <!--1앨범상세 header-->
        <div class="view_bodyAR">

            <div class="modal-content">
                <div class="view_header_fix_top">
                    <ul>
                        <li class="bg_white ofh " style="border-bottom:1px solid #eeeeee">
                                    <span class="icon">
                                        <a href="#">
                                            <img src="<?php echo URL ?>icon/Details_Content/play.svg"/>
                                        </a>
                                    </span>
                            <?php
                            if ($this->data[0]['content_title'] != "") { ?>

                                <span class='music_title'
                                      style="position:relative; top:12px;"> <?php echo $this->data[0]['content_title'] ?></span>

                            <?php } ?>
                            <span class="btn">
                                               <button type="button" class="f_white btn btn-danger btn-sm"
                                                       onclick="toggledata();">add your talent to the music</button>
                                    </span>
                        </li>
                    </ul>
                </div><!--view_header_fix_top-->
                <!--2앨범관련 커뮤니티area-->
                <div class="view_body_fix">
                    <!--앨범사진외 -->


                    <ul class="userinfo">
                        <?php foreach ($this->data as $data) { ?>

                            <li style="padding-top:8px;">
                            <span class="user"
                                  onclick="$.pagehandler.loadContent('<?php echo URL . $data['profile_url'] ?>' ,'all');"
                                  \>
                                <div class="userP">
                                    <img src="../image/p1.jpg" class="img-circle">
                                </div>
                                <div class="userN">
                                    <?php echo $data['user_name'] ?>
                                </div>
                            </span>
                                <!--                            <span class="icon">-->
                                <!--                                <a href="#"><img src="-->
                                <?php //echo URL?><!--icon/Details_Content/like.svg" style="filter:invert()"/></a>-->
                                <!--                                <a href="#"><img src="-->
                                <?php //echo URL?><!--icon/Music_pop_up/list.svg" style="filter:invert()"/></a>-->
                                <!--                                <a href="#"><img src="../icon/Details_Content/share.svg" style="filter:invert()"/></a>-->
                                <!--                            </span>-->
                            </li>


                            <li>
                            <span>
                                <?php if ($data['content_type_name'] == 'audio') { ?>
                                    <div class='albumA'><img src='<?php
                                        $path = explode('/', $data['content_path']);
                                        $filename = explode('.', $path[3]);
                                        echo URL . "wave" . DS . $path[1] . DS . $path[2] . DS . $filename[0] . ".png";
                                        ?>' alt=''/></div>
                                <?php } else if ($data['content_type_name'] == 'image') { ?>
                                    <div class='albumP'><img src='<?php echo URL . $data['content_path'] ?>'
                                                             alt=''/></div>
                                <?php } ?>
                            </span>
                            </li>


                            <!--                        --><?php
//                        if($data['comments'] != ""){ ?>
                            <!--                            <div class='albumT'>-->
                            <!--                                --><?php //  echo str_replace("\n", "<br />", $data['comments']);
//                                ?>
                            <!--                            </div>-->
                            <!--                        --><?php //} ?>

                            <?php
                            if ($data['comments'] != "") { ?>
                                <li>
                                    <span class='music_name'> <?php echo $data['comments'] ?></span>
                                </li>
                            <?php } ?>

                            <?php if ($data['comments'] != "") { ?>
                                <li>
                                    <?php
                                    $hashs = explode(",", $data['hashtags']);
                                    foreach ($hashs as $tag) {
                                        echo "<span class='f_dwhite' style='margin:2px; font-size:1em; padding:0 5px 0 5px;'>$tag</span>";
                                    }
                                    ?>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <li>
                            <form id="upload-project-form" action="" method="post" enctype="multipart/form-data">
                                <div class="adddata_write_input upload-project"
                                     style="display:none; padding : 0 0 15px 0; margin-top:10px; border-top:1px solid #eeeeee">
                                    <ul>
                                        <li>
                                            <input type="text" class="form-control" name="content_title"
                                                   placeholder="Please enter title" autocomplete="off">

                                            <div style="width:100%; height:auto; display:none;" id="previewprojectdiv">
                                                <img id="preview-project-image" src="#"
                                                     style="height:100%;width:100%;"/>
                                                <audio id="preview-project-audio" style="width:100%;" controls></audio>
                                                <audio id="preview-project-microphone" style="width:100%"></audio>
                                            </div>

                                            <textarea id="textcontent" rows="5" onkeydown="resize(this)"
                                                      onkeyup="resize(this)"
                                                      class="form-control" placeholder="show us your inspiration"
                                                      style="resize:none;" name="content_comments"
                                                      autocomplete="off"></textarea>
                                            <input type="text" class="form-control" name="hashtags" id="hashtags[]"
                                                   placeholder="Please enter title" autocomplete="off">


                                                                                    <input id="file-5-microphone-project-start" onclick="startRecordingProject(this)" style="display:none;" class="inputfile">
                                                                                    <label id='microphone-label-project-start' for="file-5-microphone-project-start">
                                                                                        <img src="
                                            <?php echo URL ?>icon/upload/voice.svg" style="width:20px; height:20px;">
                                                                                    </label>

                                                                                    <input id="file-5-microphone-project-stop" onclick="stopRecordingProject(this)" style="display:none;" class="inputfile">
                                                                                    <label id='microphone-label-project-stop' for="file-5-microphone-project-stop" style="display:none">
                                                                                        <img src="
                                            <?php echo URL ?>icon/upload/microphone-recording.svg" style="width:20px; height:20px;">
                                                                                    </label>


                                            <input type="file" name="content_path_audio" id="file-project-audio"
                                                   class="inputfile inputfile-4 f_bred"
                                                   accept="audio/mpeg3,audio/x-wav" style="display:none;"/>
                                            <label for="file-project-audio">
                                                <img src="<?php echo URL ?>img/musical-note.svg"
                                                     style="width:20px; height:20px;">
                                            </label>

                                            <input type="file" name="content_path_image" id="file-project-image"
                                                   class="inputfile inputfile-4 f_bred"
                                                   accept="image/x-png,image/gif,image/jpeg" style="display:none;"/>
                                            <label for="file-project-image">
                                                <img src="<?php echo URL ?>img/frame-landscape.svg"
                                                     style="width:20px; height:20px;">
                                            </label>

                                            <input type="submit" id="upload-content" class="btn f_right f_bred"
                                                   value="Upload" style="margin:16px 16px 0 0;">
                                        </li>
                                </div>
                            </form>
                        </li>

                        <li class="bg_white ofh " style="border-top:1px solid #eeeeee;">
                                    <span class="icon" style="margin-right:10px;">
                                        <a href="#">
                                            <img src="<?php echo URL ?>icon/Details_Content/star.svg"/>
                                        </a> <a href="#">
                                            <img
                                                    src="<?php echo URL ?>icon/Music_pop_up/list.svg"/>
                                        </a> <a href="#">
                                            <img src="<?php echo URL ?>icon/Details_Content/share.svg"/>
                                        </a>
                                    </span>
                        </li>
                    </ul>


                    <!--media-->
                    <!--                    <ul class="media-list">-->
                    <!--                        <p class="comment_title"><img src="../icon/Music_pop_up/Comment.svg"> Comment <font-->
                    <!--                                    class="f_075">9</font><span><a href="#">More</a></span></p>-->
                    <!--                        <li class="media">-->
                    <!--                            <div class="wrt_mem"><img class="img-circle" src="../image/album_p6.jpg"-->
                    <!--                                                      style="width:55px; height:55px;"></div>-->
                    <!--                            <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Comment</a> / <a-->
                    <!--                                            href="#">Edit</a></span></div>-->
                    <!--                            <div class="wrt_con"><span class="name">kahee</span> <span-->
                    <!--                                        class="dpb mgt_8 pdl_15">첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다첫번째글 내용이 보여집니다</span>-->
                    <!--                            </div>-->
                    <!--                        </li>-->
                    <!--                        <li class="media">-->
                    <!--                            <div class="wrt_mem"><img class="img-circle" src="../image/album_p3.jpg"-->
                    <!--                                                      style="width:55px; height:55px;"></div>-->
                    <!--                            <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Comment</a> / <a-->
                    <!--                                            href="#">Edit</a></span></div>-->
                    <!--                            <div class="wrt_con"><span class="name">kahee</span> <span-->
                    <!--                                        class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span></div>-->
                    <!--                        </li>-->
                    <!--                        <!--댓글-->
                    <!--                        <li class="media comment">-->
                    <!--                            <div class="wrt_mem"><img class="img-circle" src="../image/album_p6.jpg"-->
                    <!--                                                      style="width:55px; height:55px;"></div>-->
                    <!--                            <div class="wrt_day"><span>2016/10/10</span><span><a href="#">Edit</a></span>-->
                    <!--                            </div>-->
                    <!--                            <div class="wrt_con"><span class="name">kahee</span> <span-->
                    <!--                                        class="dpb mgt_5 pdl_20">첫번째글 내용이 보여집니다</span></div>-->
                    <!--                        </li>-->
                    <!--                    </ul>-->
                </div>
                <!--view_body_fix-->

                <!--3댓글쓰기-->
                <!--                <div class="view_footer bg_dblue">-->
                <!--                    <img class="img-circle mem" src="../icon/Music_pop_up/user_man.svg"-->
                <!--                         style="width:55px; height:55px;">-->
                <!--                    <img class="wrt" src="../icon/Music_pop_up/Comment.svg"-->
                <!--                         style="width:30px; height:30px; filter:invert()">-->
                <!--                    <input class="wrt_input" type="text" id="usr" placeholder="write...">-->
                <!--                </div>-->
            </div><!--modal-content-->

            <br/><br/><br/><br/><br/><br/><br/><br/><br/>
            <br/><br/><br/><br/><br/><br/><br/><br/><br/>
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
