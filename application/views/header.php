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
    <!------------jquery import ----------->
    <script src="<?php echo URL ?>js/jquery/jquery-3.1.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo URL ?>js/jquery/jquery.form.js" type="text/javascript"></script>
    <!-- draggable import -->
    <script src="<?php echo URL ?>js/jquery/jquery-ui.js" type="text/javascript"></script>

    <!-- Google Analytics -->
    <script src="<?php echo URL ?>public/js/analyticstracking.js" type="text/javascript"></script>

    <script src='https://www.google.com/recaptcha/api.js'></script> <!-- google ReCAPTCHA include -->
    <script src="https://apis.google.com/js/platform.js" async defer></script> <!-- google social login-->
    <meta name="google-signin-client_id"
          content="611141018688-vjcv2sqjcf133cgi453ogfi3lnj4c1bk.apps.googleusercontent.com">

    <!-- -------------------------------------------------------------------------
                            css reset, Java script, JS PlugIn

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
    <link href="<?php echo URL ?>css/custominput/normalize.css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo URL ?>js/custominput/custom-file-input.js"></script>
    <script type="text/javascript" src="<?php echo URL ?>js/custominput/jquery.custom-file-input.js"></script>

    <!-- css custom -->
    <link media="screen" href="<?php echo URL ?>css/style/pc.css" rel="stylesheet"/>

    <!-- Tag -->
    <script src="<?php echo URL ?>js/tag-it/jquery.caret.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo URL ?>js/tag-it/jquery.tag-editor.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?php echo URL ?>css/tag-it/jquery.tag-editor.css" rel="stylesheet" type="text/css">

    <link rel="mask-icon" href="<?php echo URL ?>mac_favicon.png" color="#000000">

    <script>
        function onSignIn(googleUser) {

            var id_token = googleUser.getAuthResponse().id_token;

            <?php
            if(Session::get('social_loggedIn') == true){
        }else{ ?>
            $.get("<?php echo URL?>social/google_login/" + id_token, function (o) {
                var value = jQuery.parseJSON(o);
                if (value.success == true) {
                    window.location.replace("http://wintle.co.kr");
                } else {
                    errorDisplay(value.error);
                }
            });
            <?php   } ?>

        }

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

//                    $.get("<?php echo URL?>search/blocks?tags="+data,function(o) {
//
//                    });


