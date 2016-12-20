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
            $(function(){

                //Ajax login/signup
                $("#upload-content-form").submit(function(event){
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
            <form id="upload-content-form" action="http://localhost/upload/uploadcontent/lyrics" method="post"  enctype="multipart/form-data">
                <input type="text" id="content_title" name="content_title" required> title
                <br><br>
                <input type="text" id="content_path" name="content_path" required> path
                <br><br>
                <input type="text" id="content_comments" name="content_comments" required> comments
                <br><br>
                <input type="text" id="hashtags[]" name="hashtags" required> hashtags
                <br><br>
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



