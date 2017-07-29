<?php
/*
$top_fst_text = "Log In";
$top_snd_text = "Sign Up";
$top_fst_link = "#popup1";
$top_snd_link = "#popup1";


if(Session::isSessionSet("loggedIn")){
    $top_fst_text = "";
    $top_snd_text = "";
    $top_fst_link = "";
    $top_snd_link = "";
}*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>wintle</title>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr"/>
    <script src="<?php echo URL ?>js/config.js" type="text/javascript"></script>
    <script src="<?php echo URL ?>js/main.js" type="text/javascript"></script>
    <!------------jquery import ----------->
    <script src="<?php echo URL ?>js/jquery/jquery-3.1.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo URL ?>js/jquery/jquery.form.js" type="text/javascript"></script>
    <!-- draggable import -->
    <script src="<?php echo URL ?>js/jquery/jquery-ui.js" type="text/javascript"></script>

    <!-- underscore js import-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>

    <!-- Google Analytics -->
    <script src="<?php echo URL ?>public/js/analyticstracking.js" type="text/javascript"></script>

    <script src='https://www.google.com/recaptcha/api.js'></script> <!-- google ReCAPTCHA include -->
    <script src="https://apis.google.com/js/platform.js" async defer></script> <!-- google social login-->
    <meta name="google-signin-client_id"
          content="611141018688-vjcv2sqjcf133cgi453ogfi3lnj4c1bk.apps.googleusercontent.com">


    <!--   반응형 웹을 위한 뷰포트 오버라이딩  -->
    <meta name="viewport" content="width=device-width">
    <!--

    -------------------------------------------------------------------------
                            css reset, Java script, JS PlugIn
    -->
    <!-- css Plug In -->
    <link href="<?php echo URL ?>css/css_reset.css" rel="stylesheet"/>

    <!--추후 화면 확장성 위해 사용하는 프레임웍-->
    <link href="<?php echo URL ?>css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="<?php echo URL ?>js/bootstrap.js"></script>

    <!--공통사용하는 기본속성-->
    <link href="<?php echo URL ?>css/base.css" rel="stylesheet" type="text/css"/>

    <!--메인및작성되 화면 관리-->
    <link href="<?php echo URL ?>css/wintle.css" rel="stylesheet" type="text/css"/>

    <!--        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

    <!-- Form process -->
    <script src="<?php echo URL ?>js/login-signup/form.js"></script>

    <link rel="stylesheet" href="<?php echo URL ?>css/style.css">

    <!-- Tile Display -->
    <script type="text/javascript" src="<?php echo URL ?>js/tiledisplay/freewall.js"></script>

    <!-- Error Message -->
    <link rel="stylesheet" href="<?php echo URL ?>css/errormessage.css">

    <!-- page handler-->
    <script type="text/javascript" src="<?php echo URL ?>js/ajax-page-call.js"></script>

    <link rel="shortcut icon" type="image/ico" href="<?php echo URL ?>favicon.ico">

    <!--    <script type="text/javascript" src="--><?php //echo URL ?><!--js/bootstrap.min.js"></script>-->

    <link href="<?php echo URL ?>css/custominput/component.css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo URL ?>js/custominput/custom-file-input.js"></script>
    <script type="text/javascript" src="<?php echo URL ?>js/custominput/jquery.custom-file-input.js"></script>

    <!-- Tag -->
    <script src="<?php echo URL ?>js/tag-it/jquery.caret.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo URL ?>js/tag-it/jquery.tag-editor.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?php echo URL ?>css/tag-it/jquery.tag-editor.css" rel="stylesheet" type="text/css">

    <!-- MAC 에서 봤을 떄 터치 바 미리보기 아이콘-->
    <link rel="mask-icon" href="<?php echo URL ?>mac_favicon.png" color="#000000">

    <!-- 모바일 화면에서 상단 주소창 색상 설정 -->
    <meta name="theme-color" content="#252525"/>

    <!-- multi track recording / microphone-->
    <script src="<?php echo URL ?>js/multi-recording/recordmp3.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo URL ?>js/multi-recording/libmp3lame.min.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?php echo URL ?>js/waveform/wavesurfer.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?php echo URL ?>css/loadingSpinner.css" rel="stylesheet">


    <!-- 홈페이지 주소 썸네일 -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="온라인 창작 놀이터 - wintle">
    <meta property="og:url" content="https://www.wintle.co.kr">
    <meta property="og:description" content="일상속에서 떠오르는 영감을 이용하여 자신만의 음악을 만들 수 있다면 ?">
    <meta property="og:image" content="https://www.wintle.co.kr/favicon.ico">

    <!-- 마이크 사용 시 나타나는 음파 사운드비주얼라이져 -->
    <script src="<?php echo URL ?>js/soundvisualizer/soundvisualizer.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo URL ?>/css/soundvisualizer/style.css">
    <script src="<?php echo URL ?>js/soundvisualizer/d3.js"></script>
    <script src="<?php echo URL ?>js/soundvisualizer/d3.hexbin.v0.min.js?5c6e4f0"></script>
    <script src="<?php echo URL ?>js/soundvisualizer/mousetrap.js"></script>
    <script src="<?php echo URL ?>js/soundvisualizer/id3-minimized.js"></script>

    <!-- 랜딩 페이지 -->
    <script type="text/javascript" src="<?php echo URL?>js/fullpage/scrolloverflow.js"></script>
    <script type="text/javascript" src="<?php echo URL?>js/fullpage/jquery.fullPage.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo URL?>css/fullpage/jquery.fullPage.css" />

    <!-- language setting -->
    <script src="<?php echo URL ?>public/js/lang/lang.js" type="text/javascript"></script>

    <!-- js zip -->
    <script src="<?php echo URL?>js/jszip/jszip.js"></script>
    <script src="<?php echo URL?>js/jszip/FileSaver.js"></script>

    <script>

        function signOut() {
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.signOut().then(function () {
                console.log('User signed out.');
            });
        }

        function onLoad() {
            gapi.load('auth2', function () {
                gapi.auth2.init();
            });
        }

        $(function () {

            //컨텐츠 최초 업로드 팝업 출력 시 제목으로 커서 자동 이동
            $('#writeContentModal').on('shown.bs.modal', function () {
                $("#content_title").focus();
            });



            $('#search').tagEditor({
                delimiter: ', ', /* space and comma */
                placeholder: 'Search',
                onEnter: function (tags) {
                    if (tags[0] != null) {
                        var data = tags[0];
                        for (var i = 1; i < tags.length; i++) {
                            data = data + "+" + tags[i];
                        }
                    }
                    $.pagehandler.loadContent("<?php echo URL?>search/blocks?tags=" + data, 'all');
                }
            });


            //upload ajax
            $("#upload-content-form").submit(function (event) {
                <?php
                if(!Session::isSessionSet('user_id')){?>
                errorDisplay("Please log in for uploading content");
                return false;
                <?php }?>




                var formData = new FormData($(this)[0]);

//                var fp = document.getElementById('preview-microphone');
                var audioBlob = document.getElementById('audioBlob');
                if (typeof audioBlob.src !== "undefined") {
                    formData.append("microphone_blob", audioBlob.src,"blob");
                }

                $.ajax({
                    url: "<?php echo URL ?>upload/uploadcontent",
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        var value = jQuery.parseJSON(data);
                        if (value.success == true) {
                            errorDisplay("업로드 완료");
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


                //콘텐츠 업로드 팝업 초기화
                $('#upload-content-form')[0].reset();
                $("#previewdiv").css("display", "none");
                $("#preview-audio").css("display", "none");
                $("#preview-microphone").css("display", "none");
                $('#file-5-audio').val("");
                $('#file-5-image').val("");
                return false;
            });


        });

        //image preview
        function readImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview-image').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        var ac = new window.AudioContext;
        // 각 웨이브폼을 실행 시키기 위한 변수 선언
        var wavesurfer_list = [];
        function createWaveform(url, elementid) {
            //element가 존재 하지 않으면 웨이브폼 생성 취소
            if (document.getElementById(elementid.substring(1, elementid.length)) == null) return;
            var wavesurfer = WaveSurfer.create({
//                waveColor: 'slategray',
                progressColor: '#EE3B24',
                waveColor: '#666',
                barWidth: 5,
                height: 200,
                interact: false,
                container: elementid,
                backend: 'MediaElement',
                audioContext: ac
            });
            //element가 존재 하지 않으면 웨이브폼 생성 취소
            if (wavesurfer.container !== null) {
                wavesurfer.load(url);
                wavesurfer.emptyAudioArray();
            }

            //웨이브폼 클릭 시 해당 웨이브폼을 실행하기 위해 key, value 형식으로 웨이브폼 정보 저장
            var obj = {
                wavesurfer: wavesurfer,
                elementid: elementid
            };
            wavesurfer_list.push(obj);
        }

        //audio preview
        function readAudio(input) {
            var pvAudio = document.getElementById('preview-audio');
            var pvMP = document.getElementById('preview-microphone');
            pvAudio.innerHTML = "";
            pvMP.innerHTML = "";

            pvAudio.src = URL.createObjectURL(input.files[0]);
            createWaveform(pvAudio.src, '#preview-audio');
        }

        //resize for textarea
        function resize(obj) {
            obj.style.height = "112px";
            obj.style.height = (12 + obj.scrollHeight) + "px";
        }

        var audio_context;
        var recorder;

        function startUserMedia(stream) {
            var input = audio_context.createMediaStreamSource(stream);
            recorder = new Recorder(input, {
                numChannels: 1
            }, "content");

            //on successfully get instance for recording
            $("#microphone-label-stop").css("display", "inline-block");
            $("#microphone-label-start").css("display", "none");
            recorder && recorder.record();
        }

        function failToGetUserMedia() {
            errorDisplay("Please allow to use microphone in order to record");
        }

        function startRecording() {
            init();
        }

        function stopRecording() {
            $("#microphone-label-stop").css("display", "none");
            $("#microphone-label-start").css("display", "inline-block");

            recorder && recorder.stop();

            var myEvent = new CustomEvent("onMicrophoneAudioUpload");
            $("#preview-microphone")[0].dispatchEvent(myEvent);

            $('.cssload-overlay').css("visibility", "visible");
            // create WAV download link using audio data blob
            createDownloadLink();
            recorder.clear();

        }

        function createDownloadLink() {
            //record call back
            recorder && recorder.exportWAV(function (blob, url) {
                //call back으로 받은 blob을 zip 파일로 생성
                var zip = new JSZip();
                zip.file("HiThere.wav", blob, {base64: true});
                zip.generateAsync({type:"blob",
                    compression: "DEFLATE"
                }).then(function(content) {
                    var tmp = document.getElementById('audioBlob');
                    tmp.src = content;
                });
                //웨이브폼을 생성해야 하므로 base64 형식에 url 도 함께 가져옴
                var au = document.getElementById('preview-microphone');
                au.controls = true;
                au.src = url;
                au.innerHTML = "";
                createWaveform(au.src, "#preview-microphone");
                $('.cssload-overlay').css("visibility", "hidden");

            });
        }

        function init() {
            window.AudioContext = window.AudioContext || window.webkitAudioContext;
            navigator.getUserMedia = ( navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia);
            window.URL = window.URL || window.webkitURL;
            audio_context = new AudioContext;
            //get user media, if it's found startUserMedia executes otherwise, function () executes
            navigator.getUserMedia({audio: true}, startUserMedia, failToGetUserMedia);
        }
    </script>
    <!--    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>-->

</head>

<header style="z-index:999; box-shadow:0 3px 10px rgba(0,0,0,0.3)" >
    <div id="header-gnb">
        <div class="row" style="height:100%;">
            <div class="HeaderImg1 col-lg-1 col-md-1 col-sm-2 col-xs-2">
                <div style="height:32px; width:32px;margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;">
                    <img src="<?php echo URL ?>img/pavicon/wintle_logo-white.svg"
                         style="height:32px;"
                         onclick="$.pagehandler.loadContent('<?php echo URL ?>index','all');">
                </div>
            </div>
            <div class="MemberShipInput col-lg-9 col-md-8 col-sm-7 col-xs-7">
                <form>
                    <textarea id="search" style="display:none"></textarea>
                </form>
            </div>
            <?php if (Session::isSessionSet("loggedIn") == false) { ?>
                <div class="MemberShipBtn1 col-lg-2 col-md-3 col-sm-3 col-xs-3 pull-right" style="top:14px; right:0;">
                    <!-- MemberShipBtn[n] {0 : 입장 전, 1 : 입장 후 (로그인 X)} -->
                  <div class="login-box" onclick='setLogInForm()' data-toggle='modal' data-target='#signModal'> <span id="top_login" style="font-size:14px; color:white;" data-langNum="1001">Log in</span> </div>
                    <div class="signup-box" onclick="setSignUpForm()"  data-toggle='modal' data-target='#signModal'><span id="top_signup" class='sign-up-text' style="font-size:14px; color:white;" data-langNum="1002">Sign up</span></div>
                    <div class="signup-box joing-us" style="display:none;" data-toggle='modal' data-target='#signModal'><span id="top_signup" class='sign-up-text' style="font-size:14px; color:white;">Join Us</span></div>
                    <!--<a style="right:10px">user name</a>-->
                </div>
            <?php } else{ ?>

                <script>
                    $.get("<?php echo URL?>common/getProfilePhoto/profile/<?php echo Session::get('user_id')?>", function (o) {
                        if (o != null) {
                            var value = jQuery.parseJSON(o);
                            var photo = $("#profile-mini");
                            if (value.profile_photo_path != null) {
                                //display default image
                                // photo.append("<img src = '"+value.profile_photo_path+"' style='width: 187px; height: 187px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'>");
                                photo.css("background-image", 'url(<?php echo URL?>' + value.profile_photo_path + ')');
                            }
                        }

                    });

                </script>

                <!--            <div class="MemberShipBtn3 col-lg-1" style="top:20px; right:5px;">-->
                <!--                <img src="--><?php //echo URL ?><!--img/pavicon/envelope.svg" style="width:20px;"-->
                <!--                     onclick="$.pagehandler.loadContent('--><?php //echo URL . "message" ?><!--','all');">-->
                <!--                <img src="--><?php //echo URL ?><!--img/pavicon/upload.svg" style="width:20px;" data-toggle='modal'-->
                <!--                     data-target='#writeContentModal'>-->


                <!--            </div>-->
                <!---->
                <!--            <div class="MemberShipBtn2 col-lg-2" style="top:16px; right:30px;"-->
                <!--                 onclick="$.pagehandler.loadContent('--><?php //echo URL . Session::get('my_profile'); ?><!--','all');">-->
                <!--                <div style="float:right; height:100%;">-->
                <!--                    <a href="#">-->
                <!--                        <div id="profile-mini"-->
                <!--                             style="background-image: url('--><?php //echo URL ?><!--img/defaultprofile.png');"></div>-->
                <!--                    </a>-->
                <!--                    <div id="profile-username" style="display:inline-block; position:relative; bottom:7px; margin:8px;">-->
                <!--                        --><?php
            //                        if (strlen(Session::get("user_name")) >= 10) {
            //                            echo substr(Session::get("user_name"), 0, 10) . "...";
            //                        } else {
            //                            echo Session::get("user_name");
            //                        }
            //
            //                        ?>
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->


                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3 pull-right" style="top:15px;">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-5 noti-button" style="top:5px;">
                            <div class="MemberShipBtn3">
                                <a href="<?php echo URL ?>logout/calllogout"><img
                                            src="<?php echo URL ?>img/pavicon/logout.svg"
                                            style="width:18px;"
                                            onclick="signOut()"></a>
                            </div>
                        </div>

                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-5 userinfo-box">
                            <div class="MemberShipBtn2" style="top:10px;"
                                 onclick="$.pagehandler.loadContent('<?php echo URL . Session::get('my_profile'); ?>','all'); ">
                                <div style="float:right; height:100%;">

                                    <div id="profile-mini"
                                         style="background-image: url('<?php echo URL ?>img/defaultprofile.png');"></div>

                                    <div id="profile-username" class="profile-username"
                                         style="display:inline-block; position:relative; bottom:7px; margin:8px;">
                                        <?php
                                        if (strlen(Session::get("user_name")) >= 10) {
                                            echo substr(Session::get("user_name"), 0, 10) . "...";
                                        } else {
                                            echo Session::get("user_name");
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            <?php } ?>
        </div>
    </div>


    <script>

    </script>


</header>