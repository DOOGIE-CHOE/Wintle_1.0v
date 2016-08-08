/**
 * Created by Daniel on 8/7/2016.
 */


// check email based on regular expression
function isValidEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function isValidUsername(username) {
    return /^\w+$/.test(username);
}

function isValidPassword(password, repassword) {
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
    if (password != repassword) {
        errors.push("Check your password");
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


//sign up conditions
function check() {
    //get all elements we need
    var username = document.getElementById("username");
    var email = document.getElementById("email_address");
    var password = document.getElementById("password");
    var repassword = document.getElementById("repassword");


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
    if (!isValidPassword(password.value, repassword.value)) {
        mark(password, 'password_wrong', false);
        mark(repassword, 'repassword_wrong', false);
        return false;
    }
    else {
        mark(password, 'password_wrong', true);
        mark(repassword, 'repassword_wrong', true);
    }


    //reCAPTCHA by google
    var response = grecaptcha.getResponse();
    if (response <= 0) {
        alert("check if you are a robot");
        return false;
    }


    return true;
}
