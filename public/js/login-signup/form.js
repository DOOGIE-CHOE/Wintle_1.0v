/**
 * Created by Daniel on 8/13/2016.
 */

// check email based on regular expression
function isValidEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function isValidUsername(name) {
    return /^\w+$/.test(name);
}

function isValidPassword(password) {
    var errors = [];
    if (password.length < 8) {
        errors.push("Your password must be at least 8 characters");
    }
    if (password.search(/[a-z]/i) < 0) {
        errors.push("Your password must contain at least one letter.");
    }
    if (password.search(/[0-9]/) < 0) {
        errors.push("Your password must contain at least one digit.");
    }
    if (errors.length > 0) {
        errorDisplay(errors[0]);
        return false;
    }

    return true;
}


// mark red if condition doesn't match
function mark(oj, id, tf) {
    if (tf == false) {
        document.getElementById(id).style.display = '';
        oj.style.backgroundColor = 'rgba(255, 0, 0, 0.2)';
    }
    else {
        oj.style.backgroundColor = 'rgba(0, 0, 0, 0)';
        document.getElementById(id).style.display = 'none';
    }
}

function signUp(){

    //get all elements we need
    var user_name = document.getElementById("user_name_signup");
    var email = document.getElementById("user_email_signup");
    var password = document.getElementById("password_signup");

     //username
     if (!isValidUsername(user_name.value)) {
        mark(user_name, 'user_name_wrong_signup', false);
        errorDisplay("Invalid Username. Please check it again");
        return false;
    }else if(user_name.value.length > 20){
        mark(user_name, 'user_name_wrong_signup', false);
        errorDisplay("Maximum username length is up to 20");
        return false;
    }
    else {
        mark(user_name, 'user_name_wrong_signup', true);
    }

    //email
    if (!isValidEmail(email.value)) {
        mark(email, 'email_wrong_signup', false);
        errorDisplay("Invalid Email Address. Please check it again");

        return false;
    }else if(email.value.length > 40){
        mark(email, 'email_wrong_signup', true);
        errorDisplay("Maximum Email length is up to 40");
        return false;
    }
    else {
        mark(email, 'email_wrong_signup', true);
    }

    //password
    if (!isValidPassword(password.value)) {
        mark(password, 'password_wrong_signup', false);
        return false;
    }
    else {
        mark(password, 'password_wrong_signup', true);
    }


    //reCAPTCHA by google
    // for server
    // client should annotate this part
  /*  var response = grecaptcha.getResponse();
    if (response <= 0) {
        errorDisplay("Are you a robot ?");
        return false;
    }
*/

  //이메일이 존재하는지 확인
    var formData = new FormData($(this)[0]);
    formData.append("user_email", $("#user_email_signup").val());
    var url = _URL+"common/checkUserEmail";
    $.ajax({
        url: url,
        data:formData,
        type: 'POST',
        async: false,
        success: function (data) {
            var tmp = jQuery.parseJSON(data);
            console.log(tmp);
            if (tmp == 0) {
                setTermsAndPrivacyForm();
            } else {
                errorDisplay("이미 존재하는 이메일 입니다");
                return false;
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}


function logIn(){
    var email = document.getElementById("user_email");
    var password = document.getElementById("password");

    //email
    if (!isValidEmail(email.value)) {
        mark(email, 'email_wrong', false);
        errorDisplay("Invalid Email Address. Please check it again");
        return false;
    }
    else {
        mark(email, 'email_wrong', true);
    }

    //password
    if (!isValidPassword(password.value)) {
        mark(password, 'password_wrong', false);
        return false;
    }
    else {
        mark(password, 'password_wrong', true);
    }

    return true;
}
function check(){
    if($("#ex_chk2").is( ":checked" ) == true && $("#ex_chk1").is(":checked" ) == true){
        return true;
    }
    else{
        errorDisplay("이용약관 및 개인정보처리방침에 동의하셔야 합니다.");
        return false;
    }
}

$(function(){
    setLogInForm();

    $("#login-text, #top_login").click(function (e){
        setLogInForm();
    });

    $("#signup-text, #top_signup").click(function (e){
        setSignUpForm();
    });

    //Ajax login/signup
    $("#login-form").submit(function(event){
        var url = $(this).attr('action');
        var data = $(this).serialize();
        //send ajax request
        $.post(url, data, function(o) {
            if(o.success == true){
                window.location.replace(_URL);
            }else{
                errorDisplay(o.error);
            }
        }, 'json');

        return false;
    });

    //Ajax login/signup
    $("#signup-form").submit(function(event){
        var url = $(this).attr('action');
        var data = $(this).serialize();
        //send ajax request
        $.post(url, data, function(o) {
            if(o.success == true){
                alert("회원가입이 완료 되었습니다");
                window.location.replace(_URL);
            }else{
                errorDisplay(o.error);
            }
        }, 'json');

        return false;
    });

    //폼 작성중 엔터키 입력시 자동 submit이 되므로 차단
    $('#signup-form').find('input').keypress(function(e){
        if ( e.which == 13 ) // Enter key = keycode 13
        {
            $(this).next().focus();  //Use whatever selector necessary to focus the 'next' input
            return false;
        }
    });

});

function setTermsAndPrivacyForm(){
    $(".SignUp").css("display","none");
    $(".terms-privacy").css("display","block");
}

function setLogInForm(){
    $("#login-form").css("display","block");
    $("#signup-form").css("display","none");
    // 팝업창이 로드 된 후에 유저네임 입력칸으로 커서 이동
    // 모바일화면에서 볼때 바로 키보드 자판이 올라오기 때문에 주석 처리
    // var interval = setInterval(function () {
    //     $("#user_email").focus();
    //     clearInterval(interval);
    // },200);
}

function setSignUpForm(){
    $("#signup-form").css("display","block");
    $("#login-form").css("display","none");
    //팝업창이 로드 된 후에 유저네임 입력칸으로 커서 이동
    // 모바일화면에서 볼때 바로 키보드 자판이 올라오기 때문에 주석 처리
    // var interval = setInterval(function () {
    //     $("#user_name").focus();
    //     clearInterval(interval);
    // },200);
}
