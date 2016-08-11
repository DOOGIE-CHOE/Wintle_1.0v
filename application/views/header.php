<?php

if(!isset($_SESSION))
{
    session_start();
}

$top_fst_text = "Log In";
$top_snd_text = "Sign Up";
$top_fst_link = "#popup1";
$top_snd_link = "#popup1";

if(isset($_SESSION['valid_user'])){
    $top_fst_text = $_SESSION['valid_user'];
    $top_snd_text = "Sign Out";
    $top_fst_link = "mypage.php";
    $top_snd_link = "signout.php";
}
?>

    <!DOCTYPE html>
    <html>
    <head>
        <!------------jquery import ----------->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>



        <script src='https://www.google.com/recaptcha/api.js'></script> <!-- google ReCAPTCHA include-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <link rel="stylesheet" href="style/style.css">

        <!-- -------------------------------------------------------------------------
                                css reset, Java script, JS PlugIn
        <!-- JQ Plug In -->
        <script src="js/multiSelectorDraggable.js"></script>

        <!-- css Plug In -->
        <link href="css/css_reset.css" rel="stylesheet" />

        <!-- css custom -->
        <link media="screen" href="css/style/pc.css" rel="stylesheet" />
        <link media="handheld" href="css/style/mobile.css" rel="stylesheet" />

        <!-- Javascript custom -->
        <script src="js/jq-jh.js"></script>

        <link rel="stylesheet" href="css/pagetransition.css">

        <link rel="stylesheet" href="css/pagetransition.css" />

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

            .signup-parent{
                position:absolute;
                /*width: 885px;
*/              width: 950px;
            }

        </style>

        <script>
            /*
             $("#popup1").click(function(){
             alert("ASd");

             });
             */

            // Add your javascript here





            $(function(){
                setLogInForm();

                $("#login-text, #top_login").click(function (e){
                    setLogInForm()
                });

                $("#signup-text, #top_signup").click(function (e){
                    $(".arrow-up-left").css("right","117px");
                    $("#popup").css("height","550px");
                    $("#username").show("fast");
                    $("#g-recaptcha").show("fast");
                    $(".SignUpText").show("fast");
                });

                $("#popup1").click(function (e)
                {
                    var container = $("#popup");
                    var block = $("#login-signup-block");

                    if ((!container.is(e.target) && container.has(e.target).length === 0) && (!block.is(e.target) && block.has(e.target).length === 0) )
                    {
                        window.location.href="#";
                    }
                });

                function setLogInForm(){
                    $(".arrow-up-left").css("right","calc(100% - 143px)");
                    $("#popup").css("height","325px");
                    $("#username").hide("fast");
                    $("#g-recaptcha").hide("fast");
                    $(".SignUpText").hide("fast");
                }

            });

        </script>

    </head>
    <body>
    <header>
        <video id="video" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0">
            <source src="background/file.webm">
        </video>
        <div id="fullpage">
            <div class="section " id="section0">
                <div class="content">
                    <div class="contaner">
                        <img class="intro" src="img/PAGE/main_logo.png"/>
                    </div>
                </div>
                <img class="paper_cap" src="img/PAGE/Cloud_paper_top.png" alt=""/>
            </div>
        </div>

        <div class="info-content">
            <div class="introbtn">뮤지션에 도전하기</div>
        </div>

        <div id="header-gnb">
            <div class="HeaderImg1">  <!-- HeaderImg[i] {0 : 홈 버튼, 1 : 로고, 2 : 메뉴 버튼} -->
                <a href="http://www.wintle.co.kr"><img src="img/pavicon/logo_white_scaled.png" style="height:50px"></a>
            </div>
            <div class="MemberShipBtn1">  <!-- MemberShipBtn[n] {0 : 입장 전, 1 : 입장 후 (로그인 X)} -->
                <a href="<?php echo $top_fst_link?>" id="top_login"><?php echo $top_fst_text?></a>
                <a href="<?php echo $top_snd_link?>" id="top_signup">&nbsp;&nbsp;<?php echo $top_snd_text?></a>
            </div>
        </div>
    </header>



    <!--  ************************************
               이용 전 까지 숨김 영역
           ( 숨김 방법: Ajax || hidden ) 
        ************************************* -->

    <!-- 네비게이션 -->
    <div class="hidden">
        <nav class="MoveContentMusic">
            <!-- background Left -->
        </nav>
        <nav class="MoveContentStudio">
            <!-- 클릭 시 class="SouceLnb" 로 변경 -->
            <div class="StudioLnb">
                <div>All</div>
                <div>Story</div>
                <div>Melody</div>
                <div>Player</div>
                <div>Art</div>
            </div>
        </nav>

        <!-- 컨텐츠 영역 -->
        <content>
            <div class="container">
                <article class="MyPage">
                    eijfla
                </article>
                <div id="music_content_box">
                    sdfdsf
                </div>
                <article class="MixPage">
                    sdfdsf
                </article>
            </div>
        </content>

        <!-- playbar -->

        <div class="PlayBar">
            <div class="container">
                <div class="controler">
                    <div>1.이전곡</div>
                    <div>2.재생버튼</div>
                    <div>3.다음곡</div>
                </div>
                <div class="albumart">앨범아트</div>
                <div class="musicinfo">
                    <div class="genre">jazz</div>
                    <div class="songname">amazing grace</div>
                    <div>
                        <div class="playtime">
                            --:--
                        </div>
                        <div class="pointer"></div>
                        <div class="playFuture"></div>
                        <div class="playPast"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        <form action="" method="post">
            <div class="popup" id="popup">
                    <span class="SignUp">
                        <img style="margin-left:28px; margin-top:18px; height:47px;" src="img/social_login.png"/>
                        <div class="divider">
                            <hr class="left"/>OR<hr class="right" />
                        </div>
                        <span name="wrong" id="email_wrong" style="display: none"
                              onclick="document.getElementById('username').value =''"><img
                                src="img/x.png"></span><input type="text" name="username" id="username" required
                                                              placeholder="Your Username" autocomplete="off">

                                                    <span name="wrong" id="email_wrong" style="display: none"
                                                          onclick="document.getElementById('email_address').value =''"><img
                                                            src="img/x.png"></span><input type="text" name="email_address" id="email_address" required
                                                                                          placeholder="Your email address" autocomplete="off">
                                                    <span name="wrong" id="password_wrong"
                                                          style="display: none"
                                                          onclick="document.getElementById('password').value =''"><img
                                                            src="img/x.png"></span><input type="password" name="password" id="password" required
                                                                                          placeholder="Enter a password" autocomplete="off">
                        <p class="SignUpText">Use at least one letter<br> one numeral, and seven characters.</p>

                        <div id="g-recaptcha" class="g-recaptcha" data-sitekey="6LcZwyATAAAAACFru_oAaZX_UCjGySRbcPFiN9Ye"></div>

                        <input id="submit" type="submit" name="submit" value="Log In" style="margin-bottom: 30px" onclick="return check()">
                    </span>
            </div>
        </form>
    </div>
    </div>
    </body>
    </html>



