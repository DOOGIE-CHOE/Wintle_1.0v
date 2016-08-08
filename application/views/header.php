<?php

if(!isset($_SESSION))
{
    session_start();
}

$top_fst_text = "Sign In";
$top_snd_text = "Sign Up";
$top_fst_link = "signin.php";
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
                ▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼▼
          ---------------------------------------------------------------------------- -->

        <!-- JQ Plug In -->
        <script src="js/multiSelectorDraggable.js"></script>

        <!-- css Plug In -->
        <link href="css/css_reset.css" rel="stylesheet" />

        <!-- css custom -->
        <link media="screen" href="css/style/pc.css" rel="stylesheet" />
        <link media="handheld" href="css/style/mobile.css" rel="stylesheet" />

        <!-- Javascript custom -->
        <script src="js/jq-jh.js"></script>

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
        </style>

        <script>
            /*
             $("#popup1").click(function(){
             alert("ASd");


             });
             */
            $(function(){
                $("#popup1").click(function (e)
                {
                    var container = $("#popup");

                    if (!container.is(e.target) && container.has(e.target).length === 0)
                    {
                        window.location.href="#";
                    }
                });
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
                <a href="http://www.wintle.co.kr"><img src="img/logo_s.png" style="height:50px"></a>
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
        <form action="" method="post">
            <div class="popup" id="popup">
                <h2 style="color:white">Sign up for Wintle</h2>
                <a class="close" href="#">×</a>
                <br><br>
                <div class="backboard">
                    <div class="SignUp">
                        <span><img src="img/username.png"></span><span name="wrong" id="username_wrong"
                                                                       style="display: none"
                                                                       onclick="document.getElementById('username').value =''"><img
                                src="img/x.png"></span><input type="text" name="username" id="username" required
                                                              placeholder="User name" autocomplete="off">

                        <span><img src="img/email.png"></span><span name="wrong" id="email_wrong" style="display: none"
                                                                    onclick="document.getElementById('email_address').value =''"><img
                                src="img/x.png"></span><input type="text" name="email_address" id="email_address" required
                                                              placeholder="Your email address" autocomplete="off">

                        <span><img src="img/password.png"></span><span name="wrong" id="password_wrong"
                                                                       style="display: none"
                                                                       onclick="document.getElementById('password').value =''"><img
                                src="img/x.png"></span><input type="password" name="password" id="password" required
                                                              placeholder="Enter a password" autocomplete="off">

                        <span><img src="img/password.png"></span><span name="wrong" id="repassword_wrong"
                                                                       style="display: none"
                                                                       onclick="document.getElementById('repassword').value =''"><img
                                src="img/x.png"></span><input type="password" name="repassword" id="repassword" required
                                                              placeholder="Re-enter a password"
                                                              autocomplete="off">

                        <p class="SignUpText">Use at least one letter<br> one numeral, and seven characters.</p>

                        <div class="g-recaptcha" data-sitekey="6LcZwyATAAAAACFru_oAaZX_UCjGySRbcPFiN9Ye"></div>

                        <input id="submit" type="submit" name="submit" value="Sign Up for Wintle" onclick="return check()">
                    </div>
                </div>
            </div>
        </form>
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