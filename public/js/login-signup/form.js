/**
 * Created by Daniel on 8/13/2016.
 */


// check email based on regular expression
function isValidEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function isValidUsername(username) {
    return /^\w+$/.test(username);
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
function displayErrorBox(){
    showError("test");
}


//sign up conditions
function check() {
    displayErrorBox();
    //get all elements we need
    var username = document.getElementById("username");
    var email = document.getElementById("email_address");
    var password = document.getElementById("password");


    //username
    if (!isValidUsername(username.value)) {
        mark(username, 'username_wrong', false);
        return false;
    }
    else {
        mark(username, 'username_wrong', true);
    }

    //email
    if (!isValidEmail(email.value)) {
        mark(email, 'email_wrong', false);
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
    var response = grecaptcha.getResponse();
    if (response <= 0) {
        alert("check if you are a robot");
        return false;
    }

    return true;
}



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
        $("#username").hide("fast");
        $("#g-recaptcha").hide("fast");
        $(".SignUpText").hide("fast");
        $("#submit").prop("value","LOG IN");
    }



    //Ajax lyrics upload
    var request;
    $("#login-signup-form").submit(function(event){

        //abort any request before get started
        if(request){
            request.abort();
        }

        //get variables
        var $form = $(this);

        var $inputs = $form.find("input, textarea");

        //Serialize variables to send
        var serializedData = $form.serialize();

        //Block any inputs during working ajax
        $inputs.prop("disabled",true);

        //send ajax request
        request = $.ajax({
            url:"uploadfunction.php",
            type:"post",
            data : serializedData,
            dataType : "json",
            success : function(data){
                if(data.success){
                    alert("Uploaded");
                    window.location.replace("mycontents.php");
                }else{
                    alert("Something went wrong. Sorry for inconvenience Please try it later :( ");
                }
            }
        });

        request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });

        // Prevent default posting of form
        event.preventDefault();
    });



});