<?php

class Verification
{
    /* Google recaptcha API url */
    private $google_url = "https://www.google.com/recaptcha/api/siteverify";
    private $secret = '6LcZwyATAAAAAFzPeCoBRL-ptF9gnGs-tP5-Bdik';

    public function VerifyCaptcha($response)
    {
        $url = $this->google_url . "?secret=" . $this->secret . "&response=" . $response;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $curlData = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($curlData, TRUE);
        if ($res['success'] == 'true')
            return TRUE;
        else
            return FALSE;
    }


}
//starts from here when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $response = $_POST['g-recaptcha-response'];
    try {
        //check reCAPTCHA verification
        if (!empty($response)) {
            $cap = new Verification();
            $verified = $cap->VerifyCaptcha($response);
            //if reCAPTCHA is verified
            if ($verified) {
                $db = new DatabaseHandler();
                if ($db->ConnectDB()) {
                    if ($db->VerifyUsername()) {
                        if ($db->VerifyEmail()) {
                            $db->RegisterUser();
                            $db->DisconnectDB();
                            echo "<script>window.location='header.php';</script>";
                            /* 2015 06 01 by Daniel
                             * i used script at the middle of php because
                             * php header('Lcation : header.php') is not working.
                             * and i don't think it's a good idea to use script here.
                             * if someone knows why, please fix it.
                             * */
                            exit;
                        }
                    }
                }
            } else {
                throw new Exception("Our system recognized you as a robot.");
            }
        }
    } catch (Exception $e) {
        $db->DisconnectDB();
        FailedOnSignUp($e->getMessage());
    }
}
?>