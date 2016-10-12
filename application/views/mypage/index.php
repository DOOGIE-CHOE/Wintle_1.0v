<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 10/11/2016
 * Time: 4:29 PM
 */

?>

<div id="all">
    <head>
        <style>
            html body{
                overflow-x:hidden;
            }

            .main-board{
                height:100%;
                width:1222px;
                background-color: ghostwhite;
                margin:auto;
            }

            .main-board .user-board{
                display:inline-block;
                position:relative;
                float:right;
                height:100%;
                width:1222px;
                background-color: #2b2e31;
            }

            #body{
                margin-top:37px;
            }

            #cover-photo{
                position:relative;
                width:100%;
                height:210px;
                background: black;
            }

            #user-info{
                position:absolute;
                height:200px;
                width:100%;
                top:117px;
                z-index: 10;
            }
            #profile{
                position:absolute;
                height:200px;
                width:250px;
            }

            #profilephoto{
                position:relative;
                z-index: 10;
                top:5px;
                left:50px;
            }

            #username, #user-hashtag{
                position:relative;
                height:100px;
                width:972px;
                z-index:20;
                float:right;
            }
            #username #name{
                position:absolute;
                font-size: 50px;
                bottom:10px;
                left:10px;
            }

            #user-hashtag #hashtag{
                position:absolute;
                top:10px;
                left:10px;
                font-size: 30px;
            }

            #content{
                position:relative;
                width:100%;
                height:500px;
                top:200px;
                background-color: #2c90c6;
            }
        </style>

    </head>

    <body id="body">
    <div class="main-board">
        <div class="user-board">
            <?php
            if(Session::get("loggedIn") != true){
                echo "Please Log In";
            }else{
                ?>
                <script>
                    $.get("index/getProfilePhoto", function(o){
                        var value = jQuery.parseJSON(o);
                        var photo = $("#profilephoto");
                        if(value.profile_photo_path == null){
                            //display default image
                            if(photo.find("img").length == 0)
                                photo.append("<img src = 'profileimages/default.png'>");
                        }else{
                            //display image as a circular image
                            if(photo.find("img").length == 0)
                                photo.append("<img src = '"+value.profile_photo_path+"' style='width: 187px; height: 187px; border-radius: 50%;background-repeat: no-repeat; background-position: center center;  background-size: cover;'>");
                        }
                    });
                </script>
            <?php } ?>
            <div id="user-info">
                <div id="profile"><div id="profilephoto"></div></div>
                <div id="username"><?php echo "<div id='name'>".Session::get('user_name')."</div>"?></div>
                <div id="user-hashtag"><div id="hashtag">#test, #test2, #test3</div></div>
            </div>

            <div id="cover-photo">

            </div>

            <div id="content"></div>


        </div>
    </div>


    </body>



</div>


