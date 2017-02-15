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
    <script src="<?php echo URL ?>public/js/jquery/jquery-3.1.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo URL ?>public/js/jquery/jquery.form.js" type="text/javascript"></script>
    <!-- draggable import -->
    <script src="<?php echo URL ?>public/js/jquery/jquery-ui.js" type="text/javascript"></script>

    <!-- Google Analytics -->
    <script src="<?php echo URL ?>public/js/analyticstracking.js" type="text/javascript"></script>

    <!--    <script src='https://www.google.com/recaptcha/api.js'></script> <!-- google ReCAPTCHA include-->
    <script src="https://apis.google.com/js/platform.js" async defer></script> <!-- google social login-->
    <meta name="google-signin-client_id"
          content="611141018688-vjcv2sqjcf133cgi453ogfi3lnj4c1bk.apps.googleusercontent.com">

    <!-- -------------------------------------------------------------------------
                            css reset, Java script, JS PlugIn

    <!-- css Plug In -->
    <link href="<?php echo URL ?>css/css_reset.css" rel="stylesheet"/>

    <!--추후 화면 확장성 위해 사용하는 프레임웍-->
    <link href="<?php echo URL ?>css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <!--공통사용하는 기본속성-->
    <link href="<?php echo URL ?>css/base.css" rel="stylesheet" type="text/css"/>


    <!--메인및작성되 화면 관리-->
    <link href="<?php echo URL ?>css/wintle.css" rel="stylesheet" type="text/css"/>

    <!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

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



    <script type="text/javascript" src="<?php echo URL ?>js/bootstrap.js"></script>

<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

    <!--    <script type="text/javascript" src="--><?php //echo URL?><!--/js/bootstrap.min.js"></script>-->
    <!--<script type="text/javascript" src="./common/js/jquery.min.js"></script>
    -->


    <!-- css custom -->
    <link media="screen" href="<?php echo URL ?>css/style/pc.css" rel="stylesheet"/>

    <!-- Tag -->
    <script src="<?php echo URL ?>js/tag-it/jquery.caret.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo URL ?>js/tag-it/jquery.tag-editor.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?php echo URL ?>css/tag-it/jquery.tag-editor.css" rel="stylesheet" type="text/css">

    <link rel="mask-icon" href="<?php echo URL?>mac_favicon.png" color="#000000">

    <script>
        function onSignIn(googleUser) {

            var id_token = googleUser.getAuthResponse().id_token;

            <?php
            if(Session::get('social_loggedIn') == true){
        }else{ ?>
            $.get("<?php echo URL?>social/google_login/" + id_token, function (o) {
                var value = jQuery.parseJSON(o);
                console.log(value.success);
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

        });
//        $(window).scroll(function() {
//            console.log($(window).scrollTop());
//
//
//
//        });
    </script>
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

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
                    if(o != null){
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
                <img src="<?php echo URL?>img/pavicon/envelope.svg" style="width:20px;"
                     onclick="$.pagehandler.loadContent('<?php echo URL . "message" ?>','all');">
                <img src="<?php echo URL?>img/pavicon/upload.svg" style="width:20px;"
                     onclick="$.pagehandler.loadContent('<?php echo URL . "upload" ?>','all');">
                <a href="<?php echo URL ?>logout/calllogout"><img src="<?php echo URL?>img/pavicon/logout.svg" style="width:18px;"
                                                                  onclick="signOut()"></a>
            </div>

            <div class="MemberShipBtn2" style="top:16px; right:30px;" onclick="$.pagehandler.loadContent('<?php echo URL . Session::get('my_profile'); ?>','all');">
                <div style="float:right; height:100%;">
                    <a href="#">
                        <div id="profile-mini" style="background-image: url('<?php echo URL ?>img/defaultprofile.png');"></div>
                    </a>
                    <script>
                        console.log("<?php echo Session::get('my_profile');echo " "; echo Session::get('profile_id')?>");

                    </script>
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
</header>
