﻿<?php

$top_fst_text = "Log In";
$top_snd_text = "Sign Up";
$top_fst_link = "#popup1";
$top_snd_link = "#popup1";


if(Session::isSessionSet("loggedIn")){
    $top_fst_text = "";
    $top_snd_text = "Log Out";
    $top_fst_link = "";
    $top_snd_link = "logout/callLogOut";
}

?>

    <!DOCTYPE html>
    <html>
    <head>


        <!------------jquery import ----------->
        <script src="<?php echo URL?>public/js/jquery/jquery-3.1.0.js" type="text/javascript" charset="utf-8"></script>


        <!-- draggable import -->
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

        <script src='https://www.google.com/recaptcha/api.js'></script> <!-- google ReCAPTCHA include-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <!-- -------------------------------------------------------------------------
                                css reset, Java script, JS PlugIn

        <!-- css Plug In -->
        <link href="css/css_reset.css" rel="stylesheet" />

        <!-- css custom -->
        <link media="screen" href="css/style/pc.css" rel="stylesheet" />

        <!-- Javascript custom -->
        <script src="js/jq-jh.js"></script>

        <!-- Form process -->
        <script src="js/login-signup/form.js"></script>

        <link rel="stylesheet" href="css/style.css">

        <!-- Tile Display -->
        <script type="text/javascript" src="js/tiledisplay/freewall.js"></script>


        <!-- Tag it -->
        <link href="css/jquery.tagit.css" rel="stylesheet" type="text/css">
        <link href="css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
        <script src="js/tag-it/tag-it.js" type="text/javascript" charset="utf-8"></script>

        <style>
            /* background video
             * --------------------------------------- */
            #video {
                position: fixed;
                top: 0px;
                left: 0px;
                min-width: 100%;
                min-height: 100%;
                width: auto;
                height: auto;
                z-index: -1;
                overflow: hidden;
            }

            /* Section 1
             * --------------------------------------- */
            .intro {
                position: absolute;
                margin: auto;
                padding-bottom: 50px;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                width: 25%;
                height: auto;
                z-index: -1;
            }

            .paper_cap {
                position: absolute;
                bottom: 0;
                float: left;
                width: 100%;
            }

            #section0 {
                background: none;
            }

            #section0 h1 {
                color: #444;
            }

            #section0 p {
                color: #333;
                opacity: 0.4;
            }

            /* Section 2
             * --------------------------------------- */
            #section1 {
                background-color: rgb(255, 255, 255);
            }

            #section1 h1 {
                color: #fff;
            }

            #section1 p {
                opacity: 0.8;
            }

            /* Section 3
             * --------------------------------------- */
            #section2 {
                background-color: #2C3E50;
            }

            #section2 h1 {
                color: #F2F2F2;
            }

            #section2 p {
                opacity: 0.6;
            }

            .login-signup-text{
                display:block;
                margin-left: auto;
                margin-right: auto;
                margin-top:30px;
                text-align: center;
            }
            .login-signup-text span{
                font-size: 17px;
                cursor:pointer;
            }

            .login-signup-text #login-text{
                margin-right:40px;
            }

            .login-signup-text #signup-text{
                margin-left:40px;
            }

            .login-signup-block {
                margin: auto;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background-color: rgba(0,0,0,0);
                height: 40px;
                width: 400px;
                position: relative;
                transition: all 5s ease-in-out;
                padding-bottom: 0;
            }

            .arrow-up-left{
                margin-top:10px;
                position:absolute;
                width: 0;
                height: 0;
                border-left: 16px solid transparent;
                border-right: 16px solid transparent;
                border-bottom: 15px solid white;
                transition:0.2s;
                -webkit-transition:0.2s;
                -moz-transition:0.2s;
                right:calc(100% - 143px);
            }

            .SignUp{
                vertical-align: top;
                display: inline-block;
                width:400px;
            }

        </style>

    </head>
    <header style="z-index:100;">
        <div class="info-content">
           <!--<iframe src="http://pollo112.wixsite.com/wintle-landingpage"></iframe>-->
            <div class="introbtn">시작하기</div>
        </div>
        <!--<video id="video" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0">
            <source src="background/file.webm">
        </video>-->

        <!--<div id="fullpage">
            <div class="section " id="section0">
                <div class="content">
                    <div class="contaner">
                        <img class="intro" src="img/PAGE/main_logo.png"/>
                    </div>
                </div>
                <img class="paper_cap" src="img/PAGE/Cloud_paper_top.png" alt=""/>
            </div>
            <div class="section " id="section1"></div>

            <div class="section " id="section2"></div>

        </div>-->

       <!-- <div class="info-content">
            <div class="introbtn">뮤지션에 도전하기</div>
        </div>
