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
    var user_name = document.getElementById("user_name");
    var email = document.getElementById("user_email");
    var password = document.getElementById("password");
     //username
     if (!isValidUsername(user_name.value)) {
        mark(user_name, 'user_name_wrong', false);
        errorDisplay("Invalid Username. Please check it again");
        return false;
    }else if(user_name.value.length > 20){
        mark(user_name, 'user_name_wrong', false);
        errorDisplay("Maximum username length is up to 20");
        return false;
    }
    else {
        mark(user_name, 'user_name_wrong', true);
    }

    //email
    if (!isValidEmail(email.value)) {
        mark(email, 'email_wrong', false);
        errorDisplay("Invalid Email Address. Please check it again");

        return false;
    }else if(email.value.length > 40){
        mark(email, 'email_wrong', true);
        errorDisplay("Maximum Email length is up to 40");
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


    //reCAPTCHA by google
    // for server
    // client should annotate this part
  /*  var response = grecaptcha.getResponse();
    if (response <= 0) {
        errorDisplay("Are you a robot ?");
        return false;
    }
*/


    return true;
}


function logIn(){
    var user_name = document.getElementById("user_name");
    var email = document.getElementById("user_email");
    var password = document.getElementById("password");
    user_name.value=" ";

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


//sign up conditions
function check() {
    var button = document.getElementById("submit");

    if(button.value == "SIGN UP"){
        if(signUp()){
            //$("#login-signup-form").attr("action","http://www.wintle.co.kr/signup/callsignup");
            $("#login-signup-form").attr("action","http://localhost/signup/callsignup");
            return true;
        }
    }
    else if(button.value == "LOG IN"){
        if(logIn()){
            //$("#login-signup-form").attr("action","http://www.wintle.co.kr/login/calllogin");
           $("#login-signup-form").attr("action","http://localhost/login/calllogin");
            return true;
        }
    }
    return false;
}



$(function(){
    setLogInForm();

    $("#login-text, #top_login").click(function (e){
        setLogInForm()
    });

    $("#signup-text, #top_signup").click(function (e){
        $(".arrow-up-left").css("right","117px");
        $("#popup").css("height","440px");
        $("#user_name").show("fast");
        $("#user_name").val('');
       // $("#g-recaptcha").show("fast");
        $(".SignUpText").show("fast");
        $("#submit").prop("value","SIGN UP");
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
        $("#user_name").hide("fast");
      //  $("#g-recaptcha").hide("fast");
        $(".SignUpText").hide("fast");
        $("#submit").prop("value","LOG IN");
    }


    //Ajax login/signup
    $("#login-signup-form").submit(function(event){
        var url = $(this).attr('action');
        var data = $(this).serialize();
        //send ajax request
        $.post(url, data, function(o) {
            if(o.success == true){
                window.location.replace("index");
            }else{
                errorDisplay(o.error);
            }
        }, 'json');

        return false;
    });

});



/*
 //Ajax lyrics upload
 var request;
 $("#login-signup-form").submit(function(event){
 var type;
 var submit = document.getElementById("submit");
 if(submit.value == "LOG IN"){
 type = 'login';
 }else if (submit.value == "SIGN UP"){
 type = 'signup';
 }else{
 return false;
 }
 //abort any request before get started
 if(request){
 request.abort();
 }
 //get variables
 var $form = $(this);

 var $inputs = $form.find("input, textarea");

 //Serialize variables to send
 var serializedData = $form.serialize() + "&type=" + type;

 //Block any inputs during working ajax
 $inputs.prop("disabled",true);

 //send ajax request
 request = $.ajax({
 url: "../ajax.php",
 type:"post",
 data : serializedData,
 dataType : "json",
 success : function(data){
 if(data.success){
 if(submit.value == "SIGN UP"){
 alert('Signed up successfully');
 }
 window.location.replace("index.php");
 }else{
 errorDisplay(data.error);
 }
 }
 });

 request.always(function () {
 // Reenable the inputs
 $inputs.prop("disabled", false);
 });

 // Prevent default posting of form
 event.preventDefault();
 });*/