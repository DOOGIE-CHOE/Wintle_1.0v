<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 5/24/17
 * Time: 1:34 PM
 */

?>

<style>
    .section{
        text-align:center;
    }
    p{
        font-size: 2em;
    }

    .main-login-signup-form{
        width: 100%;
        height:100%; !important;

    }
    .main-signup-box{
        width:100%;
        display: inline-block;
        padding: 11px;
        background: #EE3B24;
        border-radius: 3px;

    }
    .main-login-box{
        margin-bottom: 10px;
        width:100%;
        display: inline-block;
        border: 1px solid rgba(255,255,255,1);
        padding: 11px;
        border-radius: 3px;
    }
    .col-centered{
        float:none;
        display:inline-block;
    }
    .section{
        z-index: -1;
    }


    @media all and (max-width:940px){
        .main-grid-example{
            overflow: visible !important;
        }
    }

    @media all and (max-width:735px){
        .main-grid-example .img-container{
             left:-18px !important;;
         }
    }

    @media all and (max-width:414px){
        #section1 .top-blank{
              height:20% !important;;

          }
        #section1 .content-logo{
            height:24% !important;;
        }
        #section1 .content-title{
            font-size:2.2em !important;
        }
        #section1 .content-text{
            font-size:1.15em !important;
        }
        #section1 .content li{
            padding:12px 47px;
        }

        #section2 .top-blank{
            height:15% !important;;

        }
        #section2 .content-title{
            height:14% !important;
            font-size:1.1em !important;
        }
        #section2 .content-text{
            height:26% !important;
            font-size:0.8em !important;
        }
        .main-grid-example .img-container{
            padding:0;
            left: 0 !important;
        }
    }
    @media all and (max-width:320px) {
        #section2 .top-blank{
            height:15% !important;;

        }
        #section2 .content-title{
            height:14% !important;
            font-size:0.8em !important;
        }
        #section2 .content-text{
            height:26% !important;
            font-size:0.66em !important;
        }
        .main-grid-example .img-container{
            padding:0;
            left: 0 !important;
        }
    }


</style>
<body>

<!--  화면 하단 이용 약관 및 개인정보처리방침 페이지 링크 -->
<div class="row info-bottom-board" style="z-index:1;">
    <div class="col-md-2 col-lg-2 pull-right">
        <span style="color:white;" onclick="$.pagehandler.loadContent('<?php echo URL?>info/terms','all')">Terms</span>
        <span style="color:white;" onclick="$.pagehandler.loadContent('<?php echo URL?>info/privacy','all')">Privacy</span>
    </div>
</div>

<div id="fullpage">
    <div class="section" id="section0" style="z-index:10" >
        <div class="intro" style="height:100%; width:100%;">

            <div class="container-fluid" style="height:100%; position:absolute; width:100%;">
                <div class="row" style="height:35%">

                </div>

                <div class="row" style="height:30%; ">
                    <div class="col-md-4 col-centered" style="height:100%; z-index:10;">
                        <div class="main-login-signup-form">
                            <div class="row" style="height:25%">
                                <img src='<?php echo URL?>img/pavicon/wintle_logo_with_text-white.svg' style="width:100% ; height:100%;">
                            </div>
                            <div class="row" style="height:70%">
                                <div class="row" style="height:100%;">
                                    <div class="col-md-7 col-centered" style="margin-top:25px;">
                                        <div class="main-login-box" onclick='setLogInForm()' data-toggle='modal' data-target='#signModal'><span id="top_login" style="font-size:16px; color:white;" data-langNum="1001">Log in</span> </div>
                                        <div class="main-signup-box" onclick="setSignUpForm()"  data-toggle='modal' data-target='#signModal'><span id="top_signup" class='sign-up-text' style="font-size:16px; color:white;" data-langNum="1002">Sign up</span></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="row" style="height:35%">

                </div>
            </div>


            <div style="background-image:url('<?php echo URL?>img/landingpage/mic.jpg'); height:100%; width:100%;background-repeat: no-repeat;background-size: cover; z-index:0; position:absolute">
            </div>
            <div style="z-index:2; height:100%; width:100%; background: rgba(0,0,0,0.2); position:absolute">
            </div>



        </div>
    </div>

    <div class="section" id="section1" style="z-index:-1; display:none;">
        <div class="intro" style="height:100%; width:100%;">
            <div class="container-fluid" style="height:100%; position:absolute; width:100%;">
                <div class="row top-blank" style="height:22%"></div>
                <div class="row content-logo" style="height:30%">
                    <div class="col-md-8 col-centered" style="height:100%;">
                        <img src='<?php echo URL?>img/pavicon/wintle_logo-white.svg' style="width:100% ; height:100%;">
                    </div>
                </div>
                <div class="row content" style="height:20%">
                    <ui>
                        <li style="margin-top:3%" >
                            <span style="color:white; font-size:3em" class="content-title" data-langNum="1101">윈틀은 너무 쉬워서 따로 설명이 필요 없어요.</span>
                        </li>
                        <li style="margin-top:2%" >
                            <span style="color:white; font-size:1.3em" class="content-text" data-langNum="1102">내 이야기가 가사가 되고, 내가 흥얼거린 노래가 멜로디가 되고, 일상속 사진들이 엘범이 될 수 있어요.</span></br>
                            <span style="color:white; font-size:1.3em" class="content-text" data-langNum="1103"> 좋아하는 뮤지션을 팔로우 하고, 마음에 드는 곡들에 나의 작품을 더해 보세요.</span>
                        </li>
                    </ui>

                </div>
                <div class="row" style="height:20%"></div>
            </div>
        </div>
    </div>



    <div class="section" id="section2" style="z-index:-1; display:none;">
        <div class="intro" style="height:100%; width:100%;">
            <div class="container-fluid" style="height:100%; position:absolute; width:100%; padding:0 10% 0 10%">
                <div class="row top-blank" style="height:15%"></div>
                <div class="row content-title" style="height:12%">
                    <div class="col-md-5" style="float:left; color: white; text-align: left;">
                    <p data-langNum="1104">winlte은 창작 놀이터.</p>
                    <p data-langNum="1105">우리 함께 놀아 보자구요 ~</p>
                    </div>
                </div>
                <div class="row content-text" style="height:15%">
                    <div class="col-md-12" style="float:left; color: white; text-align: left; font-size:0.7em">
                        <p data-langNum="1106"></p>