//                        if(o.success == true){
//                            window.location.replace("index");
//                        }else{
//                            errorDisplay(o.error);
//                        }

                }
            });


            //upload ajax
            $("#upload-content-form").submit(function(event){
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: "<?php echo URL ?>upload/uploadcontent",
                    type: 'POST',
                    data: formData,
                    async: false,
                    success: function (data) {
                        var value = jQuery.parseJSON(data);
                        if(value.success == true){
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

            //on image selected
            $("#file-5-image").change(function(){
                $("#preview-audio").css("display","none");
                $("#preview-div").css("display","block");
                $('#file-5-audio').val("");
                if(sound != null) sound.pause();
                readImage(this);
                $("#preview-image").css("display","block");
            });

            //on audio selected
            $("#file-5-audio").change(function(){
                $("#preview-div").css("display","block");
                $("#preview-image").css("display","none");
                $('#file-5-image').val("");
                $("#preview-audio").css("display","block")
                readAudio(this);
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

        //audio preview
        var sound = null;
        function readAudio(input){
            sound = document.getElementById('preview-audio');
            sound.src = URL.createObjectURL(input.files[0]);
            console.log(input);
            // not really needed in this exact case, but since it is really important in other cases,
            // don't forget to revoke the blobURI when you don't need it
            sound.onend = function(e) {
                URL.revokeObjectURL(input.src);
            };
        }

        //resize for textarea
        function resize(obj) {
            obj.style.height = "112px";
            obj.style.height = (12 + obj.scrollHeight) + "px";
        }

    </script>
    <!--    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>-->

</head>

<header style="z-index:1100;">
    <!--    <div class="info-content">-->
    <!--        <iframe src="http://wintlecorp.com" style="bottom:50px;"></iframe>-->
    <!--    </div>-->
    <div id="header-gnb">
        <div class="HeaderImg1">  <!-- HeaderImg[i] {0 : 홈 버튼, 1 : 로고, 2 : 메뉴 버튼} -->
            <img src="<?php echo URL ?>img/pavicon/wintle_logo-white.svg"
                 style="position:relative; height:32px; top:0;"
                 onclick="$.pagehandler.loadContent('<?php echo URL ?>index','all');">
        </div>

        <!--<div class="MemberShipBtn0">
            <p id="menu page-a" onclick="$.pagehandler.loadContent('<?php /*echo URL."index"*/ ?>','all');">Page A</p>
            <p id="menu page-b" onclick="$.pagehandler.loadContent('<?php /*echo URL."albumartall"*/ ?>','all');">Page B</p>
        </div>-->
        <!--        <div class="MemberShipBtn0" style="top:0; right:110px;">-->
        <!-- <a href="#"  onclick="$.pagehandler.loadContent('<?php //echo URL?>newchart','all')">Album</a>-->
        <!--  <a href="#" onclick="$.pagehandler.loadContent('<?php //echo URL?>index','all')">Hub</a>-->
        <!--        </div>-->
        <div class="MemberShipInput">
            <form>
                <textarea id="search" style="display:none"></textarea>
            </form>
        </div>
        <?php if (Session::isSessionSet("loggedIn") == false) { ?>
            <div class="MemberShipBtn1" style="top:18px; right:0;">
                <!-- MemberShipBtn[n] {0 : 입장 전, 1 : 입장 후 (로그인 X)} -->
                <a href="#popup1" id="top_login" style="margin-right:19px; font-size:15px;">Log in</a>
                <a href="#popup1" id="top_signup" style="font-size:15px;">Sign up</a>
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

            <div class="MemberShipBtn3" style="top:20px; right:5px;">
                <img src="<?php echo URL ?>img/pavicon/envelope.svg" style="width:20px;"
                     onclick="$.pagehandler.loadContent('<?php echo URL . "message" ?>','all');">
                <img src="<?php echo URL ?>img/pavicon/upload.svg" style="width:20px;" data-toggle='modal'
                     data-target='#writeContentModal'>
                <a href="<?php echo URL ?>logout/calllogout"><img src="<?php echo URL ?>img/pavicon/logout.svg"
                                                                  style="width:18px;"
                                                                  onclick="signOut()"></a>
            </div>

            <div class="MemberShipBtn2" style="top:16px; right:30px;"
                 onclick="$.pagehandler.loadContent('<?php echo URL . Session::get('my_profile'); ?>','all');">
                <div style="float:right; height:100%;">
                    <a href="#">
                        <div id="profile-mini"
                             style="background-image: url('<?php echo URL ?>img/defaultprofile.png');"></div>
                    </a>
                    <div id="profile-username" style="display:inline-block; position:relative; bottom:7px; margin:8px;">
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

        <?php } ?>
    </div>


    <div class="modal" id="writeContentModal" role="dialog">
        <div class="modal_close" data-dismiss="modal"><a href="#">&times;</a></div><!--modal-dialog-->
        <div class="modal-dialog">
            <!--<div class="adddataBox">&lt;!&ndash;점선박스&ndash;&gt;</div>-->
            <!--<div class="adddata_write">-->
            <!--<div class="adddata_write_img"><img src="../image/write.png"></div>-->
            <form id="upload-content-form" action="" method="post" enctype="multipart/form-data">
                    <div class="adddata_write_input">
                        <ul>
                            <li>
                                <input type="text" class="form-control" name="content_title"
                                       placeholder="Please enter title" autocomplete="off">
                                <div style="width:100%; height:auto; display:none;" id="preview-div">
                                    <img id="preview-image" src="#"  style="height:100%;width:100%;"/>
                                    <audio id="preview-audio" style="width:100%;" controls></audio>
                                </div>
                                <textarea id="textcontent" rows="5" onkeydown="resize(this)" onkeyup="resize(this)"
                                          class="form-control" placeholder="show us your inspiration"
                                          style="resize:none;" name="content_comments" autocomplete="off"></textarea>
                                <input type="text" class="form-control" name="hashtags" id="hashtags[]"
                                       placeholder="Please enter title" autocomplete="off">

                                <input type="file" name="content_path_audio" id="file-5-audio" class="inputfile inputfile-4 f_bred"
                                       accept="audio/mpeg3,audio/x-wav" style="display:none;"/>
                                <label for="file-5-audio" >
                                    <img src="<?php echo URL ?>img/musical-note.svg" style="width:20px; height:20px;">
                                </label>

                                <input type="file" name="content_path_image" id="file-5-image" class="inputfile inputfile-4 f_bred"
                                       accept="image/x-png,image/gif,image/jpeg" style="display:none;" />
                                <label for="file-5-image">
                                    <img src="<?php echo URL ?>img/frame-landscape.svg" style="width:20px; height:20px;">
                                </label>

                                <input type="submit" id="upload-content" class="btn f_right f_bred" value="Upload" style="margin-top:20px;">
                            </li>
                    </div>
            </form>
            <!--</div>-->
        </div><!--modal-dialog-->
    </div><!--modal-->

</header>