-->
        <div id="header-gnb">
            <div class="HeaderImg1">  <!-- HeaderImg[i] {0 : 홈 버튼, 1 : 로고, 2 : 메뉴 버튼} -->
                <img src="img/pavicon/logo_white_scaled.png" style="height:37px"  onclick="$.pagehandler.loadContent('index','all');">
            </div>
            <div class="MemberShipBtn1" style="top:10px">  <!-- MemberShipBtn[n] {0 : 입장 전, 1 : 입장 후 (로그인 X)} -->
                <a href="<?php echo $top_fst_link?>" id="top_login"><?php echo $top_fst_text?></a>
                <a href="<?php echo $top_snd_link?>" id="top_login"><?php echo $top_snd_text?></a>
            </div>
            <div style="position:absolute; right:25px; height:37px;">
                <a href="webstudio"><img src="img/beta.png" style="height:37px"></a>
            </div>
        </div>
    </header>

    <div id="popup1" class="overlay">
        <a class="close" href="#">×</a>
        <div class="header">
            <a href="index.php"><img src="img/pavicon/logo_explain.png"></a>
        </div>
        <div class="login-signup-block" id="login-signup-block">
            <div class="login-signup-text">
                <span id="login-text">Log In</span>
                <span id="signup-text">Sign Up</span>
            </div>
            <div class="arrow-up-left"></div>
        </div>

        <!-- Sign up/Log in form -->
        <form id="login-signup-form" action ="" method="post">
            <div class="popup" id="popup">
                    <span class="SignUp">
                        <img style="margin-left:28px; margin-top:18px; height:47px;" src="img/social_login.png"/>
                        <div class="divider">
                            <hr class="left"/>OR<hr class="right" />
                        </div>
                        <span name="wrong" id="name_wrong" style="display: none"
                              onclick="document.getElementById('name').value =''"><img
                                src="img/x.png"></span><input type="text" name="name" id="name" required
                                                              placeholder="Your username" autocomplete="off">
                                                    <span name="wrong" id="email_wrong" style="display: none"
                                                          onclick="document.getElementById('user_email').value =''"><img
                                                            src="img/x.png"></span><input type="text" name="user_email" id="user_email" required
                                                                                          placeholder="Your email address" autocomplete="off">
                                                    <span name="wrong" id="password_wrong"
                                                          style="display: none"
                                                          onclick="document.getElementById('password').value =''"><img
                                                            src="img/x.png"></span><input type="password" name="password" id="password" required
                                                                                          placeholder="Enter a password" autocomplete="off">
                        <p class="SignUpText">Use at least one letter<br> one numeral, and seven characters.</p>

                        <div id="g-recaptcha" class="g-recaptcha" data-sitekey="6LcZwyATAAAAACFru_oAaZX_UCjGySRbcPFiN9Ye"></div>

                        <input id="submit" type="submit" name="submit" value="LOG IN" style="margin-bottom: 30px" onclick="return check()">
                    </span>
            </div>
        </form>
    </div>

<!--
    <script type="text/javascript" src="js/mainpage/javascript.fullPage.js"></script>
    <script type="text/javascript">
        fullpage.initialize('#fullpage', {
            anchors: ['firstPage', 'secondPage', '3rdPage', '4thpage', 'lastPage'],
            menu: '#menu',
            css3: true
        });
    </script>-->