<!--                        <p>오늘 하루는 어떤 생각에 빠지셨나요? 지금 떠오르는 일상 속의 이야기 당신의 멋있는 순간들,</p>-->
<!--                        <p>마구 떠오르는 악상, 천상의 목소리, 감각적인 연주를 이곳에 업로드 해보세요 아주 간단해요</p>-->
<!--                        <p>벌써 올리셨다고요? 조금만 기다려보세요. 어느 순간 노래가 만들어 질 거예요. 그뿐 아니에요 이젠</p>-->
<!--                        <p>내가 찾는 사람도 쉽게 만나고 소통할 수 있어요. 이젠 wintle에 빠져들게 될 껄요?</p>-->
                    </div>
                </div>

                <div class="row main-grid-example" style="overflow:hidden">
                    <div class="col-md-12 col-sm-12 col-xs-12 img-container" style="left:-30px;">
                        <img src='<?php echo URL?>img/landingpage/thirdpage-example.png' style="width:100% ; height:100%;">
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="section" id="section3" style="z-index:-1; display:none;">
        <div class="intro" style="height:100%; width:100%;">

            <div class="container-fluid" style="height:100%; position:absolute; width:100%;">
                <div class="row" style="height:35%">

                </div>

                <div class="row" style="height:30%; ">
                    <div class="col-md-4 col-centered" style="height:100%; z-index:10;">
                        <div class="main-login-signup-form">
                            <div class="row" style="height:25%">
                                <img src='<?php echo URL?>img/pavicon/wintle_logo_with_text-white.svg' style="width:100% ; height:100%;">
                            </div>
                            <div class="row" style="height:70%">
                                <div class="row" style="height:100%;">
                                    <div class="col-md-7 col-centered" style="margin-top:25px;">
                                        <div class="main-login-box" onclick='setLogInForm()' data-toggle='modal' data-target='#signModal'><span id="top_login" style="font-size:16px; color:white;" data-langNum="1001">Log in</span> </div>
                                        <div class="main-signup-box" onclick="setSignUpForm()"  data-toggle='modal' data-target='#signModal'><span id="top_signup" class='sign-up-text' style="font-size:16px; color:white;" data-langNum="1002">Sign up</span></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="row" style="height:35%">

                </div>
            </div>


            <div style="background-image:url('<?php echo URL?>img/landingpage/main_background.jpeg'); height:100%; width:100%;background-repeat: no-repeat;background-size: cover; z-index:0; position:absolute">
            </div>
            <div style="z-index:2; height:100%; width:100%; background: rgba(0,0,0,0.5); position:absolute">
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    $('#fullpage').fullpage({
        anchors: ['firstPage', 'secondPage', '3rdPage' ,'4rdPage'],
        navigation: true,
        navigationPosition: 'right',
        navigationTooltips: ['First page', 'Second page', 'Third and last page']
    });
    $(document).ready(function() {
        //페이지 새로고침 시 순간적으로 다른 section들이 보이는 증상을 제거 하기 위해
        //main을 제외한 모든 section은 기본 display none 으로 설정되며 페이지 로드가 완료되면 block으로 변경
        $("#section1").css("display","block");
        $("#section2").css("display","block");
        $("#section3").css("display","block");
    });
</script>


</body>

