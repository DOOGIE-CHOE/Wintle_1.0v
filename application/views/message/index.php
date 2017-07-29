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
            #conv-list{
                position:relative;
                width:300px;
                height:200px;
                background: antiquewhite;
            }
            #conv{
                position:relative;
                width:30px;
                height:30px;
                background: darkorange;
                margin:20px;
            }

        </style>

        <script>
            $.get("<?php echo URL?>message/getmessageoverview", function(o){
                var value = jQuery.parseJSON(o);
                for(var i = 0; i < value.length; i++){
                    $("#conv-list").append("<div id='conv' onclick='getConversation("+value[i].msg_group_id+")'></div>");
                }
            });

            function getConversation(group_id){
                $.get("<?php echo URL?>message/getConversationByGroupId/"+group_id, function(o){
                 var value = jQuery.parseJSON(o);
                    for(var i = 0; i < value.length; i++){
                        $("#text").append(value[i].message + "<br><br>");
                    }
                 });
            }

            $(function(){
                $("#username").blur(function(){
                    if( !this.value ){ //if it's empty
                        $("#userid").val('');
                    }else{
                        $.get("<?php echo URL?>common/getUserIdByName/"+$("#username").val(), function(o){
                            var value = jQuery.parseJSON(o);
                            if(value == null){
                                errorDisplay("Cannot find the user");
                                $("#userid").val('');   // clear userid
                            }else{
                                $("#userid").val(value);
                            }
                        });
                    }
                }).keypress(function( e ) {
                    if(e.which === 32)
                        return false;
                });

                //Ajax login/signup
                $("#send-message-form").submit(function(event){
                    var url = $(this).attr('action');
                    var data = $(this).serialize();
                    //send ajax request
                    $.post(url, data, function(o) {
                        if(o.success == true){
                            errorDisplay("Message is sent successfully !!!!!");
                        }else{
                            errorDisplay(o.error);
                        }
                    }, 'json');

                    return false;
                });
            });


        </script>

    </head>
    <body>
    <div id="bg"></div>

    <div class="main-board">
        <div class="music-board">
            <br><br><br>
            <form id="send-message-form" action="http://localhost/message/sendmessage" method="post"  enctype="multipart/form-data">
                <input type="text" id="username" name="user_name" required>
                <input type="text" id="userid" name="receiver_id" style="display:none" required>
                <br><br><br><br>
                <input type="text" id="message" name="message" required>
                <input type="submit" id="test" name="test" value="send">
            </form>

            <br><br><br>
            <div id="conv-list">
            </div>

            <div id="text">

            </div>
        </div>
    </div>



    </body>

</div>



