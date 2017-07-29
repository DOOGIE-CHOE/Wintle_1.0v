<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/20/2016
 * Time: 7:11 PM
 */
?>


<script>

    function onSignIn(googleUser) {
        var id_token = googleUser.getAuthResponse().id_token;

        <?php
        if(Session::get('social_loggedIn') == true){
    }else{ ?>
        $.get("<?php echo URL?>social/google_login/" + id_token, function (o) {
            console.log(o);
            var value = jQuery.parseJSON(o);

            if (value.success == true) {
                window.location.replace("https://www.wintle.co.kr");
            } else {
                errorDisplay(value.error);
            }
        });
        <?php   } ?>
    }

    function renderButton() {
        gapi.signin2.render('my-signin2', {
            'scope': 'profile email',
            'width': 240,
            'height': 50,
            'longtitle': true,
            'theme': 'dark',
        });
    }

    $(function () {


        $('#signModal').on('click', function (e) {
            if ($(e.target).attr('class') == "modal-sign-wrapper") {
                var opened = $('#signModal').hasClass('modal in');
                if (opened === true) {
                    $('#signModal').modal('hide');
                }
            }
        });
    });

</script>
<style>
    .modal-sign-wrapper {
        top: 0;
        position: absolute;
        left: 0;
        right: 0;
        margin: auto;
        height:100%;
        width:100%;
    }

    @media (min-width: 600px) {
        .modal-dialog {
            width: 500px;
            margin-top: 120px;
            margin-bottom: 200px;
        }

    }

    @media (max-width: 600px) {
        .modal-dialog {
            width: 95%;
            margin-top: 120px;
            margin-bottom: 80%;
        }
    }

    .abcRioButton {
        width: 100% !important;
        height: 100% !important;
    }

    .term-box {
        padding: 10px;
        height: 150px;
        margin: 20px 20px 0 20px;
        overflow: auto;
        word-break: break-all;
        color: #666;
        background: #f7f7f7;
    }

    .term-box .article {

    }

    .term-box .article-subtitle h3 {
        line-height: 2;
        font-size: 1.2em;
    }

    .term-box .article h4 {
        line-height: 3;
        font-size: 1em;
    }

    .term-box .article p {
        white-space: pre-line;
        font-size: 0.8em;
    }

    .checks {
        position: relative;
    }

    .checks input[type="checkbox"] { /* 실제 체크박스는 화면에서 숨김 */
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0
    }

    .checks input[type="checkbox"] + label {
        display: inline-block;
        position: relative;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .checks input[type="checkbox"] + label:before { /* 가짜 체크박스 */
        content: ' ';
        display: inline-block;
        width: 21px; /* 체크박스의 너비를 지정 */
        height: 21px; /* 체크박스의 높이를 지정 */
        line-height: 21px; /* 세로정렬을 위해 높이값과 일치 */
        margin: -2px 8px 0 0;
        text-align: center;
        vertical-align: middle;
        background: #fafafa;
        border: 1px solid #cacece;
        border-radius: 3px;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
    }

    .checks input[type="checkbox"] + label:active:before,
    .checks input[type="checkbox"]:checked + label:active:before {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .checks input[type="checkbox"]:checked + label:before { /* 체크박스를 체크했을때 */
        content: '\2714'; /* 체크표시 유니코드 사용 */
        color: #99a1a7;
        text-shadow: 1px 1px #fff;
        background: #e9ecee;
        border-color: #adb8c0;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05), inset 15px 10px -12px rgba(255, 255, 255, 0.1);
    }

    .checks.etrans input[type="checkbox"] + label {
        padding-left: 30px;
    }

    .checks.etrans input[type="checkbox"] + label:before {
        position: absolute;
        left: 0;
        top: 0;
        margin-top: 0;
        opacity: .6;
        box-shadow: none;
        border-color: #6cc0e5;
        -webkit-transition: all .12s, border-color .08s;
        transition: all .12s, border-color .08s;
    }

    .checks.etrans input[type="checkbox"]:checked + label:before {
        position: absolute;
        content: "";
        width: 10px;
        top: -5px;
        left: 5px;
        border-radius: 0;
        opacity: 1;
        background: transparent;
        border-color: transparent #6cc0e5 #6cc0e5 transparent;
        border-top-color: transparent;
        border-left-color: transparent;
        -ms-transform: rotate(45deg);
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    .no-csstransforms .checks.etrans input[type="checkbox"]:checked + label:before {
        /*content:"\2713";*/
        content: "\2714";
        top: 0;
        left: 0;
        width: 21px;
        line-height: 21px;
        color: #6cc0e5;
        text-align: center;
        border: 1px solid #6cc0e5;
    }

</style>

<div class="modal" id="signModal" role="dialog">
<!--    <div class="modal-background" style="position: absolute; height: 100%; width: 100%; top: 0;"></div>-->
        <div class="modal-sign-wrapper">
            <div class="modal-dialog">
                <!-- Sign up/Log in form -->
                <form id="login-form" action="<?php echo URL ?>login/calllogin" method="post">
                <span class="SignUp grid-item">
                        <ul id="basic-info-ul">
                            <li>
                                <div class="row" style="margin:0; padding:15px 0;">
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                             style="line-height:40px; text-align: center; border-bottom: 1px solid rgba(239,83,80,0.8);">
                                            <span id="login-text"
                                                  style="margin-left:30px; color:#EF5350; font-weight: 500;" data-langNum="1001">Log In</span>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                             style="line-height:40px; text-align: center; border-bottom: 1px solid gainsboro">
                                        <span id="signup-text" style="margin-right:30px; color:#888;" data-langNum="1002">Sign Up</span>
                                        </div>
                                </div>
                            </li>
                            <li>
                                    <div class="g-signin2" data-onsuccess="onSignIn" data-longtitle="true"
                                         style="padding:0 40px; height:50px;"></div>
                            </li>
                                <li>
                                    <div class="divider">
                                         <hr class="line-left"/><span data-langNum="1007"></span><hr class="line-right"/>
                                    </div>
                                </li>
                            <li>
                                 <span name="wrong" id="email_wrong" style="display: none"
                                       onclick="document.getElementById('user_email').value =''">
                                     <img src="<?php echo URL ?>img/x.png">
                                 </span>
                                 <input type="text" name="user_email" id="user_email" required
                                        placeholder="Your email address" autocomplete="off" data-langNum="1003">
                            </li>
                            <li>
                                <span name="wrong" id="password_wrong" style="display: none"
                                      onclick="document.getElementById('password').value =''">
                                    <img src="<?php echo URL ?>img/x.png">
                                </span>
                                <input type="password" name="password" id="password" required
                                       placeholder="Enter a password" autocomplete="off" data-langNum="1004">
                            </li>
                            <li>
                              <input id="submit" type="submit" name="submit" value="LOG IN"
                                     onclick="return logIn()">
                            </li>
                        </ul>
                 </span>
                </form>


                <form id="signup-form" action="<?php echo URL ?>signup/callsignup" method="post">
                            <span class="SignUp grid-item">
                                <ul id="basic-info-ul">
                                    <li>
                                            <div class="row" style="margin:0; padding:15px 0;">
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                     style="line-height:40px; text-align: center; border-bottom: 1px solid gainsboro;">
                                                    <span id="login-text"
                                                          style="margin-left:30px; color:#888;" data-langNum="1001">Log In</span>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
                                                     style="line-height:40px; text-align: center; border-bottom: 1px solid rgba(239,83,80,0.8);">
                                                <span id="signup-text"
                                                      style="margin-right:30px; color:#EF5350; font-weight: 500;" data-langNum="1002">Sign Up</span>
                                                </div>
                                            </div>
                                    </li>
                                    <li>
                                            <div class="g-signin2" data-onsuccess="onSignIn" data-longtitle="true"
                                                 style="padding:0 40px; height:50px;"></div>
                                    </li>
                                        <li>
                                            <div class="divider">
                                                <hr class="line-left"/><span data-langNum="1007"></span><hr class="line-right"/>
                                            </div>
                                        </li>
                                    <li>
                                        <span name="wrong" id="user_name_wrong_signup" style="display: none"
                                              onclick="document.getElementById('user_name_signup').value =''">
                                            <img src="<?php echo URL ?>img/x.png">
                                        </span>
                                        <input type="text" name="user_name_signup" id="user_name_signup" required
                                               placeholder="Your username" autocomplete="off" data-langNum="1005">
                                    </li>
                                    <li>
                                         <span name="wrong" id="email_wrong_signup" style="display: none"
                                               onclick="document.getElementById('user_email_signup').value =''">
                                             <img src="<?php echo URL ?>img/x.png">
                                         </span>
                                         <input type="text" name="user_email_signup" id="user_email_signup" required
                                                placeholder="Your email address" autocomplete="off" data-langNum="1003">
                                    </li>
                                    <li>
                                        <span name="wrong" id="password_wrong_signup" style="display: none"
                                              onclick="document.getElementById('password_signup').value =''">
                                            <img src="<?php echo URL ?>img/x.png">
                                        </span>
                                        <input type="password" name="password_signup" id="password_signup" required
                                               placeholder="Enter a password" autocomplete="off" data-langNum="1004">
                                    </li>
                                    <li>
                                        <p class="SignUpText" data-langNum="1006">비밀번호는 영문과 숫자 모두 포함된<br>7자리 이상의 문자여야 합니다.</p>
                                    </li>
                                    <!--                        <div id="g-recaptcha" class="g-recaptcha" data-sitekey="6LcZwyATAAAAACFru_oAaZX_UCjGySRbcPFiN9Ye"></div>
                                    -->
                                    <li>
                                      <input id="button" type="button" name="button" value="SIGN UP"
                                             onclick="return signUp()">
                                    </li>
                                    </ul>
                            </span>
                    <span class="terms-privacy grid-item" style="display:none;">
                            <ul>
                                <li>
                                    <div class="term-box">
                                            <div class="article-subtitle">
                                                <h3 data-langNum="1302">
                                                    제 1 장 총칙
                                                </h3>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1303">
                                                    제1조 (목적)
                                                </h4>
                                                <p class="article-text" data-langNum="1304">
                                                    본 약관은 주식회사 윈틀(wintle)(이하 "회사")가 제공하는 소셜 창작자 기반의 온라인 협업 서비스 및 유무선 인터넷 음악 인터넷 사이트 wintle(www.wintle.co.kr : 웹, 모바일 웹, 모바일 어플리케이션 및 이와 연동되는 기타 서비스 포함)과 모든 관련 서비스(이하 "서비스")를 이용함에 있어 회원과 회사간의 권리, 의무, 책임사항, 서비스 이용조건 및 절차 사항, 기타 필요한 사항을 규정함을 목적으로 합니다.
                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1305">
                                                    제2조 (약관의 효력 및 변경)

                                                </h4>
                                                <p class="article-text" data-langNum="1306">
                                                    1. 본 약관의 효력은 "서비스"를 이용하는 모든 회원에게 발생합니다.
                                                    2. 본 약관은 회사가 제공하는 "서비스"의 화면에 게시하거나 기타의 방법으로 회원에게 공지하고, 이에 동의한 회원이 서비스에 가입함으로써 효력이 발생합니다.
                                                    3. 회사는 약관의 변경이 필요한 합리적인 사유가 발생되었을 때 관련 법령을 위반하지 않는 범위에서 본 약관을 변경할 수 있으며, 적용일자 및 변경 사유를 명 시하여 현행 약관과 함께 회사의 "서비스"에 적용일자 7일(단, 회원에게 불리한 약관 개정의 경우 30일 전) 전에 "서비스" 접속 시 게시하거나, 기타의 방법을 통해 회원에게 제공하고 기존 회원에게는 적용일자 및 변경될 내용 중 중요사항에 대해 전자우편주소로 발송합니다.
                                                    4. 변경된 약관이 적용된 "서비스" 개시일까지 회원이 명시적 거부의사를 밝히지 않으면 약관 변경에 동의한 것으로 간주하며, 회사는 해당 절차에 대해 본 조 3 항에 의거 회원에게 약관 변경 내용을 제공할 때 명시하여 알립니다.
                                                    5. 본 약관은 회원이 약관에 동의한 날로부터 회원 탈퇴 시 까지 적용됩니다. 단, 본 약관의 일부 조항은 회원의 탈퇴 후에도 유효하게 적용될 수 있습니다.
                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1307">
                                                    제3조 (약관 외 준칙)
                                                </h4>
                                                <p class="article-text" data-langNum="1308">
                                                    1. 본 약관에 명시되지 않은 사항에 대해서는 콘텐츠산업진흥법, 전자상거래등에서의 소비자보호에 관한 법률, 저작권법 등 관련 법령의 규정과 일반 상관례에 따릅니다.
                                                    2. 본 약관에서 규정된 내용이 개별 서비스 약관에서 정한 이용 규정과 충돌하는 경우에는 개별 서비스 약관의 규정이 우선하여 적용됩니다
                                                </p>
                                            </div>


                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1309">
                                                    제4조 (용어의 정의)
                                                </h4>
                                                <p class="article-text" data-langNum="1310">
                                                    1. 본 약관에서 사용하는 주요한 용어의 정의는 다음과 같습니다.
                                                        1)회원:회사가 제공하는 서비스를 이용하기 위해 본 약관에 동의 또는 회사와의 별도의 계약이나 합의를 통해 가입 한 모든 고객
                                                    2) 아이디(ID) : 회원의 식별과 서비스 이용을 위해 회원이 입력하는 고유 정보
                                                        (1) 제3자의 서비스 또는 단체가 제공하는 이메일 서비스에서 사용되는 회원 소유의 이메일 계정.
                                                        (2) 회사가 연동을 허용한 SNS 및 포털 서비스에 제공하는 회원 소유의 이메일 계정
                                                    3) 비밀번호 : 회원의 서비스 이용 접속 및 정보 보호를 위해 회원이 직접 설정한 문자, 숫자, 특수 문자의 조합
                                                    4) 닉네임(별명) : 회원이 직접 정한 회원 고유의 별도 명칭
                                                    5) 운영자, 관리자 : 서비스의 관리와 운영을 위해 회사가 선정한 자
                                                    6) 이용중지 : 회사의 약관에 의거 회원의 서비스 이용을 제한하는 행위
                                                    7) 개별서비스 : 서비스 내에서 제공하는 각각의 별도 서비스
                                                    2. 본 조에서 정하지 않은 용어의 정의는 관계 법령 및 서비스 안내에서 정하는 바에 준거합니다.
                                                </p>
                                            </div>

                                            <div class="article-subtitle">
                                                <h3 data-langNum="1311">
                                                    제 2장 서비스 이용계약
                                                </h3>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1312">
                                                    제5조 (이용계약의 성립)

                                                </h4>
                                                <p class="article-text" data-langNum="1313">
                                                    1. 서비스를 이용하고자 하는 회원이 회사가 정한 가입 양식에 따라 회원정보를 기입한 후 본 약관에 동의한다는 의사표시를 함으로서 회원가입을 신청합니다.
                                                    2. 이용 계약은 회사 회원가입 희망자가 이용약관 동의 후 이용 신청에 대하여 회사가 승낙함으로써 성립합니다.
                                                </p>
                                            </div>


                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1314">
                                                    제6조 (이용신청)

                                                </h4>
                                                <p class="article-text" data-langNum="1315">
                                                    1. 회원 가입 및 서비스 이용을 희망하는 자는 약관의 내용에 동의 후 회사가 정한 양식에 따라 다음 사항을 기록하는 방식으로 신청합니다.
                                                        1) 아이디(ID)
                                                        2) 비밀번호
                                                        3) 기타 회사가 필요하다고 인정하는 항목
                                                    2. 회원은 만 18세 이상이거나, 미성년이지만 성인으로서의 권한을 가지거나, 법적인 부모 또는 후견인의 동의를 받았으며, 본 약관에 규정된 조건, 의무, 확인, 진술 및 보증에 합의하고 본 약관을 준수 할 수 있는 완전한 권한이 있음을 확인합니다. 본 서비스는 만 13세 미만의 아동을 대상으로 한 서비스가 아니므로 어떠한 경우라도 13세 미만의 아동이 본 서비스를 사용하였을 때 발생 될 수 있는 법적 분쟁에 대해 책임을 지지 않습니다. 회원에게 적절한 사이트에 대하여 부모님과 상의하시기 바랍니다.
                                                    회사는 회원의 본 서비스 이용에 어떠한 조건이 적용 되는지 회원이 알 수 있도록 본 서비스와 함께 본 약관을 제공합니다. 회원은 당사자 본 약관을 검토할 수 있는 합리적인 기회를 제공받습니다.
                                                    3. 본 약관에서 정의하지 않은 개별 서비스의 이용신청은 해당 서비스 각각의 이용신청 약관 동의로 이용가능하며 본 약관의 이용신청 조항과 충돌할 경우 개 별 서비스의 이용약관이 우선합니다. </p>
                                            </div>


                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1316">
                                                    제7조 (이용신청의 승낙)

                                                </h4>
                                                <p class="article-text" data-langNum="1317">
                                                    회사는 제6조에서 정한 사항을 정확히 기재하여 이용 신청한 고객에 대하여 서비스 이용 신청을 승낙합니다
                                                </p>
                                            </div>


                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1318">
                                                    제8조 (이용신청에 대한 승낙 제한)

                                                </h4>
                                                <p class="article-text" data-langNum="1319">
                                                    1. 다음 각호의 경우에 회사는 이용신청을 승낙하지 않을 수 있습니다.
                                                        1) 회사의 업무상, 기술상의 사정으로 서비스 제공이 불가능한 경우
                                                        2) 이용자 등록 사항을 누락하거나 오기하여 신청하는 경우, 허위서류를 첨부하는 경우 등 이용자의 귀책사유로 인하여
                                                        3) 사회의 안녕질서 또는 미풍양속을 저해하거나, 저해할 목적으로 신청한 경우
                                                        4) 만 13세 아동일 경우
                                                        5) 제26조(계약해지 및 이용제한)에 의하여 이전에 회원 자격을 상실한 적이 있는 경우, 자격 상실 이후 1년 이상 경과한 자로서 회사의 회원 재가입 승낙을 받은 경우는 예외로 합니다.
                                                        6) 서비스 이용 후 회원이 회사에 등록한 결제수단의 임의 해지 및 지급 정지, 지불 불능 등의 사유로 정당한 사유 없이 회사가 청구한 서비스 요금을 납부하지 아니한 경우
                                                        7) 회사가 서비스 사업권 내지 저작권을 허락 받지 아니한 국가에 거주, 체류중인 자 이거나 동 국가에서 사이트에 접속 하는 경우
                                                        8)범죄행위,특정한 일정기간 동안에 유료회원가입, 해지를 반복하여 정상적인용도 이외로 사용한 경우가 명백한 경우 등 회사의 서비스 방해 등의 사유로 회원자격 상실(탈퇴) 이력이 있는 경우
                                                        9) 악성 프로그램 및 버그를 이용하거나 시스템 취약점을 악용하는 등 부정한 방법을 서비스에 사용한 경우
                                                        10) 타인의 명의를 도용하여 신청한 경우.
                                                        11) 기타 회사가 정한 이용신청 요건이 만족되지 않았을 경우
                                                        12) 기타 회사의 사정상 필요하다고 인정되는 경우
                                                </p>
                                            </div>


                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1320">
                                                    제9조 (개인정보의 보호)
                                                </h4>
                                                <p class="article-text" data-langNum="1321">
                                                    1. 회사는 이용자 등록정보를 포함한 이용자의 개인정보를 보호하기 위해 관계법령이 정하는 바와 개인정보 보호정책을 준수합니다. 회사는 개인정보 보호 정책을 회사가 운영하는 사이트 화면에 게시합니다.
                                                    2. 이용자가 게시판, 메일, 채팅 등 온라인상에서 자발적으로 제공하는 개인정보는 다른 사람이 수집하여 사용할 가능성이 있으며 이러한 위험까지 회사가 부담하지는 않습니다.
                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1322">
                                                    제10조 (회원정보의 변경)

                                                </h4>
                                                <p class="article-text" data-langNum="1323">
                                                    1. 회원은 '회원정보변경' 메뉴를 통해 언제든지 본인의 개인정보를 열람하고 수정할 수 있습니다.
                                                    2. 회원은 이용 신청 시 기재한 사항이 변경되었을 경우 해당 내용을 수정 해야 하며, 회원정보를 변경하지 아니하여 발생되는 문제의 책임은 회원에게 있습니다.
                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1324">
                                                    제11조 (아이디와 닉네임 부여 및 변경)

                                                </h4>
                                                <p class="article-text" data-langNum="1325">
                                                    1. 회사는 회원에 대하여 약관에 정하는 바에 따라 회원이 입력한 정보에 따라 아이디와 닉네임을 부여합니다.
                                                    2. 회사는 다음 각 호에 해당하는 경우 회원에게 아이디 또는 닉네임 변경을 요청할 수 있습니다.\
                                                    1) 회원 아이디 또는 닉네임이 회원의 연락처 등으로 등록되어 사생활 침해의 우려가 있는 경우
                                                    2) 타인에게 혐오감을 주거나 청소년 및 아동에 유해하다고 판단하는 경우
                                                    3) 타사이트와의 통합 등으로 인해 회원들간의 아이디와 닉네임이 중복되는 부득이한 경우
                                                    4) 아이디의 소유자를 확인할 수 없거나 서비스되지 않는 이메일 계정인 경우
                                                    5) 특수문자 포함 아이디 또는 닉네임 등 회원의 정보보호 및 원활한 서비스 제공에 반하는 아이디 또는 닉네임인 경우
                                                    6) 기타 합리적인 사유가 있는 경우
                                                    3. 회사는 회원이 여러 개의 아이디를 생성한 경우 회원에게 이를 고지하고 회원이 선택하는 대표 아이디 외에 다른 아이디를 삭제할 수 있습니다.
                                                </p>
                                            </div>

                                            <div class="article-subtitle">
                                                <h3 data-langNum="1326">
                                                    제 3 장 서비스 이용
                                                </h3>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1327">
                                                    제12조 (서비스의 이용 개시)

                                                </h4>
                                                <p class="article-text" data-langNum="1328">
                                                    1. 회사는 회원의 이용 신청을 승낙한 때부터 서비스를 개시합니다. 단, 일부 서비스의 경우에는 지정된 일자부터 서비스를 개시하며, 유료서비스의 경우 회사 가 지정하는 수단으로 결재를 완료하여야 합니다. 또한 별도의 약관 동의 및 실명 인증 등의 개인 인증 절차를 필요로 할 수 있습니다.
                                                    2. 회사의 업무상 또는 기술상의 장애로 인하여 서비스를 개시하지 못하는 경우에는 사이트에 공지하거나 회원에게 이를 통지합니다.
                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1329">
                                                    제13조 (서비스의 이용 시간)

                                                </h4>
                                                <p class="article-text" data-langNum="1330">
                                                    1. 서비스의 이용은 연중무휴 1일 24시간을 원칙으로 합니다. 다만, 회사의 업무 상이나 기술상의 이유로 서비스가 일시 중지될 수 있고, 운영상의 목적 또는 사전 공지가 어려운 급박한 상황으로 회사가 정한 기간 동안에는 서비스가 일시 중지될 수 있습니다. 이러한 경우 회사는 사전 또는 사후에 이를 공지합니다.
                                                    2. 회사는 서비스를 일정범위로 분할하여 각 범위 별로 이용 가능한 시간을 별도로 정할 수 있으며 이 경우 그 내용을 공지합니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1331">
                                                    제14조 (서비스의 변경 및 중지)

                                                </h4>
                                                <p class="article-text" data-langNum="1332">
                                                    1. 회사는 상당한 이유가 있는 경우 운영상, 기술상 필요에 따라 서비스를 변경할 수 있으며, 이 경우 변경될 서비스의 내용 및 제공일자를 본 약관 제2조 3항에 서 정한 방법으로 회원에게 통지합니다. 단 변경된 내용이 중대 하거나 회원에게 불리한 경우에는 회사가 회원으로부터 본 약관 또는 유료서비스 약관 및 개별 서비스 약관에서 정한 방법으로 통지하고 동의를 받습니다.
                                                    2. 회사는 다음 각 호에 해당하는 경우 서비스의 전부 또는 일부를 일시적으로 제한하거나 중지할 수 있습니다.
                                                    1) 서비스용 설비의 보수 등 공사로 인한 부득이한 경우
                                                    2) 회원이 의도적으로 일정기간 내 특정서비스의 가입 및 해지를 반복하는 등 회사의 정상적 영업 및 서비스 제공 활동을 방해하는 경우
                                                    3) 정전, 제반 설비의 장애 또는 이용 량의 폭주 등으로 정상적인 서비스 이용에 지장이 있는 경우
                                                    4) 서비스 제공업자와의 계약 종료 등과 같은 회사의 제반 사정으로 서비스를 유지할 수 없는 경우
                                                    5) 기타 천재지변, 국가비상사태, 방송통신위원회, 한국정보보호진흥원 등 국가기관, 정부조직, 수사기관, 법원 등의 행정ᆞ사법 처분 등 행정행위로 인한 서비스 중단 등 회사가 통제할 수 없는 불가항력적 사유가 있는 경우
                                                    3. 제2항에 의한 서비스 중단의 경우에는 회사가 본 약관 제2조 제3항에서 정한 방법으로 이용자에게 통지합니다. 단, 미리 통지하는 것이 곤란하거나 급박하 거나 불가피한 사정이 있는 경우에는 사후에 통지할 수 있습니다.
                                                    4. 회사는 제공되는 서비스의 일부 또는 전부를 회사의 정책 및 운영의 필요상 수정, 중단, 변경 할 수 있으며, 이에 대하여 회원에게 별도의 보상을 하거나 책임을 지지 않습니다.
                                                    5. 유료서비스의 정지 또는 중단과 관련한 제반 사항에 대하여는 유료서비스 약관 제19조를 적용합니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1333">
                                                    제15조(정보의 제공 및 광고의 게재)

                                                </h4>
                                                <p class="article-text" data-langNum="1334">
                                                    1. 회사는 서비스를 운영함에 있어 각종 정보를 서비스 화면에 게재하거나 e-mail(전자우편) 및 서신우편 등의 방법으로 회원에게 제공할 수 있습니다.
                                                    2. 회사는 서비스의 운영과 관련하여 홈페이지, 서비스 화면, e-mail(전자우편) 등에 광고 등을 게재할 수 있습니다.
                                                    3. 회원이 서비스상에 게재되어 있는 광고를 이용하거나 서비스를 통한 광고주의 판촉활동에 참여하는 등의 방법으로 교신 또는 거래를 하는 것은 전적으로 회 원과 광고주 간의 문제입니다. 만약 회원과 광고 주 간에 문제가 발생할 경우에도 회원과 광고주가 직접 해결하여야 하며, 이와 관련하여 회사는 어떠한 책임도 지지 않습니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1335">
                                                    제16조(게시물 또는 내용물의 삭제)

                                                </h4>
                                                <p class="article-text" data-langNum="1336">
                                                    1. 회사는 회원이 게시하거나 전달하는 서비스 내의 모든 내용물(회원간 전달 포함)이 다음 각 호의 경우에 해당한다고 판단되는 경우 사전통지 없이 삭제할 수 있으며, 이에 대해 회사는 어떠한 책임도 지지 않습니다.
                                                    1) 회사, 다른 회원 또는 제3자를 비방하거나 중상모략으로 명예를 손상시키는 내용인 경우
                                                    2) 공공질서 및 미풍양속에 위반되는 내용의 정보, 문장, 도형 등의 유포에 해당하는 경우
                                                    3) 범죄적 행위에 결부된다고 인정되는 내용인 경우
                                                    4) 회사의 저작권, 제3자의 저작권 등 기타 권리를 침해하는 내용인 경우
                                                    5) 제2항 소정의 세부이용지침을 통하여 회사에서 규정한 게시기간을 초과한 경우
                                                    6) 회사에서 제공하는 서비스와 관련 없는 내용인 경우
                                                    7) 불필요하거나 승인되지 않은 광고, 판촉물을 게재하는 경우
                                                    8) 기타 관계 법령 및 회사의 지침 등에 위반된다고 판단되는 경우
                                                    2. 회사는 게시물에 관련된 세부 이용 지침을 별도로 정하여 시행할 수 있으며, 회원은 그 지침에 따라 각종 게시물(회원간 전달 포함)을 등록하거나 삭제하여야 합니다.
                                                    3. 회원은 서비스를 탈퇴하는 경우 서비스 이용 도중 회원 본인이 직접 작성한 일련의 게시물(작성 등록한 컨텐츠)에 대한 자동 삭제되지 않으므로
                                                    삭제를 원하는 경우 탈퇴 이전에 삭제하여야 합니다.
                                                    4. 회사는 원활한 서비스 제공을 위하여 정기적 또는 비정기적으로 과거의 게시물을 삭제할 수 있습니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1337">
                                                    제17조(게시물의 저작권)

                                                </h4>
                                                <p class="article-text" data-langNum="1338">
                                                    1.  회원은 서비스의 계정 보유자 자격으로 본 서비스에 오디오 및 이용자 의견을 포함한 콘텐츠를 제출할 수 있습니다. 회원은, 회사가 회원이 제출한 콘텐츠의 기밀성을 보장하지 않음을 알고 있습니다.
                                                    2. 회원 자신의 콘텐츠와 회원의 콘텐츠를 본 서비스에 제출하고 발표한 결과에 대해서 회원만이 책임을 집니다. 회원은 회원이 제출하는 콘텐츠를 발표하는데 필요한 라이센스, 권리, 동의 및 승인을 소유 하거나 보유하고 있으며, 회원은 본 약관에 따라 본 서비스를 통하여 발표하기 위하여 콘텐츠에 대한 모든 특허, 상표, 영업비밀, 저작권 또는 기타 전유적 권리를 회사에 라이센스 하였음을 확인, 진술 및 보증합니다.
                                                    3. 회원은 회원의 콘텐츠에 대한 소유권 전부를 보유함을 명확히 합니다. 그러나, 본 서비스에 콘텐츠를 제출함으로써, 회원은 본 서비스(및 그 2차적 저작물)의 일부 또는 전부를, 어떠한 미디어 포맷으로 어떠한 미디어 채널을 통하여 선전하고 재배포하는 것을 비롯하여, 본 서비스 및 본 회사의(및 그 승계인 및 계열회사)의 사업과 관련 하여 콘텐츠를 이용, 복제, 배포, 2차적 저작물을 작성하거나, 전시, 발표, 각색, 온라인에 제공하거나 전자적인 방법으로 전송하고, 공연(perform)할 수 있는 세계적이고, 비 독점적이고, 무상으로 제공되고, 양도 가능하며, 서브라이센스를 허여할 수 있는(sublicensable) 라이센스를 본 회사에 허여 합니다.
                                                    회원은 또한 본 서비스의 모든 이용 자에게, 본 서비스를 통하여 회원의 콘텐츠에 접속하고, 본 약관 및 본 서비스의 기능을 통하여 허용되는, 그 콘텐츠의 이용, 복제, 배포, 전시, 발표, 온라인에 제공하거나 전 자적인 방법으로 전송하고, 공연할 수 있는 비독점적 라이센스를 본 서비스의 모든 이용자에게 허여 합니다. 회원이 본 서비스에 제출한 오디오 콘텐츠에 대하여 회원이 허여 한 상기 라이센스는 회원이 본 서비스에서 회원의 오디오를 제거하거나 삭제한 후 상업적으로 합리적인 기간 내에 효력을 상실합니다.
                                                    귀하는 회사가 제거되거나 삭제된 회원의 오디오의 서버 사본(server copy)을 보유할 수 있으나, 이를 전시, 배포하거나 공연할 수 없음을 알고 있고 이에 동의합니다. 회원이 제출한 이용자 의견 에 대하여 회원이 허여 한 상기 라이센스는 영구적이며 취소할 수 없습니다.
                                                    4. 회원은 또한 귀하가 본 서비스에 제출한 콘텐츠는, 귀하가 이를 게시하고 또한 본 약관에 정해진 라이센스 권리 전부를 회사에 허여 할 수 있도록, 귀하가 적법한 소유권자로부터 승인을 받았거나 달리 법적으로 그러한 권한이 있는 경우를 제외하고는, 제3자가 저작권을 보유한 자료나 기타 제3자가 전유적 권리를 가진 자료를 포함하 지 않을 것에 동의합니다.
                                                    귀하는 또한 국내 및 국제 법률 및 규정에 상반 되는 콘텐츠나 기타 자료를 본 서비스에 제출하지 않을 것에 동의 합니다.
                                                    5. 회사는 이용자 또는 기타 라이센서가 본 서비스에 제출한 콘텐츠나 본 서비스에 게시된 의견, 권고 또는 조언을 보증하지 아니하며, 회사는 콘텐츠와 관련 된 일체의 책임을 명시적으로 부인합니다. 회사는 본 서비스를 통한 저작권 침해 행위나 지적재산권 침해를 허용하지 아니하며, 콘텐츠가 타인의 지적재산권을 침 해한다는 사실을 적절하게 고지 받는 경우 그 콘텐츠 일체를 제거합니다. 회사는 사전 통지 없이 콘텐츠를 제거할 권리를 보유합니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1339">
                                                    제18조 (개별 서비스 약관)

                                                </h4>
                                                <p class="article-text" data-langNum="1340">
                                                    서비스 이용을 위하여 별도의 약관이 존재할 수 있습니다. 추가되는 서비스에 따라 별도의 약관을 제정할 수 있으며, 이용약관과 개별 서비스 약관의 내용이 상충될 경우 개별 서비스 약관이 우선 적용됩니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1341">
                                                    제19조(대리 행위 및 보증의 부인)

                                                </h4>
                                                <p class="article-text" data-langNum="1342">
                                                    회원은 회원의 본 서비스 사용과 관련하여 회원 단독으로 위험을 부담하기로 동의합니다. 법률이 허용하는 최대 범위 내에서, 회사, 회사의 임직원, 이사 및 대리인은 본 서비스 및 귀하의 본 서비스 이용과 관련하여 명시적이거나 묵시적인 모든 보증을 배제합니다. 법률이 허용하는 최대 범위 내에서, 회사는 본 사이트의 콘텐츠 또는 본 사이트와 링크된 사이트의 콘텐츠의 정확성이나 완전성에 대하여 모든 보증, 조건이나 진술을 배제하며,
                                                    (1) 콘텐츠의 오류, 과실이나 부정확성,
                                                    (2)회사의 서비스에 대한 귀하의 접속 및 사용으로 인하여 발생하는 여하한 성질의 상해(personal injury)또는 재산적 손해(property damage), (3)회사의 보안서버 및/또는 그에 저장된 모든 개인정보 및/또는 금융정보에 대한 무단 접속 또는 무단 사용,
                                                    (4) 본 서비스로 또는 본 서비스로부터의 전송 장애 또는 중단,
                                                    (5) 제3자가 본 서비스로 또는 본 서비스를 통하여 전송하는 버그, 바이러스, 트로이 목마 및 유사한 것, 및/또는 
                                                    (6) 콘텐츠의 오류 또는 누락이나 본 서비스에 게재, 이메일 송부, 전송되거나 달리 본 서비스를 통하여 제공된 콘텐츠의 사용으로 인하여발생하는 여하한 종류의 손실이나 손해에 대하여 어떠한 책임도 부담하지 않습니다. 회사는 본 서비스, 하이퍼링크 된 서비스 또는 배너 등의 광고를 통하여 제3자가 광고하거나 제공하는 제품이나 서비스에 대하여 어떠한 보증, 승인, 보장 또는 그에 대한 책임을 부담하지 않으며, 회사는 제품 또는 서비스를 위한 회원과 제3자와의 거래의 당사자가 아니며, 어떠한 방식으로도 그러한 거래를 모니터링할 책임을 부담하지 않습니다. 어떠한 매체를 통해서건 또는 어떠한 상황에서건 제품이나 서비스를 구입하는 것과 관련하여, 적절한 경우, 회원은 최선의 판단력으로서 주의를 기울여야 합니다.

                                                </p>
                                            </div>

                                            <div class="article-subtitle">
                                                <h3 data-langNum="1343">
                                                    제 4 장 계약당자사의 의무
                                                </h3>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1344">
                                                    제20조(회사의 의무)

                                                </h4>
                                                <p class="article-text" data-langNum="1345">
                                                    1. 회사는 서비스 제공과 관련하여 알고 있는 회원의 신상정보를 본인의 승낙 없이 제3자에게 누설, 배포하지 않습니다. 단, 관계법령에 의한 수사상의 목적으로 관계기관으로부터 요구 받은 경우나 정보통신윤리위원회의 요청이 있는 경우 등 법률의 규정에 따른 적법한 절차에 의한 경우에는 그러하지 않습니다.
                                                    2. 제1항의 범위 내에서, 회사는 업무와 관련하여 회원의 사전 동의 없이 회원 전체 또는 일부의 개인 정보 및 회원의 서비스내 활동에 관한 통계 자료를 작성하 여 이를 사용할 수 있고, 이를 위하여 회원의 컴퓨터에 쿠키를 전송할 수 있습니다. 이 경우 회원은 쿠키의 수신을 거부하거나 쿠키의 수신에 대하여 경고하도록 사용하는 컴퓨터의 브라우저의 설정을 변경할 수 있으며, 쿠키의 설정 변경에 의해 서비스 이용이 변경되는 것은 회원의 책 임입니다.
                                                    3. 회사는 서비스와 관련한 회원의 불만사항이 접수되는 경우 이를 신속하게 처리하여야 하며, 신속한 처리가 곤란한 경우 그 사유와 처리 일정을 서비스 화면 에 게재하거나 e-mail(전자우편) 등을 통하여 동 회원에게 통지합니다.
                                                    4. 회사가 제공하는 서비스로 인하여 회원에게 손해가 발생한 경우 그러한 손해가 회사의 고의나 중과실에 기해 발생한 경우에 한하여 회사에서 책임을 부담하며, 그 책임의 범위는 통상 손해에 한합니다.
                                                    5. 회사는 정보통신망 이용촉진 및 정보보호에 관한 법률, 통신비밀보호법, 전기통신사업법 등 서비스의 운영, 유지와 관련 있는 법규를 준수합니다.
                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1346">
                                                    제21조(회원의 의무)

                                                </h4>
                                                <p class="article-text" data-langNum="1347">
                                                    1. 회원은 서비스를 이용할 때 다음 각 호의 행위를 하여서는 아니 됩니다.
                                                    1) 이용 신청 또는 변경 시 허위 사실을 기재하거나, 다른 회원의 아이디(ID) 또는 닉네임 및 비밀번호를 도용, 부정하게 사용하는 행위
                                                    2) 회사의 서비스 정보를 이용해 얻은 정보를 회사의 사전 승낙 없이 복제 또는 유통시키거나 상업적으로 이용하는 행위
                                                    3) 타인의 명예를 손상시키거나 불이익을 주는 행위
                                                    4) 게시판 등에 음란물을 게재하거나 음란사이트를 연결(링크)하는 행위
                                                    5) 회사의 저작권, 제3자의 저작권 등 기타 권리를 침해하는 행위
                                                    6) 스트리밍 또는 다운로드를 통하여 제공받은 음원 또는 영상저작물을 영리를 목적으로 하는 영업장과 매장 등에서 제3자에게 재생 등의 방법으로 이용하는 행위
                                                    7) 공공질서 및 미풍양속에 위반되는 내용의 정보, 문장, 도형, 음성 등을 타인에게 유포하는 행위 8) 서비스와 관련된 설비의 오동작이나 정보 등의 파괴 및 혼란을 유발시키는 컴퓨터바이러스 감염 자료를 등록 또는 유포하는 행위
                                                    9) 서비스 운영을 고의로 방해하거나 서비스의 안정적 운영을 방해할 수 있는 정보 및 수신자의 명시적인 수신거부의사에 반하여 광고성 정보를 전송하는 행위
                                                    10) 타인으로 가장하는 행위 및 타인과의 관계를 허위로 명시하는 행위
                                                    11) 다른 회원의 개인정보를 수집, 저장, 공개하는 행위
                                                    12) 자기 또는 타인에게 재산상의 이익을 주거나 타인에게 손해를 가할 목적으로 허위의 정보를 유통시키는 행위
                                                    13) 재물을 걸고 도박하거나 사행 행위를 하는 행위
                                                    14) 윤락행위를 알선하거나 음행을 매개하는 내용의 정보를 유통시키는 행위
                                                    15) 수치심이나 혐오감 또는 공포심을 일으키는 말이나 음향, 글이나 화상 또는 영상을 계속해서 상대방에게 도달하게 함으로써 상대방의 일상적 생활을 방해하는 행위
                                                    16) 서비스에 게시된 정보를 변경하는 행위 17) 관련 법령에 의하여 그 전송 또는 게시가 금지되는 정보(컴퓨터 프로그램 포함)의 전송 또는 게시 행위
                                                    18) 회사의 직원이나 운영자를 가장하거나 사칭하여 또는 타인의 명의를 도용하여 글을 게시하거나 메일을 발송하는 행위
                                                    19) 컴퓨터 소프트웨어, 하드웨어, 전기통신 장비의 정상적인 가동을 방해, 파괴할 목적으로 고안된 소프트웨어 바이러스, 기타 다른 컴퓨터 코드, 파일, 프로그램을 포함하고 있는 자료를 게시하거나 e-mail(전자우편)으로 발송하는 행위
                                                    20) 스토킹(stalking) 등 다른 회원을 괴롭히는 행위
                                                    21) 회사 서비스(시스템 오류 등)를 부당하게 악용하는 행위 및 이로 인해 타 회원 및 회사에 손해를 끼치는 행위 22) 기타 불법적이거나 부당한 행위
                                                    2.회원은관계법령,본약관의규정,이용안내 및 서비스상에 공지한 주의사항, 회사가 통지하는 사항 등을 준수 하여야 하며,기타 회사의 업무에 방해되는 행위를 하여서는 아니 됩니다.
                                                    3. 회원은 회사에서 공식적으로 인정한 경우를 제외하고는 서비스를 이용하여 상품을 판매하는 영업 활동을 할 수 없으며 특히 해킹, 광고를 통한 수익, 음란사이트를 통한 상업 행위, 상용소프트웨어 불법 배포 등을 할 수 없습니다. 이를 위반하여 발생한 영업 활동의 결과 및 손실, 관계기관에 의한 구속 등 법적 조치 등 에 관해서는 회사가 책임을 지지 않으며, 회원은 이와 같은 행위와 관련하여 회사에 대하여 손해배상 의무를 집니다.
                                                    4. 회원은 서비스 이용을 위해 등록할 경우 현재의 사실과 일치하는 완전한 정보(이하 "등록정보")를 제공하여야 합니다.
                                                    5. 회원은 등록정보에 변경사항이 발생할 경우 즉시 갱신하여야 합니다. 회원이 제공한 등록정보 및 갱신한 등록 정보가 부정확할 경우, 기타 회원이 본 조 제1 항에 명시된 행위를 한 경우에 회사는 본 약관 제24조에 의해 회원의 서비스 이용을 제한 또는 중지 할 수 있습니다.
                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1348">
                                                    제22조(회원 아이디(ID)와 비밀번호(PASSWORD) 관리에 대한 의무와 책임)

                                                </h4>
                                                <p class="article-text" data-langNum="1349">
                                                    1. 회사는 사이트 내에서 일부 서비스 신청 시 이용요금을 부과할 수 있으므로, 회원은 회원 아이디(ID) 및 비밀번호 (PASSWORD) 관리를 철저히 하여야 합니다.
                                                    2. 회원 아이디(ID)와 비밀번호(PASSWORD)의 관리 소홀, 부정 사용에 의하여 발생하는 모든 결과에 대한 책임은 회원 본인에게 있으며, 회사의 시스템 고장 등 회사의 책임 있는 사유로 발생하는 문제에 대해서는 회사가 책임을 집니다.
                                                    3. 회원은 본인의 아이디(ID) 및 비밀번호(PASSWORD)를 제3자에게 이용하게 해서는 안되며, 회원 본인의 아이디(ID) 및 비밀번호(PASSWORD)를 도난 당 하거나 제3자가 사용하고 있음을 인지하는 경우에는 바로 회사에 통보하고 회사의 안내가 있는 경우 그에 따라야 합니다.
                                                    4. 본 조3항의 경우 해당 회원이 아이디(ID) 등의 도용 등의 사실을 통지하지 않거나, 통지 한 경우에도 회사의 안내에 따르지 않아 발생한 불이익에 대하여는 회사는 책임지지 않습니다.
                                                    5. 회원의 아이디(ID)는 회사의 사전 동의 없이 변경할 수 없습니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1350">
                                                    제23조(회원에 대한 통지)

                                                </h4>
                                                <p class="article-text" data-langNum="1351">
                                                    1. 회원에 대한 통지를 하는 경우 회사는 회원이 등록한 e-mail(전자우편) 주소 또는 SMS 등 기타의 방법으로 회원에게 이를 통지 할 수 있습니다.
                                                    2.회원의 연락처 미 기재, 변경 등으로 인하여 개별 통지가 어려운 경우,회원이 등록한 연락처로 통지를 하였음에도 2회 이상 반송된 경우 회사는 서비스 게시판 등에 7일 이상 게시함으로써 개별 통지에 갈음할 수 있습니다.
                                                    3. 회사는 불특정 다수 회원에 대한 통지의 경우 서비스 공지 게시판 등에 게시함으로써 개별 통지에 갈음할 수 있습니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1352">
                                                    제24조(이용자의 개인정보보호)

                                                </h4>
                                                <p class="article-text" data-langNum="1353">
                                                    회사는 관련법령이 정하는 바에 따라서 회원 등록정보를 포함한 회원의 개인정보를 보호하기 위하여 노력합니다. 회원의 개인정보보호에 관해서는 관련법령 및 회사가 정하는 "개인정보취급방침"에 정한 바에 의합니다.
                                                </p>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1354">
                                                    제25조 (개인정보의 수집, 제공 및 취급 위탁)

                                                </h4>
                                                <p class="article-text" data-langNum="1355">
                                                    회사는 수집된 개인정보의 취급 및 관리 등의 업무(이하 “업무”)를 스스로 수행함을 원칙으로 하나, 필요한 경우 업무의 일부 또는 전부를 회사가 선정한 회사에 위탁할 수 있습니다.

                                                </p>
                                            </div>

                                            <div class="article-subtitle">
                                                <h3 data-langNum="1356">
                                                    제 5 장 계약해지 및 이용제한

                                                </h3>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1357">
                                                    제26조(계약 해제ᆞ해지 및 이용제한)

                                                </h4>
                                                <p class="article-text" data-langNum="1358">
                                                    1. 회원이 서비스이용계약을 해지하고자 할 경우에는 본인이 서비스 상에서 또는 전화 등 기타 회사가 제공하는 그 밖의 방법으로 회사에 해지신청을 하여야 합니다. 회원이 계약을 해지할 경우 관련 법령 및 회사의 개인정보 취급방침에 따라 회사가 회원정보를 보유하는 경우를 제외하고는 해지 즉시 회원의 모든 개인정보 및 데이터는 삭제되므로, 해지, 탈퇴 시 사전 확인하기 바라며, 이에 대하여 회사가 데이터 등의 삭제를 안내하였음에도 불구하고 회원이 개인 데이터의 보존 등 적절 한 조치를 취하지 아니하는 경우에는 회사는 책임을 지지 않습니다.
                                                    2. 회사는 회원이 제21조 또는 제8조에 규정한 회원의 의무를 이행하지 않을 경우 사전 통지 없이 즉시 이용계약을 해지 하거나 또는 서비스 이용을 중지할 수 있습니다.
                                                    3. 회원이 이용계약을 해지하고자 하는 경우에는 회원 본인이 이용계약 해지신청(회원탈퇴)을 하여야 합니다.
                                                    4. 회사는 회원이 이용계약을 체결하여 아이디(ID)와 비밀번호(PASSWORD)를 부여 받은 후에라도 회원의 자격에 따른 서비스 이용을 제한할 수 있습니다.
                                                    5. 회사는 '정보통신망이용촉진 및 정보보호 등에 관한 법률' 및 동법 시행령에 따라 1년간 서비스를 이용하지 않은 회원의 개인정보를 보호하기 위해 개인정보 파기 등 필요한 조치를 취합니다. 또한, 회사는 객관적으로 계정정보 도용 피해가 우려되는 경우 또는 회원이 계속해서 1년 이상 로그인하지 않을 경우에는 회원정보의 보호 및 운영의 효율성을 위해 임시조치, 이용제한, 계정정보 삭제 등 필요한 조치를 취할 수 있습니다.
                                                    6. 본 조 제2항 및 제4항, 제5항의 회사 조치에 대하여 회원은 회사가 정한 절차에 따라 이의 신청을 할 수 있습니다. 이의가 정당하다고 회사가 인정하는 경우, 회사는 즉시 서비스의 이용을 재개합니다.
                                                </p>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1359">
                                                    제27조(양도 금지)

                                                </h4>
                                                <p class="article-text" data-langNum="1360">
                                                    회원은 서비스의 이용 권한, 기타 이용 계약상 지위를 타인에게 양도, 증여할 수 없으며 게시물에 대한 저작권을 포함한 모든 권리 및 책임은 이를 게시한 회원 에게 있습니다.

                                                </p>
                                            </div>

                                            <div class="article-subtitle">
                                                <h3 data-langNum="1361">
                                                    제 6 장 손해배상 등


                                                </h3>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1362">
                                                    제28조(손해 배상)

                                                </h4>
                                                <p class="article-text" data-langNum="1363">
                                                    1. 회원이 본 약관의 규정을 위반함으로 인하여 회사에 손해가 발생하게 되는 경우, 본 약관을 위반한 회원은 회사에 발생하는 모든 손해를 배상하여야 합니다.
                                                    2. 회사는 이용 요금이 무료인 서비스 이용과 관련하여 고의, 중과실이 없는 한 회원에게 발생한 어떠한 손해에 관하여도 책임을 지지 않습니다. 유료 서비스 또 는 개별 서비스의 경우는 서비스 별 이용약관에 따릅니다.
                                                    3. 회원이 서비스를 이용함에 있어 행한 불법행위나 본 약관 위반행위로 인하여 회사가 당해 회원 이외의 제3자로부터 손해배상 청구 또는 소송을 비롯한 각종 이의제기를 받는 경우 당해 회원은 자신의 책임과 비용으로 회사를 면책 시켜야 하며, 회사가 면책되지 못한 경우 당해 회원은 그로 인하여 회사에 발생한 모든 손해를 배상하여야 합니다.

                                                </p>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1364">
                                                    제29조(면책사항)

                                                </h4>
                                                <p class="article-text" data-langNum="1365">
                                                    1. 회사는 천재지변 또는 이에 준하는 불가항력으로 인하여 서비스를 제공할 수 없는 경우에는 서비스 제공에 관한 책임이 면제됩니다.
                                                    2. 회사는 회원의 귀책사유로 인한 서비스의 이용 장애에 대하여 책임을 지지 않습니다.
                                                    3.회사는 회원이 서비스를 이용하여 기대하는 수익을 상실한 것에 대하여 책임을 지지않으며 그 밖에 서비스를 통하여 얻은 자료로 인한 손해 등에 대하여도 책임을 지지 않습니다. 회사는 회원이 사이트에 게재한 정보 • 자료 • 사실의 신뢰도 및 정확성 등 내용에 대하여는 책임을 지지 않습니다.
                                                    4. 회사는 회원 상호간 또는 회원과 제3자 상호간에 서비스를 매개로 발생한 분쟁에 대해서는 개입할 의무가 없으며 이로 인한 손해를 배상할 책임도 없습니다.

                                                </p>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1366">
                                                    제30조(관할법원)

                                                </h4>
                                                <p class="article-text" data-langNum="1367">
                                                    1. 서비스 이용과 관련해 회사와 회원 사이에 분쟁이 발생한 경우, 회사와 회원은 분쟁의 해결을 위해 성실히 협의합니다.
                                                    2. 본 조 제1항의 협의에서도 분쟁이 해결되지 않을 경우 회사 본사 소재지를 관할하는 법원을 전속 관할법원으로 합니다.

                                                </p>
                                            </div>
                                            <div class="article-subtitle">
                                                <h3 data-langNum="1368">
                                                    부칙
                                                </h3>
                                            </div>
                                            <div class="article">

                                                <p class="article-text" data-langNum="1369">
                                                    (시행일) 본 약관은 2017년 6월 1일부터 시행합니다.
                                                </p>
                                                <p class="article-text" data-langNum="1370">
                                                    상기에 명시된 기관 및 단체, 법률은 대한민국을 기준으로 합니다.
                                                </p>
                                            </div>
                                    </div><!-- terms -->
                                        <div style="padding:10px 20px;">
                                        <span>wintle </span><span data-langNum="1008"></span>
                                        <div class="checks etrans" style="float:right;">
                                                <input type="checkbox" id="ex_chk1">
                                                <label for="ex_chk1" data-langNum="1010">동의</label>
                                        </div>
                                    </div>
                                    </li>

                                    <li>
                                        <div class="term-box">
                                            <div class="article">
                                                <h4 class="article-title">


                                                </h4>
                                                <p class="article-text" data-langNum="1403">
                                                    사용자는 콘텐츠를 업로드, 공동 저작, 이용하거나  정보를 검색하고 공유하는 등  다양한 방법으로 wintle 서비스를 사용할 수 있습니다. 사용자가 wintle과 정보를 공유하는 경우(예를 들어 wintle 계정을 만드는 경우) wintle은 해당 서비스를 더욱 개선하여 좀 더 관련성 높은 검색결과를 표시하고, 사람들과 간편하게 연결하고, 다른 사용자와 더 빠르고 쉽게 공유할 수 있도록 도와드립니다. wintle은 wintle 서비스 사용자가 서비스를 사용할 때 wintle의 정보 사용 방식 및 개인정보 보호 방식을 명확히 이해하기를 바랍니다.

                                                    wintle 개인정보취급방침에서 다루는 내용은 다음과 같습니다.
                                                    ·        wintle에서 수집하는 정보 및 수집 이유
                                                    ·        wintle에서 정보를 사용하는 방식
                                                    ·        wintle에서 제공하는 선택 사항(정보에 대한 액세스 및 업데이트 방법 포함)

                                                    가급적 이해하기 쉽게 설명하고자 하지만 쿠키, IP 주소, 픽셀 태그 및 브라우저와 같은 용어에 익숙하지 않다면 먼저 이러한 핵심 용어에 대해 읽어 보시기 바랍니다.
                                                    wintle은 사용자의 개인정보를 중요하게 생각하고, 회원의 개인정보를 보호하기 위하여 항상 최선을 다해 노력하고 있습니다.
                                                    따라서 wintle을 처음 사용하는 사용자든 오랫동안 사용한 사용자든, 시간을 내어wintle의 관행을 살펴보고 질문이 있는 경우 wintle에 문의하시기 바랍니다.

                                                </p>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1404">
                                                    wintle에서 수집하는 정보


                                                </h4>
                                                <p class="article-text" data-langNum="1405">
                                                    wintle은 모든 사용자에게 더 나은 서비스를 제공하기 위해 아래와 같은 다양한 정보를 수집합니다.

                                                    ·        사용자가 제공하는 정보. 예를 들어, wintle 서비스 중에는 wintle 계정에 가입해야 사용할 수 있는 서비스가 많습니다. wintle 계정에 가입할 때 wintle은 사용자에게 이름, 이메일 주소 같은 개인정보를 요청합니다.
                                                    또한 wintle에서 제공하는 공유 기능을 최대한 활용하고자 하는 사용자에게 wintle 프로필을 만들도록 요청할 수 있으며, 이 프로필은 모든 이에게 공개되고 이름과 사진이 포함될 수 있습니다.

                                                    ·        사용자가 서비스를 사용할 때 수집하는 정보.
                                                     wintle은 wintle서비스를 사용하는 사용자의 웹사이트 방문 일시 또는 콘텐츠 업로드 일시, 콘텐츠 소모 시간 등 사용자가 사용하는 서비스 및 사용 방식에 대한 정보를 수집할 수 있습니다. 이러한 정보에는 다음이 포함됩니다.

                                                    o   기기 정보
                                                    wintle은 하드웨어 모델, 운영체제 버전, 고유 기기 식별자 및 모바일 네트워크 정보(전화번호 포함)와 같은 기기별 정보를 수집할 수 있습니다. wintle은 기기 식별자 또는 전화번호를 wintle 계정과 연결할 수 있습니다.

                                                    o   로그 정보
                                                    wintle 서비스를 사용하거나 wintle에서 제공하는 콘텐츠를 볼 때 wintle은 서버 로그에 있는 특정 정보를 자동으로 수집하고 저장할 수 있습니다. 여기에는 다음이 포함될 수 있습니다.
                                                    사용자가 wintle 서비스를 사용한 방법에 대한 세부 정보(예: 콘텐츠 검색, 콘텐츠 소모 시간 등)
                                                    인터넷 프로토콜 주소
                                                    기기 이벤트 정보(시스템 활동, 하드웨어 설정, 브라우저 유형, 브라우저 언어, 요청 날짜 및 시간, 참조 URL)
                                                    사용자의 브라우저 또는 wintle 계정을 고유하게 식별할 수 있는 쿠키

                                                    o   위치 정보
                                                    사용자가 위치 기반 wintle 서비스를 사용할 때 wintle은 사용자의 실제 위치에 대한 정보(예: 휴대기기에서 보낸 GPS 신호)를 수집하고 처리할 수 있습니다. 또한 근처 Wi-Fi 액세스 포인트, 비콘 및 기지국 정보를 제공할 수 있는 기기의 센서 데이터 등 다양한 기술을 사용하여 위치를 파악할 수 있습니다. 파악된 위치는 wintle의 파트너에게 제공하는 서비스(예: 오프라인 매장 음원 유통)와 사용자가 상호 작용할 때 사용 될 수 있습니다. 파트너에 대한 상세한 정보는 파트너 탭을 이용하여 주시기 바랍니다.

                                                    o   고유한 애플리케이션 번호
                                                    일부 서비스에는 고유한 애플리케이션 번호가 포함됩니다. 서비스를 설치하거나 제거할 때 또는 자동 업데이트 요청 등을 위해 서비스가 주기적으로 wintle 서버에 연결할 때 이 번호 및 운영체제 종류, 애플리케이션 버전 번호 등 설치 관련 정보가 wintle로 전송될 수 있습니다.

                                                    o   로컬 저장소
                                                    wintle은 브라우저 웹 저장소(HTML 5 포함) 및 애플리케이션 데이터 캐시 등의 메커니즘을 사용하여 정보(개인정보 포함)를 수집하고 이를 사용자의 기기에 로컬로 저장할 수 있습니다.

                                                    o   쿠키 및 익명 식별자
                                                    사용자가 wintle 서비스를 방문하는 경우 wintle은 사용자의 기기로 하나 이상의 쿠키 또는 익명 식별자를 보내는 등 다양한 기술을 사용하여 정보를 수집하고 저장할 수 있습니다. 또한 wintle 파트너에게 제공하는 서비스(예: 오프라인 매장 음원 유통)와 사용자가 상호 작용할 때 쿠키와 익명 식별자를 사용합니다

                                                </p>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1406">
                                                    wintle에서 수집한 정보를 이용하는 방법


                                                </h4>
                                                <p class="article-text" data-langNum="1407">
                                                    wintle은 모든 wintle 서비스로부터 수집한 정보를 서비스를 제공, 유지, 보호 및 개선하고 새로운 서비스를 개발하며 wintle 및wintle 사용자를 보호하는 데 사용합니다. 또한 사용자에게 좀 더 관련성 높은 검색결과 및 광고를 표시하는 등 맞춤형 콘텐츠를 제공하기 위해 이러한 정보를 사용합니다.

                                                    wintle은 사용자가 wintle 프로필로 제공하는 이름을 wintle 계정이 필요한 모든 wintle 서비스에서 사용할 수 있습니다.
                                                    또한 사용자의 이름이 모든 wintle 서비스에 일관되게 표시되도록 wintle 계정과 연결된 과거 이름을 교체할 수 있습니다. 내 이메일 주소나 나를 식별하는 정보를 다른 사용자가 가지고 있는 경우 wintle은 그 사용자에게 내 공개 wintle 프로필 정보(예: 이름 및 사진)를 표시할 수 있습니다.

                                                    사용자가 wintle에 문의하는 경우 wintle은 사용자가 겪고 있는 문제 해결에 도움이 되도록 사용자와의 커뮤니케이션 기록을 보관할 수 있습니다. wintle은 변경 예정 사항 또는 개선사항 등 wintle 서비스 관련 정보를 제공하기 위해 사용자의 이메일 주소를 사용할 수 있습니다.

                                                    wintle은 예를 들어 사용자가 아는 사람들과 쉽게 공유하도록 돕기 위한 목적 등으로, 하나의 서비스에 제공한 개인정보를 다른 wintle서비스의 정보(개인정보 포함)와 조합할 수 있습니다.

                                                    wintle은 서비스 이용 내역을 추적하여 분석을 통한 추후 개인 맞춤 서비스를 제공 및 서비스 개편 등의 척도로 활용 할 수 있습니다. 예를 들어 wintle사용자를 유사집단으로 구분하여 취향에 맞는 콘텐츠를 우선 노출 할 수 있습니다.

                                                    본 개인정보취급방침에 명시된 목적과 다른 용도로 정보를 이용할 경우 wintle은 먼저 사용자의 동의를 요청합니다.
                                                    wintle은 개인정보를 전 세계의 여러 국가에 있는 wintle 서버에서 처리합니다.
                                                    wintle은 사용자가 거주하는 국가 이외의 지역에 있는 서버에서 사용자의 개인정보를 처리할 수 있습니다.

                                                </p>
                                            </div>
                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1408">
                                                    사용자가 공유하는 정보


                                                </h4>
                                                <p class="article-text" data-langNum="1409">
                                                    사용자는 여러 wintle 서비스에서 다른 사용자와 정보를 공유할 수 있습니다. 정보를 공개적으로 공유하는 경우 검색 엔진에서 해당 정보의 색인을  생성할 수 있습니다. wintle 서비스는 콘텐츠를 공유 및 삭제할 수 있는 다양한 옵션을 제공합니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1410">
                                                    개인정보 액세스 및 업데이트

                                                </h4>
                                                <p class="article-text" data-langNum="1411">
                                                    wintle은 사용자가 wintle 서비스를 사용하는 동안 언제든지 자신의 개인정보에 액세스할 수 있도록 하고자 합니다. 해당 정보가 잘못된 경우, wintle은 합법적인 사업 목적 또는 법률적 목적을 위해 유지해야 하는 경우가 아니라면 이러한 정보를 신속하게 업데이트하거나 삭제할 수 있는 방법을 제공하기 위해 노력합니다. 개인정보를 업데이트를 하는 경우 wintle은 요청을 처리하기 전에 사용자 신원 확인을 요청할 수 있습니다.

                                                    wintle은 비합리적으로 반복적인 요청, 과도한 기술적 노력이 필요한 요청(예: 새로운 시스템을 개발하거나 기존 관행을 근본적으로 바꾸어야 하는 경우), 타인의 개인정보를 침해하는 요청 또는 매우 비현실적인 요청(예: 백업 테이프에 있는 정보 관련 요청)을 거부할 수 있습니다.

                                                    wintle은 과도한 노력이 요구되지 않는 한 정보 액세스 및 수정 서비스를 무료로 제공합니다. wintle은 우발적이거나 악의적인 삭제 행위로부터 정보를 보호하는 방식으로 서비스를 유지 관리하고자 합니다. 이에 따라 wintle은 사용자가 wintle 서비스에서 정보를 삭제한 후에도 사본을wintle 활성 서버에서 즉시 삭제하지 않을 수 있으며 백업 시스템에서 정보를 삭제하지 않을 수 있습니다.

                                                    wintle에서 공유하는 정보
                                                    wintle은 다음 경우를 제외하고는 wintle 이외의 회사, 조직 및 개인과 개인정보를 공유하지 않습니다.
                                                    ·        사용자가 동의하는 경우
                                                    wintle은 사용자가 동의한 경우 wintle 이외의 회사, 조직 및 개인과 개인정보를 공유합니다. 민감한 개인정보를 공유해야 하는 경우wintle은 사용자의 사전 동의를 요청합니다.

                                                    ·        도메인 관리자와 공유하는 경우
                                                    도메인 관리자가 wintle 계정을 대신 관리하는 경우(예: wintle Apps 사용자) 조직에 사용자 지원을 제공하는 도메인 관리자 및 리셀러는 사용자의 wintle 계정 정보(이메일 및 기타 데이터 포함)에 액세스할 수 있습니다. 도메인 관리자는 다음 작업을 수행할 수 있습니다.
                                                    o   계정 관련 통계 조회(예: 사용자가 설치한 애플리케이션 관련 통계)
                                                    o   계정 비밀번호 변경
                                                    o   계정 액세스 일시 중지 또는 해지
                                                    o   계정에 저장된 정보에 대한 액세스 또는 보관
                                                    o   관련법, 규정, 법적 절차 또는 강제력이 있는 정부 요청을 준수하기 위해 계정 정보 수집
                                                    o   정보 또는 개인정보 보호 설정을 삭제하거나 수정할 수 있는 사용자 기능 제한
                                                    자세한 내용은 도메인 관리자의 개인정보취급방침을 참조하시기 바랍니다.



                                                    ·        외부 처리가 필요한 경우
                                                    wintle은 wintle 제휴사 또는 기타 신뢰할 수 있는 업체 및 개인에게 wintle 지침을 기반으로 개인정보취급방침, 기타 기밀 및 보안관련 조치를 준수하면서 wintle의 개인정보 처리 업무를 대행하도록 개인정보를 제공할 수 있습니다.

                                                    ·        법률상 필요한 경우
                                                    wintle은 다음 목적을 위해 개인정보에 대한 액세스, 이용, 보존 또는 공개가 필요하다고 믿는 경우 wintle 이외의 회사, 조직 또는 개인과개인정보를 공유합니다.
                                                    o   관련법, 규제, 법적 절차 및 강제력이 있는 정부 요청의 준수
                                                    o   서비스 약관 위반 조사를 포함한 관련 서비스 약관 집행
                                                    o   사기, 보안 또는 기술적 문제를 감지, 예방 또는 해결
                                                    o   wintle, wintle 사용자, 일반 대중의 권리, 재산, 안전을 위험 요소로부터 보호
                                                    wintle은 개인 식별이 불가능한 집계 정보를 대중 및 wintle 파트너(예: 게시자, 오프라인 매장 유통 파트너)와 공유할 수 있습니다.
                                                    예를 들어wintle은 wintle 서비스의 일반적인 사용 경향을 보여주는 정보를 대중에 공개할 수 있습니다. wintle은 인수, 합병, 또는 자산의 매각이 있을 경우 관련 개인정보의 기밀을 계속 유지하며, 개인정보가 타사에 전달되어 해당 업체의 개인정보취급방침의 적용을 받기 전에 해당 사용자에게 미리 공지합니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1412">
                                                    정보 보안

                                                </h4>
                                                <p class="article-text" data-langNum="1413">
                                                    wintle은 보유하는 정보에 대한 무단 액세스, 변경, 공개 또는 삭제로 부터 wintle 및 wintle 사용자를 보호하기 위해 노력합니다. 특히wintle은
                                                    ·        SSL을 사용하여 여러 wintle 서비스를 암호화합니다.
                                                    ·       회원의 개인정보는 오직 본인만이 알 수 있는 비밀번호에 의해 보호되고 있고 개인정보 확인 및 변경도 비밀번호를 알고 있는 본인에 의해서만 가능합니다.
                                                    ·        회사는 해킹 등 외부침입에 대비하여 귀하의 개인정보가 유출되는 것을 막기 위해 현재 외부로부터 침입을 차단하는 장치를 이용하여 외부로부터의 공격, 해킹 등을 막고 있습니다.
                                                    ·        wintle은 개인정보 접근 권한을 wintle 대신 개인정보를 처리하기 위해 정보를 알아야 하는 wintle 직원, 계약업자(위탁업자) 및 대리인으로 제한합니다. 이들은 계약을 통해 엄격한 기밀 유지의 의무를 갖게 되며 이러한 의무를 어길 경우 제재를 받거나 계약이 해지될 수 있습니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1414">
                                                    본 방침의 적용

                                                </h4>
                                                <p class="article-text" data-langNum="1415">
                                                    wintle 개인정보취급방침은 wintle 및 제휴사가 제공하는 모든 서비스(공동 저작 및 온/오프라인 유통 등)에 적용되나 본 개인정보취급방침과 통합되지 않는 별도의 개인정보취급방침이 있는 서비스에는 적용되지 않습니다.

                                                    wintle 개인정보취급방침은 타사 또는 개인이 제공하는 서비스(검색결과에 표시되는 제품 또는 사이트, wintle 서비스를 포함할 수 있는 사이트 또는 wintle 서비스에서 링크된 다른 사이트 포함)에는 적용되지 않습니다. wintle 개인정보취급방침은 wintle 서비스의 저작물을 유통 또는 제공하기 위해 쿠키, 픽셀 태그 및 기타 기술을 사용하는 다른 회사 및 조직의 정보 관행에는 적용되지 않습니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1416">

                                                    집행

                                                </h4>
                                                <p class="article-text" data-langNum="1417">
                                                    wintle은 개인정보취급방침의 자체적인 준수를 정기적으로 검토합니다. 또한 여러 자체 규제 프레임워크를 준수합니다. 불만사항에 대한 공식 서면신고서가 접수되면 wintle은 신고서 발송자에게 연락하여 후속조치를 취합니다. wintle은 개인정보 전송과 관련하여 사용자와 직접 해결할 수 없는 불만사항이 있는 경우 문제 해결을 위해 현지 데이터 보호 당국을 비롯한 해당 규제 당국과 협력합니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1418">
                                                    회원의 권리와 의무

                                                </h4>
                                                <p class="article-text" data-langNum="1419">
                                                    회원은 본인의 개인정보를 최신의 상태로 정확하게 입력하여 불의의 사고를 예방해주시기 바랍니다. 이용자가 입력한 부정확한 정보로 인해 발생하는 사고의 책임은 이용자 자신에게 있으며 타인 정보의 도용 등 허위정보를 입력할 경우 계정의 이용이 제한될 수 있습니다.
                                                    JAM를 이용하는 회원은 개인정보를 보호 받을 권리와 함께 스스로를 보호하고 타인의 정보를 침해하지 않을 의무도 가지고 있습니다. 회원은 아이디(ID), 비밀번호를 포함한 개인정보가 유출되지 않도록 조심하여야 하며, 게시물을 포함한 타인의 개인정보를 훼손하지 않도록 유의해야 합니다. 만약 이 같은 책임을 다하지 못하고 타인의 정보 및 타인의 존엄성을 훼손할 경우에는 「정보통신망 이용촉진 및 정보보호 등에 관한 법률」등에 의해 처벌 받을 수 있습니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1420">
                                                    고지의 의무

                                                </h4>
                                                <p class="article-text" data-langNum="1421">
                                                    wintle 개인정보취급방침은 수시로 변경될 수 있습니다. wintle은 사용자의 명시적인 동의 없이 본 개인정보취급방침에 설명된 사용자의권한을 축소하지 않습니다. wintle은 개인정보취급방침에 변경이 있을 경우 해당 내용을 본 페이지에 게시하며 변경사항이 중대할 경우에는 일부서비스에서 개인정보취급방침과 관련한 변경 고지 이메일을 발송하는 등 적극적으로 알립니다. wintle은 또한 사용자가 확인할 수 있도록 본개인정보취급방침의 이전 버전을 보관합니다.

                                                </p>
                                            </div>

                                            <div class="article">
                                                <h4 class="article-title" data-langNum="1422">
                                                    개인정보관리책임자 및 담당자
                                                </h4>
                                                <p class="article-text" data-langNum="1423">
                                                    wintle은 회원의 개인정보보호를 가장 중요시하며, 회원의 개인정보가 훼손, 침해 또는 누설되지 않도록 최선을 다하고 있습니다. 서비스를 이용하시면서 발생하는 모든 개인정보보호 관련 민원을 개인정보관리책임자 혹은 담당자에게 신고하시면 신속하게 답변해드리도록 하겠습니다.

                                                    [개인정보관리책임자]
                                                    성 명 : 조재호
                                                    직 위 : 대표
                                                    - 전자우편 : support@wintle.co.kr

                                                    [개인정보관리담당자]
                                                    성 명 : 최용득
                                                    직 위 : 대표
                                                    - 전자우편 : support@wintle.co.kr

                                                    기타 개인정보에 관한 상담이 필요한 경우에는 정보통신부 산하 공공기관인 한국인터넷진흥원(KISA) 개인정보침해신고센터 또는 경찰청 사이버테러대응센터로 문의하시기 바랍니다.

                                                    [한국인터넷진흥원 개인정보침해신고센터]
                                                    전화번호 : 국번없이 118
                                                    홈페이지 주소 : http://privacy.kisa.or.kr

                                                    [경찰청 사이버테러대응센터]
                                                    전화번호 : 02-393-9112
                                                    홈페이지 주소 : http://www.netan.go.kr

                                                    [대검찰청 사이버범죄수사단]
                                                    전화번호 : 02-3480-3751
                                                    홈페이지 주소 : http://www.spo.go.kr

                                                </p>
                                            </div>
                                            <div class="article-subtitle">
                                                <h3 data-langNum="1424">
                                                    부칙
                                                </h3>
                                            </div>

                                            <div class="article">
                                                <p class="article-text" data-langNum="1425">
                                                    (시행일) 본 약관은 2017년 6월 1일부터 시행합니다.
                                                </p>
                                                <p class="article-text" data-langNum="1370">
                                                    상기에 명시된 기관 및 단체, 법률은 대한민국을 기준으로 합니다.
                                                </p>
                                            </div>
                                </div><!-- term box -->
                                <div style="padding:10px 20px;">
                                    <span>wintle </span><span data-langNum="1009"></span>
                                    <div class="checks etrans" style="float:right;">
                                            <input type="checkbox" id="ex_chk2">
                                            <label for="ex_chk2" data-langNum="1010">동의</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <input type="submit" name="submit" value="동의하고 가입하기" onclick="return check() " data-langNum="1011">
                            </li>
                        </ul>
                    </span>
                </form>
            </div>
        </div>
</div>