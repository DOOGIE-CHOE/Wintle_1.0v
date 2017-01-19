<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/20/2016
 * Time: 7:11 PM
 */
?>

<div id="popup1" class="overlay">
    <a class="close" href="#">×</a>
    <div class="header">
        <a href="index"><img src="<?php echo URL?>img/pavicon/wintle_logo_with_text-white.svg"></a>
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
                        <div style="margin-left:28px; margin-top:18px; height:47px;">
                            <div class="g-signin2" data-onsuccess="onSignIn"></div>
                            <a href="#" onclick="signOut();">Sign out</a>
                        </div>
                        <div class="divider">
                            <hr class="line-left"/>OR<hr class="line-right" />
                        </div>
                        <span name="wrong" id="user_name_wrong" style="display: none"
                              onclick="document.getElementById('user_name').value =''"><img
                                src="<?php echo URL?>img/x.png"></span><input type="text" name="user_name" id="user_name" required
                                                                              placeholder="Your username" autocomplete="off">
                                                    <span name="wrong" id="email_wrong" style="display: none"
                                                          onclick="document.getElementById('user_email').value =''"><img
                                                            src="<?php echo URL?>img/x.png"></span><input type="text" name="user_email" id="user_email" required
                                                                                                          placeholder="Your email address" autocomplete="off">
                                                    <span name="wrong" id="password_wrong"
                                                          style="display: none"
                                                          onclick="document.getElementById('password').value =''"><img
                                                            src="<?php echo URL?>img/x.png"></span><input type="password" name="password" id="password" required
                                                                                                          placeholder="Enter a password" autocomplete="off">
                        <p class="SignUpText">Use at least one letter<br> one numeral, and seven characters.</p>

                        <!--                        <div id="g-recaptcha" class="g-recaptcha" data-sitekey="6LcZwyATAAAAACFru_oAaZX_UCjGySRbcPFiN9Ye"></div>
                        -->
                        <input id="submit" type="submit" name="submit" value="LOG IN" style="margin-bottom: 30px" onclick="return check()">
                    </span>
        </div>
    </form>
</div>
