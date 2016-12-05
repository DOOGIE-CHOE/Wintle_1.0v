<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 11/30/2016
 * Time: 7:43 PM
 */
?>


<div id="all">
    <head>

        <style>
            html body{
                overflow-x:hidden;
                color:black;
            }

            .main-board{
                height:1000px;
                width:1222px;
                background-color: ghostwhite;
                margin:auto;
            }

            .main-board .music-board{
                display:inline-block;
                position:relative;
                float:right;
                height:100%;
                /*  width:75%;*/
                width:100%;
                background-color: #2b2e31;
            }

            #bg{
                position:fixed;
                height:100%;
                width:100%;
                background-repeat: no-repeat;
                background-image: url("<?php echo URL?>img/bg/bg1.png");
                background-size: cover;
            }

            #shortcut-info-icon img{
                position:relative;
                display: inline-block;
                margin:13px 26px 11px 9px;
                height:19px;
            }

            #shortcut-info-number div{
                position:absolute;
            }

        </style>

        <script>

            //Ajax login/signup
            $("#send-message-form").submit(function(event){
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
/*
            $("#send-message-form").submit(function(event){
                var url = $(this).attr('action');
                console.log(url);
                var data = $(this).serialize();
                console.log(data);
                //send ajax request
                /!*$.post(url, data, function(o) {
                 if(o.success == true){
                 window.location.replace("index");
                 }else{
                 errorDisplay(o.error);
                 }
                 }, 'json');*!/

                return false;
            });*/

            $(function(){
                $("#username").blur(function(){
                    $.get("<?php echo URL?>common/getUserIdByName/"+$("#username").val(), function(o){
                        var value = jQuery.parseJSON(o);
                        if(value == null){
                            errorDisplay("Cannot find the user");
                        }else{
                            $("#userid").val(value);
                        }
                    });
                });
            });
        </script>

    </head>
    <body>
    <div id="bg"></div>

    <div class="main-board">
        <div class="music-board">
            <br><br><br>
            <form id="send-message-form" action="http://localhost/test/testtest" method="post"  enctype="multipart/form-data">
                <input type="text" id="username" name="username" required>
                <input type="text" id="userid" name="userid" style="display:none" required>
                <br><br><br><br>
                <input type="text" id="message" name="message" required>
                <input type="submit" id="test" name="test" value="send">
            </form>
        </div>
    </div>



    </body>

</div>



